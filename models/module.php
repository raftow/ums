<?php
$file_dir_name = dirname(__FILE__);

// old include of afw.php

class Module extends AFWObject
{

    // APPLICATION - application  
    public static $MODULE_TYPE_APPLICATION = 5;

    // FRAMEWORK - framework  
    public static $MODULE_TYPE_FRAMEWORK = 4;

    // MINI_APPLICATION - mini_application  
    public static $MODULE_TYPE_MINI_APPLICATION = 8;

    // MODULE - module  
    public static $MODULE_TYPE_MODULE = 6;

    // SYSTEM - system  
    public static $MODULE_TYPE_SYSTEM = 7;


    // IN_PRODUCTION - في طور الانتاج  
    public static $MODULE_STATUS_IN_PRODUCTION = 4;

    // TEST_ONGOING - في طور التجربة  
    public static $MODULE_STATUS_TEST_ONGOING = 3;

    // ANALYSIS_ONGOING - في طور التحليل  
    public static $MODULE_STATUS_ANALYSIS_ONGOING = 1;

    // DEVELOPMENT_ONGOING - في طور التطوير  
    public static $MODULE_STATUS_DEVELOPMENT_ONGOING = 2;

    // STUDY_ONGOING - في طور الدراسة  
    public static $MODULE_STATUS_STUDY_ONGOING = 5;



    public static $DATABASE        = "";
    public static $MODULE            = "ums";
    public static $TABLE            = "";
    public static $DB_STRUCTURE = null;

    public function __construct()
    {
        parent::__construct("module", "id", "ums");
        UmsModuleAfwStructure::initInstance($this);
    }

    public static function loadByMainIndex($module_code, $create_obj_if_not_found = false)
    {
        $obj = new Module();
        if (!$module_code) throw new AfwRuntimeException("loadByMainIndex : module_code is mandatory field");

        $obj->select("module_code", $module_code);

        if ($obj->load()) {
            if ($create_obj_if_not_found) $obj->activate();
            return $obj;
        } elseif ($create_obj_if_not_found) {
            $obj->set("module_code", $module_code);

            $obj->insert();
            $obj->is_new = true;
            return $obj;
        } else return null;
    }

    public static function reverseByCodes($object_code_arr)
    {
        $obj = new Module();
        if (count($object_code_arr) != 1) throw new AfwRuntimeException("reverseByCodes : only one module_code is needed : object_code_arr=" . var_export($object_code_arr, true));
        $module_code = $object_code_arr[0];

        $file_dir_name = dirname(__FILE__);
        include("$file_dir_name/../../$module_code/module_config.php");
        if ($module_code != $MODULE) throw new AfwRuntimeException("reverseByCodes : module_code is not correct [\$MODULE=$MODULE] in $file_dir_name/../$module_code/module_config.php file");
        $module_id = $THIS_MODULE_ID;
        if (!$THIS_MODULE_ID) throw new AfwRuntimeException("reverseByCodes : THIS_MODULE_ID is not defined in module_config file for module $module_code");

        $objByCode = self::loadByMainIndex($module_code);
        if ($objByCode) {
            $objByCodeId = $objByCode->getId();
            if ($objByCodeId != $module_id) throw new AfwRuntimeException("reverseByCodes : module_id is not correct [=$module_id] in module_config file for module $module_code (vs id = $objByCodeId)");
            $objModule = $objByCode;
        } else {
            $objById = null;
            if ($module_id) $objById = self::loadById($module_id);
            if ($objById) {
                $objById_module_code = $objById->getVal("module_code");
                if ($objById_module_code != $module_code) throw new AfwRuntimeException("reverseByCodes : THIS_MODULE_ID [=$THIS_MODULE_ID] in module_config file does'nt much with module code $module_code (this new one is [$objById_module_code])");
                $objModule = $objById;
            }
        }

        if (!$objModule) {
            $objModule = new Module();
            $objModule->set("id", $module_id);
            $objModule->set("module_code", $module_code);
            $objModule->insert();
            $message = "The module $module_code has been created";
        }
        else
        {
            $message = "The module $module_code has been updated";
        }

        include("$file_dir_name/../$module_code/ini.php");

        $objModule->set("titre_short_en", $NOM_SITE["en"]);
        $objModule->set("titre_short", $NOM_SITE["ar"]);
        $objModule->set("id_module_type", 5);
        $objModule->commit();


        return [$objModule, $message];
    }

    public static function loadByCodes($object_code_arr, $create_if_not_exists_with_name = "", $lang = "ar", $rename_if_exists = false)
    {
        if (count($object_code_arr) != 1) die("Module::loadByCodes : only one module_code is needed : object_code_arr=" . var_export($object_code_arr, true));
        $module_code = $object_code_arr[0];
        $obj = self::loadByMainIndex($module_code, $create_if_not_exists_with_name);
        if (($obj->is_new) or $rename_if_exists) {
            if ($lang == "ar") $obj->set("titre_short", $create_if_not_exists_with_name);
            if ($lang == "en") $obj->set("titre_short_en", $create_if_not_exists_with_name);
            $obj->commit();
        }

        return $obj;
    }

    public static function loadById($id)
    {
        $obj = new Module();
        $obj->select_visibilite_horizontale();
        if ($obj->load($id)) {
            return $obj;
        } else return null;
    }

    public function getBusinessManagerJobrole()
    {
        $jr = $this->hetBMJob();
        $parent = $this->hetParent();
        if ((!$jr) and ($parent)) {
            $jr = $parent->getBusinessManagerJobrole();
        }

        return $jr;
    }

    public function getSystemManagerJobrole()
    {
        $jr = $this->hetSMJob();
        $parent = $this->hetParent();
        if ((!$jr) and ($parent)) {
            $jr = $parent->getSystemManagerJobrole();
        }

        return $jr;
    }

    public function getMonitoringManagerJobrole()
    {
        $jr = $this->hetMMJob();
        $parent = $this->hetParent();
        if ((!$jr) and ($parent)) {
            $jr = $parent->getMonitoringManagerJobrole();
        }

        return $jr;
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

        return $fn;
    }

    public function getDisplay($lang = "ar")
    {
        list($typeMod,) = $this->displayAttribute("id_module_type", false, $lang);
        $fn = $this->getShortDisplay($lang);
        $cc = $this->getVal("module_code");
        $return = $typeMod . " : " . $fn;
        if ($cc) $return .= " ($cc)";
        return $return;
    }

    public function getRoleTypeId($path = "", $lang = "ar")
    {
        $role_type_id = -100;

        if ((($this->getVal("id_module_type") == 6) or ($this->getVal("id_module_type") == 8)) and ($this->getVal("id_module_parent") > 0)) {
            if ($this->getParent()->getVal("id_module_type") == 5) {
                $role_type_id = 10; // role/job title
            } else {
                $this_id = $this->getId();
                $parent = $this->getParent();
                if ($parent->getId() != $this_id) list($role_type_id, $path) = $parent->getRoleTypeId($path, $lang);
                else throw new AfwRuntimeException("this module $this (id=$this_id) is parent of it self !!!");
                $role_type_id += 10;
                if ($role_type_id < 0) $role_type_id = -100;
                if ($role_type_id > 40) $role_type_id = -100;
            }

            $path .= "->" . $this->getDisplay($lang);
        } elseif (($this->getVal("id_module_type") == 5) and ($this->getVal("id_module_parent") > 0)) {
            $role_type_id = 10; // role/job title
            $path = ".";
        }
        //else throw new AfwRuntimeException("$this : id_module_type = ".$this->getVal("id_module_type")." id_module_parent = ".$this->getVal("id_module_parent"));

        return array($role_type_id, $path);
    }

    public function getModuleCode()
    {
        return $this->getVal("module_code");
    }

    public function getMyAllTables()
    {
        $lkps = $this->get("lkps");
        $tbls = $this->get("tbs");

        $return = array();
        foreach ($lkps as $lkp_id => $lkpObj) {
            if ($lkpObj->isActive())
                $return[$lkp_id] = $lkpObj;
        }

        foreach ($tbls as $tbl_id => $tblObj) {
            if ($tblObj->isActive())
                $return[$tbl_id] = $tblObj;
        }

        return $return;
    }

    public function getTableByName($tbl_name)
    {
        $all_tbls =  $this->getMyAllTables();
        foreach ($all_tbls as $tbl_id => $tbl_item) {
            if ($tbl_item->getVal("atable_name") == $tbl_name) return $tbl_item;
        }
        return null;
    }

    public function getFormuleResult($attribute, $what='value')
    {
        $objme = AfwSession::getUserConnected();
        switch ($attribute) {

            case "assrole":
                $file_dir_name = dirname(__FILE__);
                
                $id_module_parent = $this->getVal("id_module_parent");
                $role = Arole::getAssociatedRoleForSubModule($id_module_parent, $this);
                $this_id = $this->getId();
                if (!$role) return " "; //throw new AfwRuntimeException("bad returned value for call : Arole::getAssociatedRoleForSubModule($id_module_parent, $this [id=$this_id])");
                else return $role;
                break;

            case "nomcomplet":
                $fn = trim($this->valtitre_short());
                if (!$fn) $fn = trim($this->valtitre());
                if ($this->valStatus() and ($this->valStatus() != 6)  and ($this->valType() != 7)) {
                    //$fn = trim($fn." [" . $this->getStatus()."]");
                }


                return $fn;
                break;
            case "tablecount":
                if ($objme->isSuperAdmin() or AfwSession::hasOption("STATS_COMPUTE"))
                    $fn = $this->getATableCount();
                else
                    $fn = "<img src='../lib/images/fields.png' data-toggle='tooltip' data-placement='top' title='to see tables count please activate the compute stats option'  width='20' heigth='20'>";

                return $fn;
                break;

            case "bfcount":
                if (AfwSession::hasOption("STATS_COMPUTE"))
                    $fn = $this->getBFCount();
                else
                    $fn = "<img src='../lib/images/fields.png' data-toggle='tooltip' data-placement='top' title='to see this count please activate the compute stats option'  width='20' heigth='20'>";

                return $fn;
                break;

            case "ptaskcount":
                if (AfwSession::hasOption("STATS_COMPUTE"))
                    $fn = $this->getPtaskCount();
                else
                    $fn = "<img src='../lib/images/fields.png' data-toggle='tooltip' data-placement='top' title='to see this count please activate the compute stats option'  width='20' heigth='20'>";

                return $fn;
                break;

            case "tome":
                $tbs_return = array();
                $all_tbs = $this->getMyAllTables();
                foreach ($all_tbs as $tb_id => $tb_item) {
                    $tbl_rel_arr = $tb_item->get("tome");
                    foreach ($tbl_rel_arr as $tbl_rel_id => $tbl_rel_item) {
                        $tbs_return[$tbl_rel_id] = $tbl_rel_item;
                    }
                }
                return $tbs_return;
                break;

            case "ext_tome":
                $tbs_return = array();
                $all_tbs = $this->getMyAllTables();
                foreach ($all_tbs as $tb_id => $tb_item) {
                    $tbl_rel_arr = $tb_item->get("ext_tome");
                    foreach ($tbl_rel_arr as $tbl_rel_id => $tbl_rel_item) {
                        $tbs_return[$tbl_rel_id] = $tbl_rel_item;
                    }
                }
                return $tbs_return;
                break;

            case "anst":
                $tbs_return = array();
                $all_tbs = $this->getMyAllTables();
                foreach ($all_tbs as $tb_id => $tb_item) {
                    $tbl_rel_arr = $tb_item->get("anst");
                    foreach ($tbl_rel_arr as $tbl_rel_id => $tbl_rel_item) {
                        $tbs_return[$tbl_rel_id] = $tbl_rel_item;
                    }
                }
                return $tbs_return;
                break;

            case "ext_anst":
                $tbs_return = array();
                $all_tbs = $this->getMyAllTables();
                foreach ($all_tbs as $tb_id => $tb_item) {
                    $tbl_rel_arr = $tb_item->get("ext_anst");
                    foreach ($tbl_rel_arr as $tbl_rel_id => $tbl_rel_item) {
                        $tbs_return[$tbl_rel_id] = $tbl_rel_item;
                    }
                }
                return $tbs_return;
                break;


            case "orgUnitList":

                $orgUnitList = array();
                $allOrgs = $this->getOrgs();
                foreach ($allOrgs as $Orgid => $orgItem) {
                    $orgUnitList[$orgItem->getVal("id_sh")] = $orgItem->get("id_sh");
                }

                return $orgUnitList;
                break;

            case "php_ini":

                $titre_short_en = $this->getVal("titre_short_en");
                $titre_short = $this->getVal("titre_short");

                $php_ini = "   \$NOM_SITE[\"ar\"] = '$titre_short';
   \$NOM_SITE[\"en\"] = '$titre_short_en';
   \$NOM_SITE[\"fr\"] = '$titre_short_en';";

                return $php_ini;
                break;


                /*
                    case "lien_invite" :
                        $url = "http://$URL_RACINE_SITE/inscription.php?codeinvite=$codemembre";
			return $url;
		    break;*/
        }

        return AfwFormulaHelper::calculateFormulaResult($this,$attribute);
    }

    public function getAllRolesAndSubRoles()
    {
        $obj = new Arole();
        $obj->select("module_id",$this->id);
        $obj->select("avail","Y");

        return $obj->loadMany();
    }


    public function calcPhp_modules_all()
    {
        $source_php = "<textarea cols='120' rows='30' style='width:100% !important;direction:ltr;text-align:left'><?php\n"; // ";
        $mod_info = array();

        $moduleList = $this->getAllModulesByTypesAndStatuses(
            [self::$MODULE_TYPE_APPLICATION, self::$MODULE_TYPE_MINI_APPLICATION,],
            [self::$MODULE_STATUS_IN_PRODUCTION, self::$MODULE_STATUS_TEST_ONGOING,]
        );
        foreach ($moduleList as $moduleItem) {
            $moduleId = $moduleItem->id;
            $moduleCode = $moduleItem->getVal("module_code");
            $moduleType = $moduleItem->getVal("id_module_type");
            $moduleSysId = $moduleItem->getVal("id_system");

            $mod_info_item = array();
            $mod_info_item['id'] = $moduleId;
            $mod_info_item['system_id'] = $moduleSysId;

            $mod_info[$moduleCode] = $mod_info_item;

            $mod_info['m' . $moduleId] = array('code' => $moduleCode, 'type' => $moduleType);
        }
        $source_php .= "\n\t\$mod_info = " . var_export($mod_info, true) . ";";

        $source_php .= "\n ?></textarea>"; // 

        return $source_php;
    }


    public function calcPhp_module($textArea=true)
    {
        global $MODE_BATCH_LOURD, $MODE_SQL_PROCESS_LOURD;

        $MODE_BATCH_LOURD = true;
        $MODE_SQL_PROCESS_LOURD = true;
        $source_php = "";
        if($textArea) $source_php .= "<textarea cols='120' rows='30' style='width:100% !important;direction:ltr;text-align:left'>";
        $source_php .= "<?php\n"; // ";
        $tab_info = array();
        $tbf_info = array();
        $role_info = array();
        $moduleCode = $this->getVal("module_code");

        $afw_modes_arr = ['display', 'search', 'qsearch', 'edit', 'qedit', 'crossed', 'stats', 'ddb', 'minibox', 'delete'];

        $tableList = $this->getAllMyTables();
        foreach ($tableList as $tableItem) {
            $tableId = $tableItem->id;
            $tableName = $tableItem->getVal("atable_name");

            $tab_info[$tableId] = array('name' => $tableName);

            $tbf_info_item = array();
            $tbf_info_item["id"] = $tableId;
            foreach ($afw_modes_arr as $afw_mode) {
                $bf_id = UmsManager::getBunctionIdForOperationOnTable($moduleCode, $tableName, $afw_mode,null,true);
                $tbf_info_item[$afw_mode] = array('id' => $bf_id);
            }

            $tbf_info[$tableName] = $tbf_info_item;
        }

        $roleList = $this->getAllRolesAndSubRoles();
        foreach ($roleList as $roleItem) 
        {
            $roleId = $roleItem->id;
            
            $roleMenu = $roleItem->getRoleMenu();

            $role_info[$roleId] = [
                                    'name' => ["ar"=>$roleItem->getShortDisplay("ar"), 
                                              "en"=>$roleItem->getShortDisplay("en"),],
                                    'menu' => $roleMenu

                                ];
        }
        
        $source_php .= "\n\t\$tab_info = " . var_export($tab_info, true) . ";";
        $source_php .= "\n\t\$tbf_info = " . var_export($tbf_info, true) . ";";
        $source_php .= "\n\t\$role_info = " . var_export($role_info, true) . ";";

        $source_php .= "\n ?>";
        if($textArea) $source_php .= "</textarea>"; // 

        return $source_php;
    }

    public function getMyRelationTables($to_ext = true, $from_ext = true, $to_int = true, $from_int = true)
    {
        $all_rel_tables = array();
        if ($to_ext) $all_rel_tables = AfwStringHelper::hzm_array_merge($all_rel_tables, AfwStringHelper::hzm_array_merge($all_rel_tables, $this->get("ext_anst")));
        if ($from_ext) $all_rel_tables = AfwStringHelper::hzm_array_merge($all_rel_tables, AfwStringHelper::hzm_array_merge($all_rel_tables, $this->get("ext_tome")));
        if ($to_int) $all_rel_tables = AfwStringHelper::hzm_array_merge($all_rel_tables, AfwStringHelper::hzm_array_merge($all_rel_tables, $this->get("anst")));
        if ($from_int) $all_rel_tables = AfwStringHelper::hzm_array_merge($all_rel_tables, AfwStringHelper::hzm_array_merge($all_rel_tables, $this->get("tome")));

        return $all_rel_tables;
    }

    public function getRelationWithTable($tbl_id)
    {
        $all_rel_tables = $this->getMyRelationTables($to_ext = true, $from_ext = true, $to_int = true, $from_int = true);
        // die("$this getRelationWithTable($tbl_id) first get all = ".var_export($all_rel_tables,true));
        return $all_rel_tables[$tbl_id];
    }

    protected function getOtherLinksArray($mode, $genereLog = false, $step="all")
    {
        global $lang;
        $displ = $this->getDisplay($lang);

        // 4  مشروع
        // 7  مجموعة أنظمة             
        // 5  نظام
        // 8 تطبيق
        // 6  وحدة
        $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
        if (($mode == "mode_applications") and ($this->isSystem())) {
            unset($link);
            $parent_mod_id = $this->getId();
            $id_system = $this->getId();
            $link = array();
            $title = "تقسيم  النظام  إلى تطبيقات ";
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Module&currmod=ums&module_origin=ums&class_origin=Module&id_origin=$parent_mod_id&newo=3&limit=30&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_module_parent=$parent_mod_id,id_module_type=5,id_system=$id_system&sel_id_module_parent=$parent_mod_id&sel_id_system=$id_system&sel_id_module_type=5";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }
        /*
        if (($mode == "mode_applicationGoalList") or ($mode == "mode_goals_def")) {
            unset($link);
            $my_id = $this->getId();
            $link = array();
            $title = "إدارة الأهداف ";
            $title_detailed = $title . "لـ : " . $displ;
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Goal&currmod=b au&id_origin=$my_id&class_origin=Module&module_origin=ums&newo=-1&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=module_id=$my_id&sel_module_id=$my_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }*/


        if (($mode == "mode_aroles") or ($mode == "mode_allRoles")) {
            if ($this->isApplication()) {
                unset($link);
                $mod_id = $this->getId();
                $link = array();
                $title = "إدارة صلاحيات التطبيق";
                $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Arole&currmod=ums&module_origin=ums&class_origin=Module&id_origin=$mod_id&newo=3&limit=100&ids=all&fixmtit=$title&fixmdisable=1&module_id=$mod_id&sel_module_id=$mod_id";
                $link["TITLE"] = $title;
                $link["UGROUPS"] = array();
                $otherLinksArray[] = $link;
            }
        }

        if (($mode == "mode_tbs") and ($this->isApplication())) {
            $mod_id = $this->getId();
            /*
            $link = array();
            $title = "إدارة جداول التطبيق : " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Atable&currmod=p ag&module_origin=ums&class_origin=Module&id_origin=$mod_id&newo=3&limit=200&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_module=$mod_id,is_lookup=N,is_entity=Y&sel_id_module=$mod_id&sel_is_lookup=N&sel_is_entity=Y";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;

            unset($link);
            $link = array();
            $title = "إنشاء جدول جديد في : " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=Atable&currmod=p ag&sel_id_module=$mod_id&sel_is_lookup=N&sel_is_entity=Y";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;

            unset($link);
            $link = array();
            $mod_id = $this->getId();
            $title = "إدارة الصلاحيات على جداول التطبيق : " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Atable&currmod=p ag&module_origin=ums&class_origin=Module&id_origin=$mod_id&newo=3&limit=200&ids=all&submode=FGROUP&fgroup=roles_def&fixmtit=$title&fixmdisable=1&fixm=id_module=$mod_id,is_lookup=N,is_entity=Y&sel_id_module=$mod_id&sel_is_lookup=N";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;*/
        }
        /*
        if (($mode == "mode_tbs") and ($this->isModule())) {
            
            $link = array();
            $mod_id = $this->getVal("id_module_parent");
            $smod_id = $this->getId();
            $title = "إدارة جداول الوحدة : " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Atable&currmod=p ag&module_origin=ums&class_origin=Module&id_origin=$smod_id&newo=3&limit=50&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_module=$mod_id,id_sub_module=$smod_id&sel_id_module=$mod_id&sel_id_sub_module=$smod_id";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;

            $link = array();
            $mod_id = $this->getVal("id_module_parent");
            $smod_id = $this->getId();
            $title = "إدارة الصلاحيات على جداول الوحدة : " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Atable&currmod=p ag&module_origin=ums&class_origin=Module&id_origin=$smod_id&newo=3&limit=50&ids=all&submode=FGROUP&fgroup=roles_def&fixmtit=$title&fixmdisable=1&fixm=id_module=$mod_id,id_sub_module=$smod_id,is_lookup=N,is_entity=Y&sel_id_module=$mod_id&sel_id_sub_module=$smod_id&sel_is_lookup=N&sel_is_entity=Y";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if (($mode == "mode_lkps") and $this->isApplication()) {

            $link = array();
            $mod_id = $this->getId();
            $title = "إدارة القوائم الثابتة لتطبيق : " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Atable&currmod=p ag&module_origin=ums&class_origin=Module&id_origin=$mod_id&newo=3&limit=200&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_module=$mod_id,is_lookup=Y,is_entity=N&sel_id_module=$mod_id&sel_is_lookup=Y&sel_is_entity=N";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;

            $link = array();
            $mod_id = $this->getId();
            $title = "إدارة قوائم الاختيارات لتطبيق : " . $this->valTitre_short();
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Atable&currmod=p ag&module_origin=ums&class_origin=Module&id_origin=$mod_id&newo=3&limit=200&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_module=$mod_id,is_lookup=Y,is_entity=Y&sel_id_module=$mod_id&sel_is_lookup=Y&sel_is_entity=Y";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }
        */
        if (($mode == "mode_smd") and ($this->isModule() or $this->isApplication())) {
            unset($link);
            $parent_mod_id = $this->getId();
            $id_system = $this->getVal("id_system");
            $link = array();
            $title = "التقسيم إلى وحدات فرعية";
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Module&currmod=ums&module_origin=ums&class_origin=Module&id_origin=$parent_mod_id&newo=3&limit=30&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_module_parent=$parent_mod_id,id_module_type=6,id_system=$id_system&sel_id_module_parent=$parent_mod_id&sel_id_system=$id_system&sel_id_module_type=6";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }


        if (($mode == "mode_mybfs") and $this->isApplication()) {
            unset($link);
            $parent_mod_id = $this->getId();
            $id_system = $this->getVal("id_system");

            $link = array();

            $title = "إنشاء وظيفة نظام";
            $link["COLOR"] = "blue";
            $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Bfunction&currmod=ums&module_origin=ums&class_origin=Module&id_origin=$parent_mod_id&newo=3&fixmtit=$title&fixmdisable=1&fixm=curr_class_module_id=$parent_mod_id,id_system=$id_system&sel_curr_class_module_id=$parent_mod_id&sel_id_system=$id_system";
            $link["TITLE"] = $title;
            $link["UGROUPS"] = array();
            $otherLinksArray[] = $link;
        }

        if (true) {
            if (true) {
                if (true) // يوجد على الأقل جدول حقيقي
                {
                    if (true)  // intval($this->getVal("tablecount")) >0 => obsolete car  il y a aussi les BF les sous modules relations etc ..
                    {
                        $link = array();
                        $link["URL"] = "main.php?Main_Page=genere_datadic.php&mod_id=" . $this->getId();
                        $link["TITLE"] = "توليد قاموس البيانات لنظام " . $this->getDisplay();
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                    }

                    if ($this->isApplication()) {
                        $link = array();
                        $link["URL"] = "dbgen.php?sql=1&show_sql=1&mod=" . $this->getId();
                        $link["TITLE"] = "توليد هيكل قاعدة بيانات " . $this->getDisplay();
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        unset($link);
                        $link = array();
                        $link["URL"] = "dbgen.php?php=1&mod=" . $this->getId();
                        $link["TITLE"] = "توليد برمجة " . $this->getDisplay();
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        unset($link);
                        $link = array();
                        $link["URL"] = "dbgen.php?sln=jdl&show_res=1&ign=0&mod=" . $this->getId();
                        $link["TITLE"] = "توليد نموذج أقسام " . $this->getDisplay();
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        unset($link);
                        $link = array();
                        $link["URL"] = "dbgen.php?trad=1&mod=" . $this->getId();
                        $link["TITLE"] = "توليد  ملفات ترجمة حقول " . $this->getDisplay();
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        unset($link);
                        $link = array();
                        $link["URL"] = "dbgen.php?lookup=1&mod=" . $this->getId();
                        $link["TITLE"] = "توليد ترجمة قائمة الاختيارات " . $this->getDisplay();
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                        /*
                        unset($link);
                        $my_id = $this->getId();
                        $link = array();
                        $title = "إدارة قصص المستخدم ";
                        $title_detailed = $title . "لـ : " . $displ;
                        $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=UserStory&currmod=b au&id_origin=$my_id&class_origin=Module&module_origin=ums&newo=-1&limit=60&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=module_id=$my_id&sel_module_id=$my_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;*/

                        unset($link);
                        $parent_mod_id = $this->getId();
                        $id_system = $this->getVal("id_system");
                        $link = array();
                        $title = "تقسيم التطبيق إلى وحدات جزئية ";
                        $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Module&currmod=ums&module_origin=ums&class_origin=Module&id_origin=$parent_mod_id&newo=3&limit=30&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_module_parent=$parent_mod_id,id_module_type=6,id_system=$id_system&sel_id_module_parent=$parent_mod_id&sel_id_system=$id_system&sel_id_module_type=6";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;

                        unset($link);
                        $mod_id = $this->getId();
                        $link = array();
                        $title = "تحرير أصحاب الصلاحية على هذا التطبيق";
                        $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=ModuleAuser&currmod=ums&module_origin=ums&class_origin=Module&id_origin=$mod_id&newo=3&limit=90&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_module=$mod_id&sel_id_module=$mod_id";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                    }



                    unset($link);
                    $mod_id = $this->getId();
                    $link = array();
                    $title = "إدارة وظائف النظام";
                    $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Bfunction&currmod=ums&module_origin=ums&class_origin=Module&id_origin=$mod_id&newo=3&limit=100&ids=all&fixmtit=$title&fixmdisable=1&fixm=curr_class_module_id=$mod_id&sel_curr_class_module_id=$mod_id";
                    $link["TITLE"] = $title;
                    $link["UGROUPS"] = array();
                    $otherLinksArray[] = $link;

                    /*
                    unset($link);
                    $mod_id = $this->getId();
                    $link = array();
                    $title = "إدارة المهمات";
                    $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Ptask&currmod=p ag&module_origin=ums&class_origin=Module&id_origin=$mod_id&newo=3&limit=100&ids=all&fixmtit=$title&fixmdisable=1&fixm=module_id=$mod_id&sel_module_id=$mod_id";
                    $link["TITLE"] = $title;
                    $link["UGROUPS"] = array();
                    $otherLinksArray[] = $link;*/
                }
            }
            // die("je suis la, id_module_type='".$this->getVal("id_module_type")."'");


            if (($this->getVal("id_module_type") == 6) or
                ($this->getVal("id_module_type") == 8)
            ) {

                $smod_id = $this->getId();

                $link = array();
                $link["URL"] = "dbgen.php?sql=1&smod=$smod_id&mod=$mod_id";
                $link["TITLE"] = "هيكل قاعدة بيانات : " . $this->getDisplay();
                $link["UGROUPS"] = array();
                $otherLinksArray[] = $link;

                unset($link);
                $link = array();
                $link["URL"] = "dbgen.php?php=1&smod=$smod_id&mod=$mod_id";
                $link["TITLE"] = "برمجة : " . $this->getDisplay();
                $link["UGROUPS"] = array();
                $otherLinksArray[] = $link;

                unset($link);
                $link = array();
                $link["URL"] = "dbgen.php?trad=1&smod=$smod_id&mod=$mod_id";
                $link["TITLE"] = "ترجمة حقول " . $this->getDisplay();
                $link["UGROUPS"] = array();
                $otherLinksArray[] = $link;

                /*
                   unset($link);
                   $link = array();
                   $link["URL"] = "main.php?Main_Page=copytable.php&tab=".$this->getId();
                   $link["TITLE"] = "نسخ  الجدول ". $this->valTitre_short(); 
                   $link["UGROUPS"] = array();
                   $otherLinksArray[] = $link;
                   
                   $link = array();
                   $link["URL"] = "dbgen.php?sql=1&tbl=".$this->getId();
                   $link["TITLE"] = "SQL of ". $this->valTitre_short(); 
                   $link["UGROUPS"] = array();
                   $otherLinksArray[] = $link;
                   
                   unset($link);
                   $link = array();
                   $link["URL"] = "dbgen.php?php=1&tbl=".$this->getId();
                   $link["TITLE"] = "PHP of ". $this->valTitre_short(); 
                   $link["UGROUPS"] = array();
                   $otherLinksArray[] = $link;
                   
                   unset($link);
                   $link = array();
                   $link["URL"] = "dbgen.php?trad=1&tbn=".$this->getVal("atable_name");
                   $link["TITLE"] = "Field translations of ". $this->valTitre_short(); 
                   $link["UGROUPS"] = array();
                   $otherLinksArray[] = $link; */
            }
            /* obsolete
                 $link = array();
                 $mod_id = $this->getId();
                 $title = "إعادة انشاء قائمة الخدمات لنظام/تطبيق : ". $this->valTitre_short();
                 $link["URL"] = "main.php?Main_Page=gen_module_roles.php&My_Module=ums&mod=$mod_id&framework=1";
                 $link["TITLE"] = $title; 
                 $link["UGROUPS"] = array();
                 $otherLinksArray[] = $link;
                 */
        }
        return $otherLinksArray;
    }

    public function select_visibilite_horizontale($dropdown = false)
    {
        $this->select_visibilite_horizontale_default();
    }



    public function getBFCount()
    {
        $file_dir_name = dirname(__FILE__);
        

        $bf = new Bfunction();

        $mod_id = $this->getId();

        if (($mod_id) and (intval($mod_id) > 0)) {
            $bf->select("curr_class_module_id", $mod_id);
            $bf->select("avail", 'Y');
            return $bf->count();
        } else return 0;
    }

    public function getPtaskCount()
    {
        $file_dir_name = dirname(__FILE__);
        

        $ptsk = new Ptask();

        $mod_id = $this->getId();

        if (($mod_id) and (intval($mod_id) > 0)) {
            $ptsk->where("(module_id = $mod_id or project_module_id = $mod_id)");
            $ptsk->select("avail", 'Y');
            return $ptsk->count();
        } else return 0;
    }



    public function getAllMyTables($only_entities=false)
    {
        $file_dir_name = dirname(__FILE__);
        if(file_exists($file_dir_name.'/../../pag/index.php'))
        {
            AfwAutoLoader::addModule("p"."ag");
            $at = new Atable();

            $mod_id = $this->getId();

            if (($mod_id) and (intval($mod_id) > 0)) 
            {
                $at->where("(id_sub_module = '$mod_id' or id_module = '$mod_id')");
                $at->select("avail", 'Y');
                if($only_entities) $at->select("is_lookup", 'N');
                return $at->loadMany();
            } 
        }
        
        return array();
    }




    public function getATableCount($only_reel = true)
    {
        $file_dir_name = dirname(__FILE__);
        

        $at = new Atable();

        $mod_id = $this->getId();

        if (($mod_id) and (intval($mod_id) > 0)) {
            $at->where("(id_module=$mod_id or id_sub_module=$mod_id)");
            $at->select("avail", 'Y');
            return $at->count();
        } else return 0;
    }

    public function beforeInsert($id, $fields_updated)
    {
        return $this->beforeMAJ($id, $fields_updated);
    }

    public function beforeUpdate($id, $fields_updated)
    {
        return $this->beforeMAJ($id, $fields_updated);
    }


    public function beforeMAJ($id, $fields_updated)
    {
        if (!$this->getVal("titre")) {
            $this->set("titre", $this->getVal("titre_short"));
        }

        if (!$this->getVal("titre_short")) {
            $this->set("titre_short", $this->getVal("titre"));
        }
        //die(var_export($this,true));
        return true;
    }

    public function afterInsert($id, $fields_updated)
    {
        // create goals for this application and for the standard IT Jobs
        $this->genereITJobsAndGoals();
    }


    // create goals for this application and for the standard IT Jobs

    public function genereITJobsAndGoals($lang = "ar")
    {
        $info = "";

        if ($this->isApplication()) {
            list($jr1, $go1) = $this->getLookupJobResp(true, true);
            list($jr2, $go2) = $this->getDataJobResp(true, true);
        }

        if ($jr1) $info .= $jr1->translateMessage("created", $lang) . " " . $jr1->getDisplay($lang);
        if ($go1) $info .= $go1->translateMessage("created", $lang) . " " . $go1->getDisplay($lang);

        if ($jr2) $info .= $jr2->translateMessage("created", $lang) . " " . $jr2->getDisplay($lang);
        if ($go2) $info .= $go2->translateMessage("created", $lang) . " " . $go2->getDisplay($lang);

        return array("", $info);
    }


    public static function getSystemList($done = false)
    {
        if ($done) $sql_not = "not";
        else $sql_not = "";

        $system = new Module();
        $system->where("avail='Y' and id_module_type in (4,7) /* and id_module_status $sql_not in (1,2) */");
        return $system->loadMany();
    }

    public static function getModuleByCode($id_sh, $code_mod)
    {
        // $id_sh is obsolete

        global $cacheSys;
        if ($cacheSys) {
            $system = $cacheSys->getFromCache("ums", "module", $code_mod, $context = "module::getModuleByCode($id_sh, $code_mod)");
        } else $system = null;
        if (!$system) {

            $system = new Module();
            $system->select("module_code", $code_mod);
            if (!$system->load()) {
                $system = null;
            } else {
                if($cacheSys) $cacheSys->putIntoCache("ums", "module", $system, $code_mod, $context = "module::getModuleByCode($id_sh, $code_mod)");
            }
        }

        return $system;
    }


    public function genereATableDefaultFields($lang = "ar")
    {

        $mod_id = $this->getId();
        if (($mod_id) and (intval($mod_id) > 0)) {
            $file_dir_name = dirname(__FILE__);
            

            $at = new Atable();

            $at->where("(id_module=$mod_id or id_sub_module=$mod_id)");
            $at->select("avail", 'Y');
            $at_list = $at->loadMany();

            foreach ($at_list as $at_id => $at_item) {
                $at_item->createDefaultFields($lang);
            }

            return array("", "");
        } else return array("this is empty module (no ID found)", "");
    }

    
    public function genereWebServicesBFs($lang = "ar")
    {

        $this->genereWebServices();

        return array("", "");
    }

    public function genereWebServices()
    {

        $mod_id = $this->getId();
        $module = $this->getVal("module_code");

        $file_dir_name = dirname(__FILE__);

        


        $dblnk  = new DbLink();
        $dblnk->select_visibilite_horizontale();
        $dblnk->where("id_module_parent = $mod_id or mod1_id = $mod_id");
        $liste_dblnk       = $dblnk->loadMany();

        $first_dblnk = null;

        foreach ($liste_dblnk as $id_dblnk => $item_dblnk) {
            $liste_dblnk[$id_dblnk]->getBFSolution();

            if (!$first_dblnk) $first_dblnk = $liste_dblnk[$id_dblnk];
        }


        return array($first_dblnk, $liste_dblnk);
    }

    public function genereTasks($lang = "ar")
    {

        $this->genereMyTasks(true);

        return array("", "");
    }

    public function genereMyTasks($childs = false, $level = 2)
    {
        $project_module_id = $this->getVal("id_module_parent");
        $module_id = $this->getId();
        $module_code = $this->getVal("module_code");
        $module_name_en = $this->getVal("module_code");
        $module_name_ar = $this->getVal("titre_short");

        $file_dir_name = dirname(__FILE__);

        

        $ptsk_list = array();


        $ptsk = new Ptask();
        $ptsk_fld_ACTIVE = $ptsk->fld_ACTIVE();
        $ptsk->select($ptsk_fld_ACTIVE, 'Y');
        $ptsk->select("module_id", $module_id);
        $ptsk->where("ptask_code like 'hzm-$module_code-%'");
        $ptsk->set($ptsk_fld_ACTIVE, 'N');
        $ptsk->update(false);

        $module_complexity = 1;

        //@todo
        $coef_work_hours["requirements-analysis"] = 0.004;
        $coef_work_hours["application-design"] = 0.0055;

        //	Requirements collection	جمع المتطلبات
        $ptsk0 = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-requirements-collection", $name_en = "Requirements collection - $module_name_en", $name_ar = "جمع المتطلبات - $module_name_ar", $priority = 10, $description_en = "Requirements collection", $description_ar = "جمع المتطلبات", 0, true);
        $ptsk_list[$ptsk0->getId()] = $ptsk0;

        // 

        // select sum(length(ntext)) as requirements_length from ptext where module_id = $module_id

        //@todo
        $requirements_length = 9000;

        //	Requirements analysis	تحليل المتطلبات
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-requirements-analysis", $name_en = "Requirements analysis - $module_name_en", $name_ar = "تحليل المتطلبات - $module_name_ar", $priority = 10, $description_en = "Requirements analysis", $description_ar = "تحليل المتطلبات", $module_complexity * $requirements_length * $coef_work_hours["requirements-analysis"], true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //@todo
        $analysis_length = 12000;

        //	application design (data model)	تصميم التطبيق (نموذج البيانات)
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-application-design", $name_en = "application design (data and class model) - $module_name_en", $name_ar = "تصميم قاعدة البيانات - $module_name_ar", $priority = 10, $description_en = "application design (data model)", $description_ar = "تصميم التطبيق (نموذج البيانات)", $module_complexity * $analysis_length * $coef_work_hours["application-design"], true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	development audit of module	تدقيق تطويرالوحدة
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-development-audit", $name_en = "development audit - $module_name_en", $name_ar = "تدقيق تطوير - $module_name_ar", $priority = 8, $description_en = "development audit", $description_ar = "تدقيق تطوير", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	development followup of module	متابعة تطوير تطويرالوحدة
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-development-followup", $name_en = "development followup - $module_name_en", $name_ar = "متابعة تطوير - $module_name_ar", $priority = 9, $description_en = "development followup", $description_ar = "متابعة تطوير", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Create database of module	انشاء قاعدة البيانات ل......
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-create-database", $name_en = "Create database - $module_name_en", $name_ar = "انشاء قاعدة البيانات - $module_name_ar", $priority = 10, $description_en = "Create database", $description_ar = "انشاء قاعدة البيانات", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	 SSO integration	توحيد تسجيل الدخول - دمج
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-sso-integration", $name_en = "SSO integration - $module_name_en", $name_ar = "توحيد تسجيل الدخول - دمج - $module_name_ar", $priority = 10, $description_en = "SSO integration", $description_ar = "توحيد تسجيل الدخول - دمج", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Entity Classes Generation and Test	توليد أقسام كيانات العمل وتجربتها
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-entity-classes-generation-and-test", $name_en = "Entity Classes Generation and Test - $module_name_en", $name_ar = "توليد أقسام كيانات العمل وتجربتها - $module_name_ar", $priority = 10, $description_en = "Entity Classes Generation and Test", $description_ar = "توليد أقسام كيانات العمل وتجربتها", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Home: Design	تصميم الشاشة الرئيسية
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-home-design", $name_en = "Home: Design - $module_name_en", $name_ar = "تصميم الشاشة الرئيسية - $module_name_ar", $priority = 9, $description_en = "Home: Design", $description_ar = "تصميم الشاشة الرئيسية", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Home: Content	محتوى الشاشة الرئيسية
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-home-content", $name_en = "Home: Content - $module_name_en", $name_ar = "محتوى الشاشة الرئيسي - $module_name_ar", $priority = 8, $description_en = "Home: Content", $description_ar = "محتوى الشاشة الرئيسي", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Integration with the rest of modules	دمج  مع بقية الوحدات
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-integration-with-rest", $name_en = "Integration with the rest of modules - $module_name_en", $name_ar = " - $module_name_ar", $priority = 4, $description_en = "Integration with the rest of modules", $description_ar = "", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Sprints definition	تعريف الدفعات
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-sprints-def", $name_en = "Sprints definition - $module_name_en", $name_ar = "تعريف الدفعات - $module_name_ar", $priority = 9, $description_en = "Sprints definition", $description_ar = "تعريف الدفعات", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Prepare test environment	تحضير بيئة الإختبار
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-prepare-test-env", $name_en = "Prepare test environment - $module_name_en", $name_ar = "تحضير بيئة الإختبار - $module_name_ar", $priority = 4, $description_en = "Prepare test environment", $description_ar = "تحضير بيئة الإختبار", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Prepare production environment	تحضير البيئة الفعلية
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-prepare-prod-env", $name_en = "Prepare production environment - $module_name_en", $name_ar = "تحضير البيئة الفعلية - $module_name_ar", $priority = 3, $description_en = "Prepare production environment", $description_ar = "تحضير البيئة الفعلية", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Create test plans	إنشاء خطط الإختبار
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-create-test-plans", $name_en = "Create test plans - $module_name_en", $name_ar = "إنشاء خطط الإختبار - $module_name_ar", $priority = 3, $description_en = "Create test plans", $description_ar = "إنشاء خطط الإختبار", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        //	Test global system	إختبار كلي للنظام
        unset($ptski);
        $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-global-test", $name_en = "Test global system - $module_name_en", $name_ar = "إختبار كلي للنظام - $module_name_ar", $priority = 2, $description_en = "Test global system", $description_ar = "إختبار كلي للنظام", 0, true);
        $ptsk_list[$ptski->getId()] = $ptski;

        /*
                unset($ptsk);
                $ptsk = new Ptask();
                $ptsk_fld_ACTIVE = $ptsk->fld_ACTIVE();
                
                $ptsk->select($ptsk_fld_ACTIVE,'Y');
                $ptsk->select("module_id",$module_id);
                $ptsk->where("ptask_code like 'hzm-bf-%'");
                $ptsk->set($ptsk_fld_ACTIVE,'N');
                $ptsk->update(false);*/

        
        $bf = new Bfunction();
        $bf_fld_ACTIVE = $bf->fld_ACTIVE();
        $bf->select($bf_fld_ACTIVE, 'Y');
        $bf->select("curr_class_module_id", $module_id);

        $bf_list = $bf->loadMany();

        foreach ($bf_list as $bf_id => $bf_item) {
            $bf_prio = round($bf_item->getVal("bf_priority") / 10.0);
            $bf_complexity = $bf_item->getVal("bf_complexity");

            $bf_item_type = $bf_item->get("bfunction_type_id");

            $bf_item_type_en = $bf_item_type->getVal("bfunction_type_code");
            if (!$bf_item_type_en) $bf_item_type_en = "B.F";
            $bf_item_type_ar = $bf_item_type->getVal("titre_short");
            if (!$bf_item_type_ar) $bf_item_type_ar = "خدمة عملية";


            $bf_code = $bf_item->valBfunction_code();
            if (!$bf_code) $bf_code = "bf" . $bf_id;
            $bf_name_ar = $bf_item->valTitre_short();
            if ($bf_item->valBfunction_code()) $bf_name_en = "[" . $bf_item->valBfunction_code() . "]";
            else $bf_name_en = "[EN bf name not defined]";

            if (!AfwStringHelper::stringStartsWith($bf_code, "crud-")) {
                $specification_complexity = 10;
                $development_complexity = 180;
                $test_complexity = 60;

                //	Specification of BF	كتابة مواصفات bf
                unset($ptski);
                $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-bf-spec-$bf_code", $name_en = "Specification of $bf_item_type_en - $bf_name_en", $name_ar = "كتابة مواصفات $bf_item_type_ar - $bf_name_ar", $priority = $bf_prio, $description_en = "Specification of BF", $description_ar = "كتابة مواصفات", round($specification_complexity * $bf_complexity), true);
                $ptsk_list[$ptski->getId()] = $ptski;

                //	development of bf	تطوير bf
                unset($ptski);
                $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-bf-dev-$bf_code", $name_en = "Development of $bf_item_type_en - $bf_name_en", $name_ar = "تطوير $bf_item_type_ar - $bf_name_ar", $priority = $bf_prio, $description_en = "Development of bf", $description_ar = "تطوير خدمة عملية", round($development_complexity * $bf_complexity), true);
                $ptsk_list[$ptski->getId()] = $ptski;
            }
            //	Test of bf	إختبار bf
            unset($ptski);
            $ptski = Ptask::getPtask($project_module_id, $module_id, $ptask_code = "hzm-$module_code-bf-test-$bf_code", $name_en = "Test of $bf_item_type_en - $bf_name_en", $name_ar = "إختبار $bf_item_type_ar - $bf_name_ar", $priority = $bf_prio, $description_en = "Test of bf", $description_ar = "إختبار خدمة عملية", round($test_complexity * $bf_complexity), true);
            $ptsk_list[$ptski->getId()] = $ptski;
        }
        /*
                if($childs and $level>0)
                {
                        $md = new Module();
                        $md_fld_ACTIVE = $md->fld_ACTIVE();
                        $md->select($md_fld_ACTIVE,'Y');
                        $md->select("id_module_parent",$module_id);
                        $md->where("id != $module_id");
                       
                        $md_list = $md->loadMany();
                       
                        foreach($md_list as $md_id => $md_item)
                        {
                             $md_item->genereMyTasks(true, $level-1);
                        }
                }
                */


        //	Sprint deployment	تسليم دفعة
        // Ptask::getPtask($project_module_id,$module_id,$ptask_code="hzm-$module_code-", $name_en=" - $module_name_en", $name_ar=" - $module_name_ar", $priority=1, $description_en="", $description_ar="", 0, true);


        return array($ptsk0, $ptsk_list);
    }

    /*
       public function createUpdateMyRole($lang="ar")
       {
            $my_id = $this->getId();
            $application = $this->getParentApplication();
            $application_code = $application->getVal("module_code");
            $role_code =  "$application_code-module-$my_id";
            $titre_short = $this->getVal("titre_short");
            $titre_short_en = $this->getVal("titre_short_en");
            if(!$titre_short_en) $titre_short_en = AfwStringHelper::toEnglishText($role_code);
            
            $titre = $this->getVal("titre");
            $titre_en = $this->getVal("titre_en");
            
            list($arole_type_id, $path) = $this->getRoleTypeId("",$lang);
            
            if($arole_type_id<0) return array("Failed : the module $this(id=$my_id) has no role type : $path","");
            global $file_dir_name;
            
            list($new_role, $arole) = Arole::findOrCreateArole($my_id,$role_code,$titre_short,$titre_short_en,$titre,$titre_en,$arole_type_id);
       
            return array("","");
       }  */



    // same type same system (same parent optional)
    public function getBrothers($same_parent = true)
    {
        $id_module_parent = $this->getVal("id_module_parent");
        $id_system = $this->getVal("id_system");
        $id_module_type = $this->getVal("id_module_type");

        $this->select("id_system", $id_system);
        $this->select("id_module_type", $id_module_type);
        if ($same_parent) $this->select("id_module_parent", $id_module_parent);

        return $this->loadMany();
    }


    public function mergeTablesToApplication($paramsArr, $lang = "ar")
    {
        $brotherModuleId = $paramsArr["module_id"];
        if (!$brotherModuleId) return array("please specify the brother module id", "");

        $file_dir_name = dirname(__FILE__);
        

        $at = new Atable();

        $mod_id = $this->getId();
        $ret = 0;
        if (($mod_id) and (intval($mod_id) > 0)) {
            $at->select("id_module", $mod_id);
            $at->set("id_module", $brotherModuleId);
            $ret = $at->update(false);


            $at->select("id_sub_module", $mod_id);
            $at->set("id_sub_module", $brotherModuleId);
            $ret2 = $at->update(false);

            $ret += $ret2;
        }

        return array("", "$ret tables migrated to new module (ID=$brotherModuleId)");
    }


    protected function getPublicMethods()
    {

        $pbms = array();
        $this_id = $this->getId();
        /*
            if($this->isModule())
            {
                    $color = "red";
                    $title_ar = "إنشاء/تحديث مجلد الصلاحية"; 
                    $pbms["1ac55M"] = array("METHOD"=>"createUpdateMyRole","COLOR"=>$color, "LABEL_AR"=>$title_ar);
            }
            */
        if ($this->isSystem()) {
            $color = "yellow";
            $title_ar = "توليد  المهمات";
            $pbms["12a35N"] = array("METHOD" => "genereTasks", "COLOR" => $color, "LABEL_AR" => $title_ar);
        }
        /*
            $color = "yellow";
            $title_ar = "توليد مجموعة الوظائف الخاصة بي"; 
            $pbms["1N2bY5"] = array("METHOD"=>"genereMyAssociatedRole","COLOR"=>$color, "LABEL_AR"=>$title_ar);
            */
        if ($this->isSystem() or $this->isApplication()) {
            $color = "blue";
            $title_ar = "توليد جميع الحقول المبدئية لجميع الجداول لهذه الوحدة";
            $pbms["xc123B"] = array("METHOD" => "genereATableDefaultFields", "COLOR" => $color, "LABEL_AR" => $title_ar);
        }

        /*
            
            rafik : not ready because the UMS final is not ready
            
            $color = "green";
            $title_ar = "ترحيل بيانات الوحدة إلى نظام المستخدمين والصلاحيات";
            $pbms["5ZXGc1"] = array("METHOD"=>"exportToUAMS","COLOR"=>$color, "LABEL_AR"=>$title_ar);
            */

        if ($this->isApplication()) {
            $brotherAppList = $this->getBrothers();
            foreach ($brotherAppList as $brotherAppItem) {
                if ($brotherAppItem->id != $this->id) {
                    $color = "red";
                    $title_ar = "دمج الجداول مع " . $brotherAppItem->getDisplay("ar");
                    $title_en = "merge tables with " . $brotherAppItem->getDisplay("en");
                    $pbms[$brotherAppItem->myHzmCode("brotherOf" . $this_id)] = array(
                        "METHOD" => "mergeTablesToApplication", "COLOR" => $color, "LABEL_AR" => $title_ar,
                        'SEND_PARAMS' => array("module_id" => $brotherAppItem->getId()),
                        'CONFIRMATION_NEEDED' => true,
                        'CONFIRMATION_QUESTION' => array(
                            'ar' => "هل أنت متأكد أنك ترغب في " . $title_ar,
                            'en' => "Are you sure you want to "
                        ),
                        'CONFIRMATION_WARNING' => array(
                            'ar' => "هذه العملية غير قابلة للتراجع",
                            'en' => "This action can't be cancelled after done."
                        )
                    );
                }
            }

            $color = "red";
            $title_ar = "إنشاء/تحديث وظائف التطبيق";
            $pbms["1ac55M"] = array(
                "METHOD" => "createUpdateMyBFs", "COLOR" => $color, "LABEL_AR" => $title_ar,
                'CONFIRMATION_NEEDED' => true,
                'CONFIRMATION_QUESTION' => array(
                    'ar' => "هل أنت متأكد أنك ترغب في تحديث وظائف التطبيق؟",
                    'en' => "Are you sure you want to update application functions"
                ),
                'CONFIRMATION_WARNING' => array(
                    'ar' => "هذه العملية غير قابلة للتراجع",
                    'en' => "This action can't be cancelled after done."
                )
            );

            $color = "blue";
            $title_ar = "إنشاء/تحديث الاهتمام بالأهداف";
            $pbms["1hab5d"] = array("METHOD" => "genereGoalConcerns", "COLOR" => $color, "LABEL_AR" => $title_ar);

            $color = "green";
            $title_ar = "إنشاء/تحديث الأهداف والمسميات الوظيفية لتقنية المعلومات";
            $pbms["1g5X5M"] = array("METHOD" => "genereITJobsAndGoals", "COLOR" => $color, "LABEL_AR" => $title_ar);

            $color = "yellow";
            $title_ar = "هندسة معاكسة";
            $pbms["yan38B"] = array("METHOD" => "pagAllTables", "COLOR" => $color, "LABEL_AR" => $title_ar);

            if (!$this->IamInstalled()) {
                $color = "green";
                $title_ar = "تثبيت ملفات التطبيق";
                $pbms["xas15B"] = array("METHOD" => "installMe", "COLOR" => $color, "LABEL_AR" => $title_ar);
            } else {
                $color = "green";
                $title_ar = "تحديث ملفات التطبيق";
                $title_en = "update App files";
                $pbms["xas15B"] = array(
                    "METHOD" => "refreshMe", "COLOR" => $color, "LABEL_AR" => $title_ar,
                    'CONFIRMATION_NEEDED' => true,
                    'CONFIRMATION_QUESTION' => array(
                        'ar' => "هل أنت متأكد أنك ترغب في " . $title_ar,
                        'en' => "Are you sure you want to " . $title_en
                    ),
                    'CONFIRMATION_WARNING' => array(
                        'ar' => "هذه العملية غير قابلة للتراجع",
                        'en' => "This action can't be cancelled after done."
                    )
                );
            }
        }


        /*
            $color = "green";
            $title_ar = "توليد  خدمات ادارة البيانات (الكرود)"; 
            $pbms["53AYc1"] = array("METHOD"=>"genereCrudBFs","COLOR"=>$color, "LABEL_AR"=>$title_ar);
            
            $color = "darkblue";
            $title_ar = "توليد  خدمات الإستعلام والاحصائيات والتقارير"; 
            $pbms["512X01"] = array("METHOD"=>"genereConsultBFs","COLOR"=>$color, "LABEL_AR"=>$title_ar);
            */







        return $pbms;
    }

    public function IamInstalled()
    {
        global $ROOT_WWW_PATH;
        $currmod = $this->getVal("module_code");


        $i_file = $ROOT_WWW_PATH . $currmod . "/i.php";

        return (file_exists($i_file));
    }

    public function genereIniPhpFile()
    {
        $open_php = "<?php \n";
        // genere ini file
        $this_id = $this->id;
        $currmod = $this->getVal("module_code");
        $module_def = $open_php;
        $module_def .= "   \$MODULE='$currmod';\n";
        $module_def .= "   \$THIS_MODULE_ID = $this_id;\n";

        return $module_def;
    }

    public function installMe($lang = "ar", $create_project = true, $update_files = true)
    {
        global $ROOT_WWW_PATH, $START_GEN_TREE;
        $file_dir_name = dirname(__FILE__);
        ini_set('error_reporting', E_WARNING | E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
        $source_path = $START_GEN_TREE;
        // $dest_path = $START_GEN_TREE."php/";
        $dest_path = $ROOT_WWW_PATH;
        
        $currmod = $this->getVal("module_code");
        
        // require_once("$file_dir_name/../lib/afw/afw_copy_motor.php");

        if ($create_project) {
            // copy empty project folder files
            AFWCopyMotor::recurseCopy($source_path . "php/empty", $dest_path . $currmod);

            // copy company logo and title
            AFWCopyMotor::copyFile($dest_path . "external/pic/title-company.png", $dest_path . "external/pic/title-company-$currmod.png");
        }

        if ($update_files) {

            $module_def = $this->genereIniPhp();

            AfwFileSystem::write($dest_path . $currmod . "/ini.php", $module_def . $this->php_ini, false);

            // no need we should use same logo except if define const CUSTOM_COMPANY_DATA
            // copy company logo and title
            // AFWCopyMotor::copyFile($source_path."php/external/pic/title-company.png", $dest_path."external/pic/title-company-$currmod.png");
            // AFWCopyMotor::copyFile($source_path."php/external/pic/logo-company.png", $dest_path."external/pic/logo-company-$currmod.png");
        }





        ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
    }

    public function refreshMe($lang = "ar")
    {
        $this->installMe($lang, $create_project = false, $update_files = true);
    }


    public function genereGoalConcerns($lang = "ar")
    {
        $err_arr = array();
        $inf_arr = array();

        $applicationGoalList = $this->get("applicationGoalList");

        foreach ($applicationGoalList as $applicationGoalItem) {
            list($err, $inf) = $applicationGoalItem->genereConcernedGoals($lang);

            if ($err) $err_arr[] = $err;
            if ($inf) $inf_arr[] = $inf;
        }


        return array(implode("<br>\n", $err_arr), implode("<br>\n", $inf_arr));
    }

    public function createUpdateMyBFs($lang = "ar", $errors_level = 1)
    {
        $file_dir_name = dirname(__FILE__);
        

        $currApplicationId = $this->getId();
        $currmod = $this->getVal("module_code");

        $id_system = $this->getVal("id_system");

        /*if (!$framework) $framework = $MODULE_FRAMEWORK[$currApplicationId];
        if (!$framework)*/
        $framework = AfwSession::config("framework_id",1);
        if (!$this->isApplication()) return array("this module $this ($currmod) is not an application !!", "");
        if (!$id_system) return array("no system defined for module $this ($currmod) id=$currApplicationId !!", "");

        $this->resetAllGeneratedUserStories();
        $this->disableMyBFs($id_system, $framework);
        $this->resetAllGeneratedLookupAroles();

        $this->reLinkLookupResponsibilityToLookupTables($lang);
        //$this->genereLookupAroles();
        $at = new Atable();
        $at->select("id_module", $currApplicationId);
        $at->select("avail", 'Y');
        $at->select("real_table", 'Y');
        $at_list = $at->loadMany($limit = "", $order_by = "id_sub_module asc");

        $at_list_count = count($at_list);

        $errors = array();
        $warnings = array();
        $infos = array();

        // $role_code = "xx";
        $screens_count = 0;
        $new_bf_count = 0;
        $ignored_count = 0;
        $updated_bf_count = 0;
        // $new_role_count = 0;
        $to_implement_count = 0;

        if ($id_system) {
            if ($at_list_count) {
                foreach ($at_list as $atb_id => $atb_obj) {
                    $table_errors = array();
                    $table_ok = $atb_obj->isOk(true);
                    if (!$table_ok) {
                        $err_text = implode("<br>\n", $atb_obj->getDataErrors());
                        if ($errors_level >= 2) $errors[] = $err_text;
                        $table_errors[] = $err_text;
                    }

                    $atb_obj_class = $atb_obj->getTableClass();
                    $atb_obj_desc =  $atb_obj->getVal("titre_short");
                    $atb_obj_name =  $atb_obj->getVal("titre_u");
                    if (!$atb_obj_name) {
                        $atb_obj_name = "مسمى سجل مفقود جدول-" . $atb_obj->getId();
                        $errors[] = $atb_obj_name;
                        $table_errors[] = $atb_obj_name;
                        $table_ok = false;
                    }
                    $atb_obj_desc_en =  $atb_obj->getVal("titre_short_en");
                    $atb_obj_name_en =  $atb_obj->getVal("titre_u_en");
                    if (!$atb_obj_name_en) {
                        $atb_obj_name_en = "no-tu-atable-" . $atb_obj->getId();
                        if ($errors_level >= 2) $errors[] = $atb_obj_name_en;
                        $table_errors[] = $atb_obj_name_en;
                        $table_ok = false;
                    }
                    if ($table_ok) {
                        $atb_obj_cat = $atb_obj->tableCategory();
                        $atb_obj_name = $atb_obj->getVal("atable_name");

                        if ($atb_obj_cat != "vobj") {
                            // to generate titles if empty 
                            $atb_obj->beforeMAJ($atb_obj->getId(), $fields_updated = null);
                            $atb_obj->update();
                            // to generate screens
                            $bf_arr = $atb_obj->createFrameWorkScreens($framework);

                            $screens_count += count($bf_arr);
                            if (!count($bf_arr)) {
                                $warnings[] = "$atb_obj_cat table : <b>[$atb_obj_name($atb_id)]</b> has no screen !";
                            } else {
                                foreach ($bf_arr as $bf_id => $bf_data) {
                                    if ($bf_id > 0) {
                                        $bf = $bf_data["bf"];
                                        $bf_new = $bf_data["bf_new"];
                                        $menu = $bf_data["menu"];

                                        list($warn, $err, $info) = $bf->updateMeInUserStoryListAroles($menu, $lang);

                                        if ($warn) $warnings[] = $warn;
                                        if ($err) $errors[] = $err;
                                        if ($info) $infos[] = $info;

                                        if ($bf_new) $new_bf_count++;
                                        else $updated_bf_count++;
                                    } else {
                                        $ignored_count++;
                                        if ($bf_id == -1) $warnings[] = "ignored for $atb_obj_cat table : <b>[$atb_obj_name($atb_id)]</b> : " . var_export($bf_arr[-1], true);
                                    }
                                }
                            }
                        } else {
                            return array("not implemented for non original table : $atb_obj category : $atb_obj_cat", "");
                            // @todo rafik : case of rfw pages
                            $to_implement_count++;
                        }
                    } else {
                        if (!$this->isTestable()) return array("module not in dev/test mode and table with errors : $atb_obj : <br>\n" . implode("<br>\n", $table_errors), "");
                    }
                }
            } else {
                return array("no tables in module $currApplicationId !!", "");
            }
        } else {
            return array("define system for module $this - $currApplicationId !!", "");
        }

        $errors_text = implode("\n<br>", $errors);
        $infos_text = implode("\n<br>", $infos);

        return array($errors_text, "Tables treated : $at_list_count, screens : $screens_count, new BF : $new_bf_count, updated BF : $updated_bf_count, ignored : $ignored_count, rfw-to-implement cases : $to_implement_count, log :" . $infos_text);
    }
    /*
         public function exportToUAMS($lang="ar")
         {
               $file_dir_name = dirname(__FILE__);
               // // require_once("$file_dir_name/../ams/xmodule.php");
               // // require_once("$file_dir_name/../ams/xatable.php");
               $id_this = $this->getId();
               $id_module_type = $this->getVal("id_module_type");
               
               if(($id_module_type!=4) and ($id_module_type!=7)) return array("Only for projects","للمشاريع فقط"); 
               
               
               $allModules = $this->get("allModules");
               
               
               $system_code = $this->getVal("module_code");
               if(!$system_code) $system_code = "system".$id_this;
               $xSystem = Xmodule::loadByMainIndex(0, $system_code,true);
               // die(var_export($xSystem,true));
               $xSystem->set("module_name_ar",$this->getVal("titre_short"));
               $xSystem->set("module_name_en",$this->getVal("titre_short_en"));
               $xSystem->set("module_type_id",$this->getVal("id_module_type"));
               $xSystem->update();
               
               $xSystem_id = $xSystem->getId();
                                       
               
               $all_tbs = $this->getMyAllTables();                  

               $xmodule_parent_module_id = array();
               $xmodule_id_of_module_id = array();
               $allXModules = array();
               
               foreach($allModules as $moduleId => $moduleItem)
               {
                  if($moduleId != $id_this)
                  {
                     $module_code = $moduleItem->getVal("module_code");
                     if(!$module_code) $module_code = "module".$moduleId;
                     
                     $xmodule = Xmodule::loadByMainIndex($xSystem_id, $module_code,true);
                     $xmodule->set("module_name_ar",$moduleItem->getVal("titre_short"));
                     $xmodule->set("module_name_en",$moduleItem->getVal("titre_short_en"));
                     $xmodule->set("module_type_id",$moduleItem->getVal("id_module_type"));
                     $xmodule->update();
                     
                     $allXModules[$xmodule->getId()] = $xmodule;
                     $xmodule_parent_module_id[$xmodule->getId()] = $moduleItem->getVal("id_module_parent");
                     $xmodule_id_of_module_id[$moduleId] = $xmodule->getId();
                  }   
               }
               
               foreach($allXModules as $xmoduleId => $xmoduleItem)
               {
                     $xmoduleItem->set("parent_module_id",$xmodule_id_of_module_id[$xmodule_parent_module_id[$xmoduleItem->getId()]]);
                     $xmoduleItem->update();
               }
               
               foreach($all_tbs as $atableId => $atableItem)
               {
                     $module_id = $xmodule_id_of_module_id[$atableItem->getVal("id_module")];
                     $sub_module_id = $xmodule_id_of_module_id[$atableItem->getVal("id_sub_module")];
                     $table_code = $atableItem->getVal("atable_name");
                     $xtable = Xatable::loadByMainIndex($module_id, $table_code, true);
                     
                     $is_detail_table_for_others  = $atableItem->isDetailTableForOthers() ? 'Y':'N';
                          
                     $xtable->set("system_id",$xSystem_id);
                     $xtable->set("sub_module_id",$sub_module_id);
                     $xtable->set("table_name_ar",$atableItem->getVal("titre_short"));
                     $xtable->set("table_name_en",$atableItem->getVal("titre_short_en"));
                     $xtable->set("records_name_ar",$atableItem->getVal("titre_short"));
                     $xtable->set("records_name_en",$atableItem->getVal("titre_short_en"));
                     $xtable->set("one_record_ar",$atableItem->getVal("titre_u"));
                     $xtable->set("one_record_en",$atableItem->getVal("titre_u_en"));
                     $xtable->set("description_ar",$atableItem->getVal("titre"));
                     $xtable->set("description_en",$atableItem->getVal("titre_en"));
                     $xtable->set("is_entity",$atableItem->getVal("is_entity"));
                     $xtable->set("is_lookup",$atableItem->getVal("is_lookup"));
                     $xtable->set("is_detail",$is_detail_table_for_others);
                     $xtable->update();
               }
               


               return array("",""); 
         }*/

    public function pagAllTables($lang = "ar", $update_if_exists = true)
    {
        if ($this->getVal("id_module_type") != self::$MODULE_TYPE_APPLICATION) {
            return array("pagAllTables method is Only for application module", "");
        }
        $file_dir_name = dirname(__FILE__);
        //// require_once("$file_dir_name/../lib/afw/afw_displayer_factory.php");
        $cc = $this->getVal("module_code");
        AfwAutoLoader::addModule($cc);

        $m_fld_i = 0;
        $m_fld_u = 0;

        $currmod = $this->getVal("module_code");
        $all_tbs = $this->getMyAllTables();
        $pagged_arr = array();
        foreach ($all_tbs as $tb_id => $tb_item) {
            if (!$tb_item->_isEnum()) {
                $tb_name = $tb_item->valAtable_name();
                if (file_exists("$file_dir_name/../$cc/$tb_name.php")) {
                    $cl = $tb_item->valClass_name();
                    $myObj = new $cl();
                    $pagged_arr[$cl] = true;
                    $sh = 3;   // main company

                    list($fld_i, $fld_u) = $myObj->pagMe($sh, $update_if_exists);
                    $m_fld_i += $fld_i;
                    $m_fld_u += $fld_u;
                }
            }
        }


        require_once("$file_dir_name/../$cc/all_to_pag.php");
        foreach ($arr_all_files as $topag_table) {
            $cl = AfwStringHelper::tableToClass($topag_table);
            if ($cl and (!$pagged_arr[$cl])) {
                $myObj = new $cl();
                $pagged_arr[$cl] = true;
                if (!$sh) $sh = 3;   // main company
                $update_if_exists = $uie;

                list($fld_i, $fld_u) = $myObj->pagMe($sh, $update_if_exists);
                $m_fld_i += $fld_i;
                $m_fld_u += $fld_u;
            }
        }

        if ($m_fld_i + $m_fld_u > 0) $information  = "تم إضافة  $m_fld_i حقول  وتم $m_fld_u حقل ";
        else $information  = "لا يوجد تعديلات";



        return array("", $information);
    }


    public function getSystemId()
    {
        $system_id = $this->getVal("id_system");
        if ((!$system_id) and (($this->getVal("id_module_type") == 4) or ($this->getVal("id_module_type") == 7))) $system_id = $this->getId();

        return $system_id;
    }

    public function isModule()
    {
        return (($this->getVal("id_module_type") == self::$MODULE_TYPE_MINI_APPLICATION) or
            ($this->getVal("id_module_type") == self::$MODULE_TYPE_MODULE)
        );
    }

    public function isApplication()
    {
        return ($this->getVal("id_module_type") == self::$MODULE_TYPE_APPLICATION);
    }

    public function isSystem()
    {
        return (($this->getVal("id_module_type") == self::$MODULE_TYPE_SYSTEM) or ($this->getVal("id_module_type") == self::$MODULE_TYPE_FRAMEWORK));
    }

    public function attributeIsApplicable($attribute)
    {
        if ($attribute == "dbengine_id") return $this->isApplication();
        if ($attribute == "dbsystem_id") return $this->isApplication();
        if ($attribute == "tablecount") return ($this->isApplication() or $this->isModule());
        if ($attribute == "bfcount") return ($this->isApplication() or $this->isModule());
        if ($attribute == "ptaskcount") return ($this->isApplication() or $this->isModule());
        if ($attribute == "allRoles") return $this->isApplication();
        if ($attribute == "goal") return $this->isApplication();
        if ($attribute == "web") return true; //$this->isApplication();
        if ($attribute == "allbfs") return $this->isSystem();
        if ($attribute == "mybfs") return (!$this->isSystem());
        if ($attribute == "applications") return $this->isSystem();
        if ($attribute == "shs") return ($this->isSystem() or $this->isApplication());
        if ($attribute == "assrole") return $this->isModule();
        if ($attribute == "id_module_status") return ($this->isSystem() or $this->isApplication());
        if ($attribute == "id_main_sh") return ($this->isSystem() or $this->isApplication());

        if ($attribute == "applicationGoalList") return $this->isApplication();

        //this is false if($attribute=="module_code") return ($this->getVal("id_module_type")==5);

        return true;
    }

    public function findModule($new_id_module_parent, $new_id_system, $titre_short)
    {
        $modl = new Module();
        $modl->select("id_system", $new_id_system);
        $modl->select("id_module_parent", $new_id_module_parent);
        $modl->select("titre_short", $titre_short);

        if ($modl->load()) {
            return $modl;
        } else return null;
    }

    public function disableMyBFs($system_id, $framework_id = 0)
    {
        $file_dir_name = dirname(__FILE__);
        if(!$framework_id) $framework_id=AfwSession::config("framework_id", 1);
        require("$file_dir_name/../lib/framework_${framework_id}_specification.php");

        Bfunction::disableAutoGeneratedBFs($system_id, $this->getId(), $framework_screens_bfcode_starts_with . "-");
    }

    public function cloneMe($new_id_module_parent, $new_id_system)
    {
        if (($new_id_module_parent == $this->getVal("id_module_parent")) or
            ($new_id_system == $this->getVal("id_system"))
        ) {
            throw new AfwRuntimeException("can't clone module in the same system : $this to clone into ($new_id_system,$new_id_module_parent)");
        }
        $titre_short = $this->getVal("titre_short");

        $clone = $this->findModule($new_id_module_parent, $new_id_system, $titre_short);

        if ($clone) {
            $cloned = false;
        } else {
            $cloned = true;
        }

        if ($cloned) {
            $clone = $this;
            $clone->resetAsCopy();
            $clone->set("id_module_parent", $new_id_module_parent);
            $clone->set("id_system", $new_id_system);
            $clone->insert();
        }



        return array($cloned, $clone);
    }
    /*
         public function genereMyAssociatedRole($lang="ar")
         {
               $id_sub_mod = $this->getId();
               $mod = $this->het("id_module_parent");
               $mod_id = $this->getVal("id_module_parent");
               $application_code = $applicationObj->getVal("module_code");
               
               if(($id_sub_mod) and (intval($id_sub_mod)>0))
               {
                    
                    $role_code = "module-$id_sub_mod";
                    $titre_short = $this->getVal("titre_short");
                    $titre_short_en=$this->getVal("titre_short_en");
                    if(!$titre_short_en) $titre_short_en = AfwStringHelper::toEnglishText($role_code);
                    $titre=$this->getVal("titre");
                    $titre_en=$this->getVal("titre_en");
                    list($arole_type_id, $path) = $this->getRoleTypeId("",$lang);
                    
                    list($new_role, $arole) = Arole::findOrCreateArole($mod_id,$role_code,$titre_short,$titre_short_en,$titre,$titre_en,$arole_type_id);
                    return array("","");
               }
               else return array("this is empty module (no ID found)","");
                       
         }*/


    public function beforeDelete($id, $id_replace)
    {


        if ($id) {
            if ($id_replace == 0) {
                $server_db_prefix = AfwSession::config("db_prefix", "c0"); // FK part of me - not deletable 
                // p ag.atable-النظام	id_module  أنا تفاصيل لها-OneToMany
                // $this->execQuery("delete from $server_db_prefix"."p ag.atable where id_module = '$id' and avail='N'");
                
                $obj = new Atable();
                $obj->where("id_module = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Atables(s) as Module";
                    return false;
                }
                // p ag.atable-الوحدة	id_sub_module  أنا تفاصيل لها-OneToMany
                // $this->execQuery("delete from $server_db_prefix"."p ag.atable where id_sub_module = '$id' and avail='N'");
                
                $obj = new Atable();
                $obj->where("id_sub_module = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Atables(s) as Sub module";
                    return false;
                }
                // ums.module-الوحدة الأم	id_module_parent  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from $server_db_prefix"."ums.module where id_module_parent = '$id' and avail='N'");
                
                $obj = new Module();
                $obj->where("id_module_parent = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Modules(s) as Module parent";
                    return false;
                }
                // ums.bfunction-النظام	id_system  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from $server_db_prefix"."ums.bfunction where id_system = '$id' and avail='N'");
                
                $obj = new Bfunction();
                $obj->where("id_system = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some business functions(s) as System";
                    return false;
                }
                // ums.bfunction-التطبيق	curr_class_module_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from $server_db_prefix"."ums.bfunction where curr_class_module_id = '$id' and avail='N'");
                
                $obj = new Bfunction();
                $obj->where("curr_class_module_id = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some business functions(s) as Curr class module";
                    return false;
                }
                // ums.arole-التطبيق	module_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from $server_db_prefix"."ums.arole where module_id = '$id' and avail='N'");
                
                $obj = new Arole();
                $obj->where("module_id = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Aroles(s) as Module";
                    return false;
                }
                // b au.goal-تحقيق الهدف عبر نظام	system_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("delete from $server_db_prefix"."b au.goal where system_id = '$id' and avail='N'");
                $obj = new Goal();
                $obj->where("system_id = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Goals(s) as System";
                    return false;
                }
                // b au.goal-تحقيق الهدف عبر تطبيق	module_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("delete from $server_db_prefix"."b au.goal where module_id = '$id' and avail='N'");
                // require_once "../b au/goal.php";
                $obj = new Goal();
                $obj->where("module_id = '$id'");
                $nbRecords = $obj->count();
                if ($nbRecords > 0) {
                    $this->deleteNotAllowedReason = "Used in some Goals(s) as Module";
                    return false;
                }


                $server_db_prefix = AfwSession::config("db_prefix", "c0"); // FK part of me - deletable 
                // ums.module_auser-الوحدة أو المشروع	id_module  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from $server_db_prefix"."ums.module_auser where id_module = '$id' ");
                // ums.module_orgunit-النظام/ التطبيق	id_module  أنا تفاصيل لها-OneToMany
                // $this->execQuery("delete from $server_db_prefix"."p ag.module_orgunit where id_module = '$id' ");
                // sdd.ptask-المشروع	project_module_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from $server_db_prefix"."sdd.ptask where project_module_id = '$id' ");
                // sdd.ptask-النظام / الـتطبيق	module_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("delete from $server_db_prefix"."sdd.ptask where module_id = '$id' ");
                // b au.user_story-النظام	system_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("delete from $server_db_prefix"."b au.user_story where system_id = '$id' ");
                // b au.user_story-التطبيق	module_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("delete from $server_db_prefix"."b au.user_story where module_id = '$id' ");


                // FK not part of me - replaceable 
                // ums.module-النظام	id_system  حقل يفلتر به-ManyToOne
                $this->execQuery("update $server_db_prefix"."ums.module set id_system='$id_replace' where id_system='$id' ");
                // b au.gfield-النظام المصدر	module_id  حقل يفلتر به-ManyToOne
                // $this->execQuery("update $server_db_prefix"."b au.gfield set module_id='$id_replace' where module_id='$id' ");
                // p ag.afield-تطبيق قائمة الإختيارات	answer_module_id  حقل يفلتر به-ManyToOne
                //$this->execQuery("update $server_db_prefix"."p ag.afield set answer_module_id='$id_replace' where answer_module_id='$id' ");
                // b au.ptext-الوحدة أو المشروع	module_id  حقل يفلتر به-ManyToOne
                // $this->execQuery("update $server_db_prefix"."b au.ptext set module_id='$id_replace' where module_id='$id' ");
                // p ag.pmessage-الوحدة أو المشروع	module_id  حقل يفلتر به-ManyToOne
                // $this->execQuery("update $server_db_prefix"."p ag.pmessage set module_id='$id_replace' where module_id='$id' ");
                // ums.job_arole-التطبيق	module_id  حقل يفلتر به-ManyToOne
                $this->execQuery("update $server_db_prefix"."ums.job_arole set module_id='$id_replace' where module_id='$id' ");



                // MFK
                // ums.bfunction-الوحدات المعنية	module_mfk  
                $this->execQuery("update $server_db_prefix"."ums.bfunction set module_mfk=REPLACE(module_mfk, ',$id,', ',') where module_mfk like '%,$id,%' ");
            } else {
                $server_db_prefix = AfwSession::config("db_prefix", "c0"); // FK on me 
                // p ag.atable-النظام	id_module  أنا تفاصيل لها-OneToMany
                // $this->execQuery("update $server_db_prefix"."p ag.atable set id_module='$id_replace' where id_module='$id' ");
                // p ag.atable-الوحدة	id_sub_module  أنا تفاصيل لها-OneToMany
                // $this->execQuery("update $server_db_prefix"."p ag.atable set id_sub_module='$id_replace' where id_sub_module='$id' ");
                // ums.module-الوحدة الأم	id_module_parent  أنا تفاصيل لها-OneToMany
                $this->execQuery("update $server_db_prefix"."ums.module set id_module_parent='$id_replace' where id_module_parent='$id' ");
                // ums.bfunction-النظام	id_system  أنا تفاصيل لها-OneToMany
                $this->execQuery("update $server_db_prefix"."ums.bfunction set id_system='$id_replace' where id_system='$id' ");
                // ums.bfunction-التطبيق	curr_class_module_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("update $server_db_prefix"."ums.bfunction set curr_class_module_id='$id_replace' where curr_class_module_id='$id' ");
                // ums.arole-التطبيق	module_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("update $server_db_prefix"."ums.arole set module_id='$id_replace' where module_id='$id' ");
                // b au.goal-تحقيق الهدف عبر نظام	system_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("update $server_db_prefix"."b au.goal set system_id='$id_replace' where system_id='$id' ");
                // b au.goal-تحقيق الهدف عبر تطبيق	module_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("update $server_db_prefix"."b au.goal set module_id='$id_replace' where module_id='$id' ");
                // ums.module_auser-الوحدة أو المشروع	id_module  أنا تفاصيل لها-OneToMany
                $this->execQuery("update $server_db_prefix"."ums.module_auser set id_module='$id_replace' where id_module='$id' ");
                // ums.module_orgunit-النظام/ التطبيق	id_module  أنا تفاصيل لها-OneToMany
                // $this->execQuery("update $server_db_prefix"."ums.module_orgunit set id_module='$id_replace' where id_module='$id' ");
                // sdd.ptask-المشروع	project_module_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("update $server_db_prefix"."sdd.ptask set project_module_id='$id_replace' where project_module_id='$id' ");
                // sdd.ptask-النظام / الـتطبيق	module_id  أنا تفاصيل لها-OneToMany
                $this->execQuery("update $server_db_prefix"."sdd.ptask set module_id='$id_replace' where module_id='$id' ");
                // b au.user_story-النظام	system_id  أنا تفاصيل لها-OneToMany
                // $this->execQuery("update $server_db_prefix"."b au.user_story set system_id='$id_replace' where system_id='$id' ");
                // b au.user_story-التطبيق	module_id  أنا تفاصيل لها-OneToMany
                  $this->execQuery("update $server_db_prefix"."b au.user_story set module_id='$id_replace' where module_id='$id' ");
                // ums.module-النظام	id_system  حقل يفلتر به-ManyToOne
                $this->execQuery("update $server_db_prefix"."ums.module set id_system='$id_replace' where id_system='$id' ");
                // b au.gfield-النظام المصدر	module_id  حقل يفلتر به-ManyToOne
                // $this->execQuery("update $server_db_prefix"."b au.gfield set module_id='$id_replace' where module_id='$id' ");
                // p ag.afield-تطبيق قائمة الإختيارات	answer_module_id  حقل يفلتر به-ManyToOne
                // $this->execQuery("update $server_db_prefix"."p ag.afield set answer_module_id='$id_replace' where answer_module_id='$id' ");
                // b au.ptext-الوحدة أو المشروع	module_id  حقل يفلتر به-ManyToOne
                // $this->execQuery("update $server_db_prefix"."b au.ptext set module_id='$id_replace' where module_id='$id' ");
                // p ag.pmessage-الوحدة أو المشروع	module_id  حقل يفلتر به-ManyToOne
                // $this->execQuery("update $server_db_prefix"."p ag.pmessage set module_id='$id_replace' where module_id='$id' ");
                // ums.job_arole-التطبيق	module_id  حقل يفلتر به-ManyToOne
                $this->execQuery("update $server_db_prefix"."ums.job_arole set module_id='$id_replace' where module_id='$id' ");


                // MFK
                // ums.bfunction-الوحدات المعنية	module_mfk  
                $this->execQuery("update $server_db_prefix"."ums.bfunction set module_mfk=REPLACE(module_mfk, ',$id,', ',$id_replace,') where module_mfk like '%,$id,%' ");
            }
            return true;
        }
    }

    public function getParentApplication()
    {
        if ($this->isApplication()) return $this;

        $parent = $this->hetParent();
        if (!$parent) return null;
        if ($parent->getId() == $this->getId()) return null; // this is not an application and it is parent of itself, so no parent application
        return $parent->getParentApplication();
    }

    public function resetAllGeneratedUserStories()
    {
        $server_db_prefix = AfwSession::config("db_prefix", "c0");
        $file_dir_name = dirname(__FILE__);
        /*
                $application = $this->getParentApplication();
                if(!$application) throw new AfwRuntimeException("no parent application for this module : $this");*/
        if ($this->isSystem()) $my_system_id = $this->getId();
        else $my_system_id = $this->getVal("id_system");

        $system_id = $this->getId();
        $module_id = $this->getId();

        // disable old autogenerated user stories
        $ustr0 = new UserStory;

        $ustr0->where("(system_id = $system_id or module_id = $module_id)");
        $ustr0->select("source", "auto-generated");
        $ustr0->logicDelete(true, false);
        
        /*
        $ustr0->resetUpdates();
        $ustr0->set("user_story_goal_id", 0, true);
        $ustr0->select("source", "auto-generated");
        $ustr0->where("(system_id = $system_id or module_id = $module_id)");
        $ustr0->where("user_story_goal_id not in (select id from $server_db_prefix"."b au.goal where system_id=$my_system_id and goal_code like 'manual%')");
        $ustr0->update(false);*/

        // throw new AfwRuntimeException("see my query : ",array("SQL"=>true));

        $ustr0->resetUpdates();
        $ustr0->set("arole_id", 0, true);
        $ustr0->select("source", "auto-generated");
        $ustr0->where("(system_id = $system_id or module_id = $module_id)");
        $ustr0->where("arole_id not in (select id from $server_db_prefix"."ums.arole where system_id=$my_system_id and role_code like 'manual%')");
        $ustr0->update(false);


        // throw new AfwRuntimeException("end of module::resetAllGeneratedUserStories",array("FIELDS_UPDATED"=>true));
    }

    public function resetAllGeneratedLookupAroles()
    {
        $file_dir_name = dirname(__FILE__);
        

        if (!$this->isApplication()) return array("this module $this is not an application !!", "");

        // $system = $this->hetSys();
        $module_id = $this->getId();
        $application_code = $this->getVal("module_code");

        // disable old autogenerated user stories
        $rl0 = new Arole;

        $rl0->select("module_id", $module_id);
        $rl0->where("(role_code like '$application_code-module-%' or role_code = '$application_code-lookup')");   // 
        $rl0->logicDelete(true, false);
    }

    /*
        public function genereLookupAroles()
        {
                $module_id = $this->getId();
                $application_code = $this->getVal("module_code");
                
                if(!$this->isApplication()) return array("this module $this is not an application !!","");

                $file_dir_name = dirname(__FILE__); 
                
                
                $lookupRole = Arole::getOrCreateLookupRoleForApplication($this);
                
                $subModuleList = $this->get("smd");
                
                foreach($subModuleList as $subModuleID => $subModuleObj)
                {
                     $subModuleObj->getOrCreateLookupSubRoleForMe($lookupRole, $application_code, $module_id);
                }
        }
        
        public function getOrCreateLookupSubRoleForMe($lookupRole, $application_code, $module_id)
        {
             $myRole = Arole::getOrCreateLookupSubRoleForSubModule($lookupRole, $application_code, $module_id,  $this);
             
             $subModuleList = $this->get("smd");
             
             $file_dir_name = dirname(__FILE__); 
             
                
                
             foreach($subModuleList as $subModuleID => $subModuleObj)
             {
                     $subModuleObj->getOrCreateLookupSubRoleForMe($myRole, $application_code, $module_id);
             }  
        }
        */

    public function getMyMainGoal()
    {
        $mainGoalObj = $this->het("main_goal_id");
        if ($mainGoalObj) return $mainGoalObj;

        $parentMod = $this->het("id_module_parent");

        if (($parentMod) and ($parentMod->getId() == $this->getId())) $parentMod =  null; // it is parent of itself, so no parent (avoid infinite loops)

        if ($parentMod) return $parentMod->getMyMainGoal();
        else return "";
    }

    public function isRunnable()
    {
        $me = AfwSession::getUserIdActing();
        return (($this->getVal("id_module_status") == self::$MODULE_STATUS_IN_PRODUCTION) or
            (($this->getVal("id_module_status") == self::$MODULE_STATUS_TEST_ONGOING) and ($this->isTeamMember("developer", $me))));
    }

    public function isTestable()
    {
        $me = AfwSession::getUserIdActing();
        return (($this->getVal("id_module_status") == self::$MODULE_STATUS_DEVELOPMENT_ONGOING) or
            ($this->getVal("id_module_status") == self::$MODULE_STATUS_TEST_ONGOING));
    }

    public function isTeamMember($role, $user)
    {
        return ($user == 1);
    }


    public function getRAMObjectData()
    {
        $category_id = 4;

        $file_dir_name = dirname(__FILE__);
        
        $moduleTypeObj = $this->getType();
        $lookup_code = $moduleTypeObj->getVal("lookup_code");
        $typeObj = RAMObjectType::loadByMainIndex($lookup_code);
        $type_id = $typeObj->getId();

        $code = $this->getVal("module_code");
        if (!$code) $code = "module-" . $this->getId();
        $name_ar = $this->getVal("titre_short");
        $name_en = $this->getVal("titre_short_en");
        $specification = $this->getVal("titre");

        $childs = array();
        $childs[4] =  $this->get("smd");
        if ($this->isSystem() or $this->isApplication()) {
            //$childs[1] =  $this->get("orgUnitList");
        }


        if ($this->isApplication()) {
            $childs[12] =  $this->getAllMyGoals();
            //$childs[5] =  $this->get("allRoles");
        }

        if ($this->isModule()) {
            //$childs[7] =  $this->getMyAllTables();
        }



        return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
    }

    public function setEditJobroleForLookups($jrObj)
    {


        $mod_id = $this->getId();

        if (($mod_id) and (intval($mod_id) > 0)) {
            $file_dir_name = dirname(__FILE__);
            
            $at = new Atable();

            $at->select("id_module", $mod_id);
            $at->select("is_lookup", 'Y');
            $at->select("avail", 'Y');

            $at->set("jobrole_id", $jrObj->getId());

            $at->update(false);
        }
    }


    public function getAllMyGoals()
    {
        return AfwStringHelper::hzm_array_merge($this->get("applicationGoalList"), $this->get("otherGoalList"));
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

    public function reLinkLookupResponsibilityToLookupTables($lang = "ar")
    {
        return $this->getLookupJobResp($create_obj_if_not_found = true, $always_update_name = false, $lang);
    }

    public function getLookupJobResp($create_obj_if_not_found = true, $always_update_name = false, $lang = "ar")
    {

        $appCode = $this->getVal("module_code");

        $code_jr = $appCode . "-lookup";
        $domain = null;
        if(AfwSession::config("MODE_DEVELOPMENT",false))
        {                            
            $id_pm = $this->getVal("id_pm");
            AfwAutoLoader::addModule("p"."ag");
            $domain = Domain::loadById($id_pm);
        }
        
        if ((!$domain) or (!$domain->getId())) {
            return null;
        }

        $file_dir_name = dirname(__FILE__);
        
        $jrObj = Jobrole::loadByMainIndex($domain->getId(), $code_jr, $create_obj_if_not_found);

        if ($jrObj->is_new or $always_update_name) {
            $jrObj->set("titre_short_en", "Lookup data");
            $jrObj->set("titre_short", "البيانات المرجعية ");
            $jrObj->update();
        }

        $this->setEditJobroleForLookups($jrObj);
        return $this->updateLookupGoal($jrObj, $create_obj_if_not_found, $always_update_name);
    }


    public function updateLookupGoal($jrObj = null, $create_obj_if_not_found = true, $always_update_name = false)
    {
        
        $domain = null;
        if(AfwSession::config("MODE_DEVELOPMENT",false))
        {                            
            $id_pm = $this->getVal("id_pm");
            AfwAutoLoader::addModule("p"."ag");
            $domain = Domain::loadById($id_pm);
        }
        
        if ((!$domain) or (!$domain->getId())) {
            return null;
        }
        $file_dir_name = dirname(__FILE__);
        

        if (!$jrObj) {
            $appCode = $this->getVal("module_code");
            $code_jr = $appCode . "-lookup";
            $jrObj = Jobrole::loadByMainIndex($domain->getId(), $code_jr, false);
        }

        if ((!$jrObj) or (!$jrObj->getId())) {
            return null;
        }

        $code_jr = $jrObj->getVal("jobrole_code");

        $goalObj = null;

        if ($this->getId() and $this->getVal("id_system")) {
            
            $goal_code = strtoupper($code_jr);

            $goalObj = Goal::loadByMainIndex($this->getVal("id_system"), $this->getId(), $goal_code, $create_obj_if_not_found);
            if ($goalObj->is_new or $always_update_name) {
                $goalObj->set("goal_name_en", "lookup data");
                $goalObj->set("goal_name_ar", "البيانات المرجعية");
                $goalObj->set("goal_desc_en", "lookup data management");
                $goalObj->set("goal_desc_ar", "إدارة البيانات المرجعية للنظام");
            }
            $goalObj->set("goal_type_id", Goal::$GOAL_TYPE_JOB_RESPONSIBILITY_GOAL);
            $goalObj->set("domain_id", $domain->getId());
            $goalObj->set("jobrole_id", $jrObj->getId());
            $goalObj->update();
        }




        
        $at = new Atable();

        $at->select("id_module", $this->getId());
        $at->select("is_lookup", 'Y');
        $at->select("avail", 'Y');

        $atList = $at->loadMany();
        $at_mfk = ",";
        foreach ($atList as $atItem) {
            $at_mfk .= $atItem->getId() . ",";
        }
        if ($goalObj) {
            global $lang;
            $goalObj->set("atable_mfk", $at_mfk);
            $goalObj->update();
            $goalObj->genereConcernedGoals($lang, $regen = true, $operation_men = ",1,2,3,5,");
        }
        return array($jrObj, $goalObj);
    }


    public function getDataJobResp($create_obj_if_not_found = true, $always_update_name = false)
    {
        $appCode = $this->getVal("module_code");
        $code_jr = $appCode . "-data";

        $domain = $this->het("domain");
        if ((!$domain) or (!$domain->getId())) {
            return null;
        }


        $file_dir_name = dirname(__FILE__);
        
        $jrObj = Jobrole::loadByMainIndex($domain->getId(), $code_jr, $create_obj_if_not_found);
        if ($jrObj->is_new or $always_update_name) {
            $jrObj->set("titre_short_en", "product admin");
            $jrObj->set("titre_short", "إدارة التطبيق");
            $jrObj->update();
        }

        $goalObj = null;

        if ($this->getId() and $this->getVal("id_system")) {
            
            $goal_code = strtoupper($code_jr);
            $goalObj = Goal::loadByMainIndex($this->getVal("id_system"), $this->getId(), $goal_code, $create_obj_if_not_found);
            if ($goalObj->is_new or $always_update_name) {
                $goalObj->set("goal_name_en", "product admin");
                $goalObj->set("goal_name_ar", "إدارة التطبيق");
                $goalObj->set("goal_desc_en", "product general data admin");
                $goalObj->set("goal_desc_ar", "إدارة البيانات العامة للنظام");
            }
            $goalObj->set("goal_type_id", Goal::$GOAL_TYPE_JOB_RESPONSIBILITY_GOAL);
            $goalObj->set("domain_id", $domain->getId());
            $goalObj->set("jobrole_id", $jrObj->getId());
            $goalObj->update();
        }


        return array($jrObj, $goalObj);
    }

    public function getMyURL($lang)
    {
        global $URL_ROOT;

        $module_code = $this->getVal("module_code");

        return $URL_ROOT . "/$module_code/";
    }

    public function applyFilter($filter)
    {
        // if You got this error : Illegal mix of collations (latin1_swedish_ci,IMPLICIT) and (utf8_general_ci,COERCIBLE) for ....
        //  do
        //   SET collation_connection = 'utf8_general_ci';
        //   ALTER DATABASE your_database_name CHARACTER SET utf8 COLLATE utf8_general_ci;
        //   ALTER TABLE your_table_name CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;

        if (($filter == "application") or ($filter == "app")) {
            $this->select("id_module_type", self::$MODULE_TYPE_APPLICATION);
            $filter = "";
        }

        if (!$filter) return true;
        else return false;
    }

    public static function getAllModulesByTypesAndStatuses($types_arr, $status_arr)
    {
        $obj = new Module();

        $obj->selectIn("id_module_type", $types_arr);
        $obj->selectIn("id_module_status", $status_arr);
        $obj->select("avail", "Y");

        return $obj->loadMany();
    }


    public function getAtableAfter($atable)
    {
        $id_order = $atable->id;
        if (!$id_order) return null;

        $af = new Atable();

        $af->select("id_module", $this->getId());
        $af->select("avail", 'Y');
        $af->where("id > $id_order");
        $af_list = $af->loadMany($limit = "1", $order_by = "id asc");

        if (count($af_list) > 0) {
            return current($af_list);
        } else return null;
    }


    public function getAtableBefore($atable)
    {
        $id_order = $atable->id;
        if (!$id_order) return null;

        $af = new Atable();

        $af->select("id_module", $this->getId());
        $af->select("avail", 'Y');
        $af->where("id < $id_order");
        $af_list = $af->loadMany($limit = "1", $order_by = "id desc");

        if (count($af_list) > 0) {
            return current($af_list);
        } else return null;
    }

    public function stepsAreOrdered()
    {
        return false;
    }


    public function myShortNameToAttributeName($attribute){
        if($attribute=="mainsh") return "id_main_sh";
        if($attribute=="title") return "titre_short";
        if($attribute=="type") return "id_module_type";
        if($attribute=="status") return "id_module_status";
        if($attribute=="sys") return "id_system";
        if($attribute=="parent") return "id_module_parent";
        if($attribute=="domain") return "id_pm";
        if($attribute=="engine") return "dbengine_id";
        if($attribute=="system") return "dbsystem_id";
        if($attribute=="php") return "php_ini";
        if($attribute=="shs") return "orgs";
        if($attribute=="app") return "applications";
        if($attribute=="tables") return "tbs";
        if($attribute=="lookups") return "lkps";
        if($attribute=="bmjob") return "id_analyst";
        if($attribute=="mmjob") return "id_hd";
        if($attribute=="smjob") return "id_br";
        if($attribute=="dispjobs") return "jobrole_mfk";
        return $attribute;
    }

    public function getSystem()
    {

    }


    /*
  mysqldump -h 127.0.0.1 -u root --databases -p --single-transaction c0bau  > /var/www/html/sql/20171128_c0bau.sql

*/
}
