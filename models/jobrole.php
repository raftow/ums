<?php


class Jobrole extends UmsObject
{

     private $mainGoal = null;

     public static $DATABASE          = "";
     public static $MODULE              = "ums";
     public static $TABLE               = "jobrole";
     public static $DB_STRUCTURE = null;
     
     

     public function __construct()
     {
          parent::__construct("jobrole", "id", "ums");
          $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
          //$this->ORDER_BY_FIELDS = "id_sh_org,id_sh_div,min_exp desc, min_injob_exp desc,titre_short"; // id_sh_dep,
          $this->ORDER_BY_FIELDS = "id_domain, id_sh_org, id_sh_div, titre_short";
          $this->UNIQUE_KEY = array('id_domain', 'jobrole_code');
          $this->AUTOCOMPLETE_FIELD = "titre_short";
          $this->editByStep = true;
          $this->editNbSteps = 3;
          $this->showQeditErrors = true;
          $this->showRetrieveErrors = true;
          $this->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
          $this->after_save_edit = array("class"=>'Domain',"attribute"=>'id_domain', "currmod"=>'p'.'ag',"currstep"=>2);
     }

     public static function loadById($id)
     {
          $obj = new Jobrole();
          $obj->select_visibilite_horizontale();
          if ($obj->load($id)) {
               return $obj;
          } else return null;
     }

     public static function loadAll($id_domain=0)
     {
        $obj = new CustomerType();
        $obj->select("active",'Y');
        $obj->select("id_domain", $id_domain);
        if($id_domain) $objList = $obj->loadMany();
        
        return $objList;
     }

     public static function loadByMainIndex($id_domain, $jobrole_code, $create_obj_if_not_found = false)
     {
          $obj = new Jobrole();
          if (!$id_domain) throw new AfwRuntimeException("loadByMainIndex : id_domain is mandatory field");
          if (!$jobrole_code) throw new AfwRuntimeException("loadByMainIndex : jobrole_code is mandatory field");


          $obj->select("id_domain", $id_domain);
          $obj->select("jobrole_code", $jobrole_code);

          if ($obj->load()) {
               if ($create_obj_if_not_found) $obj->activate();
               return $obj;
          } elseif ($create_obj_if_not_found) {
               $obj->set("id_domain", $id_domain);
               $obj->set("jobrole_code", $jobrole_code);

               $obj->insert();
               $obj->is_new = true;
               return $obj;
          } else return null;
     }

     public function getDisplay($lang = 'ar')
     {
          /*$objme = AfwSession::getUserConnected();
                
                $id = "";
                
                if($objme->isSuperAdmin())
                {
                     $id = trim($this->getId());
                     $id = " ($id)";
                }*/

          // $domain = $this->hetDomain();

          if ($lang == "ar") $fn = trim($this->valtitre_short());
          if ($lang == "en") $fn = trim($this->valtitre_short_en());

          return $fn;  // $domain."->".
     }

     public function getDropDownDisplay($lang = 'ar')
     {
          /*$objme = AfwSession::getUserConnected();
                
                $id = "";
                
                if($objme->isSuperAdmin())
                {
                     $id = trim($this->getId());
                     $id = " ($id)";
                }*/

          $domain = null; //$this->hetDomain();

          if ($lang == "ar") $fn = trim($this->valtitre_short());
          if ($lang == "en") $fn = trim($this->valtitre_short_en());
          if ($domain and ($domain->getId() > 0)) $fn = $domain->getDropDownDisplay($lang) . "->" . $fn;

          return $fn;
     }

     public function getModeDisplayLink()
     {
          $disp = $this->getDisplay();
          $id = $this->getId();
          return "<a style='color:#fff !important' target='_jr_mode_display' href='main.php?Main_Page=afw_mode_display.php&cl=Jobrole&id=$id&currmod=ums'>$disp</a>";
     }


     protected function getOtherLinksArray($mode, $genereLog = false, $step = "all")
     {
          global $lang, $Main_Page;

          if ($Main_Page == "afw_mode_edit.php") $mode_origin = "edit";
          if ($Main_Page == "afw_mode_qedit.php") $mode_origin = "qedit";
          if ($Main_Page == "afw_mode_search.php") $mode_origin = "search";
          if (!$mode_origin) $mode_origin = "display";


          $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);
          $my_id = $this->getId();
          $displ = $this->getDisplay($lang);

          /*
             if($mode=="mode_conds")
             {
                        if(true) //if($this->getVal("id_sh_dep") == 5)  
                        {
                                   unset($link);
                                   $auser_id = $this->getId();
                                   $link = array();
                                   $title = "شروط الأهلية لهذه الوظيفة";
                                   $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=JobCondition&currmod=sdd&mode_origin=$mode_origin&id_origin=$job_id&class_origin=Jobrole&module_origin=ums&newo=3&limit=30&ids=all&fixmtit=$title&fixmdisable=1&fixm=job_id=$job_id&sel_job_id=$job_id";
                                   $link["TITLE"] = $title;
                                   $link["UGROUPS"] = array();
                                   $otherLinksArray[] = $link;
                        }        
             }
             */

          if ($mode == "mode_jobAroleList") {
               unset($link);
               $my_id = $this->getId();
               $link = array();
               $title = "إدارة صلاحيات المسؤولية الوظيفية ";
               $title_detailed = $title . " : " . $displ;
               $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=JobArole&currmod=ums&id_origin=$my_id&class_origin=Jobrole&module_origin=ums&newo=10&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=jobrole_id=$my_id&sel_jobrole_id=$my_id";
               $link["TITLE"] = $title;
               $link["UGROUPS"] = array();
               $otherLinksArray[] = $link;
          }
          /*
          if ($mode == "mode_jobGoalList") {
               unset($link);
               $my_id = $this->getId();
               $link = array();
               $title = "إدارة  أهداف المسؤولية الوظيفية";
               $title_detailed = $title . " : " . $displ;
               $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=Goal&currmod=b au&id_origin=$my_id&class_origin=Jobrole&module_origin=ums&newo=4&limit=30&ids=all&fixmtit=$title_detailed&fixmdisable=1&fixm=jobrole_id=$my_id&sel_jobrole_id=$my_id";
               $link["TITLE"] = $title;
               $link["UGROUPS"] = array();
               $otherLinksArray[] = $link;
          }*/

          return $otherLinksArray;
     }

     protected function getSpecificDataErrors($lang="ar",$show_val=true,$step="all",$erroned_attribute=null,$stop_on_first_error=false, $start_step=null, $end_step=null)
     {
          $sp_errors = array();

          //if(count($this->getRoles()) == 0)


          return $sp_errors;
     }

     protected function getPublicMethods()
     {

          $pbms = array();

          $color = "green";
          $title_ar = "توليد الصلاحيات بحسب الأهداف";
          $pbms["xab5cB"] = array("METHOD" => "createArolesFromGoals", "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "");

          $color = "blue";
          $title_ar = "توليد الهدف الرئيسي";
          $pbms["ya77cA"] = array("METHOD" => "genereMainGoal", "COLOR" => $color, "LABEL_AR" => $title_ar, "ADMIN-ONLY" => true, "BF-ID" => "");



          return $pbms;
     }


     public function createArolesFromGoals($lang = "ar")
     {
          $jobGoalList = $this->het("jobGoalList");

          if ((!is_array($jobGoalList)) or (count($jobGoalList) == 0)) {
               return array("No goal found, create goals before", "");
          }

          $file_dir_name = dirname(__FILE__);
          // 
          // 

          $createdUpdatedAroles = array();

          $createdArolesCount = 0;
          $updatedArolesCount = 0;
          $attachedArolesCount = 0;


          $attachedAlready_arr = array();
          $ignored_arr = array();

          foreach ($jobGoalList as $jobGoalId => $jobGoal) {
               if ($jobGoal->getVal("module_id")) {
                    if ($jobGoal->isOk(true)) {
                         $ar = $jobGoal->getOrCreateAssociatedArole();
                         if ($ar->is_new) $createdArolesCount++;
                         else $updatedArolesCount++;



                         $ancetre = $ar->getAncetre();
                         if ($ancetre) {
                              $jar = JobArole::loadByMainIndex($this->getId(), $jobGoal->getVal("module_id"), $ancetre->getId(), $create_obj_if_not_found = true);
                              if ($jar->is_new) $attachedArolesCount++;
                              else $attachedAlready_arr[] = $jar->getDisplay($lang);
                              $createdUpdatedAroles[$jar->getId()] = $jar;
                         } else {
                              throw new AfwRuntimeException("the role $ar has no ancestor arole type = 10");
                         }
                    } else {
                         return array("الهدف الوظيفي : $jobGoal برقم تسلسلي $jobGoalId يحتوي على أخطاء", "");
                    }
               } else {
                    $ignored_arr[] = $jobGoal->getDisplay($lang);
               }
          }

          $attachedAlready_text = implode(" , ", $attachedAlready_arr);
          $ignored_text  = implode(" , ", $ignored_arr);

          $createdUpdatedArolesCount = count($createdUpdatedAroles);

          return array("", "done : $createdUpdatedArolesCount,  created : $createdArolesCount updated : $updatedArolesCount attached : $attachedArolesCount already attached : $attachedAlready_text ignored : $ignored_text");
     }

     public function getFormuleResult($attribute, $what='value')
     {
          $server_db_prefix = AfwSession::config("db_prefix", "default_db_");

          switch ($attribute) {
               case "mainApplication":
                    $domainObj = null; // $this->hetDomain();
                    $mainApplication = null;
                    if ($domainObj)  $mainApplication = $domainObj->get("mainApplication");

                    if (!$mainApplication) {
                         $this_id = $this->getId();
                         // 
                         $mainApplication = new Module();
                    }

                    if ($mainApplication->isEmpty()) {
                         $jobrole_code = $this->getVal("jobrole_code");
                         $jobrole_code_arr = explode("/", $jobrole_code);
                         if (count($jobrole_code_arr) > 1) {
                              $application_code = strtolower($jobrole_code_arr[0]);
                              $mainApplication->clearSelect();
                              $mainApplication->where("avail='Y' and id_module_type = 5 and module_code='$application_code'");
                              $mainApplication->load();
                         }
                    }

                    if ($mainApplication->isEmpty()) {
                         $mainApplication->clearSelect();
                         $mainApplication->where("id in (select distinct jar.module_id from ".$server_db_prefix."ums.job_arole jar 
                                                    where jar.avail='Y'
                                                      and jar.jobrole_id = $this_id) and avail='Y' and id_module_type = 5");

                         $mainApplication->load();
                    }

                    if ($mainApplication->isEmpty()) {
                         $jobrole_code = $this->getVal("jobrole_code");
                         $jobrole_code_arr = explode("-", $jobrole_code);
                         $application_code = strtolower($jobrole_code_arr[0]);
                         $mainApplication->clearSelect();
                         $mainApplication->where("avail='Y' and id_module_type = 5 and module_code='$application_code'");
                         $mainApplication->load();
                    }
                    // else die("stop : mainApplication '$mainApplication' is not emplty id = ".$mainApplication->getId());

                    if ($mainApplication->isEmpty()) {
                         $mainApplication->set("titre_short", "غير معروف");
                         $mainApplication->set("titre_short_en", "unknown");
                    }

                    return $mainApplication;
                    break;

               case "statsGoal":
                    if ($this->statsGoal) return $this->statsGoal;
                    $this->statsGoal = new Goal();
                    $this_id = $this->getId();
                    $this->statsGoal->where("avail='Y' and jobrole_id = $this_id and goal_code = 'stats'");
                    if ($this->statsGoal->load()) return $this->statsGoal;
                    else {
                         return "";
                    }
                    break;

               case "lookupGoal":
                    if ($this->lookupGoal) return $this->lookupGoal;
                    $this->lookupGoal = new Goal();
                    $this_id = $this->getId();
                    $this->lookupGoal->where("avail='Y' and jobrole_id = $this_id and goal_code like 'lookup%'");
                    if ($this->lookupGoal->load()) return $this->lookupGoal;
                    else {
                         return "";
                    }
                    break;

               case "mainGoal":
                    if ($this->mainGoal) return $this->mainGoal;
                    $this->mainGoal = new Goal();
                    $this_id = $this->getId();
                    $jobrole_code = $this->getVal("jobrole_code");
                    $goal_code = strtoupper($jobrole_code);
                    if (!$goal_code) return "";

                    $this->mainGoal->where("avail='Y' and jobrole_id = $this_id and goal_code = '$goal_code'");
                    if ($this->mainGoal->load()) return $this->mainGoal;
                    else {
                         return "";
                    }
                    break;



               case "myRoles":
                    $mainApplication = $this->get("mainApplication");
                    if ($mainApplication) $mainApplication_id = $mainApplication->getId();
                    else $mainApplication_id = 0;
                    if (!$mainApplication_id) $mainApplication_id = 0;

                    // 
                    $ar = new Arole();
                    $this_id = $this->getId();
                    $ar->where("id in (select distinct jar.arole_id from ".$server_db_prefix."ums.job_arole jar 
                                            where jar.avail='Y'
                                              and jar.jobrole_id = $this_id
                                              and jar.module_id = $mainApplication_id) and arole_type_id = 10");
                    return $ar->loadMany();
                    break;
          }
     }

     public function isFinished()
     {
          return (($this->getVal("id_valid") > 0) and ($this->isOk(true)));
     }


     public function finished()
     {
          return ($this->isFinished() ? "Y" : "N");
     }


     public function getMainGoalByApplication($module_id)
     {
          $file_dir_name = dirname(__FILE__);

          if ($this->mainGoal) return $this->mainGoal;
          $this->mainGoal = new Goal();
          $this_id = $this->getId();
          $jobrole_code = $this->getVal("jobrole_code");
          $goal_code = strtoupper($jobrole_code);
          if (!$goal_code) return "";

          $this->mainGoal->where("avail='Y' and jobrole_id = $this_id and module_id = $module_id and goal_code = '$goal_code'");
          if ($this->mainGoal->load()) return $this->mainGoal;
          else {
               return "";
          }
     }


     /*
        public function simulOnEmpl($empl,$lang="ar")
        {
                $ok = true;
                
                $thiscond_list =& $this->getConds();
                $application_log = "";
                
                foreach($thiscond_list as $thiscond_id => $thiscond_item)
                {
                      if($thiscond_item->isOk())
                      {
                          $coef = $thiscond_item->getVal("coef");
                          $rad = $thiscond_item->is("radical");

                          $cond =& $thiscond_item->getCond();

                          list($res, $log) = $cond->ApplyEmplOnJob($empl, $this);
                          $application_log .= "<br>$log";
                          if(!$res)
                          {
                                  $ok = false;
                                  $info = $thiscond_item->getVal("excuse_text_$lang");
                                  $info .= " :\n<br><b>".$thiscond_item->getVal("recitMe")."</b>"; //getDisplay(); // لم يتم تجاوز الشرط التالي
                                  if($rad) break;
                          }
                      }
                      else 
                      {
                         $application_log .= "<br>الوظيفة $this الشرط $thiscond_item غير مكتمل أو غير صحيح";
                         $info = "الشرط $thiscond_item غير مكتمل أو غير صحيح";
                         $ok = false;
                         break;
                      }  
                }
                
                return array($ok, $info, $application_log);
        
        }*/

     public function getRAMObjectData()
     {
          $category_id = 3;

          // $file_dir_name = dirname(__FILE__); 
          // $orgTypeObj = $this->getOrgType();
          // $lookup_code = $orgTypeObj->getVal("lookup_code");
          //$typeObj = RAMObjectType::loadByMainIndex($lookup_code); 
          $type_id = 300; //$typeObj->getId();
          $code = "jobrole-" . $this->getId();
          $name_ar = $this->getVal("titre_short");
          $name_en = $this->getVal("titre_short_en");
          $specification = $this->getVal("titre");

          $childs = array();

          // $childs[5] =  $this->get("myRoles");
          $childs[12] = $this->getAllMyGoals();

          return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
     }

     public function getAllMyGoals()
     {
          return AfwStringHelper::hzm_array_merge($this->get("jobGoalList"), $this->get("otherGoalList"));
     }

     public function findGoalWithCodeEndsWith($suffix, $atable_id = 0)
     {
          $file_dir_name = dirname(__FILE__);
          if ($atable_id) $goalListMatrix[] = GoalConcern::getJobRoleGoalListUsingTable($this->id, $atable_id);
          if (!$atable_id) $goalListMatrix[] = $this->get("jobGoalList");
          if (!$atable_id) $goalListMatrix[] = $this->get("otherGoalList");
          foreach ($goalListMatrix as $goalList) {
               foreach ($goalList as $goalItem) {
                    $goalItemCode = $goalItem->getVal("goal_code");
                    if (AfwStringHelper::stringStartsWith($goalItemCode, $suffix)) return $goalItem;
               }
          }


          return null;
     }

     public function genereMainGoal($lang = "ar")
     {
          $goalObj = $this->get("mainGoal");

          $mainApplication = $this->get("mainApplication");
          $id_domain = $this->getVal("id_domain");
          if (!$goalObj) {
               if (!$mainApplication or ($mainApplication->isEmpty())) return array("", "mainApplication is needed to generate the main goal");
               $system_id = $mainApplication->getVal("id_system");
               $module_id = $mainApplication->getId();

               if (!$system_id) return array("", "the system of mainApplication $mainApplication is not defined");

               $jobrole_code = $this->getVal("jobrole_code");
               $goal_code = strtoupper($jobrole_code);
               if (!$goal_code) return array("you need to define the jobrole code for this jobrole", "");



               $info = "";
               $err = "";



               $file_dir_name = dirname(__FILE__);
               $goalObj = Goal::loadByMainIndex($system_id, $module_id, $goal_code, $create_obj_if_not_found = true);

               $action = "created";
          } else {
               $action = "found and updated";
          }

          $goalObj->set("goal_type_id", Goal::$GOAL_TYPE_JOB_RESPONSIBILITY_GOAL);
          $goalObj->set("jobrole_id", $this->getId());
          $goalObj->set("domain_id", $id_domain);
          $goalObj->set("goal_name_en", $this->getVal("titre_short_en"));
          $goalObj->set("goal_name_ar", $this->getVal("titre_short"));
          $goalObj->set("goal_desc_en", $this->getVal("titre_en"));
          $goalObj->set("goal_desc_ar", $this->getVal("titre"));
          $goalObj->update();

          if (!$goalObj->isEmpty()) $info .= "common goal $action for this jobrole :  $goalObj<br>";
          else $err .= "common goal not $action for this jobrole :  $goalObj<br>";


          return array($err, $info);
     }


     public function beforeMAJ($id, $fields_updated)
     {
          $lang = AfwLanguageHelper::getGlobalLanguage();  

          if (!$this->getVal("titre")) {
               $this->set("titre", $this->getVal("titre_short"));
          }

          if (!$this->getVal("titre_short")) {
               $this->set("titre_short", $this->getVal("titre"));
          }

          if (!$this->getVal("titre_en")) {
               $this->set("titre_en", $this->getVal("titre_short_en"));
          }

          if (!$this->getVal("titre_short_en")) {
               $this->set("titre_short_en", $this->getVal("titre_en"));
          }


          if ((!$this->getVal("jobrole_code")) or ($this->getVal("jobrole_code") == "--")) {
               $this->set("jobrole_code", AfwStringHelper::codeNaming($this->getVal("titre_short_en")));
          } // require_once


          return true;
     }

     public function beforeDelete($id, $id_replace)
     {
          if ($id) {
               if ($id_replace == 0) {
                    $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - not deletable 
                    // b au.goal-المسؤولية الوظيفية الرئيسية في تحقيق اله	jobrole_id  أنا تفاصيل لها-OneToMany
                    // $this->execQuery("delete from ".$server_db_prefix."b au.goal where jobrole_id = '$id' and avail='N'");
                    $obj = new Goal();
                    $obj->where("jobrole_id = '$id'");
                    $nbRecords = $obj->count();
                    if ($nbRecords > 0) {
                         $this->deleteNotAllowedReason = "Used in some goal(s) as Jobrole";
                         return false;
                    }


                    $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK part of me - deletable 
                    // ums.job_arole-الوظيفة	jobrole_id  أنا تفاصيل لها-OneToMany
                    $this->execQuery("delete from ".$server_db_prefix."ums.job_arole where jobrole_id = '$id' ");
                    // sdd.job_permission-الوظيفة	jobrole_id  أنا تفاصيل لها-OneToMany
                    // $this->execQuery("delete from ".$server_db_prefix."sdd.job_permission where jobrole_id = '$id' ");
                    // b au.user_story-الدور الوظيفي	jobrole_id  أنا تفاصيل لها-OneToMany
                    // $this->execQuery("delete from ".$server_db_prefix."b au.user_story where jobrole_id = '$id' ");
                    // b au.goal_concern-المسؤولية الساعية	jobrole_id  أنا تفاصيل لها-OneToMany
                    // $this->execQuery("delete from ".$server_db_prefix."b au.goal_concern where jobrole_id = '$id' ");


                    // FK not part of me - replaceable 
                    // ums.atable-وظيفة صلاحية التعديل	jobrole_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ".$server_db_prefix."ums.atable set jobrole_id='$id_replace' where jobrole_id='$id' ");
                    // ums.module-وظيفة مسؤول الأعمال	id_analyst  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ".$server_db_prefix."ums.module set id_analyst='$id_replace' where id_analyst='$id' ");
                    // ums.module-وظيفة مسؤول المراقبة	id_hd  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ".$server_db_prefix."ums.module set id_hd='$id_replace' where id_hd='$id' ");
                    // ums.module-وظيفة مسؤول النظام	id_br  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ".$server_db_prefix."ums.module set id_br='$id_replace' where id_br='$id' ");



                    // MFK
                    // ums.atable-وظائف صلاحية العرض	jobrole_mfk  
                    $this->execQuery("update ".$server_db_prefix."ums.atable set jobrole_mfk=REPLACE(jobrole_mfk, ',$id,', ',') where jobrole_mfk like '%,$id,%' ");
                    // ums.module-وظائف صلاحية العرض	jobrole_mfk  
                    $this->execQuery("update ".$server_db_prefix."ums.module set jobrole_mfk=REPLACE(jobrole_mfk, ',$id,', ',') where jobrole_mfk like '%,$id,%' ");
                    // hrm.employee-وظائف الصلاحيات	jobrole_mfk  
                    $this->execQuery("update ".$server_db_prefix."hrm.employee set jobrole_mfk=REPLACE(jobrole_mfk, ',$id,', ',') where jobrole_mfk like '%,$id,%' ");
                    // crm.request_type-وظائف الموظفين المسموح لهم بهذا النوع من	authorized_jobrole_mfk  
                    // $this->execQuery("update ".$server_db_prefix."crm.request_type set authorized_jobrole_mfk=REPLACE(authorized_jobrole_mfk, ',$id,', ',') where authorized_jobrole_mfk like '%,$id,%' ");

               } else {
                    $server_db_prefix = AfwSession::config("db_prefix", "default_db_"); // FK on me 
                    // b au.goal-المسؤولية الوظيفية الرئيسية في تحقيق اله	jobrole_id  أنا تفاصيل لها-OneToMany
                    $this->execQuery("update ".$server_db_prefix."b au.goal set jobrole_id='$id_replace' where jobrole_id='$id' ");
                    // ums.job_arole-الوظيفة	jobrole_id  أنا تفاصيل لها-OneToMany
                    $this->execQuery("update ".$server_db_prefix."ums.job_arole set jobrole_id='$id_replace' where jobrole_id='$id' ");
                    // sdd.job_permission-الوظيفة	jobrole_id  أنا تفاصيل لها-OneToMany
                    // $this->execQuery("update ".$server_db_prefix."sdd.job_permission set jobrole_id='$id_replace' where jobrole_id='$id' ");
                    // b au.user_story-الدور الوظيفي	jobrole_id  أنا تفاصيل لها-OneToMany
                    // $this->execQuery("update ".$server_db_prefix."b au.user_story set jobrole_id='$id_replace' where jobrole_id='$id' ");
                    // b au.goal_concern-المسؤولية الساعية	jobrole_id  أنا تفاصيل لها-OneToMany
                    // $this->execQuery("update ".$server_db_prefix."b au.goal_concern set jobrole_id='$id_replace' where jobrole_id='$id' ");
                    // ums.atable-وظيفة صلاحية التعديل	jobrole_id  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ".$server_db_prefix."ums.atable set jobrole_id='$id_replace' where jobrole_id='$id' ");
                    // ums.module-وظيفة مسؤول الأعمال	id_analyst  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ".$server_db_prefix."ums.module set id_analyst='$id_replace' where id_analyst='$id' ");
                    // ums.module-وظيفة مسؤول المراقبة	id_hd  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ".$server_db_prefix."ums.module set id_hd='$id_replace' where id_hd='$id' ");
                    // ums.module-وظيفة مسؤول النظام	id_br  حقل يفلتر به-ManyToOne
                    $this->execQuery("update ".$server_db_prefix."ums.module set id_br='$id_replace' where id_br='$id' ");


                    // MFK
                    // ums.atable-وظائف صلاحية العرض	jobrole_mfk  
                    $this->execQuery("update ".$server_db_prefix."ums.atable set jobrole_mfk=REPLACE(jobrole_mfk, ',$id,', ',$id_replace,') where jobrole_mfk like '%,$id,%' ");
                    // ums.module-وظائف صلاحية العرض	jobrole_mfk  
                    $this->execQuery("update ".$server_db_prefix."ums.module set jobrole_mfk=REPLACE(jobrole_mfk, ',$id,', ',$id_replace,') where jobrole_mfk like '%,$id,%' ");
                    // hrm.employee-وظائف الصلاحيات	jobrole_mfk  
                    $this->execQuery("update ".$server_db_prefix."hrm.employee set jobrole_mfk=REPLACE(jobrole_mfk, ',$id,', ',$id_replace,') where jobrole_mfk like '%,$id,%' ");
                    // crm.request_type-وظائف الموظفين المسموح لهم بهذا النوع من	authorized_jobrole_mfk  
                    // $this->execQuery("update ".$server_db_prefix."crm.request_type set authorized_jobrole_mfk=REPLACE(authorized_jobrole_mfk, ',$id,', ',$id_replace,') where authorized_jobrole_mfk like '%,$id,%' ");


               }
               return true;
          }
     }

     public function canBePublicDisplayed()
     {
          $denied_ids_arr = [7, 2, 101, 132, 131, 134];
          // @todo : we need here to add a column to be managed in ums not hard coded by temporary
          return (!in_array($this->getId(), $denied_ids_arr));
     }

     public function stepsAreOrdered()
     {
          return false;
     }


     public function myShortNameToAttributeName($attribute){
          if($attribute=="domain") return "id_domain";
          if($attribute=="description") return "titre";
          if($attribute=="description_en") return "titre_en";
          if($attribute=="roles") return "jobAroleList";
          if($attribute=="goals") return "jobGoalList";
          if($attribute=="org") return "id_sh_org";
          if($attribute=="div") return "id_sh_div";
          return $attribute;
     }
}
