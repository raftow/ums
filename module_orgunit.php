<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table module_orgunit : module_orgunit - علاقات الأنظمة بالإدارات 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class ModuleOrgunit extends AFWObject{

        public static $MY_ATABLE_ID=3493; 
        // إجراء إحصائيات حول علاقات الأنظمة بالإدارات 
        public static $BF_STATS_MODULE_ORGUNIT = 102838; 
        // إدارة علاقات الأنظمة بالإدارات 
        public static $BF_QEDIT_MODULE_ORGUNIT = 102833; 
        // إنشاء علاقة نظام بإدارة 
        public static $BF_EDIT_MODULE_ORGUNIT = 102832; 
        // الاستعلام عن علاقة نظام بإدارة 
        public static $BF_QSEARCH_MODULE_ORGUNIT = 102837; 
        // البحث في علاقات الأنظمة بالإدارات 
        public static $BF_SEARCH_MODULE_ORGUNIT = 102836; 
        // عرض تفاصيل علاقة نظام بإدارة 
        public static $BF_DISPLAY_MODULE_ORGUNIT = 102835; 
        // مسح علاقة نظام بإدارة 
        public static $BF_DELETE_MODULE_ORGUNIT = 102834; 

        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= "module_orgunit"; 
        
        public static $DB_STRUCTURE = null; 
        
        public function __construct(){
		parent::__construct("module_orgunit","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "id";
                $this->ORDER_BY_FIELDS = "id";
                 
                
                
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
	}
        
        public static function loadById($id)
        {
           $obj = new ModuleOrgunit();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        
        
        
        public function getDisplay($lang="ar")
        {
               return $this->getVal("id");
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
            //$pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
            
            
            
            return $pbms;
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
            
            
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
             
}
?>