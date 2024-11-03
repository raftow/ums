<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table idn_type : idn_type - أنواع الهويات 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class IdnType extends AFWObject{

        public static $MY_ATABLE_ID=351; 
        // إدارة أنواع الهويات 
        public static $BF_QEDIT_IDN_TYPE = 103322; 
        // عرض تفاصيل نوع الهوية 
        public static $BF_DISPLAY_IDN_TYPE = 103324; 
        // مسح نوع الهوية 
        public static $BF_DELETE_IDN_TYPE = 103323; 


 // lookup Value List codes 
        // AHWAL - بطاقة أحوال  
        public static $IDN_TYPE_AHWAL = 1; 

        // IQAMA - إقامة  
        public static $IDN_TYPE_IQAMA = 2; 

        // OTHER - أخرى  
        public static $IDN_TYPE_OTHER = 99; 


        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= "idn_type"; 
        public static $DB_STRUCTURE = null; 
        
        
        public function __construct(){
		parent::__construct("idn_type","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 1;
                $this->DISPLAY_FIELD = "idn_type_name_ar";
                $this->ORDER_BY_FIELDS = "lookup_code";
                //$this->IS_LOOKUP = true; 
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array('lookup_code');
                
                $this->showQeditErrors = true;
                $this->showRetrieveErrors = true;
                $this->public_display = true;
	}
        
        public static function loadById($id)
        {
           $obj = new IdnType();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public static function loadAll()
        {
           $obj = new IdnType();
           $obj->select("active",'Y');

           $objList = $obj->loadMany();
           
           return $objList;
        }

        
        public static function loadByMainIndex($lookup_code,$create_obj_if_not_found=false)
        {
           $obj = new IdnType();
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
               return $this->getVal("idn_type_name_$lang");
        }
        

        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            //$pbms["xc123B"] = array("METHOD"=>"methodName","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"");
            
            
            
            return $pbms;
        }
        
        public function fld_CREATION_USER_ID()
        {
                return "id_aut";
        }

        public function fld_CREATION_DATE()
        {
                return "date_aut";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return "id_mod";
        }

        public function fld_UPDATE_DATE()
        {
        	return "date_mod";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return "id_valid";
        }

        public function fld_VALIDATION_DATE()
        {
                return "date_valid";
        }
        
        public function fld_VERSION()
        {
        	return "version";
        }

        public function fld_ACTIVE()
        {
        	return  "avail";
        }
        
        public function isTechField($attribute) {
            return (($attribute=="id_aut") or ($attribute=="date_aut") or ($attribute=="id_mod") or ($attribute=="date_mod") or ($attribute=="id_valid") or ($attribute=="date_valid") or ($attribute=="version"));  
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
                       // ums.auser-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.auser set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // bmu.b_m_employee-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}bmu.b_m_employee set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // bmu.customer_account-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}bmu.customer_account set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // trn.pregistration-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}trn.pregistration set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // crm.crm_customer-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}crm.crm_customer set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // ria.student-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // ria.parent_user-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.parent_user set idn_type_id='$id_replace' where idn_type_id='$id' ");

                        
                   
                   // MFK
                       // ums.country-أنواع الهويات في السعودية	sa_idn_type_mfk  
                        $this->execQuery("update ${server_db_prefix}ums.country set sa_idn_type_mfk=REPLACE(sa_idn_type_mfk, ',$id,', ',') where sa_idn_type_mfk like '%,$id,%' ");

               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 
                       // ums.auser-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.auser set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // bmu.b_m_employee-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}bmu.b_m_employee set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // bmu.customer_account-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}bmu.customer_account set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // trn.pregistration-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}trn.pregistration set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // crm.crm_customer-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}crm.crm_customer set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // ria.student-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set idn_type_id='$id_replace' where idn_type_id='$id' ");
                       // ria.parent_user-نوع الهوية	idn_type_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.parent_user set idn_type_id='$id_replace' where idn_type_id='$id' ");

                        
                       // MFK
                       // ums.country-أنواع الهويات في السعودية	sa_idn_type_mfk  
                         $this->execQuery("update ${server_db_prefix}ums.country set sa_idn_type_mfk=REPLACE(sa_idn_type_mfk, ',$id,', ',$id_replace,') where sa_idn_type_mfk like '%,$id,%' ");

                   
               } 
               return true;
            }    
	}
             
}
?>