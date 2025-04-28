<?php

// 6/7/2021 :
// ALTER TABLE `arole` CHANGE `titre_en` `titre_en` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL; 
// ALTER TABLE `arole` CHANGE `titre_short_en` `titre_short_en` VARCHAR(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL; 
// 21/3/2024 :
// ALTER TABLE ".$server_db_prefix."ums.arole CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;


// old include of afw.php

class Arole extends AFWObject
{

    public static $DATABASE        = "";
    public static $MODULE            = "ums";
    public static $TABLE            = "";
    public static $DB_STRUCTURE = null;


    public function __construct($tablename = "arole")
    {
        parent::__construct($tablename, "id", "ums");
        $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
        $this->DISPLAY_FIELD = "titre_short";
        $this->ORDER_BY_FIELDS = "titre_short";
        $this->copypast = false;
        $this->editByStep = true;
        $this->editNbSteps = 6;
        $this->showRetrieveErrors = true;

        $this->UNIQUE_KEY = array('module_id', 'role_code');
    }

    public static function loadById($id)
    {
        $obj = new Arole();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public static function loadByMainIndex($module_id, $role_code, $create_obj_if_not_found = false)
    {
        $obj = new Arole();
        if (!$module_id) throw new AfwRuntimeException("loadByMainIndex : module_id is mandatory field");
        if (!$role_code) throw new AfwRuntimeException("loadByMainIndex : role_code is mandatory field");


        $obj->select("module_id", $module_id);
        $obj->select("role_code", $role_code);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("module_id", $module_id);
            $obj->set("role_code", $role_code);

            $obj->insert();
            $obj->is_new = true;
            return $obj;
        } else return null;
    }

    public function getShortDisplay($lang = "ar")
    {
        $lang = strtolower(trim($lang));
        if (!$lang) $lang = "ar";
        if ($lang == "fr") $lang_suffix = "_en";
        elseif ($lang == "ar") $lang_suffix = "";
        else $lang_suffix = "_" . $lang;
        $fn = trim($this->getVal("titre_short$lang_suffix"));
        if (!$fn) $fn = trim($this->getVal("titre$lang_suffix"));
        $id = $this->getId();
        if (!$fn) $fn = "arole.$id";
        // list($typ,) = $this->displayAttribute("arole_type_id");
        // $fn .= " ($typ)";

        $moduleId = $this->getVal("module_id");
        $moduleObj = $this->het("module_id");

        if ($moduleObj) {
            $module_code = $moduleObj->getVal("module_code");
            if($module_code) $fn = AfwReplacement::trans_replace($fn, $module_code, $lang);
            // else die("check module code for module id = $moduleId name ".$moduleObj->getDisplay($lang));
        }

        return $fn;
    }

    public function getDropDownDisplay($lang = "ar")
    {
        $count = $this->calc("rbfListCount") + $this->calc("childListCount");

        return $this->getShortDisplay($lang) . " ($count)";
    }

    public function getDisplay($lang = "ar")
    {
        $fn = $this->getShortDisplay($lang);

        $parent = $this->hetParent();
        if ($parent) {
            return $parent->getDisplay($lang) . "->" . $fn;
        } else {
            return $fn;
        }
    }

    public function getAncetre()
    {
        if ($this->getVal("arole_type_id") == 10) return $this;
        $parent = $this->hetParent();
        if ($parent) return $parent->getAncetre();
        else return null;
    }

    public static function findAroleByCode($module_id, $role_code)
    {
        global $arr_AroleByCode;
        if ($arr_AroleByCode[$module_id][$role_code]) return $arr_AroleByCode[$module_id][$role_code];
        $rl = new Arole();
        $rl->select("module_id", $module_id);
        $rl->select("role_code", $role_code);

        if (!$rl->load()) {
            return null;
        }

        $arr_AroleByCode[$module_id][$role_code] = $rl;

        return $rl;
    }

    public function getParentGoal()
    {
        $goal = new Goal();
        $goal->set("goal_name_ar", "لا يوجد");
        $goal->set("goal_name_en", "Not found");


        $role_code = $this->getVal("role_code");

        list($role_type, $role_type_id) = explode("-", $role_code);

        if ($role_type == "goal") {
            if (is_numeric($role_type_id)) {
                $goal_id = $role_type_id;
                if ($goal_id) $goal->load($goal_id);
            } else {
                $goal_code = $role_type_id;
                $system_id = $this->getVal("system_id");
                $module_id = $this->getVal("module_id");
                $goal = Goal::loadByMainIndex($system_id, $module_id, $goal_code, $create_obj_if_not_found = false);
            }
        }

        if ($goal == null) {
            $goal = new Goal();
            $goal->set("goal_name_ar", "لا يوجد");
            $goal->set("goal_name_en", "Not found");
        }

        return $goal;
    }


    public static function getAssociatedRoleForSubModule($module_id, $subModuleObj)
    {
        if ($subModuleObj) $subModuleObjId = $subModuleObj->getId();
        else $subModuleObjId = 0;
        if (!$subModuleObjId) return null;

        $applicationObj = $subModuleObj->getParentApplication();
        if (!$applicationObj) return null;

        $application_id = $applicationObj->getId();
        $application_code = $applicationObj->getVal("module_code");
        if (!$application_code) throw new AfwRuntimeException("the application $applicationObj ($application_id) has not a module code");

        $role_code = "$application_code-module-" . $subModuleObjId;

        return self::findAroleByCode($module_id, $role_code);
    }

    public static function getOrCreateLookupRoleForApplication($applicationObj)
    {
        global $lang;
        if (!$applicationObj->isApplication()) throw new AfwRuntimeException("$applicationObj is not an application");
        if ($applicationObj) $applicationObjId = $applicationObj->getId();
        else $applicationObjId = 0;
        if (!$applicationObjId) return null;
        $application_code = $applicationObj->getVal("module_code");

        if (!$application_code) throw new AfwRuntimeException("$applicationObj has not an application code");

        $role_code = "$application_code-lookup";

        $titre_short          = "البيانات المرجعية";
        $titre_short_en       = "Lookup data";
        $titre                = "البيانات المرجعية";
        $titre_en             = "Lookup data";

        $arole_type_id = 10;
        list($new_role, $rl) = self::findOrCreateArole($applicationObjId, $role_code, $titre_short, $titre_short_en, $titre, $titre_en, $arole_type_id, $update_props = true);

        return $rl;
    }


    public static function getOrCreateLookupSubRoleForSubModule($lookupRole, $application_code, $module_id, $subModuleObj)
    {
        global $lang;
        if (!$lookupRole) throw new AfwRuntimeException("lookupRole is required for Arole::getOrCreateLookupSubRoleForSubModule method");

        if ($subModuleObj) $subModuleObjId = $subModuleObj->getId();
        else $subModuleObjId = 0;
        if (!$subModuleObjId) throw new AfwRuntimeException("subModuleObj is required for Arole::getOrCreateLookupSubRoleForSubModule method");

        $role_code = "$application_code-module-" . $subModuleObjId;

        $titre_short          = $subModuleObj->getVal("titre_short");
        $titre_short_en       = $subModuleObj->getVal("titre_short_en");
        if (!$titre_short_en)
            $titre_short_en = AfwStringHelper::toEnglishText($role_code);
        $titre                = $subModuleObj->getVal("titre");
        $titre_en             = $subModuleObj->getVal("titre_en");
        list($arole_type_id, $path) = $subModuleObj->getRoleTypeId("", $lang);
        if ($arole_type_id < 0) {
            throw new AfwRuntimeException("the module $subModuleObj (id=$subModuleObjId) has no role type, may be level too deep : $path");
        }
        list($new_role, $rl) = self::findOrCreateArole($module_id, $role_code, $titre_short, $titre_short_en, $titre, $titre_en, $arole_type_id + 10, $update_props = true);
        $rl->set("parent_arole_id", $lookupRole->getId());
        $rl->update();

        return $rl;
    }


    public static function findOrCreateArole($module_id, $role_code, $titre_short, $titre_short_en, $titre, $titre_en, $arole_type_id, $update_props = true)
    {
        global $cache_roles_arr;

        $new_role = false;

        if (!$cache_roles_arr[$module_id][$role_code]) {
            $cache_roles_arr[$module_id][$role_code] = new Arole();
            $cache_roles_arr[$module_id][$role_code]->select("module_id", $module_id);
            $cache_roles_arr[$module_id][$role_code]->select("role_code", $role_code);

            if (!$cache_roles_arr[$module_id][$role_code]->load()) {
                $cache_roles_arr[$module_id][$role_code]->set("module_id", $module_id);
                $cache_roles_arr[$module_id][$role_code]->set("role_code", $role_code);

                $cache_roles_arr[$module_id][$role_code]->set("titre_short", $titre_short);
                $cache_roles_arr[$module_id][$role_code]->set("titre_short_en", $titre_short_en);
                $cache_roles_arr[$module_id][$role_code]->set("titre", $titre);
                $cache_roles_arr[$module_id][$role_code]->set("titre_en", $titre_en);
                $cache_roles_arr[$module_id][$role_code]->set("avail", 'Y');
                $cache_roles_arr[$module_id][$role_code]->set("arole_type_id", $arole_type_id);

                $cache_roles_arr[$module_id][$role_code]->insert();
                $cache_roles_arr[$module_id][$role_code]->is_new = true;
                $new_role = true;
            }
        }

        if ((!$new_role) and ($update_props)) {

            $cache_roles_arr[$module_id][$role_code]->set("titre_short", $titre_short);
            $cache_roles_arr[$module_id][$role_code]->set("titre_short_en", $titre_short_en);
            $cache_roles_arr[$module_id][$role_code]->set("titre", $titre);
            $cache_roles_arr[$module_id][$role_code]->set("titre_en", $titre_en);
            $cache_roles_arr[$module_id][$role_code]->set("avail", 'Y');
            $cache_roles_arr[$module_id][$role_code]->set("arole_type_id", $arole_type_id);

            $cache_roles_arr[$module_id][$role_code]->update();
        }

        return array($new_role, $cache_roles_arr[$module_id][$role_code]);
    }

    public function getMenuBFs()
    {
        $rbfList = $this->get("rbfList");

        $all_bf_arr = array();

        foreach ($rbfList as $rbfId => $rbfObj) {
            if ($rbfObj->isActive() and ($rbfObj->getVal("bfunction_id") > 0) and $rbfObj->is("menu", false)) {
                $bfObj = $rbfObj->het("bfunction_id");
                $bf_id = $rbfObj->getVal("bfunction_id");
                // die("in getMenuBFs of arole ".$this->id."<br>add $bf_id / ".$bfObj->getDisplay("ar")."<br>");
                $all_bf_arr[$bf_id] = $bfObj;
            }
        }

        return $all_bf_arr;
    }

    public function getAllBFs()
    {
        $rbfList = $this->get("rbfList");

        $all_bf_arr = array();

        foreach ($rbfList as $rbfId => $rbfObj) {
            if ($rbfObj->isActive() and ($rbfObj->getVal("bfunction_id") > 0)) {
                $bfObj = $rbfObj->het("bfunction_id");
                $bf_id = $rbfObj->getVal("bfunction_id");
                // echo "<br>allbf : $bf_id / $bfObj<br>";
                $all_bf_arr[$bf_id] = $bfObj;
            }
        }

        return $all_bf_arr;
    }

    /*
        
        canDoBF Mean that This role or one of its sub-folders have this BF in BF authorised list 
        
        */

    public function canDoBF($bf_id)
    {
        /*
              $hasBF = $this->HasAsSpecialBF($bf_id);
              if($hasBF) return true;*/
        $file_dir_name = dirname(__FILE__);

        $rbf = new AroleBf();
        $rbf->select("arole_id", $this->getId());
        $rbf->select("bfunction_id", $bf_id);
        $rbf->select("avail", "Y");

        if ($rbf->load()) {
            return true;
        } else {
            $this_sub_folders = $this->get("childList");
            foreach ($this_sub_folders as $sub_folder_item) {
                if ($sub_folder_item and (is_object($sub_folder_item)) and $sub_folder_item->isActive()) {
                    if ($sub_folder_item->canDoBF($bf_id)) return true;
                }
            }
        }

        return false;
    }

    public function canDoBFLog($bf_id)
    {
        $canDoBFLog = "";
        $this_id = $this->getId();
        /*
              $hasBF = $this->HasAsSpecialBF($bf_id);
              if($hasBF) return "bf $bf_id found in role $this_id as SpecialBF (bfunction_mfk)";
              */
        $file_dir_name = dirname(__FILE__);

        $rbf = new AroleBf();
        $rbf->select("arole_id", $this_id);
        $rbf->select("bfunction_id", $bf_id);
        $rbf->select("avail", "Y");

        if ($rbf->load()) {
            return "bf $bf_id found in role $this_id as bf item authorized (tab.arole_bf)";
        } else {
            $this_sub_folders = $this->get("childList");
            foreach ($this_sub_folders as $sub_folder_item) {
                if ($sub_folder_item and (is_object($sub_folder_item)) and $sub_folder_item->isActive()) {
                    if ($sub_folder_item->canDoBF($bf_id)) {
                        $sub_folder_item_id = $sub_folder_item->getId();
                        $sub_canDoBFLog = $sub_folder_item->canDoBFLog($bf_id);
                        return "role[$sub_folder_item_id]->" . $sub_canDoBFLog;
                    }
                }
            }
        }

        return false;
    }

    /*
        HasAsSpecialBF Method Mean that This role or one of its sub-folders have this BF as Special BF (saved in field bfunction_mfk and means not table/mode matrix BFs)
        */
    /*
        obsolete meaning of bfunction_mfk not clear
        public function HasAsSpecialBF($bf_id)
        {
               $bfunction_mfk = $this->getVal("bfunction_mfk");
               $token = ",$bf_id,";
               if (strpos($bfunction_mfk, $token) !== FALSE) return true;
               else 
               {
                      $this_sub_folders = $this->get("childList");
                      foreach($this_sub_folders as $sub_folder_item)
                      {
                         if($sub_folder_item and (is_object($sub_folder_item)) and $sub_folder_item->isActive())
                         {
                                if($sub_folder_item->HasAsSpecialBF($bf_id)) return true;
                         }
                      }
               }
               
               return false;
        
        }*/

    public function getFolderUrl()
    {
        $myId = $this->getId();
        $url = "role_folder_menu.php?id=$myId";

        return $url;
    }



    public function getFormuleResult($attribute, $what = 'value')
    {
        // global $me, $URL_RACINE_SITE;    

        switch ($attribute) {
            case "auser_mfk":
                require_once("module_auser.php");
                $mau = new ModuleAuser();
                $mau->select("avail", "Y");
                $role_id = $this->getId();
                $module_id = $this->getVal("module_id");
                $mau->select("id_module", $module_id);
                $mau->where("arole_mfk like '%,$role_id,%'");
                $mau_list = $mau->loadMany();

                $auser_list = array();

                foreach ($mau_list as $mau_id => $mau_item) {
                    if ($mau_item->getVal("id_auser")) {
                        $auser_list[$mau_item->getVal("id_auser")] = &$mau_item->get("id_auser");
                    }
                }

                return $auser_list;
                break;

            case "system_id":
                $modSystem = $this->hetModule();
                if ($modSystem) {
                    $system = $modSystem->hetSys();
                    if ($system) return $system;
                    else return 0;
                } else return 0;
                break;

            case "bfList":

                $bfList = array();
                $rbfList = $this->get("rbfList");
                foreach ($rbfList as $rbf_id => $rbfItem) {
                    $bfList[$rbfItem->getVal("bfunction_id")] = $rbfItem->get("bfunction_id");
                }

                return $bfList;
                break;            
        }

        return AfwFormulaHelper::calculateFormulaResult($this, $attribute, $what);
    }




    public function getRoleMenu($sub_folders = true, $items = true)
    {
        global $lang, $MENU_ICONS, $menu_css_arr;


        $menu_folder = array();
        $module_id = $this->getVal("module_id");
        $lkp_module_role_code = "lkp-module-$module_id";
        $role_code = $this->getVal("role_code");

        $menu_folder["need_admin"] = ($lkp_module_role_code == $role_code);

        //if($this->getId()==84) die("($lkp_module_role_code == $role_code) ? => ".$menu_folder["need_admin"]);
        $my_id = $this->getId();
        $menu_folder["id"] = $my_id;
        $default_menu_desc = "menu.arole" . $this->getId();
        $menu_folder["menu_name_$lang"] = $this->getShortDisplay($lang);
        if(!$menu_folder["menu_name_ar"]) $menu_folder["menu_name_ar"] = $this->getShortDisplay("ar");
        if(!$menu_folder["menu_name_ar"]) $menu_folder["menu_name_ar"] = $default_menu_desc;
        if(!$menu_folder["menu_name_en"]) $menu_folder["menu_name_en"] = $this->getShortDisplay("en");
        if(!$menu_folder["menu_name_en"]) $menu_folder["menu_name_en"] = $default_menu_desc;
        if ($lang == "ar") $lang_other = "en";
        else $lang_other = "ar";
        
        $menu_folder["page"] = "main.php?Main_Page=fm.php&a=$module_id&r=" . $this->getId();
        $menu_folder["css"] = $menu_css_arr[$my_id];
        if (!$menu_folder["css"]) $menu_folder["css"] = "info";
        $menu_folder["icon"] = $MENU_ICONS[$my_id] . " icon-$my_id";
        $menu_folder["showme"] = true;
        $menu_folder["items"] = array();
        if ($items) {
            $this_bfs_list = array(); //$this->get("bfunction_mfk");
            $this_bfs_menu = $this->getMenuBFs();

            $this_bfs = array_merge($this_bfs_list, $this_bfs_menu);



            $this_bfs_atable_arr = array();

            foreach ($this_bfs as $bf_index => $bf_item) {
                if ($bf_item and (is_object($bf_item))) {
                    $this_bfs_atable_arr[$bf_index] = $bf_item->getVal("curr_class_atable_id");
                } else {
                    unset($this_bfs[$bf_index]);
                }
            }

            array_multisort($this_bfs_atable_arr, $this_bfs);
            /*
                    if($this->getId()==80)
                    {
                        throw new AfwRuntimeException("this_bfs[0] = ".$this_bfs[0]);
                    }*/

            foreach ($this_bfs as $bf_item) {
                if ($bf_item and (is_object($bf_item)) and $bf_item->isActive()) {
                    $menu_folder["items"][$bf_item->getId()] = array();
                    $bf_item_id =  $bf_item->getId();
                    $title_ar =  $bf_item->getShortDisplay("ar");
                    if (!$title_ar) $title_ar = "bf-$bf_item_id-ar";
                    $title_en =  $bf_item->getShortDisplay("en");
                    if (!$title_en) $title_ar = "bf-$bf_item_id-en";
                    
                    
                    $menu_folder["items"][$bf_item->getId()]["id"] = $bf_item->getId();
                    $menu_folder["items"][$bf_item->getId()]["code"] = $bf_item->getVal("bfunction_code");
                    $menu_folder["items"][$bf_item->getId()]["level"] = $bf_item->getVal("hierarchy_level_enum");
                    $menu_folder["items"][$bf_item->getId()]["menu_name_ar"] = $title_ar;
                    $menu_folder["items"][$bf_item->getId()]["menu_name_en"] = $title_en;
                    $menu_folder["items"][$bf_item->getId()]["page"] = $bf_item->getUrl();
                    $menu_folder["items"][$bf_item->getId()]["css"] = "bf";
                    $menu_folder["items"][$bf_item->getId()]["icon"] = $bf_item->getIcon();
                    //$menu_folder["items"][$bf_item->getId()]["png"] = $bf_item->getPng();
                } else {
                    /*
                            if($this->getId()==80)
                            {
                                throw new AfwRuntimeException("bf_item = ".var_export($bf_item,true));
                            }*/
                }
            }
        }
        /*
              if($this->getId()==80)
              {
                  throw new AfwRuntimeException("menu_folder = ".var_export($menu_folder,true));
              }*/

        $menu_folder["sub-folders"] = array();
        if ($sub_folders) {
            $this_folders = $this->get("childList");

            foreach ($this_folders as $folder_item) {
                if ($folder_item and (is_object($folder_item)) and $folder_item->isActive()) {
                    //$menu_folder["folders"][$folder_item->getId()] = array();
                    //$title_lang =  $folder_item->getDisplay($lang);
                    //$folder_item_id =  $folder_item->getId();
                    //if(!$title_lang) $title_lang = "folder-role-$folder_item_id-$lang";
                    //$menu_folder["folders"][$folder_item->getId()]["title"] = $title_lang;
                    //$menu_folder["folders"][$folder_item->getId()]["page"] = $folder_item->getFolderUrl();
                    //$menu_folder["folders"][$folder_item->getId()]["css"] = "role";
                    $menu_folder["sub-folders"][$folder_item->getId()] = $folder_item->getRoleMenu();
                }
            }
        }

        return $menu_folder;
    }

    public function addBF($bf_id, $forceInMenu=false)
    {
        global $lang;

        $file_dir_name = dirname(__FILE__);

        $this_display = $this->getShortDisplay($lang);


        $menu_added_info = "";
        $menu_added_error = "";
        $rbf = new AroleBf();
        $rbf->select("arole_id", $this->getId());
        $rbf->select("bfunction_id", $bf_id);

        if (!$rbf->load()) {
            $rbf->set("arole_id", $this->getId());
            $rbf->set("bfunction_id", $bf_id);
            $rbf->set("menu", 'N');
            $rbf->insert();
            //$menu_added_info = "new RBF inserted id = ".$rbf->getId();
        } else {
            $rbf->set("avail", 'Y');
            $rbf->set("menu", 'N');
            $rbf->update();
            //$menu_added_info = "existing RBF updated id = ".$rbf->getId();
        }

        $bf = $rbf->hetBF();

        if ($bf) {
            if ($forceInMenu or $bf->isMenu()) {
                /*
                       $mfk_before = $this->getVal("bfunction_mfk");
                       $this->addRemoveInMfk("bfunction_mfk",array($bf->getId()), array());
                       $mfk_after = $this->getVal("bfunction_mfk");
                       */
                $rbf->set("menu", 'Y');
                $rbf->update();
                // if($bf->getId()==101434) throw new AfwRuntimeException("before:$mfk_before | after:$mfk_after ");

                $menu_added = $this->update();
                if ($menu_added)
                    $menu_added_info .= "<br>[$bf] تم إضافته كقائمة في [$this_display]";
                else
                    $menu_added_info .= "<br>[$bf] موجود سابقا  كقائمة في [$this_display]";
            } else {
                $menu_added_info .= "<br>[$bf] ليس قائمة";
            }
        } else {
            $menu_added_error = "الوظيفة [id=$bf_id] مفقودة أو تحتوي على مشكل وتعذر إضافتها للقائمة";
        }

        $rol = $rbf->hetRole();
        if ($rol) {
            $rol->set("avail", 'Y');
            $rol->update();
        }

        return array($menu_added_error, $menu_added_info);
    }

    public function removeBF($bf_id)
    {
        



        $rbf = new AroleBf();
        $rbf->select("arole_id", $this->getId());
        $rbf->select("bfunction_id", $bf_id);
        $menu_removed = false;
        if ($rbf->load()) {
            $rbf->set("avail", 'N');
            $menu_removed = $rbf->update();
        }

        // $bf = $rbf->hetBF();
        /*
              if($bf_id)
              {
                       $this->addRemoveInMfk("bfunction_mfk",array(), array($bf_id));
                       $menu_removed = $this->update();
              }*/

        return $menu_removed;
    }

    protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
    {
        global $lang;

        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
        $arole_id = $this->getId();
        $displ = $this->getDisplay($lang);

        if ($mode == "display") {
            if ($this->getVal("arole_type_id") == 10) {

                $link = array();
                $link["URL"] = "main.php?Main_Page=hzm_bf_role_manage.php&rol=$arole_id";
                $link["TITLE"] = "إدارة الصلاحيات على قاعدة البيانات";
                $link["UGROUPS"] = array();
                $otherLinksArray[] = $link;
            }

            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة الصلاحيات الفرعية ";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Arole&currmod=ums&id_origin=$my_id&class_origin=Arole&module_origin=ums&newo=-1&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=parent_arole_id=$my_id&sel_parent_arole_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if (($mode == "mode_all_rbfList") or ($mode == "display")) {
            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة جميع الوظائف الفرعية";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=AroleBf&currmod=ums&id_origin=$my_id&class_origin=Arole&module_origin=ums&newo=-1&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=arole_id=$my_id&sel_arole_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if (($mode == "mode_rbfList") or ($mode == "display")) {
            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إضافة وظيفة فرعية";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=AroleBf&currmod=ums&id_origin=$my_id&class_origin=Arole&module_origin=ums&sel_arole_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }


        return $otherLinksArray;
    }



	public function getTableRightsMatrice($framework, $subModId = 0)
    {
        $file_dir_name = dirname(__FILE__);
        include_once("$file_dir_name/../../p"."ag/models/atable.php");
        $this_id = $this->getId();
        $matriceArr = array();
        $moduleObj = $this->hetModule();
        if ($moduleObj) {
            $moduleId = $moduleObj->getId();
            $moduleCode = $moduleObj->getVal("module_code");

            $at = new Atable();
            $at->select("id_module", $moduleId);
            if ($subModId) $at->select("id_sub_module", $subModId);
            $at->select("avail", 'Y');
            $atableList = $at->loadMany($limit = "", $order_by = "id_sub_module asc, titre_short asc");

            foreach ($atableList as $atableId => $atableObj) {
                $matriceArr[$atableId]["obj"] = $atableObj;

                $tbl_name = $atableObj->getVal("atable_name");
                $cat = $atableObj->tableCategory();
                $bf_arr = $atableObj->createFrameWorkScreens($framework, false);

                foreach ($bf_arr as $bf_id => $bf_data) {
                    if ($bf_id > 0) {
                        $bf = $bf_data["bf"];
                        $bf_new = $bf_data["bf_new"];
                        $menu = $bf_data["menu"];
                        $framework_mode = $bf_data["mode"];
                        if ($menu) $arole_id = -1;
                        else $arole_id = $this->getId();
                        if (!$bf) {
                            $this->throwError("role:$this_id, module:$moduleCode($moduleId), table($tbl_name/id=$atableId/cat=$cat) : createFrameWorkScreens has created null BF for framework mode : $framework_mode");
                        }
                        $matriceArr[$atableId][$framework_mode] = array("bf" => $bf, "arole_id" => $arole_id, "menu" => $menu);
                    }
                }
            }
        } else $matriceArr["error"] = "module not defined for role : $this";

        return  $matriceArr;
    }


    public function saveTableRightsMatrice($framework, $data_posted, $subModId)
    {
        $file_dir_name = dirname(__FILE__);

        require_once("$file_dir_name/../../p"."ag/models/atable.php");
        include("$file_dir_name/../pag/framework_${framework}_specification.php");
        $removed_count = 0;
        $added_count = 0;
        $menu_removed_count = 0;
        $menu_added_count = 0;

        $moduleObj = $this->hetModule();
        if ($moduleObj) {
            $moduleId = $moduleObj->getId();
            $moduleCode = $moduleObj->getVal("module_code");

            $at = new Atable();
            $at->select("id_module", $moduleId);
            $at->select("id_sub_module", $subModId);
            $at->select("avail", 'Y');
            $atableList = $at->loadMany($limit = "", $order_by = "id_sub_module asc, titre_short asc");

            foreach ($atableList as $atableId => $atableObj) {
                $cat = $atableObj->tableCategory();

                foreach ($framework_mode_list as $framework_mode => $framework_mode_item) {
                    $checkbox_name = "chk_" . $framework_mode . "_" . $atableId;
                    $bf_id_input_name = "bf_id_" . $framework_mode . "_" . $atableId;

                    $bf_old_checked = $data_posted["old_" . $checkbox_name];
                    $bf_checked = $data_posted[$checkbox_name];
                    $bf_id = $data_posted[$bf_id_input_name];

                    //if($checkbox_name == "chk_qsearch_25") die("old:$bf_old_checked != new:$bf_checked");

                    if (($bf_old_checked != $bf_checked) and ($bf_id > 0)) {
                        if ($bf_checked) {
                            $menu_added = $this->addBF($bf_id);
                            $added_count++;
                            if ($menu_added) $menu_added_count++;
                        } else {
                            $menu_removed = $this->removeBF($bf_id);
                            $removed_count++;
                            if ($menu_removed) $menu_removed_count++;
                        }
                    }
                }
            }
        } else $this->throwError("module not defined for role : $this");

        return array($added_count, $removed_count, $menu_added_count, $menu_removed_count);
    }


    public function beforeDelete($id, $id_replace)
    {


        if ($id) {
            if ($id_replace == 0) {
                $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - not deletable 
                $this->execQuery("delete from ${server_db_prefix}ums.arole where parent_arole_id = '$id' and avail='N'");

                $obj = new Arole();
                $obj->where("parent_arole_id = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Aroles(s) as Parent arole";
                    return false;
                }


                $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - deletable 
                // ums.job_arole-الصلاحية المسندة	arole_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from ${server_db_prefix}ums.job_arole where arole_id = '$id' ");
                // ums.arole_bf-الصلاحية	arole_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from ${server_db_prefix}ums.arole_bf where arole_id = '$id' ");
                // b au.user_story-الصلاحية المستخدمة	arole_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("delete from ${server_db_prefix}b au.user_story where arole_id = '$id' ");


                // FK not part of me - replaceable 



                // MFK
                // ums.arole-arole_mfk	arole_mfk  
                $this->execQuery("update ${server_db_prefix}ums.arole set arole_mfk=REPLACE(arole_mfk, ',$id,', ',') where arole_mfk like '%,$id,%' ");
                // ums.module_auser-الصلاحيات المسندة	arole_mfk  
                $this->execQuery("update ${server_db_prefix}ums.module_auser set arole_mfk=REPLACE(arole_mfk, ',$id,', ',') where arole_mfk like '%,$id,%' ");
                // ums.module_auser-الصلاحيات التي يمكنه أن يسندها لغيره	open_arole_mfk  
                $this->execQuery("update ${server_db_prefix}ums.module_auser set open_arole_mfk=REPLACE(open_arole_mfk, ',$id,', ',') where open_arole_mfk like '%,$id,%' ");
            } else {
                $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK on me 
                // ums.arole-الصلاحية الأم	parent_arole_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("update ${server_db_prefix}ums.arole set parent_arole_id='$id_replace' where parent_arole_id='$id' ");
                // ums.job_arole-الصلاحية المسندة	arole_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("update ${server_db_prefix}ums.job_arole set arole_id='$id_replace' where arole_id='$id' ");
                // ums.arole_bf-الصلاحية	arole_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("update ${server_db_prefix}ums.arole_bf set arole_id='$id_replace' where arole_id='$id' ");
                // b au.user_story-الصلاحية المستخدمة	arole_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("update ${server_db_prefix}b au.user_story set arole_id='$id_replace' where arole_id='$id' ");


                // MFK
                // ums.arole-arole_mfk	arole_mfk  
                $this->execQuery("update ${server_db_prefix}ums.arole set arole_mfk=REPLACE(arole_mfk, ',$id,', ',$id_replace,') where arole_mfk like '%,$id,%' ");
                // ums.module_auser-الصلاحيات المسندة	arole_mfk  
                $this->execQuery("update ${server_db_prefix}ums.module_auser set arole_mfk=REPLACE(arole_mfk, ',$id,', ',$id_replace,') where arole_mfk like '%,$id,%' ");
                // ums.module_auser-الصلاحيات التي يمكنه أن يسندها لغيره	open_arole_mfk  
                $this->execQuery("update ${server_db_prefix}ums.module_auser set open_arole_mfk=REPLACE(open_arole_mfk, ',$id,', ',$id_replace,') where open_arole_mfk like '%,$id,%' ");
            }
            return true;
        }
    }

    public static function getAllRolesForModuleAndUser($module_id, $user_id, $only_ids = false)
    {
        // die("rafik 2-6721 ($module_id, $user_id)");
        $mau = ModuleAuser::loadByMainIndex($module_id, $user_id);
        if (!$mau) {
            // if(($module_id==18) and ($user_id==1)) die("getAllRolesForModuleAndUser($module_id, $user_id) = [$mau]");
            if ($only_ids) return array(false, "");
            else return array(false, array());
        }
        // if(($module_id==18) and ($user_id==1)) die("getAllRolesForModuleAndUser($module_id, $user_id, $only_ids) => arole_mfk=".$mau->getVal("arole_mfk"));
        if ($only_ids) return array(true, trim($mau->getVal("arole_mfk"), ","));
        else return array(true, $mau->getRoles());
    }


    public function getRAMObjectData()
    {
        $category_id = 5;


        $typeObj = $this->getType();
        $lookup_code = $typeObj->getVal("lookup_code");
        $typeObj = RAMObjectType::loadByMainIndex($lookup_code);
        $type_id = $typeObj->getId();

        $code = $this->getVal("role_code");
        if (!$code) $code = "arole-" . $this->getId();
        $name_ar = $this->getVal("titre_short");
        $name_en = $this->getVal("titre_short_en");
        $specification = $this->getVal("titre");

        $childs = array();

        $childs[5] =  $this->get("childList");
        $childs[6] =  $this->get("bfList");

        return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
    }

    protected function getMyModeView()
    {
        return "display";
    }

    public function stepsAreOrdered()
    {
        return false;
    }

    public function myShortNameToAttributeName($attribute)
    {
        if ($attribute == "sys") return "system_id";
        if ($attribute == "module") return "module_id";
        if ($attribute == "type") return "arole_type_id";
        if ($attribute == "title") return "titre_short";
        if ($attribute == "title_en") return "titre_short_en";
        if ($attribute == "parent") return "parent_arole_id";
        if ($attribute == "goal") return "goal_id";
        return $attribute;
    }


    public function calcPhp_rbf()
        {
            $module_id = $this->getVal("module_id");
            $role_code = $this->getVal("role_code");
            $titre_short_en = $this->getVal("titre_short_en");
            $titre_short = $this->getVal("titre_short");
            $titre_en = $this->getVal("titre_en");
            $titre = $this->getVal("titre");
            $php_code = "\t\$aroleObj = Arole::loadByMainIndex($module_id, '$role_code', true);\n";
            $php_code .= "\t\$aroleObj->set('titre_short_en','$titre_short_en');\n";
            $php_code .= "\t\$aroleObj->set('titre_short','$titre_short');\n";
            $php_code .= "\t\$aroleObj->set('titre_en','$titre_en');\n";
            $php_code .= "\t\$aroleObj->set('titre','$titre');\n";
            $bfList = array();
            $rbfList = $this->get("rbfList");
            foreach ($rbfList as $rbf_id => $rbfItem) {
                // bfunction_id can be new so import it also by same method
                $bfItem = $rbfItem->get("bfunction_id");
                $id_system = $bfItem->getVal("id_system");
                $curr_class_module_id = $bfItem->getVal("curr_class_module_id");
                if ($module_id != $curr_class_module_id) throw new RuntimeException("calcPhp_rbf module_id != curr_class_module_id $module_id != $curr_class_module_id for : <br>\n $bfItem");
                $curr_class_atable_id = $bfItem->getVal("curr_class_atable_id");
                if(!$curr_class_atable_id) $curr_class_atable_id = 0;
                if($curr_class_atable_id>0)
                {
                    $file_dir_name = dirname(__FILE__);
                    include_once("$file_dir_name/../../p"."ag/models/atable.php");
                    $curr_class_atableObj = Atable::loadById($curr_class_atable_id);
                    if($curr_class_atableObj)
                    {
                        $id_module = $curr_class_atableObj->getVal("id_module");
                        $atable_name = $curr_class_atableObj->getVal("atable_name");

                        $php_code .= "\t\$newAtableObj = Atable::loadByMainIndex($id_module, '$atable_name');\n";
                        $php_code .= "\tif(\$newAtableObj) \$newAtableObj_id = \$newAtableObj->id;\n";
                        $php_code .= "\telse \$newAtableObj_id = -2; // not found table in destination\n";
                    }
                    else 
                    {
                        $php_code .= "\t\$newAtableObj_id = -1; // delete table seems\n";
                    }
                }
                else $php_code .= "\t\$newAtableObj_id = 0; // bf not related to table seems\n";

                $file_specification = $bfItem->getVal("file_specification");
                $bf_specification = $bfItem->getVal("bf_specification");
                $php_code .= "\t\$objBF = Bfunction::loadByBusinessIndex($id_system, \$newAtableObj_id, $curr_class_atable_id, '$file_specification', '$bf_specification', true);\n";
                $arole_id = $rbfItem->getVal("arole_id");
                $this_id = $this->id;
                if ($arole_id != $this_id) throw new RuntimeException("calcPhp_rbf arole_id != this_id $arole_id != $this_id for : <br>\n $this");
                $php_code .= "\tAroleBf::loadByMainIndex(\$aroleObj->id, \$objBF->id, true);\n";
            }

            return $php_code;
        }
}
