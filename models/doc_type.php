<?php

// ALTER TABLE xxx_ums.doc_type add   titre_short_en varchar(48)  DEFAULT NULL  AFTER titre_short;
class DocType extends AFWObject{

        // lookup Value List codes 
        // ATTACHEMENT - مرفق آخر  
        public static $DOC_TYPE_ATTACHEMENT = 7; 

        // ATTESTATION - شهادة حضور دورة تدريبية  
        public static $DOC_TYPE_ATTESTATION = 2; 

        // AWARD - جائزة  
        public static $DOC_TYPE_AWARD = 23; 

        // BANNER - بنر   
        public static $DOC_TYPE_BANNER = 9; 

        // BIG_PHOTO - صورة تعريفية  
        public static $DOC_TYPE_BIG_PHOTO = 13; 

        // BOOK - كتاب دراسي  
        public static $DOC_TYPE_BOOK = 8; 

        // CERTIFICATE - شهادة إحترافية (مهارة)  
        public static $DOC_TYPE_CERTIFICATE = 4; 

        // CV - سيرة ذاتية  
        public static $DOC_TYPE_CV = 20; 

        // DIPLOMA - مؤهل علمي  
        public static $DOC_TYPE_DIPLOMA = 6; 

        // EMPLOYMENT - شهادة توظيف  
        public static $DOC_TYPE_EMPLOYMENT = 19; 

        // EVENT - حضور فعالية  
        public static $DOC_TYPE_EVENT = 25; 

        // EXAM - شهادة اجتياز اختبار  
        public static $DOC_TYPE_EXAM = 28; 

        // EXCEL - ملف بيانات اكسل للاستيراد  
        public static $DOC_TYPE_EXCEL = 14; 

        // EXPERIENCE - شهادة خبرة  
        public static $DOC_TYPE_EXPERIENCE = 3; 

        // EXTERNAL_PHOTO - صورة خارجية  
        public static $DOC_TYPE_EXTERNAL_PHOTO = 15; 

        // IDN_PHOTO - صورة الهوية  
        public static $DOC_TYPE_IDN_PHOTO = 18; 

        // INTERNAL_PHOTO - صورة داخلية  
        public static $DOC_TYPE_INTERNAL_PHOTO = 16; 

        // LOCATION - صورة الخريطة  
        public static $DOC_TYPE_LOCATION = 17; 

        // MEMBERSHIP - شهادة عضوية  
        public static $DOC_TYPE_MEMBERSHIP = 26; 

        // OTHER_CERTIFICATE - شهادات أخرى  
        public static $DOC_TYPE_OTHER_CERTIFICATE = 5; 

        // PATENT - براءة اختراع  
        public static $DOC_TYPE_PATENT = 24; 

        // PHOTO - صورة فوتو  
        public static $DOC_TYPE_PHOTO = 27; 

        // PRACTICE_PLAN - المقترح البحثي  
        public static $DOC_TYPE_PRACTICE_PLAN = 22; 

        // PRO - Doc type » 11  
        public static $DOC_TYPE_PRO = 11; 

        // SMALL_PHOTO - شعار / ايقونة  
        public static $DOC_TYPE_SMALL_PHOTO = 12; 

        // SPRODUCT - الانتاج العلمي  
        public static $DOC_TYPE_SPRODUCT = 21; 

        // TAZKIA - تزكية  
        public static $DOC_TYPE_TAZKIA = 29; 

        // UNKNOWN - غير معروف  
        public static $DOC_TYPE_UNKNOWN = 1; 

        // VIDEO - فيديو توضيحي  
        public static $DOC_TYPE_VIDEO = 10;
        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null; 
        
	
	public function __construct($tablename="doc_type"){
		parent::__construct($tablename,"id","ums");
                $this->public_display = true;
                $this->IS_LOOKUP = true;
                $this->IS_SMALL_LOOKUP = true;
                $this->DISPLAY_FIELD_BY_LANG = ['ar'=>'titre_short', 'en'=>'titre_short_en',];
                $this->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
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
              return array($ext_arr, $ft_arr, $ft_used);
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
