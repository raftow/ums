<?php

$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Ugroup extends AFWObject{

	public static $DATABASE		= ""; 
	public static $MODULE		    = "ums"; 
	public static $TABLE			= "ugroup"; 
	public static $DB_STRUCTURE = null; 
	
	public function __construct(){
		parent::__construct("ugroup","id","ums");
        UmsUgroupAfwStructure::initInstance($this);    
	}
	
	public static function loadByMainIndex($module_id, $ugroup_type_id, $ugroup_scope_id, $definition,$create_obj_if_not_found=false)
	{
	   if(!$module_id) throw new AfwRuntimeException("loadByMainIndex : module_id is mandatory field");
	   if(!$ugroup_type_id) throw new AfwRuntimeException("loadByMainIndex : ugroup_type_id is mandatory field");
	   if(!$ugroup_scope_id) throw new AfwRuntimeException("loadByMainIndex : ugroup_scope_id is mandatory field");
	   if(!$definition) throw new AfwRuntimeException("loadByMainIndex : definition is mandatory field");


	   $obj = new Ugroup();
	   $obj->select("module_id",$module_id);
	   $obj->select("ugroup_type_id",$ugroup_type_id);
	   $obj->select("ugroup_scope_id",$ugroup_scope_id);
	   $obj->select("definition",$definition);

	   if($obj->load())
	   {
			if($create_obj_if_not_found) $obj->activate();
			return $obj;
	   }
	   elseif($create_obj_if_not_found)
	   {
			$obj->set("module_id",$module_id);
			$obj->set("ugroup_type_id",$ugroup_type_id);
			$obj->set("ugroup_scope_id",$ugroup_scope_id);
			$obj->set("definition",$definition);

			$obj->insertNew();
			if(!$obj->id) return null; // means beforeInsert rejected insert operation
			$obj->is_new = true;
			return $obj;
	   }
	   else return null;
	   
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
                   $sgrp->set("ugroup_type_id",3);
               }
               
               return $sgrp;
        }


		public function getNodeDisplay($lang="ar")
        {
             return $this->getShortDisplay($lang)." (". $this->getVal("definition").")";
        }
}
?>