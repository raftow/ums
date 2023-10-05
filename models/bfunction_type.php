<?php

$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class BfunctionType extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "ums"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
		"id" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),
		"titre" => array("IMPORTANT" => "IN", "SHOW" => true, "QEDIT" => false, "RETRIEVE" => false, "EDIT" => true, "UTF8" => true, "SIZE" => 255, "TYPE" => "TEXT"),
		titre_en => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "QEDIT" => false, "SIZE" => 255, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, "TYPE" => "TEXT"),
                "titre_short" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "UTF8" => true, "SIZE" => 64, "SHORTNAME" => title, "TYPE" => "TEXT"),
		titre_short_en => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 64, "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => true, "TYPE" => "TEXT"),
                
                "bfunction_type_code" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "SIZE" => 32, "TYPE" => "TEXT", SHORTNAME=>lookup_code),
		"for_role" => array("IMPORTANT" => "IN", "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "YN"),
		"id_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"avail" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "EDIT-ADMIN" => true, "TYPE" => "YN"),
		"version" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("IMPORTANT" => "IN", "SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
	);
	
	*/ public function __construct(){
		parent::__construct("bfunction_type","id","ums");
                
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                // $this->copypast = true;
                $this->DISPLAY_FIELD = "titre_short";
                $this->ORDER_BY_FIELDS = "titre_short";
	}
}
?>