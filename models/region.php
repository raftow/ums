<?php
// ------------------------------------------------------------------------------------
// ----             auto generated php class of table region : region - المناطق 
// ------------------------------------------------------------------------------------

                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class Region extends AFWObject{

	public static $DATABASE		= ""; 
    public static $MODULE		    = "ums"; 
    public static $TABLE			= ""; 
    public static $DB_STRUCTURE = null; 
    
    
    public function __construct(){
		parent::__construct("region","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "region_name";
                $this->ORDER_BY_FIELDS = "region_name";

                $this->UNIQUE_KEY = array('lookup_code');
                
                $this->copypast = true;
                $this->public_display = true;
	}

        public static function loadById($id)
        {
           $obj = new Region();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }

        public static function loadAll()
        {
           $obj = new Region();
           $obj->select("avail",'Y');
 
           $objList = $obj->loadMany();
 
           return $objList;
        }
        
        public static function decodeRegion($region_id,$lang)
        {
           $regObj = Region::loadById($region_id);
           if(!$regObj) return "";
           return $regObj->getDisplay($lang);
        }

        public static function findRegion($lookup_code, $region_name)
        {
           $obj = new Region();
           if(!$lookup_code) throw new AfwRuntimeException("loadByMainIndex : lookup_code is mandatory field");
           if(!$region_name) throw new AfwRuntimeException("loadByMainIndex : region_name is mandatory field");
           
 
           $obj->select("region_name",$region_name);     
           if($obj->load())
           {
                // die("region obj loaded with region_name=$region_name : ".var_export($obj,true));
                $obj->set("lookup_code",$lookup_code);
                
                $obj->activate();
                return $obj;
           }

           unset($obj);
           $obj = new Region();
           $obj->select("lookup_code",$lookup_code);
 
           if($obj->load())
           {
                $obj->set("region_name",$region_name);
                $obj->activate();
                return $obj;
           }
           else
           {
                $obj->set("lookup_code",$lookup_code);
                $obj->set("region_name",$region_name);
                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
 
        }
        
        public function fld_CREATION_USER_ID()
        {
                return  "id_aut";
        }

        public function fld_CREATION_DATE()
        {
                return  "date_aut";
        }

        public function fld_UPDATE_USER_ID()
        {
                return  "id_mod";
        }

        public function fld_UPDATE_DATE()
        {
                return  "date_mod";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
                return  "id_valid";
        }

        public function fld_VALIDATION_DATE()
        {
                return  "date_valid";
        }
        
        public function fld_VERSION()
        {
                return  "version";
        }

        public function fld_ACTIVE()
        {
                return  "avail";
        }


        public function beforeDelete($id,$id_replace) 
        {
            $server_db_prefix = AfwSession::config("db_prefix","c0");
            
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

                   
                   // FK not part of me - replaceable 
                       // ums.city-region_id	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../ums/city.php";
                            City::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}ums.city set region_id='$id_replace' where region_id='$id' ");
                        }
                       
                       // crm.crm_customer-المنطقة	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../crm/crm_customer.php";
                            // CrmCustomer::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}crm.crm_customer set region_id='$id_replace' where region_id='$id' ");
                        }
                       // license.invester-المنطقة	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../license/invester.php";
                            Invester::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}license.invester set region_id='$id_replace' where region_id='$id' ");
                        }

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
                       // ums.city-region_id	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../ums/city.php";
                            City::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}ums.city set region_id='$id_replace' where region_id='$id' ");
                        }
                       
                       // crm.crm_customer-المنطقة	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../crm/crm_customer.php";
                            // CrmCustomer::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}crm.crm_customer set region_id='$id_replace' where region_id='$id' ");
                        }
                       
                       // license.invester-المنطقة	region_id  نوع علاقة بين كيانين ← 2
                        if(!$simul)
                        {
                            // require_once "../license/invester.php";
                            Invester::updateWhere(array('region_id'=>$id_replace), "region_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}license.invester set region_id='$id_replace' where region_id='$id' ");
                        }

                        
                        // MFK

                   
               } 
               return true;
            }    
	}
}

