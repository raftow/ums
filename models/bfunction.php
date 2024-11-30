<?php
class Bfunction extends UmsObject{

        public function __construct(){
		parent::__construct("bfunction","id","ums");
                UmsBfunctionAfwStructure::initInstance($this);
	}

        // PROCESS - إجراء  
        public static $BFUNCTION_TYPE_PROCESS = 2; 

        // STAT - إحصائية آلية  
        public static $BFUNCTION_TYPE_STAT = 6; 

        // SCREEN_TAB - تبويب في شاشة  
        public static $BFUNCTION_TYPE_SCREEN_TAB = 7; 

        // MOBILE_APP - تطبيق جوال  
        public static $BFUNCTION_TYPE_MOBILE_APP = 8; 

        // REPORT - تقرير  
        public static $BFUNCTION_TYPE_REPORT = 13; 

        // WEB_SERVICE - خدمة ويب داخلية  
        public static $BFUNCTION_TYPE_WEB_SERVICE = 10; 

        // EXTERNAL_URL - رابط ويب خارجي  
        public static $BFUNCTION_TYPE_EXTERNAL_URL = 9; 

        // SCREEN - شاشة  
        public static $BFUNCTION_TYPE_SCREEN = 1; 

        // MENU - قائمة  
        public static $BFUNCTION_TYPE_MENU = 5; 

        // QUERY - كويري  
        public static $BFUNCTION_TYPE_QUERY = 11; 

        // FGROUP - مجموعة حقول  
        public static $BFUNCTION_TYPE_FGROUP = 14; 

        // SCREEN_GROUP - مجموعة شاشات  
        public static $BFUNCTION_TYPE_SCREEN_GROUP = 12; 

        // STEP - مرحلة  
        public static $BFUNCTION_TYPE_STEP = 3; 

        // SCREEN_METHOD - وظيفة في شاشة  
        public static $BFUNCTION_TYPE_SCREEN_METHOD = 4;
        
        
	public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= "bfunction"; 
        public static $DB_STRUCTURE = null; 
        
        
        
        
        public static function loadByUK($uk_vals)
        {
             $obj = new Bfunction();
             $obj->select("curr_class_module_id",$uk_vals["curr_class_module_id"]);
             $obj->select("bfunction_code",$uk_vals["bfunction_code"]);
             if($obj->load())
             {
                return $obj;
             }
             else
             {
                return null;
             }
        }
        
        public static function loadByMainIndex($curr_class_module_id, $bfunction_code,$create_obj_if_not_found=false)
        {
           $obj = new Bfunction();
           $obj->select("curr_class_module_id",$curr_class_module_id);
           $obj->select("bfunction_code",$bfunction_code);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("curr_class_module_id",$curr_class_module_id);
                $obj->set("bfunction_code",$bfunction_code);
                $obj->is_new = true;
                $obj->insert();
                return $obj;
           }
           else return null;
           
        }

        public static function loadByBusinessIndex($id_system, $curr_class_module_id, $curr_class_atable_id, $file_specification, $bf_specification="", $create_obj_if_not_found=false)
        {
           if(!$id_system) throw new AfwRuntimeException("loadByMainIndex : id_system is mandatory field");
           if(!$curr_class_module_id) throw new AfwRuntimeException("loadByMainIndex : curr_class_module_id is mandatory field");
           if(!$curr_class_atable_id) throw new AfwRuntimeException("loadByMainIndex : curr_class_atable_id is mandatory field");
           if(!$file_specification) throw new AfwRuntimeException("loadByMainIndex : file_specification is mandatory field");


           $obj = new Bfunction();
           $obj->select("id_system",$id_system);
           $obj->select("curr_class_module_id",$curr_class_module_id);
           $obj->select("curr_class_atable_id",$curr_class_atable_id);
           $obj->select("file_specification",$file_specification);
           $obj->select("bf_specification",$bf_specification);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("id_system",$id_system);
                $obj->set("curr_class_module_id",$curr_class_module_id);
                $obj->set("curr_class_atable_id",$curr_class_atable_id);
                $obj->set("file_specification",$file_specification);
                $obj->set("bf_specification",$bf_specification);

                $obj->insertNew();
                if(!$obj->id) return null; // means beforeInsert rejected insert operation
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }

        

        public function getShortDisplay($lang="ar")
        {                
                $lang = strtolower(trim($lang));
                if(!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
                
                if($lang=="fr") $lang_suffix = "_en";
                elseif($lang=="ar") $lang_suffix = "";
                else $lang_suffix = "_".$lang;

                $fn = trim($this->getVal("titre_short$lang_suffix"));
                if(!$fn) $fn = trim($this->getVal("titre$lang_suffix"));
                if(!$fn) $fn = "bf.".$this->id;
                

                $curr_class_module_id = $this->getVal("curr_class_module_id");
                $curr_class_module_code = AfwPrevilege::moduleCodeOfModuleId($curr_class_module_id);
                
                return AfwReplacement::trans_replace($fn, $curr_class_module_code, $lang);
        }
        
        
        
        public function getDisplay($lang="ar")
        {
             return $this->getShortDisplay($lang);
        }
        
        
        
        public function beforeInsert($id, $fields_updated) {
             return $this->beforeMAJ($id, $fields_updated);
        }
        
        
        public function beforeUpdate($id, $fields_updated) {
                global $_SERVER;
             
                $id_system = $this->getVal("id_system");
                $file = $this->getVal("file_specification");
                $curr_class_module_id = $this->getVal("curr_class_module_id");
                $curr_class_atable_id = $this->getVal("curr_class_atable_id");
                $bf_spec = $this->getVal("bf_specification");
                // die("BF-$id_system-$file-$curr_class_module_id-$curr_class_atable_id-$bf_spec => ".var_export($_SERVER["BF-$id_system-$file-$curr_class_module_id-$curr_class_atable_id-$bf_spec"],true));
                $_SERVER["BF-$id_system-$file-$curr_class_module_id-$curr_class_atable_id-$bf_spec"] =& $this;
                
                return $this->beforeMAJ($id, $fields_updated);  
        }
        
        
        public function beforeMAJ($id, $fields_updated) 
        {
              global $lang;  //// old require of common_string
                
                if(!$this->getVal("titre")) {
                           $this->set("titre",$this->getVal("titre_short"));
                }

                if(!$this->getVal("titre_short")) {
                           $this->set("titre_short",$this->getVal("titre"));
                }
                
                if(($this->isToBeInUserStory()) and (!$this->isEmpty()) and (!$this->isInUserStory()))
                {
                    $this->generateUserStory($lang, 0, false);  
                }
                
		return true;
	}
        
        public function afterInsert($id, $fields_updated) 
        {
                global $lang;
                if(($this->isToBeInUserStory()) and (!$this->isEmpty()) and (!$this->isInUserStory()))
                {
                    $this->generateUserStory($lang, 0, false);  
                }
        
        }
        
        public function resetAllGeneratedUserStories()
        {
              
              $system_id = $this->getVal("id_system");
                // $module_id = $this->getVal("curr_class_module_id");
                
                // disable old autogenerated user stories
                $ustr0 = new UserStory;
                
                // $ustr0->select("system_id",$system_id);
                // $ustr0->select("module_id",$module_id);
                
                $count_affected = 0;
                
                $ustr0->resetUpdates();
                $ustr0->select("bfunction_id",$this->getId());
                $ustr0->where("source not like '%-manual'");
                $count_affected += $ustr0->logicDelete(true,false);
                
                $ustr0->resetUpdates();
                $ustr0->set("user_story_goal_id", 0, true);
                $ustr0->select("bfunction_id",$this->getId());
                $ustr0->where("source not like '%-manual'");
                //$ustr0->where("user_story_goal_id not in (select id from ${server_db_prefix}b au.goal where system_id=$system_id and goal_code like 'manual%')");
                $count_affected += $ustr0->update(false);
                
                $ustr0->resetUpdates();
                $ustr0->set("arole_id", 0, true);
                $ustr0->select("bfunction_id",$this->getId());
                $ustr0->where("source not like '%-manual'");
                //$ustr0->where("arole_id not in (select id from ${server_db_prefix}ums.arole where system_id=$system_id and role_code like 'manual%')");
                $count_affected += $ustr0->update(false);
                
                return array("","$count_affected user storie(s) affected");
        
        }
        
        public function isStats()
        {
              $file_specification = $this->getVal("file_specification");
              return($file_specification=="stats");
        }
        
        public function isEnumOrLookup()
        {
              $tableObj = $this->getCurrTable();
              return ($tableObj and $tableObj->isEnumOrLookup());
        }
        
        public function getCurrTable()
        {
                if(self::pagIsThere())
                {
                        $tableObj_id = $this->getVal("curr_class_atable_id");
                        return Atable::loadById($tableObj_id);
                }
                
        }
        
        public function enumLookupModule()
        {
                $tableObj = $this->getCurrTable();
                
                if($tableObj and $tableObj->isEnumOrLookup())
                {
                     return $tableObj->hetSubModule();
                }
                
                return null;
        
        }
        
        public static function bfOperationToCode($oper)
        {
             if($oper=="edit") return array(1, "تعديل / إضافة");
             if($oper=="insert") return array(1, "تعديل / إضافة");
             if($oper=="update") return array(1, "تعديل / إضافة");
             if($oper=="display") return array(2, "إستعلام / عرض");
             if($oper=="search") return array(2, "إستعلام / عرض");
             if($oper=="qsearch") return array(2, "إستعلام / عرض");
             if($oper=="show") return array(2, "إستعلام / عرض");
             if($oper=="retrieve") return array(2, "إستعلام / عرض");
             if($oper=="delete") return array(3,"مسح");
             if($oper=="stats") return array(4,"إحصائيات");
             if($oper=="qedit") return array(5,"إدارة سريعة");
             
             return -1;
        }
        
        public function generateUserStory($lang="ar", $framework=0, $commit=true)
        {
                if(!$framework) $framework=AfwSession::config("framework_id", 1);
                if(!$this->getId()) return array("user story can't be created because bfunction is still empty","");
                
                $this_display = $this->getShortDisplay($lang);
                
                
                $tableObj = $this->getCurrTable();
                $system_id = $this->getVal("id_system");
                if(!$system_id) $system_id = 1;
                $module_id = $this->getVal("curr_class_module_id");
                $ustr_arr = array();

                $errors = array();
                $infos = array();

                
                if(!$tableObj) 
                {
                        $this->resetAllGeneratedUserStories();
                        $jrl_code = "sdd-manager";
                        $default_job_id = 52;
                        $ustr = UserStory::loadByMainIndex($system_id, $module_id, $default_job_id, $this->getId(), $create_obj_if_not_found=true);
                        if(!$ustr->getId()) throw new AfwRuntimeException("loadByMainIndex($system_id, $module_id, $default_job_id, ".$this->getId().") failed !",array("SQL"=>true));
                        $ustr->set("source","not-auto-generated");
                           
                        $ustr->putGoalIfNeeded();
                        $ustr_arr[$ustr->getId()] = $ustr;
                        $infos[] = "هذه الوظيفة [$this_display]   لا تحتوي على جدول مرتبط بها ";
                }
                else
                { 
                        $atable_display = $tableObj->getShortDisplay($lang);
                        /* raf:b au-v2 include("$file_dir_name/../lib/framework_${framework}_specification.php"); */
                        
                        $tbl_cat = $tableObj->tableCategory();
                        
                        
                        $this->resetAllGeneratedUserStories();
                        
        
                        $bfOperation = $this->getVal("file_specification");
                        
                        list($id_oper_bf, $oper_display) = self::bfOperationToCode($bfOperation);
                        
                        if($id_oper_bf)
                        {
                             $goalConcernList = $tableObj->getGoalConcernList($id_oper_bf);
                             if(count($goalConcernList)==0)
                             {
                                   $errors[]  = "لا يوجد أهداف تتعلق باجراء هذه العملية [$oper_display] على هذا الجدول [$atable_display]";
                             }
                             foreach($goalConcernList as $goalConcernObj)
                             {
                                  $goalConcernObj_display = $goalConcernObj->getShortDisplay($lang);
                                  
                                  $jroleObj = $goalConcernObj->hetJobrole();
                                  if($jroleObj) 
                                  {
                                        $ustr = UserStory::loadByMainIndex($system_id, $module_id, $jroleObj->getId(), $this->getId(), $create_obj_if_not_found=true);
                                        $goal_id = $goalConcernObj->getVal("goal_id");
                                        $ustr->set("user_story_goal_id", $goal_id);
                                        $ustr->set("source","auto-generated-v2");
                                        $ustr->set("comments","goal concern v2 : ". $goalConcernObj->getDisplay($lang));
                                        $ustr->update();
                                  }
                                  else
                                  {
                                        $errors[]  = "السعي : [$goalConcernObj_display] لا يحتوي على مسؤولية تنفذه";
                                  }      
                             }
                        }
                        else
                        {
                             $errors[]  = "[$bfOperation] is unkownm operation code";
                        }
                        
                        /* raf:b au-v2                
                        $jrl_code = $framework_mode_list[$bfOperation]["categories"][$tbl_cat];
                        $goal_code = $framework_mode_list[$bfOperation]["goals"][$tbl_cat];
                        list($goal_code_type, $goal_code_value) = explode(":",$goal_code);
                        
                                              
                        if($jrl_code) $jrlist = $tableObj->getJobrolesByCode($jrl_code);
                        else $jrlist = array();
                        
                        if(count($jrlist)==0)
                        {
                             throw new AfwRuntimeException("for table $tableObj category = $tbl_cat for operation=$bfOperation, code of jobroles=[$jrl_code] return empty list (method: Atable::getJobrolesByCode)");
                        }

                        
                        $jrlist_text = "";
                        
                        foreach($jrlist as $jroleObj)
                        {
                              $jrlist_text .= $jroleObj->getDisplay($lang);
                              
                              $ustr = UserStory::loadByMainIndex($system_id, $module_id, $jroleObj->getId(), $this->getId(), $create_obj_if_not_found=true);
                              if(!$ustr->getId()) throw new AfwRuntimeException("loadByMainIndex($system_id, $module_id, ".$jroleObj->getId().", ".$this->getId().") failed !",array("SQL"=>true));
                              if($ustr->getVal("user_story_goal_id")>0)
                              {
                                     $user_story_goal = $ustr->het("user_story_goal_id");
                                     $ustr_source = $ustr->getVal("source");
                                     //throw new AfwRuntimeException("generateUserStory user story $ustr ($ustr_source) found with non empty goal $user_story_goal");
                                     //strange but we will put it 0
                                     $ustr->set("user_story_goal_id",0);
                              }
                              // init these values but they should be changed
                              // if found like this not changed there's problem in the goal choice process
                              $ustr->set("source","not-auto-generated");
                              $ustr->set("comments","no decision taken to choose the goal");
                              
                              if($goal_code_type=="id")
                              {
                                          $goal_id = $goal_code_value;
                                          $goal_decision = "goal id forced by framework config for [oper=$bfOperation][categ=$tbl_cat] => $goal_code";
                                          // die("$this : $goal_code -> $goal_id");
                              }
                              else
                              {
                                    if(!$goal_code_type)
                                    {
                                          $goal_code_type = "endswith";
                                          $goal_code_value = "lookup";
                                    }
                                    
                                    if($goal_code_type=="endswith")
                                    {
                                          $tableId = $tableObj->getId();
                                          $goal = $jroleObj->findGoalWithCodeEndsWith("-".$goal_code_value,$tableId);
                                          if($goal) 
                                          {
                                                $goal_id = $goal->getId();
                                                $goal_decision = "goal [$goal] for found for table $tableId and goal code ([oper=$bfOperation][categ=$tbl_cat] => $goal_code)";
                                          }
                                          //if($goal_code_value=="data") throw new AfwRuntimeException("generateUserStory debugg $jroleObj -> findGoalWithCodeEndsWith(-$goal_code_value,$tableId) => $goal");
                                    }      
                              }
                              
                              if($goal_id) 
                              {
                                      //if($goal_code_value=="data") throw new AfwRuntimeException("generateUserStory debugg ustr->set(user_story_goal_id, $goal_id)");
                                      $ustr->set("user_story_goal_id", $goal_id);
                                      $ustr->set("source","auto-generated");
                                      $ustr->set("comments",$goal_decision);
                                      $ustr->update();
                              }
                              else $ustr->putGoalIfNeeded();
                               
                              //$ustr->beforeMAJ($ustr->getId(), array());
                              
                              // @todo : check : id in (select arole_id from ".$server_db_prefix."ums.job_arole where jobrole_id = §jobrole_id§ and module_id = §module_id§ and avail='Y')
                              $jroleObj->optimG ettingItems["jobAroleList"] = true;
                              $jroleObj->optimG ettingItems["roles"] = true; 
                              
                              
                              
                              
                              $ustr_arr[$ustr->getId()] = $ustr;
                              
                              $jrlist_text .=  " : ".$ustr->getDisplay($lang).", <br>";
                        }
                        
                        $ustr_arr_count = count($ustr_arr);
                        
                        $_jobroles_codes_help = "
 // djs : DisplayJobroles  <br>
 // em  : Entity Manager Jobrole <br>
 // bm  : Business Manager Jobrole <br>
 // sm  : System Manager Jobrole <br>
 // mm  : Monitoring Manager Jobrole <br>
";                        
                        return array("","$ustr_arr_count user story(ies) generated for (job-code=$jrl_code), jobrole(s) : <br> $jrlist_text <br> $_jobroles_codes_help");
                        */
                }
                
                $errors_text = implode("<br>\n",$errors);
                $infos_text = implode("<br>\n",$infos);
                
                return array($errors_text,$infos_text);

        }
        
        
       
       public static function disableAutoGeneratedBFs($id_system, $module_id, $bf_code_starts_with)
       {
           global $file_dir_name;
               
               include_once("$file_dir_name/../ums/arole_bf.php");
               
               $rbf = new AroleBf();
               
               $rbf->where("bfunction_id in (select id from ".$server_db_prefix."ums.bfunction 
                                                where id_system='$id_system' 
                                                  and curr_class_module_id='$module_id' 
                                                  and bfunction_code like '$bf_code_starts_with%') 
                            and (source='auto-generated' or source='' or source is null)");
               
               $rbf->set($rbf->fld_ACTIVE(),'N');
               $rbf->update(false);
               
               $bf = new Bfunction();
               if((!$id_system) or (!$bf_code_starts_with))
               {
                   throw new AfwRuntimeException("You should specify id_system and starts of bf code to disable auto generated BFs.");
               }
               $bf->select("id_system",$id_system);
               $bf->select("curr_class_module_id",$module_id);
               $bf->where("bfunction_code like '$bf_code_starts_with%'");
               
               $bf->set($bf->fld_ACTIVE(),'N');
               $bf->update(false);
       
       }

       public static function getOrCreateScriptBfunction($id_system, $module_id, $file_specification, $bf_spec, $bf_name, $bf_name_en, $bf_desc="", $bf_desc_en="", $public="N", $bf_type=1, $bf_code="", $bf_complexity=0,$bf_priority=0,$resetUS=false)
       {
                if(!$bf_code) 
                {
                        //die("Bfunction::getOrCreateScriptBfunction(id_system=$id_system, module_id=$module_id, file_specification=$file_specification, bf_spec=$bf_spec, bf_name=$bf_name, bf_name_en=$bf_name_en, bf_desc=$bf_desc, bf_desc_en=$bf_desc_en, public=$public, bf_type=$bf_type, bf_code=$bf_code, bf_complexity=$bf_complexity,bf_priority=$bf_priority,resetUS=$resetUS)");
                        $bf_code = trim($file_specification,".php");
                }
                if(!$bf_spec) $bf_spec = 'none';
                $bf = new Bfunction();
                $bf->select("id_system",$id_system);
                $bf->select("curr_class_module_id",$module_id);
                $bf->select("file_specification",$file_specification);
                $bf->select("bf_specification",$bf_spec);

                if($bf->load())
                {
                        $bf->activate();
                        return $bf;
                }
                else
                {                
                        $bf->set("id_system",$id_system);    // system
                        $bf->set("curr_class_module_id",$module_id);  // module itself 
                        $bf->set("file_specification", $file_specification);  // source code of BF
                        $bf->set("bf_specification",$bf_spec);

                        $bf->set("curr_class_atable_id",0);  // no related table
                        $bf->set("direct_access","N");
                        $bf->set("public",$public);
                        $bf->set("titre_short",$bf_name);
                        $bf->set("titre_short_en",$bf_name_en);
                        $bf->set("titre",$bf_desc);
                        $bf->set("titre_en",$bf_desc_en);
                        $bf->set("bfunction_type_id",$bf_type);
                        $bf->set("avail",'Y');
                        $bf->set("bfunction_code",$bf_code);
                        $bf->set("bf_complexity",$bf_complexity);
                        $bf->set("bf_priority",$bf_priority);
                        
                        
                        $bf->insert();
                }

                return $bf;
                 
       }

       public static function createNewBfunction($id_system, $file, $curr_class_module_id, $curr_class_atable_id, $bf_spec, $bf_name, $bf_name_en, $bf_desc="", $bf_desc_en="", $direct_access="obsolete-param", $public="N", $bf_type=1, $bf_code="", $bf_complexity=0,$bf_priority=0,$resetUS=false)
       {

        
                if($curr_class_module_id and $bf_code) $bf = Bfunction::loadByMainIndex($curr_class_module_id, $bf_code,$create_obj_if_not_found=true);
                else $bf = new Bfunction();
                                
                $bf->set("id_system",$id_system);    // system
                $bf->set("file_specification",$file);  // source code of BF
                $bf->set("curr_class_module_id",$curr_class_module_id);  // module itself (where table curr_class_atable_id is)
                $bf->set("curr_class_atable_id",$curr_class_atable_id);  // related table
                if(!$bf_spec) $bf_spec = 'none';
                $bf->set("bf_specification",$bf_spec);
                
                $bf->set("direct_access","Y");
                $bf->set("public",$public);
                $bf->set("titre_short",$bf_name);
                $bf->set("titre_short_en",$bf_name_en);
                $bf->set("titre",$bf_desc);
                $bf->set("titre_en",$bf_desc_en);
                $bf->set("bfunction_type_id",$bf_type);
                $bf->set("avail",'Y');
                $bf->set("bfunction_code",$bf_code);
                $bf->set("bf_complexity",$bf_complexity);
                $bf->set("bf_priority",$bf_priority);
                
                
                $bf->commit();

                return $bf;
                 
       }
       
        // Search Bfunction by 5 fields :
        // id_system   => system
        // file_specification  => source file (or hazm mode if framework = hazm, means : bf code starts with "hazm_")
        // curr_class_module_id  => module itself (where table curr_class_atable_id is)
        // curr_class_atable_id
        // bf_specification
       
       public static function getOrCreateBF($id_system, $file, $curr_class_module_id, $curr_class_atable_id, $bf_spec, $bf_name, $bf_name_en, $bf_desc, $bf_desc_en, $direct_access="N", $public="N", $bf_type=1, $bf_code="", $bf_complexity=0,$bf_priority=0,$resetUS=false)
       {
                             
                $bf = Bfunction::getBfunction($id_system, $file, $curr_class_module_id, $curr_class_atable_id, $bf_spec);
                if(!$bf)
                {
                        $bf = self::createNewBfunction($id_system, $file, $curr_class_module_id, $curr_class_atable_id, $bf_spec, $bf_name, $bf_name_en, $bf_desc, $bf_desc_en, $direct_access, $public, $bf_type, $bf_code, $bf_complexity,$bf_priority,$resetUS);
                        // $id_bf = $bf->getId();
                        // obsolete
                        // $_SESSION["BFS"]["BF-$id_system-$file-$curr_class_module_id-$curr_class_atable_id-$bf_spec"] =& $bf;
                        // $_SESSION["BFS"]["BF-BYID-$id_bf"] =& $bf;
                        $bf_new = true;
                }
                
                if($bf)
                {
                        $bf->set("direct_access",$direct_access);
                        $bf->set("public",$public);
                        $bf->set("titre_short",$bf_name);
                        $bf->set("titre_short_en",$bf_name_en);
                        $bf->set("titre",$bf_desc);
                        $bf->set("titre_en",$bf_desc_en);
                        $bf->set("bfunction_type_id",$bf_type);
                        $bf->set($bf->fld_ACTIVE(),'Y');
                        $bf->set("bfunction_code",$bf_code);
                        $bf->set("bf_complexity",$bf_complexity);
                        $bf->set("bf_priority",$bf_priority);
                        if($resetUS) $bf->resetAllGeneratedUserStories();                        
                        $bf->update();
                        
                }
                
                return array($bf,$bf_new);
        }
        
        
       public function disableMeFromMenus($lang="ar", $only_auto_generated=false)
       {
           global $file_dir_name;
               
               include_once("$file_dir_name/../ums/arole_bf.php");
               
               $rbf = new AroleBf();
               $rbf->select("bfunction_id",$this->getId()); 
               if($only_auto_generated) $rbf->where("source='auto-generated' or source='' or source is null");
               
               $rbf->set($rbf->fld_ACTIVE(),'N');
               $nb_rows = $rbf->update(false);
               
               
               return array("",$this->getShortDisplay($lang)." : this business function is disabled from $nb_rows menu(s)");
       
       }
        
        
        public static function getBfunctionById($id_bf)
        {
                
                // if($_SESSION["BFS"]["BF-BYID-$id_bf"]) 
                //   return $_SESSION["BFS"]["BF-BYID-$id_bf"]; 
                
                $bf = new Bfunction();

                if($bf->load($id_bf)) 
                {
                      // $_SESSION["BFS"]["BF-BYID-$id_bf"] =& $bf;
                      return $bf;
                }
                else return null;
        }
                
        public static function getBfunction($id_system, $file_specification, $curr_class_module_id, $curr_class_atable_id, $bf_specification="")
        {
                
                global $getBfunction, $gloablBFS;
                if(!$getBfunction) $getBfunction = 0;
                else $getBfunction++;
                
                if($getBfunction>10) 
                {
                        throw new AfwRuntimeException("getBfunction($id_system, $file_specification, $curr_class_module_id, $curr_class_atable_id, $bf_specification) entered too much time AfwSession::log_all_data = " .AfwSession::log_all_data());
                }

                
                 if($gloablBFS["BF-$id_system-$file_specification-$curr_class_module_id-$curr_class_atable_id-$bf_specification"]) 
                   return $gloablBFS["BF-$id_system-$file_specification-$curr_class_module_id-$curr_class_atable_id-$bf_specification"]; 
                
                $bf = new Bfunction();
                $bf->select("id_system",$id_system);
                $bf->select("file_specification",$file_specification);
                $bf->select("curr_class_module_id",$curr_class_module_id);
                $bf->select("curr_class_atable_id",$curr_class_atable_id);
                // si $bf_specification n'est pas specifie cela veut dire qu'on accepte toute valeur 
                // et que ce champ contiendra une valeur par defaut et le fait de la changer ne change rien au fait que c'est la telle business function
                // si $bf_specification est specifie cela veut dire que ce param s'il change ce n'est plus la meme BF 
                if($bf_specification) $bf->select("bf_specification",$bf_specification);
                
                if($bf->load()) 
                {
                      $gloablBFS["BF-$id_system-$file_specification-$curr_class_module_id-$curr_class_atable_id-$bf_specification"] =& $bf;
                      return $bf;
                }
                else return null;
        }
        
        
        public function getFormuleResult($attribute, $what='value') 
        {
            global $lang;   
            $server_db_prefix = AfwSession::config("db_prefix","default_db_"); 
               
	       switch($attribute) 
               {
                    case "arole_mfk" :
                        $rl = new Arole();
                        
                        $bf_id = $this->getId();
                        $sql_cond = "avail='Y' and id in (select arole_id from ".$server_db_prefix."ums.arole_bf where bfunction_id='$bf_id' and avail='Y')"; // obsolete : bfunction_mfk like '%,$bf_id,%' or 
                        $rl->where($sql_cond); 
                        $rl_list = $rl->loadMany();

                        $return = AfwFormatHelper::decodeObjectList($rl_list,$what,$lang, $implodeSeparator=","); 
                        // if($what != "value") die("arole_mfk as $what return ".var_export($return,true));
                        return $return;
                    break;
                    
                    case "is_special" :
                        return ($this->isSpecial()) ? 'Y' : 'N'; 
                    break;
                    
                    case "tobinus" :
                        return ($this->isToBeInUserStory()) ? 'Y' : 'N'; 
                    break;
                    
                    case "tobinus_reason" :
                        return $this->isToBeInUserStoryReason(); 
                    break;
                    
                    case "mainGoal" :
                        return $this->getMyMainGoal(); 
                    break;
                    
                    
               }
        }
        
        
        
        public function getMyMainGoal()
        {
                $tbl = $this->getCurrTable();
                if($tbl) return $tbl->getMyMainGoal();
                else return "";
        }
        
        public function isSpecial()
        {
           $direct_access = $this->_isDirect_access();
           $bf_specification = $this->getVal("bf_specification");
           
           return (($direct_access) or ($bf_specification== 'SPECIAL'));
        }
        
        public function isMenu()
        {
             $framework=AfwSession::config("framework_id", 1);
             if($this->getVal("curr_class_atable_id"))
             {
                 $tbl = $this->getCurrTable();
                 if($tbl) $tbl_cat = $tbl->tableCategory();
                 else $tbl_cat = "default";
                 
                 $framework_file_php = dirname(__FILE__)."/../../lib/framework_${framework}_specification.php";
                 include($framework_file_php);
                 $mode = $this->getVal("file_specification");
                 if(($mode=="qsearch") and ($tbl_cat=="entity") and (!$framework_mode_list[$mode]["menu"][$tbl_cat]))
                 {
                    throw new AfwRuntimeException("$framework_file_php : error in framework ${framework} specification menu for mode $mode for category $tbl_cat not defined true : ".var_export($framework_mode_list,true));
                 }
                 
                 
                 return $framework_mode_list[$mode]["menu"][$tbl_cat];
             }
             else
             {
                 if($this->getId()==101434) throw new AfwRuntimeException("error this bf should have table ".var_export($this,true));
                 
                 return ($this->getVal("bfunction_type_id")==5);
             }    
                 
        }
        
        
        public function getUrl()
        {
              if($this->getVal("curr_class_atable_id"))
              {
                  $this_id = $this->getId();
                  $bf_specification = $this->getVal("bf_specification");
                  $file_specification = $this->getVal("file_specification");
                  $tableObj = $this->getCurrTable();
                  $tableObj_id = $tableObj->id;
                  $tableObj_name = $tableObj->getVal("atable_name");
                  $cl = $tableObj->getTableClass();
                  $currmod_obj = $tableObj->hetModule();
                  if(!$currmod_obj) throw new AfwRuntimeException("This BF id = $this_id ($file_specification) is related to table ($tableObj_id) $tableObj_name that does'nt have module defined !");
                  $currmod = $currmod_obj->getVal("module_code");
                  $url = "main.php?Main_Page=afw_mode_".$file_specification.".php&cl=$cl&currmod=$currmod";
                  if($bf_specification and ($bf_specification!="none")) $url .= "&$bf_specification"; 
              }
              else
              {
                  $direct_access = $this->is("direct_access");
                  $bf_specification = $this->getVal("bf_specification");
                  $file_specification = $this->getVal("file_specification");
                  if($direct_access)
                     $url = $file_specification;
                  else
                     $url = "main.php?Main_Page=".$file_specification;
                  if($bf_specification and ($bf_specification!="none")) $url .= "&$bf_specification";   
              }
              
              return $url;
        
        }
        
        protected function getPublicMethods()
        {
            
            $pbms = array();
            
            $color = "yellow";
            $title_ar = "إنشاء نسخة مطابقة"; 
            $pbms["xc19CB"] = array("METHOD"=>"creerCopie","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true);
            
            
            $color = "green";
            $title_ar = "توليد قصص المستخدم"; 
            $pbms["vc12CA"] = array("METHOD"=>"generateUserStory","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true);
            
            
            $color = "blue";
            $title_ar = "تحديث الصلاحيات اللازمة"; 
            $pbms["x1azbA"] = array("METHOD"=>"updateBFRoles","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true);
            
            
            $color = "red";
            $title_ar = "تعطيلي من  جميع القوائم"; 
            $pbms["x4sdaB"] = array("METHOD"=>"disableMeFromMenus","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true);
            
            
            $color = "red";
            $title_ar = "تصفير جميع قصص المستخدمين المولدة"; 
            $pbms["xj52kJ"] = array("METHOD"=>"resetAllGeneratedUserStories","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true);
            
            
            
            
            
            
            return $pbms;
        }
        
        public function creerCopie($lang="ar")
        {
            $field_vals=array();
            $field_vals["bfunction_code"] = "copy-of-".$this->getVal("bfunction_code");
            $field_vals["bf_specification"] = "copy-of-".$this->getVal("bf_specification");
             
            $field_vals["titre_short_en"] = $this->getVal("titre_short_en") . " -- copy";
            $field_vals["titre_short"] = $this->getVal("titre_short") . " -- نسخة";
            return $this->createCopy($lang, $field_vals);
        }
        
        public function getPhpCode()
        {
                $this_id = $this->getId();
                
                if($this->_isSpecial())
                {
                        return $this->getVal("bfunction_code");
                }
                else
                {
                        $tbl = $this->getCurrTable();;
                        if($tbl)
                        {
                        $my_upper_atable_name = strtoupper($tbl->getVal("atable_name"));
                        $my_upper_mode = strtoupper($this->getVal("file_specification")); 
                        
                        return "BF_${my_upper_mode}_$my_upper_atable_name";
                        
                        }
                        else throw new AfwRuntimeException("BF $this_id is not special and has no table class defined !");
                }
             
             
        
        }
        
        protected function getSpecificDataErrors($lang="ar",$show_val=true,$step="all",$erroned_attribute=null,$stop_on_first_error=false, $start_step=null, $end_step=null)
        {
              $sp_errors = array();
              
              if(($this->isToBeInUserStory()) and (!$this->isInUserStory()))
              {
                   $sp_errors["bfunction_type_id"] = "هذه الوظيفة يجب أن تكون  ضمن قصة مستخدم";
              } 
              
              
              return $sp_errors;
        }
        
        public static function listUserStoriesBFTypes()
        {
              $listBFTypes = array();
              
        
              $listBFTypes[self::$BFUNCTION_TYPE_FGROUP] = self::$BFUNCTION_TYPE_FGROUP;
              $listBFTypes[self::$BFUNCTION_TYPE_SCREEN_TAB] = self::$BFUNCTION_TYPE_SCREEN_TAB;
              $listBFTypes[self::$BFUNCTION_TYPE_SCREEN] = self::$BFUNCTION_TYPE_SCREEN;
              $listBFTypes[self::$BFUNCTION_TYPE_REPORT] = self::$BFUNCTION_TYPE_REPORT;
              $listBFTypes[self::$BFUNCTION_TYPE_SCREEN_METHOD] = self::$BFUNCTION_TYPE_SCREEN_METHOD;


              return $listBFTypes;              
        }
         
        
        public function isToBeInUserStory()
        {
             $listBFTypes = self::listUserStoriesBFTypes();
             
             $myTable = $this->getCurrTable();
             $bf_type = $this->getVal("bfunction_type_id");
             
             if(!$myTable) return ($listBFTypes[$bf_type]>0);
             
             $has_opt_full_scr = $myTable->hasOption($myTable::$TBOPTION_OPEN_ROLES_ON_FULL_SCREEN);
             $has_opt_fgroup = $myTable->hasOption($myTable::$TBOPTION_OPEN_ROLES_ON_FIELD_GROUPS);
             $has_opt_scrTabs = $myTable->hasOption($myTable::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS);
             
             $full_screen_option = true; //($has_opt_full_scr or ((!$has_opt_fgroup) and (!$has_opt_scrTabs)));
             
             
             return (
                    (($bf_type==self::$BFUNCTION_TYPE_FGROUP) and ($has_opt_fgroup)) or 
                    (($bf_type==self::$BFUNCTION_TYPE_SCREEN_TAB) and ($has_opt_scrTabs)) or
                    (($bf_type==self::$BFUNCTION_TYPE_SCREEN) and ($full_screen_option))
                    );
        } 
        
        public function isToBeInUserStoryReason()
        {
             $listBFTypes = self::listUserStoriesBFTypes();
             
             $myTable = $this->getCurrTable();
             $bf_type = $this->getVal("bfunction_type_id");
             
             if(!$myTable)
             {
                  if($listBFTypes[$bf_type]>0) return "not associated to table but bf_type=$bf_type is in U.S. BF types";
                  else return "not associated to table and bf_type=$bf_type is not in U.S. BF types";
             }
             

             $myTable_name = $myTable->getVal("atable_name");

             if((($bf_type==self::$BFUNCTION_TYPE_FGROUP) and ($myTable->hasOption($myTable::$TBOPTION_OPEN_ROLES_ON_FIELD_GROUPS)))) return "bf_type=$bf_type (BFUNCTION_TYPE_FGROUP) and option TBOPTION_OPEN_ROLES_ON_FIELD_GROUPS ".$myTable::$TBOPTION_OPEN_ROLES_ON_FIELD_GROUPS." is activated in table $myTable_name";
             if((($bf_type==self::$BFUNCTION_TYPE_SCREEN_TAB) and ($myTable->hasOption($myTable::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS)))) return "bf_type=$bf_type (BFUNCTION_TYPE_SCREEN_TAB) and option TBOPTION_OPEN_ROLES_ON_SCREEN_TABS ".$myTable::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS." is activated in table $myTable_name";
             
             $has_opt_full_scr = $myTable->hasOption($myTable::$TBOPTION_OPEN_ROLES_ON_FULL_SCREEN);
             $has_opt_fgroup = $myTable->hasOption($myTable::$TBOPTION_OPEN_ROLES_ON_FIELD_GROUPS);
             $has_opt_scrTabs = $myTable->hasOption($myTable::$TBOPTION_OPEN_ROLES_ON_SCREEN_TABS);
             
             $full_screen_option = true;
             
             // die(var_export([$has_opt_full_scr,(!$has_opt_fgroup),(!$has_opt_scrTabs), ((!$has_opt_fgroup) and (!$has_opt_scrTabs)), $full_screen_option],true));
             
             if(($bf_type==self::$BFUNCTION_TYPE_SCREEN) and ($full_screen_option)) 
                         return "bf is a screen (BFUNCTION_TYPE_SCREEN) and option TBOPTION_OPEN_ROLES_ON_FULL_SCREEN is on for table $myTable_name 
                                      (us on full screen=$has_opt_full_scr,us on field group=$has_opt_fgroup,us on screen Tab=$has_opt_scrTabs)";

             if(($bf_type==self::$BFUNCTION_TYPE_SCREEN_TAB) and ($has_opt_scrTabs)) 
                         return "bf is a screen tab (BFUNCTION_TYPE_SCREEN_TAB) and option TBOPTION_OPEN_ROLES_ON_SCREEN_TABS is on for table $myTable_name 
                                      (us on full screen=$has_opt_full_scr,us on field group=$has_opt_fgroup,us on screen Tab=$has_opt_scrTabs)";

             if(($bf_type==self::$BFUNCTION_TYPE_FGROUP) and ($has_opt_fgroup)) 
                         return "bf is a screen fgroup (BFUNCTION_TYPE_FGROUP) and option TBOPTION_OPEN_ROLES_ON_FIELD_GROUPS is on for table $myTable_name 
                                      (us on full screen=$has_opt_full_scr,us on field group=$has_opt_fgroup,us on screen Tab=$has_opt_scrTabs)";
             
             
             return "bf_type=$bf_type and (us on full screen = $has_opt_full_scr, us on field group=$has_opt_fgroup, us on screen Tab = $has_opt_scrTabs)";
             
        }
        

        public function isInUserStory()
        {
                if(!$this->id) return false;
                
                if(AfwSession::config("MODE_DEVELOPMENT",false))
                {                            
                    AfwAutoLoader::addModule("b"."au");   
                    return count(UserStory::loadAll($this->id));
                }
                else return true;
        }
        
        public function getIsMenu()
        {
                $framework=AfwSession::config("framework_id", 1);
                
                if(!$this->getId()) return false;
                $tableObj = $this->getCurrTable();
                if(!$tableObj) return false; 

                $file_dir_name = dirname(__FILE__);
                include("$file_dir_name/../lib/framework_${framework}_specification.php");
                
                $tbl_cat = $tableObj->tableCategory();
                
                $bfOperation = $this->getVal("file_specification");
                
                if(!$bfOperation) return false;
                if(!$tbl_cat) return false;
                                 
                $menu = $framework_mode_list[$bfOperation]["menu"][$tbl_cat];
        
                return $menu;
        }
        
        
        public function updateBFRoles($lang="ar")
        {
                $menu = $this->getIsMenu();
                
                list($warn,$err,$info) = $this->updateMeInUserStoryListAroles($menu,$lang);
                if($warn) $err .= "\n<br>warnings : ".$warn;
                return array($err,$info);
        }        

        
        public function updateMeInUserStoryListAroles($menu,$lang="ar")
        {
              $this_display = $this->getShortDisplay($lang);
              
              $userStoryList = $this->get("userStoryList");
              
              $warn_arr = array();
              $err_arr = array();
              $info_arr = array();
              
              $nb_roles = 0;
              
              $examples_roles = "";
              
              if(count($userStoryList)==0)
              {
                  if($menu) $err_arr[] = "لا يوجد قصص مستخدم لهذه الوظيفة [$this_display] وهي في عداد القوائم";
              }
              
              foreach($userStoryList as $userStoryID => $userStoryItem)
              {
                   if($userStoryItem)
                   {
                        $arole = $userStoryItem->het("arole_id");
                        if($arole) 
                        {
                                list($warn,$err,$info) = $this->updateMeInArole($arole,$menu,$lang);
                                if($warn) $warn_arr[] = $warn;
                                if($err) $err_arr[] = $err;
                                if($info) $info_arr[] = $info;
                                
                                $nb_roles++;
                                if(strlen($examples_roles)<80) $examples_roles .= $arole->getShortDisplay($lang).",";
                        }
                        else
                        {
                                $userStoryItemDisplay = $userStoryItem->getShortDisplay($lang);
                                $err_arr[] = "قصة المستخدم [$userStoryItemDisplay] لا تحتوي على الصلاحية المستخدمة لتنفيذها";
                        }
                   }
                   else
                   {
                        $err_arr[] = "قصة المستخدم $userStoryID غير صحيحة أو تم حذفها";
                   }
              }
              
              $info_arr[] = "$nb_roles صحلاية(ات) تم ربطها بالوظيفة [$this_display] ومن أمثلة ذلك ما يلي ($examples_roles)";
              
              return array(implode(" / \n",$warn_arr),
                           implode(" / \n",$err_arr),
                           implode(" / \n",$info_arr));
        }
        
        public function updateMeInArole($arole,$menu=-1,$lang="ar")
        {
                  if($menu==-1) $menu = $this->getIsMenu();
                  // $role_name = $arole->getDisplay($lang);
                  $role_id = $arole->getId();
                  $bf_id = $this->getId();
                  
                  $info = "";
                  $err = "";
                  $warn = "";
                  
                  list($err, $info) = $arole->addBF($bf_id);
                  
                  /*
                  if($menu)
                  {
                       $arole->addRemoveInMfk("bfunction_mfk",array($bf_id), array());
                  }
                  else
                  {
                       $mfk_before = $arole->getVal("bfunction_mfk");
                       $arole->addRemoveInMfk("bfunction_mfk",array(), array($bf_id));
                       $mfk_after = $arole->getVal("bfunction_mfk");
                       
                       if($mfk_before <> $mfk_after)
                       {
                           $warn = "تم حذف الوظيفة $this - $bf_id من الدور الوظيفي($role_name - $role_id) (قبل:$mfk_before | بعد:$mfk_after)";
                       }
                  }*/
                  
                  return array($warn,$err,$info);
        }
        
        public function attributeIsApplicable($attribute)
        {
              if($attribute=="tobinus_reason")
              {
                  //return $this->is("tobinus"); 
              }
              
              return true;
        }
        
        
        public function beforeDelete($id,$id_replace) 
        {
                $server_db_prefix = AfwSession::config("db_prefix","default_db_");
 
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 
 
 
                       // spp.ticket-الوظيفة الالكترونية	bfunction_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("delete from ${server_db_prefix}spp.ticket where bfunction_id = '$id' ");
                       // ums.arole_bf-الوظيفة	bfunction_id  أنا تفاصيل لها-OneToMany


                       // b au.user_story-الوظيفة العملية	bfunction_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("delete from ${server_db_prefix}b au.user_story where bfunction_id = '$id' ");
 
 
                       // FK not part of me - replaceable 
                       // ums.bfunction-الوظيفة العملية الأم	parent_bfunction_id  حقل يفلتر به-ManyToOne
                        
 
 
                       // MFK
                       // ums.arole-ما في القائمة من وظائف خاصة (غير الكرود)	bfunction_mfk  
                        $this->execQuery("update ${server_db_prefix}ums.arole set bfunction_mfk=REPLACE(bfunction_mfk, ',$id,', ',') where bfunction_mfk like '%,$id,%' ");
 
               }
               else
               {
                         // FK on me 
                       // spp.ticket-الوظيفة الالكترونية	bfunction_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("update ${server_db_prefix}spp.ticket set bfunction_id='$id_replace' where bfunction_id='$id' ");
                       // ums.arole_bf-الوظيفة	bfunction_id  أنا تفاصيل لها-OneToMany
                        $this->execQuery("update ${server_db_prefix}ums.arole_bf set bfunction_id='$id_replace' where bfunction_id='$id' ");
                       // b au.user_story-الوظيفة العملية	bfunction_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("update ${server_db_prefix}b au.user_story set bfunction_id='$id_replace' where bfunction_id='$id' ");
                       // ums.bfunction-الوظيفة العملية الأم	parent_bfunction_id  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}ums.bfunction set parent_bfunction_id='$id_replace' where parent_bfunction_id='$id' ");
 
                        // MFK
                       // ums.arole-ما في القائمة من وظائف خاصة (غير الكرود)	bfunction_mfk  
                        $this->execQuery("update ${server_db_prefix}ums.arole set bfunction_mfk=REPLACE(bfunction_mfk, ',$id,', ',$id_replace,') where bfunction_mfk like '%,$id,%' ");
 
 
               } 
               return true;
            }    
	}
        
        
        public function getRAMObjectData()
        {
                  $category_id = 6;

                  $typeObj = $this->getType();
                  $lookup_code = $typeObj->getVal("lookup_code");
                  $typeObj = RAMObjectType::loadByMainIndex($lookup_code); 
                  $type_id = $typeObj->getId();
                  
                  $code = $this->getVal("bfunction_code");
                  if(!$code) $code = "bfunction-".$this->getId(); 
                  $name_ar = $this->getVal("titre_short");
                  $name_en = $this->getVal("titre_short_en");
                  $specification = $this->getVal("titre");
                  
                  $childs = array();
                  
                  $childs[6] =  $this->get("childList");
                  $childs[11] =  $this->get("userStoryList");
                  
                  return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
        
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

        public function getIcon()
        {
                global $MENU_ICONS;
                $icon_table = "";
                $tableObj = $this->getCurrTable();
                
                if($tableObj)
                {
                        $icon_table = $tableObj->icon;
                }

                if(contient($this->bfunction_code,"search"))
                {
                        return $icon_table ? $icon_table."s hzm-icon-search" : "search";
                } 

                if(contient($this->bfunction_code,"stats"))
                {
                        return $icon_table ? $icon_table."s hzm-icon-stats" : "stats";
                }
                
                if(contient($this->bfunction_code,"edit")) return $icon_table ? $icon_table : "edit";
                if(contient($this->bfunction_code,"delete")) return "delete";

                return $MENU_ICONS["BF-".$this->id]." bficon-".$this->id." bfc-".$this->bfunction_code;
        }

        public function findMeInRoles($aroles_ids, $context="log")
        {
                if(!$aroles_ids) return false;
                $bf_in_roles_code = "find-roles($aroles_ids)-in-bf-".$this->id;

                $in_cache = AfwSession::getVar($bf_in_roles_code);
                if($in_cache)
                {
                        if($in_cache != "not-found") return $in_cache;
                        else return false;
                }
                global $lang;
                AfwSession::contextLog("look to find $this in roles : $aroles_ids", $context);
                list($role_item, $role_item_sql) = $this->relRbfList()->resetWhere("avail='Y' and arole_id in ($aroles_ids)")->getFirst();
                
                AfwSession::contextLog("sql : $role_item_sql role_item = $role_item", $context);
                
                
                if($role_item) AfwSession::setVar($bf_in_roles_code, "bf found in role ".$role_item->getDisplay($lang));
                else AfwSession::setVar($bf_in_roles_code, "not-found");

                if(AfwSession::getVar($bf_in_roles_code) != "not-found") return AfwSession::getVar($bf_in_roles_code);
                else return false;
        }


        public function isEasyAttribute($attribute)
        {
                if($attribute=="bfunction_code") return true;
                return false;
        }

        public function myShortNameToAttributeName($attribute){
                if($attribute=="system") return "id_system";
                if($attribute=="type") return "bfunction_type_id";
                if($attribute=="table") return "curr_class_atable_id";
                if($attribute=="title") return "titre_short";
                if($attribute=="title_en") return "titre_short_en";
                if($attribute=="special") return "is_special";
                return $attribute;
        }

        public function getScenarioItemId($currstep)
        {
                if($currstep == 1) return 115;
                if($currstep == 2) return 116;
                if($currstep == 3) return 117;
                if($currstep == 4) return 118;

                return 0;
        }
                                
                                                                                  
                
}
// old	
// alter table ".$server_db_prefix."ums.bfunction add   parent_bfunction_id int(11) DEFAULT NULL  after bfunction_type_id;

// 23/1/2023
// ALTER TABLE `bfunction` CHANGE `id_system` `id_system` INT(11) NOT NULL DEFAULT '0';
// 27/9/2024
// ALTER TABLE `bfunction` ADD `hierarchy_level_enum` SMALLINT NOT NULL DEFAULT '999' AFTER `bfunction_code`;	


?>