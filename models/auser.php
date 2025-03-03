<?php
/*
alter table auser change username username  varchar(128);
update auser set username = email where email not like '%@company.com';

07/02/2022

alter table auser change quarter quarter varchar(40) NULL;
alter table auser change sim_card_sn sim_card_sn varchar(128) NULL;
alter table auser change ggn_code ggn_code varchar(255) NULL;
alter table auser change twitter_id twitter_id varchar(25) NULL;


16/5/2022
alter table auser change password password varchar(255) NULL;

12/1/2023

delete from auser where email is null or email = '';
ALTER TABLE `auser` ADD UNIQUE( `email`);
ALTER TABLE `auser` CHANGE `address` `address` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, 
                    CHANGE `cp` `cp` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, 
                    CHANGE `quarter` `quarter` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, 
                    CHANGE `sim_card_sn` `sim_card_sn` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, 
                    CHANGE `password` `password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, 
                    CHANGE `twitter_id` `twitter_id` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL; 

*/
// rafik 27/9/2024
// ALTER TABLE `auser` ADD `hierarchy_level_enum` SMALLINT NOT NULL DEFAULT '999' AFTER `lang_id`;
// INSERT INTO `auser` (`id`, `id_aut`, `date_aut`, `id_mod`, `date_mod`, `id_valid`, `date_valid`, `avail`, `version`, `update_groups_mfk`, `delete_groups_mfk`, `display_groups_mfk`, `sci_id`, `city_id`, `country_id`, `mobile_type_id`, `idn_type_id`, `lang_id`, `hierarchy_level_enum`, `address`, `cp`, `email`, `genre_id`, `firstname`, `f_firstname`, `idn`, `lastname`, `mobile`, `mobile_sn`, `mobile_code`, `pwd`, `quarter`, `sim_card_sn`, `ggn_code`, `username`, `ldap`, `password`, `remember_token`, `fb_id`, `google_id`, `twitter_id`, `valide_email`, `valide_mobile`, `email_token`, `mobile_activation_id`, `email_token_expiry_date`, `remember_token_expiry_date`, `last_selected_school`) VALUES ('2', '1', '2024-12-26 07:45:10.000000', '1', '2024-12-26 07:45:10.000000', NULL, NULL, 'Y', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '999', NULL, NULL, 'robot@company.com', '1', 'المهمة', NULL, NULL, 'الآلية', NULL, NULL, NULL, '123456', NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);        

$file_dir_name = dirname(__FILE__); 
               
// old include of afw.php
// AfwAutoLoader::init();


class Auser extends UmsObject implements AfwFrontEndUser {
        
        private $myEmployeeObj = null;
        private $myEmployeeId = null;
        private $myModules = null;
        private $iCanDoOperationArray = [];

        public static $MAX_USERS_CRM_START = 1000000;
        
        public static $MY_ATABLE_ID=1407; 
        // إحصائيات حول حسابات المستخدمين 
        public static $BF_STATS_AUSER = 1890; 
        // إدارة حسابات المستخدمين 
        public static $BF_QEDIT_AUSER = 1886; 

        // بحث سريع في حسابات المستخدمين 
        public static $BF_QSEARCH_AUSER = 1968; 
        // تحرير حساب مستخدم 
        public static $BF_EDIT_AUSER = 1885; 

        // عرض تفاصيل حساب مستخدم 
        public static $BF_DISPLAY_AUSER = 1888; 
        // مسح حساب مستخدم 
        public static $BF_DELETE_AUSER = 1887; 
        
        public static $COMPTAGE_BEFORE_LOAD_MANY = true;

        public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= "auser"; 
        
        public static $DB_STRUCTURE = null; 
        
        public function __construct()
        {
                parent::__construct("auser","id","ums");
                UmsAuserAfwStructure::initInstance($this);
        }
        
        public static function robot($robot_id, $robot_code, $robot_name)
        {
                $obj = new Auser();
                if(!$obj->load($robot_id))
                {
                   $obj->set("id", $robot_id);
                }
                $obj->set("username", $robot_code);
                $obj->set("firstname", $robot_name);                
                $obj->commit();
                return $obj;
        }
        
        
        public static function loadById($id)
        {
           $obj = new Auser();
           if($id)
           {
                // if($id != 1) die("before perform Auser::loadById($id)");
                // no visibily horizontale for auser because used in all UMS processes and make infinite loops
                // $obj->select_visibilite_horizontale();
                if(!$obj->load($id))
                {
                   $obj = null;
                }

                // if($id != 1) die("after perform Auser::loadById($id) = ".var_export($obj,true));
           }
           
           return $obj; 
        }
        
        public static function loadByEmail($email,$create_obj_if_not_found=false)
        {
           $obj = new Auser();
           if(!$email) throw new AfwRuntimeException("loadByMainIndex : email is mandatory field");
 
 
           $obj->select("email",$email);
 
           if($obj->load())
           {
                if(!$obj->id) AfwRunHelper::lightSafeDie("Auser::loadByEmail($email) = Auser[$obj->id] => ".var_export($obj,true));
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("email",$email);                
                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
 
        }

        public static function isUsedEmail($email)
        {
              $user = self::loadByEmail($email);  
              if($user) return $user->id;
              else return 0;
        }


        public static function loadByUsername($username)
        {
           $obj = new Auser();
           if(!$username) throw new AfwRuntimeException("loadByUsername : username is mandatory attribute");
 
 
           $obj->select("username",$username);
 
           if($obj->load())
           {
                return $obj;
           }
           else return null;
 
        }


        public static function isInternal($username)
        {
                $obj = self::loadByUsername($username);
                if(!$obj) return false;
                return $obj->isInternalDomain();
        }



        public static function findOrCreateUser($username, $email, $firstname, $fathername, $lastname, $idn_type_id="", $idn="", $mobile="")
        {
		$obj = self::loadByEmail($email, $create_obj_if_not_found=true);
                
                $obj->set("firstname",$firstname);
                $obj->set("f_firstname",$fathername);
                $obj->set("lastname",$lastname);

                $obj->set("username",$username);

                if($mobile) $obj->set("mobile",$mobile);
                if($idn_type_id and $idn)
                {
                        $obj->set("idn_type_id",$idn_type_id);
                        $obj->set("idn",$idn);
                }
                $obj->commit();


                return $obj;
        }
                
        
        public static function loadByMainIndex($idn_type_id, $idn,$create_obj_if_not_found=false)
        {
           $obj = new Auser();
           $obj->select("idn_type_id",$idn_type_id);
           $obj->select("idn",$idn);

           if($obj->load())
           {
                if($create_obj_if_not_found) $obj->activate();
                return $obj;
           }
           elseif($create_obj_if_not_found)
           {
                $obj->set("idn_type_id",$idn_type_id);
                $obj->set("idn",$idn);

                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
           else return null;
           
        }


        
        public function getContextTables()
        {
        
        
        }
        
        
        public function i_have_one_of_roles($roles_authorized)
        {
           
           $file_dir_name = dirname(__FILE__); 
           
                
           foreach($roles_authorized as $role_authorized)
           {
               if($role_authorized)
               {
                       list($module_authorized,$role_code_authorized) = explode(".",$role_authorized);
                       if($module_authorized and $role_code_authorized)
                       {
                            list($org_id, $module_authorized_id, $mau_found) = $this->hasModule($module_authorized);
                            //if($role_authorized=="sdd.goal-45") die("$role_authorized (module=$module_authorized,role=$role_code_authorized) I have module ? => ($org_id, $module_authorized_id, $mau_found)");
                            if($module_authorized_id and $mau_found)
                            {
                                  
                                  $role = Arole::findAroleByCode($module_authorized_id,$role_code_authorized);
                                  if($role) $role_id = $role->getId(); else $role_id = 0;
                                  
                                  //if($role_authorized=="sdd.goal-45") die("(module=$module_authorized,role=$role_code_authorized) findAroleByCode($module_authorized_id,$role_code_authorized) => $role_id($role) is it in arole_mfk : ".$mau_found->getVal("arole_mfk"));
                                  if($role)
                                  {
                                      
                                      $role_found = $mau_found->findInMfk("arole_mfk", $role->getId());
                                      if($role_authorized=="sdd.goal-45") 
                                      {
                                          //if($role_found) die("الصلاحية $role موجودة في $mau_found");
                                      }
                                      if($role_found) return true;
                                  }
                                  
                            }
                       }
               } 
           }
           
           return false;
        }
        
        
        public function hasRole($module_code, $role_id)
        {
                if(!is_numeric($role_id))
                {
                        $role_code = $role_id;
                        $role_id = UmsManager::decodeRole($module_code, $role_code); 
                }
                if($role_id<=0) return false;

                list($auth, $found_roles_ids) = $this->canRunApplication($module_code);

                if(!$auth) return false;

                $found_roles_ids_arr = explode(",",$found_roles_ids);
                return in_array($role_id, $found_roles_ids_arr);
        }
        
        
        public function i_have_one_of_bfs($bfs)
        {
            if(!$bfs) return true;
            if(!is_array($bfs))
            {
                $bfs = explode(",",trim($bfs,","));
            }
            if((is_array($bfs)) and (!count($bfs))) return false;
            
            foreach($bfs as $bf_id) 
            {
                if($this->iCanDoBF($bf_id))
                {
                      return true;
                }
            }
            
            return false;    
            
        }
        
        protected function userBelongToMe($auser,$my_type_id)
        {
               if($my_type_id==1) return ($this->getId()==$auser->getId());
               
               return false;
        }
        
        public function i_belong_to_one_of_ugroups($authorized_ugroups,$dataObj)
        {
             global $file_dir_name;
             if(!$authorized_ugroups) return true;
             if((is_array($authorized_ugroups)) and (!count($authorized_ugroups))) return true;  // si aucun role défini alors tout le monde a droit donc y compris moi    
             //die("authorized_ugroups=".var_export($authorized_ugroups,true));
             foreach($authorized_ugroups as $ugroup)
             {
                if(!is_object($ugroup))
                {
                     
                     $ugroup = Ugroup::getSpecialGroup($ugroup);
                }
                
                if($ugroup->isMember($this,$dataObj)) return true;
                             
             }
             
             return false;
                
        }
        
        
        public final function isSuperAdmin()
        {
                if(class_exists("AfwSession"))
                {
                        $arr_admin = AfwSession::config("super-admin-users-arr", [1]);
                }
                else $arr_admin = [1];  // ,467,448
                return (in_array($this->getId(),$arr_admin)); // في الوقت الحالي
        }
        

        public final function isAdmin()
        {
                if($this->isSuperAdmin()) return true;
                $arr_admin = [];
                if(class_exists("AfwSession"))
                {
                        $arr_admin = AfwSession::config("admin-users-arr", []);
                }                
                return (in_array($this->getId(),$arr_admin));
        }

        public function giveMeTheseModulesAnRoles($moduleToGiveArr) // ,$my_org_id = 3
        {
                $countGived = 0;
                $log_arr = array();
                foreach($moduleToGiveArr as $module_id => $module_roles)
                {
                        $this->giveMeModule($module_id,$module_roles);
                        if(is_array($module_roles)) $module_roles = implode(",",$module_roles);
                        $log_arr[] = "gived for module $module_id : $module_roles";
                        $countGived++;
                }
                $log_arr[] = $countGived." ". $this->tm("module-role(s) has been affected to this user according to his job respobilities"); // .var_export($moduleToGiveArr,true)


                return implode("<br>\n", $log_arr);
        }

        public function removeMeTheseRoles($rolesToRemoveArr)
        {
                $countRemoved = 0;
                $log_arr = array();
                foreach($rolesToRemoveArr as $module_id => $module_roles)
                {
                        $this->removeMeRoles($module_id,$module_roles);
                        if(is_array($module_roles)) $module_roles = implode(",",$module_roles);
                        $log_arr[] = "remnove from module $module_id roles : $module_roles";
                        $countRemoved += count($module_roles);
                }
                $log_arr[] = $countRemoved." ". $this->tm("role(s) has been removed from this user"); // .var_export($moduleToGiveArr,true)
                
                return implode("<br>\n", $log_arr);
        }


        public function getMyModulesAndRoles($mod, $create_obj_if_not_found=true)
        {
                $this_id = $this->id;
                if(!$this_id) return array();
                $my_module_id = 0;
                if(is_numeric($mod))
                {
                    $my_module_id = $mod;
                }
                
                if(!$my_module_id)
                {
                        $my_module = Module::getModuleByCode(0, $mod);
                        
                        if($my_module) 
                        {
                                $my_module_id =  $my_module->getId();
                        }
                        else
                        {
                                $my_module_id = 0;   
                        }

                        if(!$my_module_id)
                        {
                             return array();
                        }
                }

                $mau = ModuleAuser::loadByMainIndex($my_module_id, $this_id, $create_obj_if_not_found);

                return array($mau->id => $mau);
        }

        public function giveMeModule($mod,$roles,$my_org_id = 3)
        {
            global $file_dir_name; 
                if(is_array($roles))
                {
                    $ids_to_add_arr = $roles;
                }
                else
                {
                    $ids_to_add_arr = explode(",", trim($roles,","));
                }
        
                if(count($ids_to_add_arr)==0)
                {
                    throw new AfwRuntimeException("give module access to a user need to define roles on this module");
                }
        
                $my_module_id = 0;
                if(is_numeric($mod))
                {
                    $my_module_id = $mod;
                }
                
                if(!$my_module_id)
                {
                        $my_module = Module::getModuleByCode($my_org_id, $mod);
                        
                        if($my_module) 
                        {
                             $my_module_id =  $my_module->getId();
                        }
                        else
                        {
                             throw new AfwRuntimeException(":: giveMeModule($mod,$roles) :: module [$mod] not found");
                        }
                }
                
                $mau = ModuleAuser::loadByMainIndex($my_module_id, $this->getId(), $create_obj_if_not_found=true);
                $ids_to_remove_arr = array();
                
                
                //throw new AfwRuntimeException("ids_to_add_arr = ".var_export($ids_to_add_arr,true));
                $arole_mfk_before = $mau->getVal("arole_mfk");
                $mau->addRemoveInMfk("arole_mfk",$ids_to_add_arr, $ids_to_remove_arr);
                $arole_mfk_after = $mau->getVal("arole_mfk");
                
                //throw new AfwRuntimeException("ids_to_add_arr = ".var_export($ids_to_add_arr,true).", arole_mfk_before = $arole_mfk_before , arole_mfk_after=$arole_mfk_after");
                
                $mau->update();
                
                
                return $mau;
                
                
        }


        public function removeMeRoles($my_module_id, $roles)
        {
            global $file_dir_name; 
        
                if(is_array($roles))
                {
                        $ids_to_remove_arr = $roles;
                }
                else
                {
                        $ids_to_remove_arr = explode(",", trim($roles,","));
                }

                if(count($ids_to_remove_arr)==0)
                {
                    return;
                }
        
                
                $ids_to_add_arr = array();
                
                
                $mau = ModuleAuser::loadByMainIndex($my_module_id, $this->getId(), $create_obj_if_not_found=false);
                if($mau)
                
                // throw new AfwRuntimeException("ids_to_add_arr = ".var_export($ids_to_add_arr,true));
                // $arole_mfk_before = $mau->getVal("arole_mfk");
                $mau->addRemoveInMfk("arole_mfk",$ids_to_add_arr, $ids_to_remove_arr);
                // $arole_mfk_after = $mau->getVal("arole_mfk");                
                // throw new AfwRuntimeException("ids_to_add_arr = ".var_export($ids_to_add_arr,true).", arole_mfk_before = $arole_mfk_before , arole_mfk_after=$arole_mfk_after");
                
                $mau->update();
                
                
                return $mau;
                
                
        }

        /* obsolete yezzi ehchem
        
        public function togglePopup($lang)
        {
           $objme = AfwSession::getUserConnected();
           if(!isset($objme->popup)) $objme->popup = true;
           else $objme->popup = (!$objme->popup);
        }

        */
        
        protected function getPublicMethods()
        {
            //$objme = AfwSession::getUserConnected();
            
            $pbms = array();
            /*
            if(($objme) and ($objme->getId()==$this->getId()))
            {
                    if($objme->popup) {
                        $color = "green";
                        $title_ar = "تعطيل خيار النوافذ المتعددة"; 
                    }
                    else
                    {
                        $color = "x";
                        $title_ar = "تفعيل خيار النوافذ المتعددة";  
                    }
                    $pbms["xc123B"] = array("METHOD"=>"togglePopup","COLOR"=>$color, "LABEL_AR"=>$title_ar);
            }*/
            
            $color = "green";
            $title_ar = "إنشاء كفاءة جديدة"; 
            $pbms["yc5BiH"] = array("METHOD"=>"createSemplIfNotExists","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true);
            
            $color = "red";
            $title_ar = "تصفير كلمة المرور"; 
            $pbms["As478w"] = array("METHOD"=>"resetPassword","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true);
            
            $color = "blue";
            $title_ar = "انشاء ملف الكاش"; 
            $pbms["JKu76w"] = array("METHOD"=>"generateCacheFile","COLOR"=>$color, "LABEL_AR"=>$title_ar, "ADMIN-ONLY"=>true);
            
            return $pbms;
        }
        

        public function canRunApplication($module_code)
        {
                list($module_id, $system_id) = UmsManager::decodeModule($module_code);
                return $this->getMyRoles($module_id, $only_ids=true);
        }
        
        
        public function hasModule($mod)
        {
                // throw new AfwRuntimeException("new UMS coming إن شاء الله");
                
                global $file_dir_name;
                
                if($this->myModules[$mod]) return $this->myModules[$mod];
                $report_arr = array();
                
                
                $my_org_id = 3; // $this->getVal("id_sh_org");
                
                $my_module = Module::getModuleByCode($my_org_id, $mod);
                
                if($my_module) 
                {
                     $my_module_id =  $my_module->getId();
                }
                else
                {
                     $my_module_id = 0;
                }
                $report_arr[] = "$mod => id = $my_module_id";
                
                $mau_found = null;
                if($my_module_id) $mau_found = $this->findMyModule($my_module_id);
                if($mau_found) $report_arr[] = "mau_found => count = ".count($mau_found);
                else $report_arr[] = "mau_found empty ";
                
                $this->myModules[$mod] = array($my_org_id, $my_module_id, $mau_found, implode("<br>\n", $report_arr));
                
                return $this->myModules[$mod];
                
        }
        
        public function loadMyModules()
        {
                $mau_list_var = "mau_for_".$this->getId();
                $mau_list = AfwSession::getVar($mau_list_var);
                if(!$mau_list)
                {
                        $mau_list = $this->get("mau");
                        AfwSession::setVar($mau_list_var, $mau_list);
                }

                return $mau_list;
        }         
                
        public function findMyModule($my_module_id)
        {
                // throw new AfwRuntimeException("new UMS coming إن شاء الله");
                
                global $log_show;  // $this->sql_reason = "findMyModule($my_module_id) on $this";
                if(!$my_module_id)
                {
                      throw new AfwRuntimeException("findMyModule : module to find not specified !");
                }
                
                $this->loadMyModules();
                
                $mau_found = null;
                foreach($this->mau_list as $mau_item)
                {
                      //echo " compare $my_module_id to $mau_item <br>";
                      $mau_item_module_id = $mau_item->getVal("id_module"); 
                      if($mau_item_module_id==$my_module_id)
                      {
                           $mau_found = $mau_item;
                           // throw new AfwRuntimeException(var_export($mau_found,true));
                           break;
                      }
                      //else echo " compare $my_module_id != id of module of $mau_item = $mau_item_module_id <br>"; 
                }
                //echo " found : $mau_found<br>"; 
                return $mau_found;
        }
        
        public function iCanDoOperationOnObjClass($myObj,$operation_sql)
        {
             if($this->isSuperAdmin()) return true;   
             global $lang;
             
             if($operation_sql=="update") $operation_sql = "edit";
             elseif($operation_sql=="view") $operation_sql = "display";
             elseif($operation_sql=="search") $operation_sql = "display";
             elseif($operation_sql=="qsearch") $operation_sql = "display";
             
             if($operation_sql=="edit") 
             {
                $myObj_displ = $myObj->getDisplay($lang);
                list($editWithoutRole, $editWithoutRoleReason) = $myObj->userCanEditMeWithoutRole($this);
                if($editWithoutRole) 
                {
                        AfwSession::contextLog("[".$this->getDisplay($lang)."] can edit '$myObj_displ' without role. $editWithoutRoleReason", "iCanDo");
                        return true;
                }
                else
                {                        
                        AfwSession::contextLog("[".$this->getDisplay($lang)."] can not edit '$myObj_displ' without role : $editWithoutRoleReason", "iCanDo");
                }   
             } 
             
             if(($operation_sql=="display") and $myObj->public_display) return true;
             if(($operation_sql=="display") and $myObj->canBePublicDisplayed()) 
             {
                return true;
             }
             if($operation_sql=="display") AfwSession::contextLog("$myObj_displ is not public display and can 'not' BePublicDisplayed()", "iCanDo");
             
             if(($operation_sql=="display") and $myObj->canBeSpeciallyDisplayedBy($this)) 
             {
                return true;
             }
             if($operation_sql=="display") AfwSession::contextLog("$myObj_displ can 'not' BeSpeciallyDisplayedBy($this)", "iCanDo");
             
                
             $module_code = $myObj->getMyModule();
             $table = $myObj->getMyTable();

             
             
             return $this->iCanDoOperation($module_code, $table, $operation_sql);
        }
        
        public function iCanDoOperation($module_code,$table,$operation_sql, $ignore_cache=false)
        {
                $this->fld_ACTIVE();
                if(isset($this->iCanDoOperationArray["$module_code-$table-$operation_sql"]))
                {
                        return $this->iCanDoOperationArray["$module_code-$table-$operation_sql"];
                }
                // return true;
                if($operation_sql=="update") $operation = "edit";
                elseif($operation_sql=="view") $operation = "display";
                else $operation = $operation_sql;
                
                if($this->isSuperAdmin()) return true;
                list($module_id, $system_id) = UmsManager::decodeModule($module_code);
                AfwSession::contextLog("list($module_id, $system_id) = decodeModule($module_code)", "iCanDo");
                $atable_id = UmsManager::decodeTable($module_id, $table);
                AfwSession::contextLog("$atable_id = decodeTable($module_id, $table)", "iCanDo");
                AfwSession::contextLog("can i do [$operation] on table $table(id=$atable_id) from module [$module_code](id=$module_id) and system(id=$system_id)", "iCanDo");
                $operation_specification = $operation;
                $bf_id = UmsManager::decodeBfunction($system_id, $operation, $module_id, $atable_id, "",null,$ignore_cache);
                //if($atable_id==13336) 
                //die("decoded Bfunction $bf_id ".AfwSession::log_all_data());
                AfwSession::contextLog("UmsManager::decodeBfunction($system_id, $operation, $module_id, $atable_id) = $bf_id", "iCanDo");
                
                if($bf_id>0)
                {
                        
                        $return = $this->iCanDoBF($bf_id);
                        //die("rafik 4567aa ($module_id, $system_id, $atable_id, $bf_id, $return = this->iCanDoBF)");
                        AfwSession::contextLog("iCanDoBF($bf_id) => return=[$return]", "iCanDo");
                }
                else 
                {
                        $return = false;
                        AfwSession::contextLog("BF ID invalid or BF not found for operation $operation", "iCanDo");
                }

                if(($operation_sql=="edit") and ($table=="school_class"))
                {
                        //die(AfwSession::getLog("iCanDo"));
                }
                
                /*if((!$return or true) and ($this->id==758))
                {
                        AfwSession::debuggLog();    
                }*/

                $this->iCanDoOperationArray["$module_code-$table-$operation_sql"] = $return;
                return $return;
        
        }
        
        public function getICanDoLog()
        {
             // very bad it erase all log find better solution (named log) 
             // return AfwSession::getLog(); 
        }
        
        public function iCanDoBFCode($curr_class_module_id, $bfCode)
        {
               // return true; 
               $bfObj = Bfunction::loadByMainIndex($curr_class_module_id, $bfCode);
               return $this->iCanDoBF($bfObj);
               
        }
        
        public function iCanDoBF($bfObj)
        {
                // return true;
                global $file_dir_name;
                
                AfwSession::contextLog("iCanDoBF : start of iCanDoBF find BF [$bfObj]", "iCanDo");
                if($this->isSuperAdmin())
                {
                        AfwSession::contextLog("iCanDoBF : because super admin iCanDoBF returned true ", "iCanDo");
                        return true;
                } 

                if(!$bfObj)
                {
                        AfwSession::contextLog("iCanDoBF : because bf [$bfObj] is not defined returned null ", "iCanDo");
                        return null;
                } 
                
                if(is_numeric($bfObj)) { 
                        $bfId = $bfObj;  
                        $bfObj = null; 
                }
                elseif(is_object($bfObj)) $bfId = $bfObj->id;
                else die("iCanDoBF($bfObj) strange BF");
                if(!$bfId) die("iCanDoBF($bfObj) strange BF ID");

                $this_id = $this->id;
                $cache_user_can_bf_code = "user_${this_id}_can_do_bf_$bfId";
                $can = AfwSession::getVar($cache_user_can_bf_code);
                if(!empty($can)) AfwSession::contextLog("iCanDoBF : $cache_user_can_bf_code found in cache = $can, stop !", "iCanDo");
                if($can=="Y") return true;
                if($can=="N") return false;
                AfwSession::contextLog("iCanDoBF : $cache_user_can_bf_code not found in cache, continue..", "iCanDo");
                

                $can = "N";

                if(!is_object($bfObj))
                {                        
                        $bfObj = Bfunction::getBfunctionById($bfId);
                }
                
                if(!is_object($bfObj)) return "bf unknown, so you can if you want";
                AfwSession::contextLog("iCanDoBF : bf found : $bfObj", "iCanDo");
                if($bfObj->_isPublic())
                {
                        AfwSession::setVar($cache_user_can_bf_code, "Y");
                        return "bf is public";
                } 

                AfwSession::contextLog("iCanDoBF : bf $bfObj is not public", "iCanDo");

                $module_id = $bfObj->getVal("curr_class_module_id");

                list($auth, $mau_found_roles_ids) = $this->getMyRoles($module_id, $only_ids=true);
                AfwSession::contextLog("iCanDoBF : for user : $this ($this_id) roles in module $module_id => $mau_found_roles_ids", "iCanDo");
                
                $foundInRoles = $bfObj->findMeInRoles($mau_found_roles_ids, "iCanDo");
                if($foundInRoles)
                {
                        AfwSession::setVar($cache_user_can_bf_code, "Y");
                        return $foundInRoles;
                }
                else
                {
                        AfwSession::setVar($cache_user_can_bf_code, "N");
                        return false;
                }
        }
        
        /*  bfunction_mfk obsolete
        public function myBFs($module_id)
        {
                //if(isset($this->myBFList[$module_id])) return $this->myBFList[$module_id];
                
                $mau_found = $this->findMyModule($module_id);
                $my_bfs_arr = array();
                
                if(!$mau_found) return $my_bfs_arr;
                
                $mau_found_roles = $mau_found->get("arole_mfk");
                
                foreach($mau_found_roles as $role_item)
                {
                      $role_item_bfs = $role_item->get("bfunction_mfk");
                      
                      $my_bfs_arr = array_merge($my_bfs_arr,$role_item_bfs);
                }
                
                $my_bfs_arr_by_id = array();
                foreach($my_bfs_arr as $bf)
                {
                      if($bf and (is_object($bf))) $my_bfs_arr_by_id[$bf->getId()] = $bf;
                }
                
                //$this->myBFList[$module_id] = $my_bfs_arr_by_id;  
                
                return  $my_bfs_arr_by_id;
        } */

        private function getMyRoles($module_id, $only_ids=false)
        {
                //die("rafik 6721");
                return Arole::getAllRolesForModuleAndUser($module_id, $this->id, $only_ids);
        }
        
        
        public function getMenuFor($module_id, $langue="", $sub_folders=false, $items = false)
        {
                
                global $lang;
                if(!$langue) $langue = $lang;
                
                // $file_dir_name = dirname(__FILE__); 
                // 
                
                // store it in temp php file associated to current session 
                //if($this->cache_m enu[$module_id][$langue]) return $this->cache_me nu[$module_id][$langue];
                
                

                $menu_arr = array();

                

                $menus_special_arr = AfwSession::config("menus_special_$module_id", null);
                if($menus_special_arr)
                {
                        foreach($menus_special_arr as $menu_special_id => $menu_special)    
                        {
                                $menu_arr[$menu_special_id] = $menu_special;
                        }
                }


                list($authorized, $mau_found_roles) = $this->getMyRoles($module_id);
                global $ACCEPT_WITHOUT_ROLE_MODULE;                
                
                if((!$ACCEPT_WITHOUT_ROLE_MODULE[$module_id]) and 
                   (!AfwSession::config("mdoule_$module_id"."_is_public", false)))
                {
                        if(!$authorized) 
                        {
                                throw new AfwRuntimeException("WHy get here rafik B 20250223<br>\n user_id = $this->id<br>\nmodule_id=$module_id");
                                $message = $this->tm("Denied M.A.U Access to this module for user %s <br>\nuser_id : %d<br>\nmodule_id : %d");
                                $message = sprintf($message, $this->getDisplay($langue), $this->id, $module_id);
                                AfwSession::pushError($message);
                                return $menu_arr;
                        }
                        
                        if(!count($mau_found_roles)) 
                        {
                                $message = $this->tm("No roles assigned to this module for user %s <br>\nuser_id : %d<br>\nmodule_id : %d");
                                $message = sprintf($message, $this->getDisplay($langue), $this->id, $module_id);
                                AfwSession::pushWarning($message);
                        }        
                        
                        
                }

                foreach($mau_found_roles as $role_id => $role_item)
                {
                        //if(!is_object($role_item)) die("auser::getMenuFor -> mau_found_roles : ".var_export($mau_found_roles,true));
                        /**
                         * @var Arole $role_item
                         */
                        if($role_item)
                        {
                                if($role_item->isActive())   $menu_arr[$role_item->getId()] = $role_item->getRoleMenu($sub_folders, $items);
                        }
                        else
                        {
                                AfwSession::pushError("Deleted or fictive role [$role_id] found on $module_id for user $this");
                        }
                }
                
                $menu_arr["-1"] = array (
                        'need_admin' => false,
                        'id' => 'control',
                        'menu_name_ar' => 'لوحة التحكم',
                        'menu_name_en' => 'control panel',
                        'page' => 'main.php?Main_Page=fm.php&r=control',
                        'css' => 'info',
                        'icon' => NULL,
                        'items' => array(1=>"aaa"),
                        'sub-folders' => array (),
                        );
                
                
                //if(!$this->cache_me nu[$module_id][$langue]) $this->cache_me nu[$module_id][$langue] = $menu_arr;

                //die($this->getDisplay("ar")."->getMenuFor($module_id, $langue, $sub_folders, $items) will return ".var_export($menu_arr,true));
                return  $menu_arr;
        }
        
        
        
        public function getDisplay($lang="ar")
        {
                /*
                $fn = trim($this->valFirstname());
                $fn = trim($fn." " . $this->valLastname());
                return $fn;*/
                
                // return $this->valUsername()." (".$this->calNomcomplet().")";
                
                return $this->calcNomcomplet() . " (".$this->valUsername().")";
                
                
        }
        
        public function getShortDisplay($lang="ar")
        {
                return $this->calcNomcomplet($lang);
                
                
        }
        
        public function __toString() 
        {
                return $this->getDisplay();   
	}
	
	public function calcNomcomplet($lang="ar") 
        {
                $fn = ""; // trim($this->valPrefixe());
                $fn = trim($fn." " . $this->valFirstname());
                $fn = trim($fn." " . $this->valF_firstname());
                $fn = trim($fn." " . $this->valLastname());
                
                return $fn;
        }
        
        public function getMyCode($not_defined_code = "not_defined_code")
        {
	       $str = md5($this->getVal("email") . $this->getVal("id") . date("Ymd"));
	       return substr($str, 0, 10);
        }
        
        public function getDepartment()
        {
               return null; 
        }
        
        /*
        public function is_to_send_for($tal)
        {
                return true;
        }*/
        
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             $objme = AfwSession::getUserConnected();
             $me = ($objme) ? $objme->id : 0;

           
             
             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, $genereLog, $step);
             if(($mode=="display") or ($mode=="edit")) 
             {
             
                   unset($link);
                   $auser_id = $this->getId();
                   $link = array();
                   $title = "الصلاحيات على الأنظمة والتطبيقات";  // ".$this->getDisplay()." 
                   $link["URL"] = "main.php?Main_Page=afw_mode_qedit.php&cl=ModuleAuser&currmod=ums&id_origin=$auser_id&class_origin=Auser&module_origin=ums&newo=3&limit=30&ids=all&fixmtit=$title&fixmdisable=1&fixm=id_auser=$auser_id&sel_id_auser=$auser_id&return_mode=1&popup=1";
                   $link["TITLE"] = $title;
                   $link["UGROUPS"] = array();
                   $link["MODE"] = "edit";
                   $link["MODULE"] = "ums";
                   $link["CLASS"] = "ModuleAuser";
                   $otherLinksArray[] = $link;
             
             
             
             
                if($objme and $objme->getId() == $this->getId())
                {
                        unset($link);
                        $link = array();
                        $title = "مرفقاتي ";
                        $link["URL"] = "afw_my_files.php?x=1";
                        $link["TITLE"] = $title;
                        $link["UGROUPS"] = array();
                        $otherLinksArray[] = $link;
                }
                 
             }
             
             if($mode=="mode_mau")
             {
                   $my_id = $this->id;
                   unset($link);
                   $link = array();
                   $title = "إضافة صلاحية جديدة";
                   
                   $link["URL"] = "main.php?Main_Page=afw_mode_edit.php&cl=ModuleAuser&currmod=ums&sel_id_auser=$my_id";
                   $link["TITLE"] = $title;
                   $link["UGROUPS"] = array();
                   $otherLinksArray[] = $link;
             }
             return $otherLinksArray;          
        }
        
        
        public function getContextValue($currmod, $attribute)
        {
               $objme = AfwSession::getUserConnected(); 
               if(($currmod=="ria") and is_object($objme) and ($objme->getId()==$this->getId()) and ($objme->contextSchoolId>0)) 
               {
                    if($attribute == "group_num") return $objme->contextGroupNum;
                    if($attribute == "school_id") return $objme->contextSchoolId;
                    if($attribute == "year") return $objme->contextYear;
               }
               return "context for ($currmod, $attribute) not implemented";
        }
        
        public function getEmployeeId($company_id=0)
        {
            if($this->myEmployeeId) return $this->myEmployeeId;
            
            if(true) 
            {
              $empl = $this->getEmployee($company_id);
              
              if($empl and (!$empl->isEmpty())) $return = $empl->getId();
              else $return = 0;
              
              if($return) $this->myEmployeeId = $return;
              return $return;
            }
            else return 0;
        }

        public function getEmployee($company_id=0)
        {
                $file_dir_name = dirname(__FILE__);
                
                if($this->myEmployeeObj) return $this->myEmployeeObj;
                
                
                //die("select * from ".$server_db_prefix."hrm.employee where auser_id = ".$this->getId());
                $this->myEmployeeObj = new Employee();
                $this->myEmployeeObj->select("auser_id",$this->getId());
                //if($company_id) $empl->select("id_sh_org",$company_id);
                
                if($this->myEmployeeObj->load()) return $this->myEmployeeObj;
                unset($this->myEmployeeObj);

                $this->myEmployeeObj = null;

                return null;
                
                
                
        }

        
        // rafik say but is it correct ? :
        // all 3 below functions
        // getStudentId(), createMyStudentAccount(), getStudent()
        // should become obsolete student is student (ria), employee is employee (hrm)
        public function getStudentId()
        {
            if($this->getId()>5000000) return ($this->getId() - 5000000);
            
            if($this->myStudentId) return $this->myStudentId;
            
            if(true) 
            {
              $file_dir_name = dirname(__FILE__);
              require_once "$file_dir_name/../ria/student.php";
              $studentObj = $this->getStudent();
              if($studentObj) $return = $studentObj->getId();
              else $return = 0;
              
              if($return) $this->myStudentId = $return;
              return $return;
            }
            else return 0;
        }
        
        public function createMyStudentAccount($lang="ar",$student_num="")
        {
              $err_arr = array();
              $info_arr = array();
              
                $file_dir_name = dirname(__FILE__);
                require_once "$file_dir_name/../ria/student.php";
                
                $stdnt = $this->getStudent();
                
                $stdnt->set("auser_id",$this->getId());
                $stdnt->set("genre_id",$this->getVal("genre_id"));
                $stdnt->set("firstname",$this->getVal("firstname"));
                $stdnt->set("lastname",$this->getVal("lastname"));
                $stdnt->set("mobile",$this->getVal("mobile"));
                if($student_num) $stdnt->set("student_num",$student_num);
                $stdnt->set("email",$this->getVal("email"));
                
                $stdnt->commit();
                $this->myStudentObj =& $stdnt;
              
              
              return array(implode("\n<br>",$err_arr), implode("\n<br>",$info_arr));
        }
        
        public function getStudent()
        {
                $file_dir_name = dirname(__FILE__);
                
                require_once "$file_dir_name/../ria/student.php";
                //if($this->myStudentObj) return $this->myStudentObj;
                
                
                $stdnt = new Student();
                if($this->getId()<=5000000)
                {
                        $stdnt->select("auser_id",$this->getId());
                        $stdnt->load();
                        $student_id = $stdnt->getId();
                        // die("i a m real user of student $student_id : stdnt obj = ".var_export($stdnt,true));                
                }
                else
                {
                        $student_id = $this->getId()-5000000;
                        $stdnt->load($student_id);
                        // die("i a m virtual user of student $student_id : stdnt obj = ".var_export($stdnt,true));
                }
                
                
                //$this->myStudentObj =& $stdnt;
                
                // return $this->myStudentObj;
                return $stdnt;
        }
        
        
        /*
        public function getSempl()
        {
            global $file_dir_name;
                require_once "$file_dir_name/../sdd/sempl.php";
                
                $smpl = new Sempl();
                $smpl->select("auser_id",$this->getId());
                
                $smpl->load();
                
                return $smpl;
        
        }
        
        
        public function createSemplIfNotExists($lang="ar")
        {
            global $file_dir_name;
                $sempl = $this->getSempl();
                
                if(!$sempl->getId())
                {
                    $sempl->set("auser_id",$this->getId());
                    $sempl->set("gender_id",1);
                    $sempl->set("firstname",$this->getVal("firstname"));
                    $sempl->set("f_firstname",$this->getVal("f_firstname"));
                    $sempl->set("lastname",$this->getVal("lastname"));
                    $sempl->set("mobile",$this->getVal("mobile"));
                    
                    $sempl->insert();
                    $mess = "تم انشاء  حساب موظف بقسم التطوير ";
                }
                else $mess = "تم العثور على  حساب موجود سابقا  للموظف  بقسم التطوير ";
                
                return array("",$mess . $sempl);
        
        }
        */
        
        public function getUserCanTable($module_code,$table,$operation)
        {
              if($this->isSuperAdmin()) return true;
              
              if(!isset($this->userCanTable[$module_code][$table][$operation]))
              { 
                  $this->userCanTable[$module_code][$table][$operation] = $this->iCanDoOperation($module_code,$table,$operation);
              }
              
              return $this->userCanTable[$module_code][$table][$operation];
        }
        
        
        public function getMyDepartmentBranchIds($module="")
        {
                // user has only one organization 
                // $module param is obsolete
                if($module) throw new AfwRuntimeException("user has only one organization => module param is obsolete but has value = $module");

                $company_id = $this->getMyOrganizationId();
                $empl = $this->getEmployee($company_id);
                if($empl and (!$empl->isEmpty()))
                {
                      $empl_dep = $empl->getVal("id_sh_dep");
                      if($empl_dep>0) return $empl->get("id_sh_dep")->getBranchListOfIDs();
                }
                return 0;
        }
        
        public function getMyDepartmentId($module="")
        {
                // user has only one organization 
                // $module param is obsolete
                if($module) throw new AfwRuntimeException("user has only one organization => module param is obsolete but has value = $module");

                if($this->myDepartmentId) return $this->myDepartmentId;
                $this->myDepartmentId = 0;
                $me = AfwSession::getUserIdActing();
                // throw new AfwRuntimeException("why getMyDepartmentName and where ?");
                
                if($me<=1000000) $empl = $this->getEmployee();
                else $empl = null;
                
                if($empl and (!$empl->isEmpty()))
                {     
                      $this->myDepartmentId = $empl->getVal("id_sh_dep");
                }
                else
                {
                        // rafik : @todo to be better studied
                        if(AfwSession::config("student_user_enabled",false))
                        {
                                $stdnt = $this->getStudent();
                                if($stdnt)
                                {
                                        $school = $stdnt->hetSchool();
                                        if($school)
                                        {
                                        $dep = $school->initOrgunit(true);
                                        if($dep) $this->myDepartmentId = $dep->getId();
                                        else $this->myDepartmentId = 0;
                                        }
                                        else $this->myDepartmentId = 0; 
                                }
                                else $this->myDepartmentId = 0;
                        }
                }
                
                return $this->myDepartmentId;
        }
        
        
        public function getMyDepartmentName($lang="ar")
        {
                $me = AfwSession::getUserIdActing();
                // throw new AfwRuntimeException("why getMyDepartmentName and where ?");
                
                
                if($me<=1000000) $empl = $this->getEmployee();
                else $empl = null;

                if($empl and (!$empl->isEmpty()))
                {
                      $divObj = $empl->het("id_sh_div");
                      if($divObj) return $divObj->getDisplay($lang);
                }
                else
                {
                        // rafik : @todo to be better studied
                        if(AfwSession::config("student_user_enabled",false))
                        {
                                $stdnt = $this->getStudent();
                                if($stdnt)
                                {
                                        $school = $stdnt->hetSchool();
                                        if($school)
                                        {
                                        $dep = $school->hetOrgunit();
                                        if($dep) return $dep->getDisplay($lang);
                                        else return "no department";
                                        }
                                        else return "no school"; 
                                }
                        }
                }
                
                return "Unknown department";
        }
        
        public function getMyJob($lang="ar")
        {
                $me = AfwSession::getUserIdActing();
                // throw new AfwRuntimeException("why getMyDepartmentName and where ?");
                
                if($me<=1000000) $empl = $this->getEmployee();
                else $empl = null;
                
                
                if($empl and (!$empl->isEmpty()))
                {
                      return $empl->getVal("job");
                }
                return "Unknown job";
        }        
        
        public function getMyOrganizationId($module="")
        {
                // user has only one organization 
                // $module param is obsolete
                if($module) throw new AfwRuntimeException("user has only one organization => module param is obsolete but has value = [$module]");
                $objme = AfwSession::getUserConnected();
                
                if($this->myOrganizationId) return $this->myOrganizationId;
                $myOrganizationId = 0; 
                $empl = $this->getEmployee(0);
                if($empl and (!$empl->isEmpty()))
                {
                        $myOrganizationId = $empl->getVal("id_sh_org");
                }
                elseif(AfwSession::config("student_user_enabled",false))
                {
                        $stdnt = $this->getStudent();
                        if($stdnt)
                        {
                                $school = $stdnt->hetSchool();
                                if($school)
                                {
                                        $dep = $school->hetOrgunit();
                                        // if($dep) $dep = $dep->hetParent();
                                        
                                        if($dep) $myOrganizationId = $dep->getVal("id_sh_org");
                                        else $myOrganizationId = 0;
                                }
                                else $myOrganizationId = 0; 
                        }
                }
              
              /*
              $myOrganizationId = 1; 
              
              if(($module=="ria") and ($objme->getId()==$this->getId()) and false) // pour moi trop obsolete, rafik
              {
                        $myOrganizationId = $objme->contextOrgUnitId;
              }
              elseif(($module=="frz") and ($objme->getId()==$this->getId()))
              {
                        $sempl = $this->getSempl();
                        if($sempl)
                        {
                              $sempl_org = $sempl->getVal("id_sh_org");
                              if($sempl_org>0) $myOrganizationId = $sempl_org;
                        }

              }
              elseif(($module=="btb") and ($objme->getId()==$this->getId()) and ($objme->getId()==1))
              {
                        $myOrganizationId = 118;
              } 
              else
              {
                      
                      $empl = $this->getEmployee(0);
                      if($empl and (!$empl->isEmpty()))
                      {
                              $myOrganizationId = $empl->getVal("id_sh_org");
                      }
                      elseif(AfwSession::config("student_user_enabled",false))
                      {
                            $stdnt = $this->getStudent();
                            if($stdnt)
                            {
                                $school = $stdnt->hetSchool();
                                if($school)
                                {
                                      $dep = $school->hetOrgunit();
                                      // if($dep) $dep = $dep->hetParent();
                                      
                                      if($dep) $myOrganizationId = $dep->getVal("id_sh_org");
                                      else $myOrganizationId = 0;
                                }
                                else $myOrganizationId = 0; 
                            }
                      }
              }
              */
              $this->myOrganizationId = $myOrganizationId;
              
              return $myOrganizationId;
        
        }
        
        public function loadOptions()
        {
             $this->CHECK_ERRORS = true;
        }

        protected function isSpecificOption($attribute)
        {
              return false;
        }
        
        
        
        public function showICanDoLog($echo=false)
        {
                $return_log = "<br>iCanDoOperationLog <br>";
                $return_log .= $this->showArr($this->iCanDoOperationLog);
                   
                $return_log .= "<br>iCanDoBFLog <br>";
                $return_log .= $this->showArr($this->iCanDoBFLog);

                if($echo) echo $return_log;

                return $return_log;        
        }
        
        public function getUserInfos()
        {
          
          $email = $this->getVal("email");
          
          return self::emailToUsername($email);
        }     

        public static function emailToUsername($email)  
        {
          $main_company_domain = AfwSession::config("main_company_domain","");
          /*
          $pos = strpos($email,"@");
          $username = substr($email,0,$pos);
          $domain_name = substr($email,$pos+1);*/
          
          list($username, $domain_name) = explode("@",$email);
          
          //if($username=="aalmalki") die("list($username, $domain_name) = explode(@,$email) and main_company_domain=$main_company_domain");

          // rafik @doc:date:26/5/2021: as username should be unique the domain name is omitted only for the 
          // main company domain to avoid duplicated usernames like this case :
          // aalmalki@xxxx.gov.sa
          // aalmalki@yyyy.com.sa

          if(strtolower($main_company_domain) != strtolower($domain_name))
          {
                $username = $email; 
                $domain_name = "";  
          }

          // if($username=="aalmalki") die("domains : $main_company_domain vs $domain_name");
          
          return array($username, $domain_name);
        }
        
        public function initUser($from_active_directory=false, $reset_password=false) 
        {
                global $lang;
                $info = array();
                $err = array();
                $war = array();
                if((!$from_active_directory) and $reset_password)
                {                 
                        if(!$this->pwd) list($err[],$info[], $war[], $pwd,$sent_by, $sent_to) = $this->resetPassword($lang);
                        if(count($err)==0) $info[] = $this->tm("Password has been resetted. The new password has been sent by",$lang)." : ".$this->tm($sent_by,$lang)." ". $this->tm("to",$lang) . " " . $sent_to;
                }
                else
                {
                        
                }

                return AfwFormatHelper::pbm_result($err, $info);
        }


        public function generateCacheFile($lang="ar", $onlyIfNotDone=false, $throwError=false)
        {                
                try
                {
                        $parent_project_path = AfwSession::config("parent_project_path", "");
                        if(!$parent_project_path) return ["please define parent_project_path system config parameter", ""];
                        $me_id = $this->id;
                        $file_path = $parent_project_path."/cache/chusers";
                        $fileName = "user_$me_id"."_data.php";
                        $fileFullName = $file_path."/".$fileName;
                        if($onlyIfNotDone and file_exists($fileFullName))
                        {
                                return ["", "already generated file $fileFullName"];
                        }

                        $php = $this->calcPhp(false);
                        AfwFileSystem::write($fileFullName, $php);
                        return array("", "$fileFullName created successfully");
                }
                catch(Exception $e)
                {
                        if($throwError) throw $e;
                        return array($e->getMessage(),'');
                }
        }
        
        
        public function resetPassword($lang="ar",$commit=true, $password_sent_by=null, $message_prefix="")
        {
                if(!$password_sent_by) $password_sent_by = AfwSession::config("password_sent_by", ["sms"]);
                $objme = AfwSession::getUserConnected();
                $username = $this->getVal("username");
                $firstname = $this->getVal("firstname");
                if(!$username) 
                {
                        $username = $this->getVal("mobile");
                        if(!$username) $username = $this->getVal("idn");
                        if(!$username) $username = $this->getId();
                        $username = "u".$username;
                        $this->set("username",$username);
                }
                $sent_by = "nothing";
                $sent_to = "nobody";
                $len = AfwSession::config("password_generated_length", 4);
                $pwd = AfwEncryptionHelper::password_generate($username,$len);
                $pwd_enc = AfwEncryptionHelper::password_encrypt($pwd);
                $this->set("pwd",$pwd_enc);
                if($commit) 
                {
                        $this->commit();
                        $info_detail = "";
                        if($objme and $objme->isSuperAdmin()) $info_detail = "<!-- username=$username  enc($pwd)=$pwd_enc -->";
                        if(!$message_prefix) $message_prefix = $firstname;
                        $message = $message_prefix;
                        $message .= "<br>\n ".$this->tm("Your user name is",$lang) ." : ". $username;
                        $message .= "<br>\n ".$this->tm("Your new password is",$lang) ." : ". $pwd;
                        $info = $message." : $info_detail";
                        foreach($password_sent_by as $password_sent_by_try)
                        {
                                if($password_sent_by_try=="sms")
                                {
                                        $send_succeeded = false;
                                        $simulate_sms_to_mobile = AfwSession::config("simulate_sms_to_mobile", null);
                                        if($simulate_sms_to_mobile) $sms_mobile = $simulate_sms_to_mobile;
                                        else $sms_mobile = $this->getVal("mobile");
                                        // @todo : send SMS / Email with the new password
                                        if($sms_mobile)
                                        {
                                                list($send_succeeded, $sms_info) = AfwSmsSender::sendSMS($sms_mobile, $message);
                                                // if send succeeded
                                                if($send_succeeded)
                                                {
                                                        $sent_to = $sms_mobile;
                                                        $sent_by = "sms";
                                                } 
                                        }
                                        else
                                        {
                                                // die("auser without mobile : ".var_export($this,true));
                                                $sms_info = "no mobile number provided to send sms";
                                        }
                                        $info .= "/".$sms_info;

                                }

                                if($password_sent_by_try=="email")
                                {
                                        
                                }                                
                        }
                }
                else $info = $this->tm("Password reset, but need commit",$lang);

                
                
                return array("", $info, "", $pwd, $sent_by, $sent_to);
              
        }
        
        public function beforeMAJ($id, $fields_updated) 
        {
                
            global $lang;
                
                if($this->getVal("mobile")=="05") {
                     $this->set("mobile","");
                }
                
                if(!$this->getVal("username")) 
                {
                           list($username, $domain_name) = $this->getUserInfos();
                           if($username) $this->set("username",$username);
                }
                
                
                
                

		return true;
	}
        
        public function afterUpdate($id, $fields_updated) 
        {
                
                $objme = AfwSession::getUserConnected();
               
                if(($objme) and ($this->getId()==$objme->getId()))
                {
                    AfwSession::unsetUserConnected();
                    $langObj = $this->hetLang();
                    if($langObj) AfwSession::setVar("lang", $langObj->valCode());
                }
                
                // this code
                /*
                if($fields_updated["mobile"] and $this->getId() and $this->getVal("mobile") and (!$this->getAttributeError("mobile"))) 
                {
                           $file_dir_name = dirname(__FILE__);
                           
                           
                           
                           $empl = new Employee();
                           $empl->select("mobile",$this->getVal("mobile"));
                           $empl->where("(auser_id is null or auser_id = 0)");
                           $empl->set("auser_id",$this->getId());
                           $empl->update(false);
                }
                */
        }
                                        
        protected function importRecord($dataRecord,$orgunit_id,$overwrite_data,$options,$lang, $dont_check_error)
        {
                $errors = [];
                
                foreach($dataRecord as $key => $val) $$key = $val;
                if(!$idn)
                {
                $errors[] = $this->translateMessage("missed idn value",$lang);
                return array(null,$errors,[],[]);
                }
                
                if(!$mobile)
                {
                $errors[] = $this->translateMessage("missed mobile value",$lang);
                return array(null,$errors,[],[]);
                }
                
                // idn and idn type identification
                $idn_type_id = 0;
                $idn_type_ok = false;
                if($idn_type) list($idn_type_ok, $idn_type_id) = AfwStringHelper::parseAttribute($this,"idn_type_id",$idn_type,$lang,false);
                if(!$idn_type_ok)
                {
                        // find it from idn format
                        list($idn_correct, $idn_type_id) = AfwFormatHelper::getIdnTypeId($idn);
                }
                
                if($idn_correct)
                {
                 
                        $user = self::loadByMainIndex($idn_type_id, $idn, $create_obj_if_not_found=true);
                        
                        
                        if($overwrite_data or $user->is_new)
                        {
                         
                                if($genre) list($val_ok, $val_parsed_or_error) = AfwStringHelper::parseAttribute($user,"genre_id",$genre,$lang); else $val_ok = true;
                                if(!$val_ok) $errors[] = $val_parsed_or_error;
                                
                                if($nationality) list($val_ok, $val_parsed_or_error) = AfwStringHelper::parseAttribute($user,"country_id",$nationality,$lang); else $val_ok = true;
                                if(!$val_ok) $errors[] = $val_parsed_or_error;
                                
                                if($firstname) list($val_ok, $val_parsed_or_error) = AfwStringHelper::parseAttribute($user,"firstname",$firstname,$lang); else $val_ok = true;
                                if(!$val_ok) $errors[] = $val_parsed_or_error;
                                
                                if($fatherfirstname) list($val_ok, $val_parsed_or_error) = AfwStringHelper::parseAttribute($user,"f_firstname",$fatherfirstname,$lang); else $val_ok = true;
                                if(!$val_ok) $errors[] = $val_parsed_or_error;
                                
                                if($grandfathername) list($val_ok, $val_parsed_or_error) = AfwStringHelper::parseAttribute($user,"g_f_firstname",$grandfathername,$lang); else $val_ok = true;
                                if(!$val_ok) $errors[] = $val_parsed_or_error;
                                
                                if($lastname) list($val_ok, $val_parsed_or_error) = AfwStringHelper::parseAttribute($user,"lastname",$lastname,$lang); else $val_ok = true; 
                                if(!$val_ok) $errors[] = $val_parsed_or_error;
                                
                                if($mobile) list($val_ok, $val_parsed_or_error) = AfwStringHelper::parseAttribute($user,"mobile",$mobile,$lang); else $val_ok = true; 
                                if(!$val_ok) $errors[] = $val_parsed_or_error;
                                
                                
                                if(count($errors)==0)
                                {
                                $errors = $user->getDataErrors($lang);
                                
                                }                             
                                if(count($errors)==0)
                                {
                                $user->commit();
                                } 
                         
                        }
                        else
                        {
                                $errors[] = $this->translateMessage("This user already exists and overwrite is not allowed",$lang);
                        }
                        return array($user,$errors,[],[]);
                }
                else
                {
                        $errors[] = $this->translateMessage("incorrect idn format",$lang) . " : " . $idn;
                        return array(null,$errors,[],[]);
                } 
          
          
          
      }
      
      protected function namingImportRecord($dataRecord,$lang)
      {
          return $dataRecord["firstname"]. " " . $dataRecord["fatherfirstname"]. " " . $dataRecord["lastname"];
      }
      
      protected function getRelatedClassesForImport($options=null)
      {
          $importClassesList = [];
          
          return $importClassesList;
      }
      
      public function beforeDelete($id,$id_replace) 
        {
            
 
            if($id)
            {   
               if($id_replace==0)
               {
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 
 
 
                   $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 
                       // ria.family_relation-الولي	resp_rea_user_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("delete from ${server_db_prefix}ria.family_relation where resp_rea_user_id = '$id' ");
                       // sched.schedule_receiver-المستخدم	auser_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("delete from ${server_db_prefix}sched.schedule_receiver where auser_id = '$id' ");
                       // sched.gen_report_receiver-المستخدم	auser_id  أنا تفاصيل لها-OneToMany
                      //  $this->execQuery("delete from ${server_db_prefix}sched.gen_report_receiver where auser_id = '$id' ");
 
 
                   // FK not part of me - replaceable 
                       // b au.ptext-تحرير	author_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}b au.ptext set author_id='$id_replace' where author_id='$id' ");
                       // ums.afile-صاحب الملف	owner_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}ums.afile set owner_id='$id_replace' where owner_id='$id' ");
                       // ums.module_auser-الموظف	id_auser  غير معروفة-unkn
                        $this->execQuery("delete from ${server_db_prefix}ums.module_auser where id_auser='$id' ");
                       // spp.ticket_followup-المستخدم المتابع	auser_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}spp.ticket_followup set auser_id='$id_replace' where auser_id='$id' ");
                       // ria.alert-owner_id	owner_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.alert set owner_id='$id_replace' where owner_id='$id' ");
                       // ria.attendance-auser_id	auser_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.attendance set auser_id='$id_replace' where auser_id='$id' ");
                       // ria.school_employee-المستخدم	rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.school_employee set rea_user_id='$id_replace' where rea_user_id='$id' ");
                       // ria.student-والد الطالب(ة)	father_rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set father_rea_user_id='$id_replace' where father_rea_user_id='$id' ");
                       // ria.student-والدة الطالب(ة)	mother_rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set mother_rea_user_id='$id_replace' where mother_rea_user_id='$id' ");
                       // ria.student-ولي متابع للطالب(ة) 1	resp1_rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set resp1_rea_user_id='$id_replace' where resp1_rea_user_id='$id' ");
                       // ria.student-ولي متابع للطالب(ة) 2	resp2_rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set resp2_rea_user_id='$id_replace' where resp2_rea_user_id='$id' ");
                       // sdd.sempl-بيانات المستخدم	auser_id  جزء مني ويعمل مستقلا-OneToOneUnidirectional
                       // $this->execQuery("delete from ${server_db_prefix}sdd.sempl where auser_id='$id' ");
                       // sched.schedule-منشئ الجدولة	created_by  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}sched.schedule set created_by='$id_replace' where created_by='$id' ");
                       // hrm.orgunit-مدير الادارة	id_responsible  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}hrm.orgunit set id_responsible='$id_replace' where id_responsible='$id' ");
 
 
               }
               else
               {
                        $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 
                       
                       // ria.family_relation-الولي	resp_rea_user_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("update ${server_db_prefix}ria.family_relation set resp_rea_user_id='$id_replace' where resp_rea_user_id='$id' ");
                       // sched.schedule_receiver-المستخدم	auser_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("update ${server_db_prefix}sched.schedule_receiver set auser_id='$id_replace' where auser_id='$id' ");
                       // sched.gen_report_receiver-المستخدم	auser_id  أنا تفاصيل لها-OneToMany
                       // $this->execQuery("update ${server_db_prefix}sched.gen_report_receiver set auser_id='$id_replace' where auser_id='$id' ");
                       // b au.ptext-تحرير	author_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}b au.ptext set author_id='$id_replace' where author_id='$id' ");
                       // ums.afile-صاحب الملف	owner_id  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}ums.afile set owner_id='$id_replace' where owner_id='$id' ");
                       // ums.module_auser-الموظف	id_auser  غير معروفة-unkn
                        $this->execQuery("update ${server_db_prefix}ums.module_auser set id_auser='$id_replace' where id_auser='$id' ");
                       // spp.ticket_followup-المستخدم المتابع	auser_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}spp.ticket_followup set auser_id='$id_replace' where auser_id='$id' ");
                       // ria.alert-owner_id	owner_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.alert set owner_id='$id_replace' where owner_id='$id' ");
                       // ria.attendance-auser_id	auser_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.attendance set auser_id='$id_replace' where auser_id='$id' ");
                       // ria.school_employee-المستخدم	rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.school_employee set rea_user_id='$id_replace' where rea_user_id='$id' ");
                       // ria.student-والد الطالب(ة)	father_rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set father_rea_user_id='$id_replace' where father_rea_user_id='$id' ");
                       // ria.student-والدة الطالب(ة)	mother_rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set mother_rea_user_id='$id_replace' where mother_rea_user_id='$id' ");
                       // ria.student-ولي متابع للطالب(ة) 1	resp1_rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set resp1_rea_user_id='$id_replace' where resp1_rea_user_id='$id' ");
                       // ria.student-ولي متابع للطالب(ة) 2	resp2_rea_user_id  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}ria.student set resp2_rea_user_id='$id_replace' where resp2_rea_user_id='$id' ");
                       // sdd.sempl-بيانات المستخدم	auser_id  جزء مني ويعمل مستقلا-OneToOneUnidirectional
                       // $this->execQuery("update ${server_db_prefix}sdd.sempl set auser_id='$id_replace' where auser_id='$id' ");
                       // sched.schedule-منشئ الجدولة	created_by  حقل يفلتر به-ManyToOne
                       // $this->execQuery("update ${server_db_prefix}sched.schedule set created_by='$id_replace' where created_by='$id' ");
                       // hrm.orgunit-مدير الادارة	id_responsible  حقل يفلتر به-ManyToOne
                        $this->execQuery("update ${server_db_prefix}hrm.orgunit set id_responsible='$id_replace' where id_responsible='$id' ");
 
 
                        
 
               } 
               return true;
            }    
	}
        
        public function isCustomer()
        {
            $this_id = $this->getId();
            if($this_id > self::$MAX_USERS_CRM_START) return true;
            else return false;
        }
        
        public function getCustomerId()
        {
            $this_id = $this->getId();
            if($this_id > self::$MAX_USERS_CRM_START) return ($this_id-self::$MAX_USERS_CRM_START);
             
            return 0;
        }
        
        public function canBeSpeciallyDisplayedBy($auser)
        {
               return ($auser and ($auser->getId()==$this->getId()));
        }

        /********************  NEW UMS  ************** */

        public function initWithModule($MODULE)
        {
                global $PUBLIC_MODULE_ROLES, $ACCEPT_WITHOUT_ROLE_MODULE;                

                if($MODULE=="lib") return array(true, "done"); // throw new AfwRuntimeException("initWithModule($MODULE)???");
                
                
                if($ACCEPT_WITHOUT_ROLE_MODULE[$MODULE])
                {
                        return array(true, "module authorized without role");
                }
                else
                {
                        $me_id = $this->id;
                        $file_full_path = dirname(__FILE__)."/../cache/chusers/user_$me_id"."_data.php";
                        if(file_exists($file_full_path))
                        {
                                include($file_full_path);
                                if($mau_info[$MODULE])
                                {
                                        return array(true, "done-from-cache");
                                }
                                else
                                {
                                        $mau_info_export = var_export($mau_info,true);
                                        $message_after_init = "roles-authorization not found in-cache for module ".$MODULE." in user_$me_id"."_data";
                                        $message_after_init .= " <!-- after inc $file_full_path \n cached mau_info = $mau_info_export -->";
                                        return array(false, $message_after_init);
                                }
                        }
                        elseif($PUBLIC_MODULE_ROLES[$MODULE])
                        {
                                $mau_found = $this->giveMeModule($MODULE, $PUBLIC_MODULE_ROLES[$MODULE]);
                                return array(true, "done");
                        }
                        else
                        {
                                
                                $mau_found = $this->getMyModulesAndRoles($MODULE);
                                if($mau_found and (count($mau_found)>0)) return array(true, "already exists");
                                return array(false, "roles-authorization not found");
                        }
                }

                
        }

        public function calcPhp($text_area=true)
        {
                $source_php = "";
                if($text_area) $source_php .= "<textarea cols='120' rows='30' style='width:100% !important;direction:ltr;text-align:left'>";
                $source_php .= "<?php\n"; // ";
                $user_info = array();
                $mau_info = array();
                $menu = array();
                $quick_links_arr = array();

                $quick_links_arr["ar"] = $this->getMyQuickLinks("ar");
                $quick_links_arr["en"] = $this->getMyQuickLinks("en");

                
                $user_info['user_department']["ar"] = $this->getMyDepartmentName("ar");
                $user_info['user_department']["en"] = $this->getMyDepartmentName("en");
                $user_info['user_job']["ar"] = $this->getMyJob("ar");
                $user_info['user_job']["en"] = $this->getMyJob("en");
                $user_info['user_full_name']["ar"] = $this->getShortDisplay("ar");
                $user_info['user_full_name']["en"] = $this->getShortDisplay("en");

                $mauList = $this->loadMyModules();
                foreach($mauList as $mauItem)
                {
                        $moduleItem = $mauItem->getModule();
                        $moduleId = $moduleItem->id;
                        if($moduleId)
                        {
                                $moduleCode = $moduleItem->getVal("module_code");
                                $roles_mfk = trim(trim($mauItem->getVal("arole_mfk")),",");
                                $roles_arr = explode(",",$roles_mfk);

                                $mau_info_item = array();
                                $mau_info_item['id'] = $moduleId;
                                foreach($roles_arr as $rid)
                                {
                                        $mau_info_item['r'.$rid] = true;
                                }

                                $rolesList = $mauItem->get("arole_mfk");

                                foreach($rolesList as $roleItem)
                                {
                                        if($roleItem)
                                        {
                                                $roleId = $roleItem->id;
                                                $bfList = $roleItem->get("bfList"); 
                                                foreach($bfList as $bfItem)
                                                {
                                                        $bfId = $bfItem->id;
                                                        if(!isset($mau_info_item['bf'.$bfId]))
                                                        {
                                                                $mau_info_item['bf'.$bfId] = array();
                                                        }
                                                        $mau_info_item['bf'.$bfId][$roleId] = true;
                                                }
                                        }
                                }

                                $mau_info[$moduleCode] = $mau_info_item;
                                $mau_info['m'.$moduleId] = array('code'=>$moduleCode,'roles'=>$roles_arr);

                                $menu[$moduleCode] = array();
                                $menu[$moduleCode]["all"] = $this->getMenuFor($moduleId,"ar");
                                //$menu[$moduleCode]["en"] = $this->getMenuFor($moduleId,"en");
                        }
                        
                }

                

                $source_php .= "\n\t\$user_info = ".var_export($user_info,true).";";

                $source_php .= "\n\t\$mau_info = ".var_export($mau_info,true).";";

                $source_php .= "\n\t\$menu = ".var_export($menu,true).";";

                $source_php .= "\n\t\$quick_links_arr = ".var_export($quick_links_arr,true).";";

                $source_php .= "\n ?>";
                
                if($text_area) $source_php .= "</textarea>"; // 

                return $source_php;
        }


        public function calcRights()
        {
                global $lang;
                $html = "<div class='ums-rights'>";

                $mauList = $this->get("mau");
                $myId = $this->id;

                foreach($mauList as $mauItem)
                {
                        $moduleItem = $mauItem->getModule();
                        $moduleId = $moduleItem->id;
                        $rdiv = $mauItem->calcRightsDiv();
                        $aroles = $mauItem->showAttribute("arole_mfk");
                        if($rdiv and $aroles)
                        {
                                $html .= "<div class='module-ums module-$moduleId'>".$moduleItem->getDisplay($lang). "<div class='ums-aroles'>" . $aroles . "</div></div>\n";
                                $html .= "<div class='module-rights rights-$moduleId-$myId'>\n";
                                $html .= $rdiv;
                                $html .= "</div>";
                        }
                        
                        
                }
                $html .= "</div>";

                return $html;

        }


        public function isInternalDomain()
        {
                list($user_name, $user_domain) = explode("@", strtolower($this->getVal("email")));
                return AfwLoginUtilities::isInternalDomain($user_domain);                 
        }

        public function canDisableRO($desc, $module_code)
        {
                list($auth, $found_roles_ids) = $this->canRunApplication($module_code);
                $found_roles_ids_arr = explode(",",$found_roles_ids);                
                foreach($found_roles_ids_arr as $found_role_id)
                {
                        if($desc["DISABLE-READONLY-$found_role_id"]) return true;
                }

                

                return false;
        }


        public function getMyQuickLinks($lang="ar", $except_module="")
        {
                $quick_links_arr = array();
                
                if(!$this->isCustomer())
                {
                        $mauList = $this->loadMyModules();
                        foreach($mauList as $mauItem)
                        {
                                $moduleItem = $mauItem->hetModule();
                                if($moduleItem and $moduleItem->isRunnable() and ($except_module != $moduleItem->getVal("module_code")))
                                {
                                        $quick_links_arr[] = array('target'=>$moduleItem->getVal("module_code"), 
                                                                'name_ar'=>$moduleItem->getShortDisplay("ar"), 
                                                                'name_en'=>$moduleItem->getShortDisplay("en"), 
                                                                'url'=>$moduleItem->getMyURL($lang));
                                }
                        }
                
                }

                return $quick_links_arr;
        }

        public function stepsAreOrdered()
        {
                return false;
        }

        public function getUserPicture()
        {
                $html = "";
                // @todo see in uploaded files of this user if there are picture

                // use initials like RB for Rafik BOUBAKER
                
                $initials = AfwStringHelper::initialsOfName($this->getVal("username"));                
                $html = "<div class='user-account'>$initials</div>";
                return $html;
        }

        
        
                
}
