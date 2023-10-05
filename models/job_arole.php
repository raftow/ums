<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table job_arole : job_arole - صلاحيات الوظائف 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class JobArole extends AFWObject{

	public static $DATABASE		= ""; public static $MODULE		    = "ums"; public static $TABLE			= ""; public static $DB_STRUCTURE = null; /* = array(
                id => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

		
		"jobrole_id" => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 40, 
                                      "SEARCH-ADMIN" => true, "SHOW-ADMIN" => true, "EDIT-ADMIN" => true, "UTF8" => false, 
                                      TYPE => FK, ANSWER => jobrole, ANSMODULE => pag, MANDATORY=>true,
                                      RELATION => OneToMany,  
                                      "DEFAULT" => 0),
		"module_id" => array("IMPORTANT" => "IN", "SEARCH" => false, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 40, "UTF8" => false, 
                                       TYPE => FK, ANSWER => module, ANSMODULE => ums, MANDATORY=>true, 
                                       "DEFAULT" => 0,
                                       RELATION => OneToMany, 
                                       WHERE => "id_module_type=5 and id_pm in (select id_domain from c0pag.jobrole where id = §jobrole_id§)"),
		"arole_id" => array("IMPORTANT" => "IN", "SEARCH" => false, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, "SIZE" => 40, "UTF8" => false, 
                                       TYPE => FK, ANSWER => arole, ANSMODULE => ums, MANDATORY=>true, 
                                       "DEFAULT" => 0,
                                       RELATION => OneToMany, 
                                       WHERE => "module_id = §module_id§ and arole_type_id = 10"),
                
                id_aut => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                date_aut => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                id_mod => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                date_mod => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                id_valid => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                date_valid => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "DATETIME"),
                avail => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "DEFAULT" => "Y", "TYPE" => "YN"),
                version => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "INT"),
                update_groups_mfk => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                delete_groups_mfk => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                display_groups_mfk => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                sci_id => array("SHOW-ADMIN" => true, "RETRIEVE" => false, "EDIT" => false, "TYPE" => "FK", "ANSWER" => "scenario_item", "ANSMODULE" => "pag"),
                tech_notes 	    => array(TYPE => TEXT, CATEGORY => FORMULA, "SHOW-ADMIN" => true, 'STEP' =>"all", TOKEN_SEP=>"§", READONLY=>true, "NO-ERROR-CHECK"=>true),
	);
	
	*/ public function __construct(){
		parent::__construct("job_arole","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->ORDER_BY_FIELDS = "jobrole_id, module_id, arole_id";
                $this->UNIQUE_KEY = array('jobrole_id','module_id','arole_id');
                 
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
                
                
	}
        
        public static function loadById($id)
        {
           $obj = new JobArole();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        public static function loadByMainIndex($jobrole_id, $module_id, $arole_id,$create_obj_if_not_found=false)
        {
           $obj = new JobArole();
           $obj->select("jobrole_id",$jobrole_id);
           $obj->select("module_id",$module_id);
           $obj->select("arole_id",$arole_id);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("jobrole_id",$jobrole_id);
                $obj->set("module_id",$module_id);
                $obj->set("arole_id",$arole_id);

                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               $data = array();
               $link = array();
               

               list($data[0],$link[0]) = $this->displayAttribute("jobrole_id",false, $lang);
               list($data[1],$link[1]) = $this->displayAttribute("module_id",false, $lang);
               list($data[2],$link[2]) = $this->displayAttribute("arole_id",false, $lang);
               $data[3] = "id=".$this->getId();
               
               return implode(" - ",$data);
        }        
        
        
        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             global $me, $objme, $lang;
             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             
             
             return $otherLinksArray;
        }
        
        
        
        protected function beforeDelete($id,$id_replace) 
        {
            
            
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK part of me - not deletable 

                        
                   $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","c0"); // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}
?>