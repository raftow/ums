<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table arole_type : arole_type - أنواع مجموعات الخدمات 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AroleType extends AFWObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null; 
        
        public function __construct(){
		parent::__construct("arole_type","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "name_ar";
                $this->ORDER_BY_FIELDS = "id";
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array("lookup_code");
	}
        
        public function getDisplay($lang="ar")
        {
                $id = trim($this->getId());
                $fn = "$id - ".trim($this->getVal("name_$lang"));
                
                return $fn;
        } 
}
?>