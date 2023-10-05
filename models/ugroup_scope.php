<?php
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class UgroupScope extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "ums"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
		"id" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "TYPE" => "PK"),
		"titre" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "UTF8" => true, "SIZE" => 255, "TYPE" => "TEXT"),
		"titre_short" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "UTF8" => true, "SIZE" => 40, "TYPE" => "TEXT"),
                "ugroup_scope_fn" => array("SHOW" => true, "RETRIEVE" => false, "EDIT" => true, "UTF8" => false, "SIZE" => 40, "TYPE" => "TEXT"),
                
		"id_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_aut" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_mod" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"id_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "auser", "ANSMODULE" => "ums", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0),
		"date_valid" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATE"),
		"avail" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT-ADMIN" => true, "DEFAULT" => "Y", "TYPE" => "YN"),
		"version" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
		"update_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"delete_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"display_groups_mfk" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
		"sci_id" => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "scenario_item", "TYPE" => "FK", "SIZE" => 40, "DEFAULT" => 0)
	);
	
	*/ public function __construct($tablename="ugroup_scope")
        {
		parent::__construct($tablename,"id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                $this->DISPLAY_FIELD = "titre_short";
                $this->ORDER_BY_FIELDS = "id";
	}
        
        
        public function userIsInScope($auser,$dataObj_context)
        {
               $ugroup_scope_fn = $this->getVal("ugroup_scope_fn");
               
               if($ugroup_scope_fn)
               {
                        $inScopeMethod = "check".ucwords(strtolower($ugroup_scope_fn));
                        return $this->$inScopeMethod($auser,$dataObj_context);               
               }
               
               return false;
        
        }
}
?>