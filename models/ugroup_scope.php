<?php 

                
$file_dir_name = dirname(__FILE__); 
                
// require_once("$file_dir_name/../afw/afw.php");

class UgroupScope extends AFWObject{

        public static $MY_ATABLE_ID=3503; 
        // إحصائيات مجالات مجموعات المستخدمين 
        public static $BF_STATS_UGROUP_SCOPE = 104932; 
        // إدارة مجالات مجموعات المستخدمين 
        public static $BF_QEDIT_UGROUP_SCOPE = 104931; 
        // إنشاء مجال مجموعة مستخدمين 
        public static $BF_EDIT_UGROUP_SCOPE = 104930; 
        // البحث في مجالات مجموعات المستخدمين 
        public static $BF_SEARCH_UGROUP_SCOPE = 104928; 
        // عرض تفاصيل مجال مجموعة مستخدمين 
        public static $BF_DISPLAY_UGROUP_SCOPE = 104927; 
        // مجالات مجموعات المستخدمين 
        public static $BF_QSEARCH_UGROUP_SCOPE = 104929; 
  
        public static $DATABASE		= "uoh_ums";
        public static $MODULE		= "ums";        
        public static $TABLE		= "ugroup_scope";

	    public static $DB_STRUCTURE = null;
	
	    public function __construct(){
			parent::__construct("ugroup_scope","id","ums");
            UmsUgroupScopeAfwStructure::initInstance($this);    
	    }
        
        public static function loadById($id)
        {
           $obj = new UgroupScope();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        

        public function getScenarioItemId($currstep)
                {
                    
                    return 0;
                }
        
        public static function loadByMainIndex($ugroup_scope_fn,$create_obj_if_not_found=false)
        {


           $obj = new UgroupScope();
           $obj->select("ugroup_scope_fn",$ugroup_scope_fn);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("ugroup_scope_fn",$ugroup_scope_fn);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        public function getDisplay($lang="ar")
        {
               if($this->getVal("titre_short_$lang")) return $this->getVal("titre_short_$lang");
               $data = array();
               $link = array();
               


               
               return implode(" - ",$data);
        }
        
        
        

        
        protected function getOtherLinksArray($mode,$genereLog=false,$step="all")      
        {
             global $lang;
             // $objme = AfwSession::getUserConnected();
             // $me = ($objme) ? $objme->id : 0;

             $otherLinksArray = $this->getOtherLinksArrayStandard($mode,$genereLog,$step);
             $my_id = $this->getId();
             $displ = $this->getDisplay($lang);
             
             
             
             // check errors on all steps (by default no for optimization)
             // rafik don't know why this : \//  = false;
             
             return $otherLinksArray;
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "green";
            $title_ar = "xxxxxxxxxxxxxxxxxxxx"; 
            $methodName = "mmmmmmmmmmmmmmmmmmmmmmm";
            //$pbms[AfwStringHelper::hzmEncode($methodName)] = array("METHOD"=>$methodName,"COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true, "BF-ID"=>"", 'STEP' =>$this->stepOfAttribute("xxyy"));
            
            
            
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
                       // ums.ugroup-مجال المجموعة	ugroup_scope_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../ums/ugroup.php";
                            Ugroup::removeWhere("ugroup_scope_id='$id'");
                            // $this->execQuery("delete from ${server_db_prefix}ums.ugroup where ugroup_scope_id = '$id' ");
                            
                        } 
                        
                        

                   
                   // FK not part of me - replaceable 

                        
                   
                   // MFK

               }
               else
               {
                        // FK on me 
                       // ums.ugroup-مجال المجموعة	ugroup_scope_id  حقل يفلتر به
                        if(!$simul)
                        {
                            // require_once "../ums/ugroup.php";
                            Ugroup::updateWhere(array('ugroup_scope_id'=>$id_replace), "ugroup_scope_id='$id'");
                            // $this->execQuery("update ${server_db_prefix}ums.ugroup set ugroup_scope_id='$id_replace' where ugroup_scope_id='$id' ");
                            
                        }
                        

                        
                        // MFK

                   
               } 
               return true;
            }    
	}

	public function userIsInScope($auser,$dataObj_context)
	{
			$ugroup_scope_fn = $this->getVal("ugroup_scope_fn");
			
			if($ugroup_scope_fn)
			{
					$inScopeMethod = "check".ucwords(strtolower($ugroup_scope_fn));
					return $this->$inScopeMethod($auser,$dataObj_context);               
			}
			
			return false;
	
	}
             
}



// errors 

