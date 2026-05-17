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
        $title_ar = "xxxxxxxxxxxxxxxxxxxx";
        $title_en = "xxxxxxxxxxxxxxxxxxxx";
        $methodName = "mmmmmmmmmmmmmmmmmmmmmmm";
        //$pbms[AfwStringHelper::hzmEncode($methodName)] = 
        array(
            "METHOD" => $methodName,
            "COLOR" => $color,
            "LABEL_AR" => $title_ar,
            "LABEL_EN" => $title_en,
            "ADMIN-ONLY" => true,
            "BF-ID" => "",
            'STEP' => $this->stepOfAttribute("xxyy")
        );



        return $pbms;
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
}



// errors 
