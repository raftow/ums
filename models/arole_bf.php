<?php
                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class AroleBf extends AFWObject{
 
        public static $MY_ATABLE_ID=13481; 
        // إجراء إحصائيات حول وظائف في صلاحية 
        public static $BF_STATS_AROLE_BF = 102878; 
        // إدارة وظائف في صلاحية 
        public static $BF_QEDIT_AROLE_BF = 102873; 
        // إنشاء وظيفة في صلاحية 
        public static $BF_EDIT_AROLE_BF = 102872; 
        // الاستعلام عن وظيفة في صلاحية 
        public static $BF_QSEARCH_AROLE_BF = 102877; 
        // البحث في وظائف في صلاحية 
        public static $BF_SEARCH_AROLE_BF = 102876; 
        // عرض تفاصيل وظيفة في صلاحية 
        public static $BF_DISPLAY_AROLE_BF = 102875; 
        // مسح وظيفة في صلاحية 
        public static $BF_DELETE_AROLE_BF = 102874; 
 
 
	public static $DATABASE		= ""; 
    public static $MODULE		    = "ums"; 
    public static $TABLE			= ""; 
    public static $DB_STRUCTURE = null; /* = array(
                "id" => array("SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "TYPE" => "PK"),

        module_id     => array("TYPE" => "FK", "ANSWER" => "module",  
                    SHOW => false, EDIT => false,            
                    CATEGORY=>SHORTCUT, SHORTCUT=>"bfunction_id.curr_class_module_id", 
                    SHORTNAME=>module, ANSMODULE => ums),

		arole_id => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, "EDIT" => true, "QEDIT" => true, 
                                    SIZE => 64, "SEARCH-ADMIN" => true, SHOW => true, "EDIT-ADMIN" => true, "UTF8" => false, 
                                    TYPE => FK, ANSWER => arole, SHORTNAME=>role, ANSMODULE => ums, DEFAUT => 0,
                                    WHERE=>"(§bfunction_id§ = '0' or §module_id§ = 0 or module_id = §module_id§)"),

		bfunction_id => array(RELATION => OneToMany, SEARCH => true, SHOW => true, RETRIEVE => true, 
                                        EDIT => true, QEDIT => true, 
                                        SIZE => 64, "SEARCH-ADMIN" => true, SHOW => true, "EDIT-ADMIN" => true, "UTF8" => false, 
                                        TYPE => FK, ANSWER => bfunction, ANSMODULE => ums,                                         
                                        SHORTNAME=>bf, DEFAUT => 0, AUTOCOMPLETE=>true),

		menu => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, 
                        "EDIT" => true, "QEDIT" => true, CSS=> width_pct_25, 
                        "SEARCH-ADMIN" => true, SHOW => true, "EDIT-ADMIN" => true, 
                        "UTF8" => false, "TYPE" => "YN", CHECKBOX=>true),

        avail => array(SHOW => true, "RETRIEVE" => false, EDIT => true, 
                        DEFAUT => "Y", "TYPE" => "YN", "QEDIT-ADMIN" => true, CHECKBOX=>true, CSS=> width_pct_25),                        
        
        source => array("IMPORTANT" => "IN", "SEARCH" => true, "SHOW" => true, "RETRIEVE" => true, 
                    "EDIT" => true, "QEDIT" => true, 
                    "SIZE" => 60, "SEARCH-ADMIN" => true, SHOW => true, "EDIT-ADMIN" => true,  
                    "TYPE" => "TEXT", "UTF8" => false,),


                "id_aut" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_aut" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "TYPE" => "DATETIME"),
                "id_mod" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_mod" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "TYPE" => "DATETIME"),
                "id_valid" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "TYPE" => "FK", "ANSWER" => "auser", "ANSMODULE" => "ums"),
                "date_valid" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "TYPE" => "DATETIME"),
                
                "version" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "TYPE" => "INT"),
                "update_groups_mfk" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                "delete_groups_mfk" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                "display_groups_mfk" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "ANSWER" => "ugroup", "ANSMODULE" => "ums", "TYPE" => "MFK"),
                "sci_id" => array(SHOW => true, HIDE_IF_NEW => true, STEP => 99,"RETRIEVE" => false, "QEDIT" => false, "TYPE" => "FK", "ANSWER" => "scenario_item", "ANSMODULE" => "pag"),
	);
	
	*/ public function __construct()
        {
		parent::__construct("arole_bf","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
                $this->DISPLAY_FIELD = "";
                $this->ORDER_BY_FIELDS = "";
                $this->after_save_edit = array("class"=>'Arole',"attribute"=>'arole_id', "currmod"=>'ums',"currstep"=>4);
	}
		
        public static function loadById($id)
        {
           $obj = new AroleBf();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public function getDisplay($lang = 'ar')
        {
               list($bfunction_title,$link) = $this->displayAttribute("bfunction_id",false, $lang);
               list($arole_title,$link2) = $this->displayAttribute("arole_id",false, $lang);
               $this_id = $this->getId();
               $bf_id = $this->getVal("bfunction_id");
               $arole_id = $this->getVal("arole_id");
               $bf_code = $this->getVal("bfunction_id.bfunction_code"); 
               $rbf_tit = $bfunction_title . " ($bf_id) =>  $arole_title ($arole_id)";
               if($this->getVal("menu")=="Y")
               {
                   return $rbf_tit;
               }
               else
               {
                   //$id_trans = $this->translate("id",$lang);
                   $hidden_trans = $this->translateOperator("HIDDEN-MENU",$lang);
                   return $hidden_trans." ". $rbf_tit;
               }
               
        }
        
        
        public function beforeMAJ($id, $fields_updated)
        {
              $bf = $this->hetBF();
              $role = $this->hetRole();
              
              $active = $this->isActive();
              
              
              if($bf and $role)
              {
                  if($bf->isMenu())
                  {
                       /*
                       if($active)
                       {
                           $bf_to_remove = array();
                           $bf_to_add = array($bf->getId());
                       }
                       else
                       {
                           $bf_to_remove = array($bf->getId());
                           $bf_to_add = array();
                       }
                       
                       $mfk_before = $role->getVal("bfunction_mfk");
                       $role->addRemoveInMfk("bfunction_mfk",$bf_to_add, $bf_to_remove);
                       $mfk_after = $role->getVal("bfunction_mfk");
                       
                       // if($bf->getId()==101434) throw new AfwRuntimeException("before:$mfk_before | after:$mfk_after ");
                       
                       $menu_added = $role->update();
                       */
                  }
                  else
                  {
                       // if($bf->getId()==101434) throw new AfwRuntimeException("bf is not menu ".var_export($bf,true));
                  }
              }
              else
              {
                  throw new AfwRuntimeException("bf and role should be defined in arole_bf : ".var_export($this,true));
              }
              
              return true;
        }
        

	public function beforeDelete($id,$id_replace) 
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

        public function shouldBeCalculatedField($attribute){
            if($attribute=="module_id") return true;
            return false;
        }

        public function myShortNameToAttributeName($attribute){
            if($attribute=="module") return "module_id";
            if($attribute=="role") return "arole_id";
            if($attribute=="bf") return "bfunction_id";
            return $attribute;
        }
}
?>