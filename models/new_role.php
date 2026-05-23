<?php


$file_dir_name = dirname(__FILE__);

// require_once("$file_dir_name/../afw/afw.php");

class NewRole extends AFWObject
{

    public static $MY_ATABLE_ID = 13982;

    public static $DATABASE        = "";
    public static $MODULE                = "ums";
    public static $TABLE            = "new_role";
    /**
     * DB_STRUCTURE is the main source of configuration for the class 
     *    it is used in all the modules and methods to know how 
     *    to handle the class attributes
     * @var array|null
     */
    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct("new_role", "id", "ums");
        UmsNewRoleAfwStructure::initInstance($this);
    }
    /**
     * @param mixed $id
     * @return NewRole
     */
    public static function loadById($id)
    {
        $obj = new NewRole();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }



    public function getScenarioItemId($currstep)
    {
        return 0;
    }

    public static function loadByMainIndex($system_id, $module_id, $new_role_code, $create_obj_if_not_found = false)
    {
        if (!$system_id) throw new AfwRuntimeException("loadByMainIndex : system_id is mandatory field");
        if (!$module_id) throw new AfwRuntimeException("loadByMainIndex : module_id is mandatory field");
        if (!$new_role_code) throw new AfwRuntimeException("loadByMainIndex : new_role_code is mandatory field");


        $obj = new NewRole();
        $obj->select("system_id", $system_id);
        $obj->select("module_id", $module_id);
        $obj->select("new_role_code", $new_role_code);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("system_id", $system_id);
            $obj->set("module_id", $module_id);
            $obj->set("new_role_code", $new_role_code);

            $obj->insertNew();
            if (!$obj->id) return null; // means beforeInsert rejected insert operation
            $obj->is_new = true;
            return $obj;
        } else return null;
    }


    public function getDisplay($lang = "ar")
    {

        $data = array();
        $link = array();


        list($data[0], $link[0]) = $this->displayAttribute("new_role_code", false, $lang);
        list($data[2], $link[2]) = $this->displayAttribute("new_role_name_ar", false, $lang);
        list($data[3], $link[3]) = $this->displayAttribute("new_role_desc_ar", false, $lang);
        list($data[4], $link[4]) = $this->displayAttribute("new_role_name_en", false, $lang);
        list($data[5], $link[5]) = $this->displayAttribute("new_role_desc_en", false, $lang);


        return implode(" - ", $data);
    }





    protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
    {
        $lang = AfwLanguageHelper::getGlobalLanguage();
        // $objme = AfwSession::getUserConnected();
        // $me = ($objme) ? $objme->id : 0;

        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
        $my_id = $this->getId();
        $displ = $this->getDisplay($lang);



        // check errors on all steps (by default no for optimization)
        // rafik don't know why this : \//  = false;

        return $otherLinksArray;
    }

    protected function getPublicMethods()
    {

        $pbms = array();

        $color = "green";
        $title_ar = "تنفيذ الطلب";
        $title_en = "Execute request";
        $methodName = "executeNewRoleRequest";
        $pbms[AfwStringHelper::hzmEncode($methodName)] =
            array(
                "METHOD" => $methodName,
                "COLOR" => $color,
                "LABEL_AR" => $title_ar,
                "LABEL_EN" => $title_en,
                "ADMIN-ONLY" => true,
                "BF-ID" => "",
                'STEP' => $this->stepOfAttribute("divResults")
            );



        return $pbms;
    }

    public function executeNewRoleRequest($lang = "ar")
    {
        $update_if_exists = true;
        $object_code_arr = [];
        /**
         * @var Module $moduleObject
         */
        $moduleObject = $this->het("module_id");
        if (!$moduleObject) return ["can't create the role without define the application module", ""];
        $jrole_code = "";
        $jrObject = $this->het("jobrole_id");
        if ($jrObject) $jrole_code = $jrObject->getVal("jobrole_code");
        $module_code = $moduleObject->getModuleCode();
        $goal_code = $this->getVal("new_role_code");
        $object_code_arr[0] = $goal_code;
        $object_code_arr[1] = $module_code;
        $object_code_arr[2] = $jrole_code;
        $object_code_arr[3] = $lang;
        $object_code_arr[4] = null; // arole code will be defined later by Goal::add-ByCodes

        $object_name_ar  = $this->getVal("new_role_name_ar");
        $object_title_ar = $this->getVal("new_role_desc_ar");
        $object_title_en = $this->getVal("new_role_desc_en");
        $object_name_en  = $this->getVal("new_role_name_en");



        $other_settings = ",";
        $aTableList = $this->get("atable_mfk");
        $hlSettings = [];
        foreach ($aTableList as $aTableItem) {
            $v_atable_name = $aTableItem->getVal("atable_name");
            // hierrarchy level from setttings
            $hl = AfwSettingsHelper::readParamValue($this, "settings", "hl-" . $v_atable_name);
            if ($hl) $hlSettings[$v_atable_name] = $hl;
            $other_settings .= $v_atable_name . ",";
        }
        $object_code_arr[5] = $hlSettings;
        list($objToShow, $message, $error, $warning, $jrObj) = Goal::addByCodes($object_code_arr, $object_name_en, $object_name_ar, $object_title_en, $object_title_ar, $other_settings, $update_if_exists);
    }

    public function fld_CREATION_USER_ID()
    {
        return "id_aut";
    }

    public function fld_CREATION_DATE()
    {
        return "date_aut";
    }

    public function fld_UPDATE_USER_ID()
    {
        return "id_mod";
    }

    public function fld_UPDATE_DATE()
    {
        return "date_mod";
    }

    public function fld_VALIDATION_USER_ID()
    {
        return "id_valid";
    }

    public function fld_VALIDATION_DATE()
    {
        return "date_valid";
    }

    public function fld_VERSION()
    {
        return "version";
    }

    public function fld_ACTIVE()
    {
        return  "avail";
    }



    public function beforeMaj($id, $fields_updated)
    {
        if ($fields_updated["atable_mfk"]) {
            $settings = $this->getVal("settings");
            $aTableList = $this->get("atable_mfk");
            /**
             * @var Atable $aTableItem
             */
            foreach ($aTableList as $aTableItem) {
                $v_atable_name = $aTableItem->getVal("atable_name");
                $ar_atable_name = $aTableItem->getShortDisplay("ar");
                $hl_title = "اعدادات مستوى الهيكل التنظيمي المسموح له بادارةالجدول"; // $this->tm("")
                // hierrarchy level from setttings
                $hl = AfwSettingsHelper::readParamValue($this, "settings", "hl-" . $v_atable_name);
                if (!$hl) {
                    $settings .= "\n--$hl_title: $ar_atable_name--";
                    $settings .= "\nhl-$v_atable_name:1";
                }
            }

            $this->set("settings", $settings);
        }
        return true;
    }


    public function beforeDelete($id, $id_replace)
    {
        $server_db_prefix = AfwSession::config("db_prefix", "nauss_");

        if (!$id) {
            $id = $this->getId();
            $simul = true;
        } else {
            $simul = false;
        }

        if ($id) {
            if ($id_replace == 0) {
                // FK part of me - not deletable 


                // FK part of me - deletable 


                // FK not part of me - replaceable 



                // MFK

            } else {
                // FK on me 


                // MFK


            }
            return true;
        }
    }

    public function calcDivLevels($what = "value")
    {
        $html = "<h1>مستويات الهيكل التنظيمي</h1>";
        $css = "";
        $lang = AfwLanguageHelper::getGlobalLanguage();


        $main_company = AfwSession::currentCompany();
        $current_domain = 25;
        include(dirname(__FILE__) . "/../../client-$main_company/extra/hierarchy_level-$main_company.php");
        /**
         * @var array $hierarchy_level
         */
        if (!isset($hierarchy_level)) $hierarchy_level = [];
        $header = ['ar' => 'عربي', 'en' => 'انجليزي', 'id' => 'مسلسل'];
        foreach ($hierarchy_level as $id => $lookup_row) {
            $hierarchy_level[$id]['id'] = $id;
        }

        list($html_table, $ids) = AfwShowHelper::tableToHtml($hierarchy_level, $header);

        $html .= $html_table;

        // $html .= "<br>header=" . var_export($header, true);
        // $html .= "<br>hierarchy_level=" . var_export($hierarchy_level, true);

        return $html;
    }

    public function calcDivResults($what = "value")
    {
        $html = "";
        $css = "";

        $lang = AfwLanguageHelper::getGlobalLanguage();


        $title_rg = $this->tm("related goal", $lang);
        $title_rr = $this->tm("related role", $lang);
        $title_rbfs = $this->tm("related BFs", $lang);
        $title_rbfs_details = $this->tm("related BFs details", $lang);




        // show related goal object
        $html .= "<h5 class=\"bluetitle\"><i></i>$title_rg</h5>";
        $goalObject = $this->getRelatedGoalObject();
        if ($goalObject) {
            $hide_retrieve_cols = ["gggg", "xxx",];
            $force_retrieve_cols = ["id",];
            $options = ['mode_force_cols' => true, 'hide_retrieve_cols' => $hide_retrieve_cols, 'force_retrieve_cols' => $force_retrieve_cols];
            $html .= AfwShowHelper::showRetrieveTable($goalObject, $lang, $options);
        }
        unset($goalObject);

        // show related role object
        $html .= "<h5 class=\"bluetitle\"><i></i>$title_rr</h5>";
        $roleObject = $this->getRelatedRoleObject();
        if ($roleObject) {
            $hide_retrieve_cols = ["gggg", "xxx",];
            $force_retrieve_cols = ["id", "active",];
            $options = ['mode_force_cols' => true, 'hide_retrieve_cols' => $hide_retrieve_cols, 'force_retrieve_cols' => $force_retrieve_cols];
            $html .= AfwShowHelper::showRetrieveTable($roleObject, $lang, $options);
        }

        // show related BFs in menu
        $html .= "<h5 class=\"bluetitle\"><i></i>$title_rbfs</h5>";
        list($bfMenuObjectList, $rbfMenuObjectList) = $this->getRelatedBfMenuObjectList();
        if (count($rbfMenuObjectList) > 0) {
            $hide_retrieve_cols = ["gggg", "xxx",];
            $force_retrieve_cols = ["id", "active", "menu"];
            $options = ['mode_force_cols' => true, 'hide_retrieve_cols' => $hide_retrieve_cols, 'force_retrieve_cols' => $force_retrieve_cols];
            $html .= AfwShowHelper::showRetrieveTable($rbfMenuObjectList, $lang, $options);
        }

        if (count($bfMenuObjectList) > 0) {
            $html .= "<h5 class=\"bluetitle\"><i></i>$title_rbfs_details</h5>";
            $hide_retrieve_cols = ["gggg", "xxx",];
            $force_retrieve_cols = ["id", "active"];
            $options = ['mode_force_cols' => true, 'hide_retrieve_cols' => $hide_retrieve_cols, 'force_retrieve_cols' => $force_retrieve_cols];
            $html .= AfwShowHelper::showRetrieveTable($bfMenuObjectList, $lang, $options);
        } else $html .= "No menu related BFs generated. <br> this =>" . var_export($this, true);

        // nothing generated
        if (!$html) $html = "nothing generated";

        return $html;
    }

    public function getRelatedGoalObject()
    {
        $goal_code = $this->getVal("new_role_code");
        $objModule = $this->het("module_id");
        if (!$objModule) return null;
        $objModule_id = $objModule->id;
        $system_id = $objModule->getVal("id_system");
        return Goal::loadByMainIndex($system_id, $objModule_id, $goal_code);
    }

    public function getRelatedRoleObject()
    {
        $goal_code = $this->getVal("new_role_code");
        $objModule = $this->het("module_id");
        if (!$objModule) return null;
        $objModule_id = $objModule->id;
        // $system_id = $objModule->getVal("id_system");
        $arole_code = "goal-" . $goal_code;
        return Arole::loadByMainIndex($objModule_id, $arole_code);
    }


    public function getRelatedBfMenuObjectList()
    {
        $goal_code = $this->getVal("new_role_code");
        $objModule = $this->het("module_id");
        $objModule_id = $objModule->id;
        $objArole = $this->getRelatedRoleObject();

        if ($objArole) {
            return $objArole->getMenuBFs(true);
        } else return [[], []];
    }

    public function calcPhp_code($what = "value")
    {
        $objArole = $this->getRelatedRoleObject();
        /**
         * @var Module $objModule
         */
        $objModule = $this->het("module_id");
        if ($objArole and $objModule) {

            $moduleCode = $objModule->getModuleCode();
            $previlegeFilenameForRole = UmsManager::previlegeFilenameForRole($moduleCode, $objArole->id);
            $phpCode = $objArole->calcPhp_code($what);
            $message = "<div class='help fleft ums'>Please create or erase or merge this file : /$moduleCode/previleges/role/$previlegeFilenameForRole.php <b>with below code</b></div>";
            $message2 = "<div class='help fleft ums'>Also Please add at the end of this file : /$moduleCode/previleges.php the line below :<br>
                        include('previleges/role/$previlegeFilenameForRole.php');<br>
                        Finally deploy this change to see this new previleges or roles
                        </div>";
            return $message . $phpCode . $message2;
        } elseif (!$objModule) return "<div class='warning'>No module defined</div>";
        else return "<div class='warning'>No Arole associated</div>";
    }
}



// errors 
