<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table module_status : module_status - حالات التطبيقات 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class ModuleStatus extends AFWObject{

        public static $MY_ATABLE_ID=426; 
        // إدارة حالات المشاريع 
        public static $BF_QEDIT_MODULE_STATUS = 102846; 
        // عرض تفاصيل حالة مشروع 
        public static $BF_DISPLAY_MODULE_STATUS = 102848; 
        // مسح حالة مشروع 
        public static $BF_DELETE_MODULE_STATUS = 102847; 


        // lookup Value List codes
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

        
	public static $DATABASE		= ""; 
     
     public static $MODULE		    = "ums"; 
     public static $TABLE			= "module_status"; 
     public static $DB_STRUCTURE = null; 
     
     
     public function __construct(){
		parent::__construct("module_status","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "titre_short";
                $this->ORDER_BY_FIELDS = "lookup_code";
                $this->IS_LOOKUP = true; 
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array('lookup_code');
                
	}
        
        public static function loadById($id)
        {
           $obj = new ModuleStatus();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public static function loadAll()
        {
           $obj = new ModuleStatus();
           $obj->select("active",'Y');

           $objList = $obj->loadMany();
           
           return $objList;
        }

        
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           $obj = new ModuleStatus();
           if(!$lookup_code) throw new AfwRuntimeException("loadByMainIndex : lookup_code is mandatory field");


           $obj->select("lookup_code",$lookup_code);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("lookup_code",$lookup_code);

                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               if($this->getVal("titre_short")) return $this->getVal("titre_short");
               $data = array();
               $link = array();
               

               list($data[0],$link[0]) = $this->displayAttribute("lookup_code",false, $lang);

               
               return implode(" - ",$data);
        }
        
        
        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             global $me, $objme, $lang;
             $otherLinksArray = array();
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             
             
             return $otherLinksArray;
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            $pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
            
            
            
            return $pbms;
        }
        
        public function beforeMAJ($id, $fields_updated) {
        
                if(!$this->getVal("titre")) {
                           $this->set("titre",$this->getVal("titre_short"));
                }
                
                if(!$this->getVal("titre_en")) {
                           $this->set("titre_en",$this->getVal("titre_short_en"));
                }
                
                
                if(!$this->getVal("lookup_code")) {
                           $this->set("lookup_code",AfwStringHelper::constNaming($this->getVal("titre_short_en")));
                }
                
                return true;
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
            
            
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 

                        
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 
                       // ums.module-حالة المشروع	id_module_status  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.module set id_module_status='$id_replace' where id_module_status='$id' ");

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 
                       // ums.module-حالة المشروع	id_module_status  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.module set id_module_status='$id_replace' where id_module_status='$id' ");

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}
?>