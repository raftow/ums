<?php

// ALTER TABLE xxx_ums.doc_type add   titre_short_en varchar(48)  DEFAULT NULL  AFTER titre_short;
class DocType extends AFWObject{
        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null; 
        
	
	public function __construct($tablename="doc_type"){
		parent::__construct($tablename,"id","ums");
                $this->public_display = true;
                $this->DISPLAY_FIELD_BY_LANG = ['ar'=>'titre_short', 'en'=>'titre_short_en',];
	}
         
        public static function loadAll($ids="", $order_by="")
        {
           $obj = new DocType();
           $obj->select_visibilite_horizontale();
           if($ids) $obj->where("id in ($ids)");
           return $obj->loadMany($limit = "", $order_by);
        }
        
        public static function loadById($id)
        {
           $obj = new DocType();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public static function getExentionsAllowed($ids, $upper=true)
        {
              if(is_array($ids)) $ids = implode(",",$ids);  
              if(!$ids) $ids = "0";
              $dt = new DocType();
              $cond = "avail='Y' and id in ($ids)";
              $dt->where($cond);
              
              $dtList = $dt->loadMany();
              
              $ft_arr = array();
              $ft_used = array();
              $ext_arr = array();
              $ext_used = array();
              
              foreach($dtList as $dtItem)
              {
                  $valid_ext = $dtItem->getVal("valid_ext");
                  $valid_ext_arr = explode(",", $valid_ext);
                  foreach($valid_ext_arr as $valid_ext_item)
                  {
                      if($upper) $valid_ext_item = trim(strtoupper($valid_ext_item));
                      else $valid_ext_item = trim(strtolower($valid_ext_item));
                      
                      if(!$ext_used[$valid_ext_item])
                      {
                         $ext_used[$valid_ext_item] = true;
                         $ext_arr[] = $valid_ext_item; 
                      }
                  }
                  $valid_ft = $dtItem->getDisplay();
                  if(!$ft_used[$valid_ft])
                  {
                       $ft_used[$valid_ft] = true;
                       $ft_arr[] = $valid_ft; 
                  }
              }
              //$ext_arr[] = $cond;
              return array($ext_arr, $ft_arr);
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
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); 
                   // FK part of me - not deletable 
 
 
                   // FK part of me - deletable 
 
 
                   // FK not part of me - replaceable 
                       // ums.afile-نوع المستند	doc_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.afile set doc_type_id='$id_replace' where doc_type_id='$id' ");
 
 
 
                   // MFK
                       // mcc.content_type-أنواع المستندات	doc_type_mfk  
                        $this->execQuery("update ${server_db_prefix}mcc.content_type set doc_type_mfk=REPLACE(doc_type_mfk, ',$id,', ',') where doc_type_mfk like '%,$id,%' ");
 
               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); 
                        // FK on me 
                       // ums.afile-نوع المستند	doc_type_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.afile set doc_type_id='$id_replace' where doc_type_id='$id' ");
 
 
                        // MFK
                       // mcc.content_type-أنواع المستندات	doc_type_mfk  
                        $this->execQuery("update ${server_db_prefix}mcc.content_type set doc_type_mfk=REPLACE(doc_type_mfk, ',$id,', ',$id_replace,') where doc_type_mfk like '%,$id,%' ");
 
 
               } 
               return true;
            }    
	}
        
        public function calcExtentions()
        {
             $ext = $this->getVal("valid_ext");
             $ext = strtoupper(str_replace(",", " / ", $ext));
             return $ext;
        }    
}
?>