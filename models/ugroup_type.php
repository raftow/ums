<?php
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class UgroupType extends AFWObject{

	public static $DATABASE		= ""; 
	public static $MODULE		    = "ums"; 
	public static $TABLE			= "ugroup_type"; 
	public static $DB_STRUCTURE = null; 
	
	public function __construct(){
		parent::__construct("ugroup_type","id","ums");
		UmsUgroupTypeAfwStructure::initInstance($this);    
	}

	public static function loadByMainIndex($lkp_code,$create_obj_if_not_found=false)
	{


		$obj = new UgroupType();
		$obj->select("lkp_code",$lkp_code);

		if($obj->load())
		{
			if($create_obj_if_not_found) $obj->activate();
			return $obj;
		}
		elseif($create_obj_if_not_found)
		{
			$obj->set("lkp_code",$lkp_code);

			$obj->insertNew();
			if(!$obj->id) return null; // means beforeInsert rejected insert operation
			$obj->is_new = true;
			return $obj;
		}
		else return null;
		
	}

	public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","uoh_");
            
            if(!$id)
            {
                $id = $this->getId();
                $simul = true;
            }
            else
            {
                $simul = false;
            }
            
            if($id)
            {   
               if($id_replace==0)
               {
                   // FK part of me - not deletable 

                        
                   // FK part of me - deletable 
                       // ums.ugroup-متعلق المجموعة	ugroup_type_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../ums/ugroup.php";
                            Ugroup::removeWhere("ugroup_type_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}ums.ugroup where ugroup_type_id = '$id' ");
                            
                        } 
                        
                        

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
                       // ums.ugroup-متعلق المجموعة	ugroup_type_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../ums/ugroup.php";
                            Ugroup::updateWhere(array('ugroup_type_id'=>$id_replace), "ugroup_type_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}ums.ugroup set ugroup_type_id='$id_replace' where ugroup_type_id='$id' ");
                            
                        }
                        

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
}
?>