<?php

$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class BfunctionType extends AFWObject{

	public static $DATABASE		= ""; 
	public static $MODULE		    = "ums"; 
	public static $TABLE			= ""; 
	public static $DB_STRUCTURE = null; 
	
	public function __construct(){
		parent::__construct("bfunction_type","id","ums");
                
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                // $this->copypast = true;
                $this->DISPLAY_FIELD = "titre_short";
                $this->ORDER_BY_FIELDS = "titre_short";
	}
}
?>