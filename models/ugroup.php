<?php

$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Ugroup extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "ums"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
		"id" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "PK"),
		"titre_short" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "UTF8" => true, "SIZE" => 40, "TYPE" => "TEXT"),
		"titre" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "UTF8" => true, "SIZE" => 255, "TYPE" => "TEXT"),
		"ugroup_type_id" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "ugroup_type", "ANSMODULE" => "ums", "SIZE" => 40, "DEFAULT" => 0, "SHORTNAME"=>"type"),
		"ugroup_scope_id" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "FK", "ANSWER" => "ugroup_scope", "ANSMODULE" => "ums", "SIZE" => 40, "DEFAULT" => 0, "SHORTNAME"=>"scope"),
		"definition" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "TEXT"),

		"id_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"avail" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "TYPE" => "YN"),
		"version" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0)
	);
	
	*/ public function __construct(){
		parent::__construct("ugroup","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                $this->DISPLAY_FIELD = "titre_short";
                $this->ORDER_BY_FIELDS = "titre_short";
	}
        
        public function isMember($auser,$dataObj)
        {
                $my_type_id = $this->getVal("ugroup_type_id");
                if(!$my_type_id) $my_type_id = 1;
                return ($dataObj and $dataObj->userBelongToGroupDefinition($auser,$my_type_id));  
        }
        
        public static function getSpecialGroup($ugroup)
        {
               $sgrp = new UGroup();
               if($ugroup=="owner")
               {
                   $sgrp->set("ugroup_type_id",1);
               }
               
               return $sgrp;
        }
}
?>