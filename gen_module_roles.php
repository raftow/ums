<?php
/*      
   if((!$objme) or (!$objme->isSuperAdmin())) 
   {
       $out_scr .= "غير مسموح لك بهذه العملية هذه خاصة بالمشرف العام فقط.you are not authorized to do this action. reserved only for root users !";
       return;
   }

   $_sql_analysis_seuil_calls = 700;
   $loadMany_max = 1000;
      
   
   
   
   
   $moduleObj = new Module();
   $moduleObj->load($mod);
   
   if(($moduleObj->getVal("id_module_type")==7) or ($moduleObj->getVal("id_module_type")==4))
   {
        $listApplications = $moduleObj->get("applications");
   }
   else
   {
        $listApplications = array();
        $listApplications[$moduleObj->getId()] = $moduleObj;
   }
   
   foreach($listApplications as $currApplication)
   {
           $currApplicationId = $currApplication->getId();
           $currmod = $currApplication->getVal("module_code");
           
           $id_system = $currApplication->getVal("id_system");
        
           if(!$framework) $framework = $MODULE_FRAMEWORK[$currApplicationId];
        
           
           $currApplication->disableMyBFs($id_system, $framework);
           
           $at = new Atable();
           $at->select("id_module",$currApplicationId);
           $at->select("avail",'Y');
           $at_list = $at->loadMany($limit = "", $order_by = "id_sub_module asc");
           
           $at_list_count = count($at_list);
           
           if(!$lang) $lang = "ar";
           $arole_arr = array();
           $id_sub_mod = 0;
           $role_code = "xx";
           $screens_count = 0;
           $new_bf_count = 0;
           $ignored_count = 0;
           $updated_bf_count = 0;
           $new_role_count = 0;
           $to_implement_count = 0;
           // die("count(at_list) = " . count($at_list));
           
           
              
           if($id_system) 
           {   
              if($at_list_count) 
              {
                        foreach($at_list as $atb_id => $atb_obj)
                        {
                                     
                                     $atb_id_sub_module = $atb_obj->getVal("id_sub_module");
                                     if($atb_id_sub_module)
                                          $submod_obj = $atb_obj->getSubModule();
                                     else
                                          throw new AfwRuntimeException("for $atb_obj no sub module defined");
                                               
                                     if($submod_obj->getId() != $id_sub_mod)
                                     {
                                            $id_sub_mod = $submod_obj->getId();
                                            $role_code =  "module-$id_sub_mod";
                                            $titre_short=$submod_obj->getVal("titre_short");
                                            $titre_short_en=$submod_obj->getVal("titre_short_en");
                                            if(!$titre_short_en) $titre_short_en = AfwStringHelper::toEnglishText($role_code);
                                            $titre=$submod_obj->getVal("titre");
                                            $titre_en=$submod_obj->getVal("titre_en");
                                            list($arole_type_id, $path) = $submod_obj->getRoleTypeId("",$lang);
                                            if($arole_type_id<0)
                                            {
                                                 throw new AfwRuntimeException("for table $atb_obj the module $submod_obj(id=$id_sub_mod) has no role type : $path");
                                            } 
                                            list($new_role, $arole_arr[$role_code]) = Arole::findOrCreateArole($currApplicationId,$role_code,$titre_short,$titre_short_en,$titre,$titre_en,$arole_type_id);
                                            if(!$arole_arr[$role_code])
                                            {
                                                 throw new AfwRuntimeException("for table=$atb_obj submodule=$submod_obj($atb_id_sub_module) the role_code $role_code has no role object created !");
                                            }
                                            else
                                            {
                                                 if($new_role) $out_scr .= "<div class='alert alert-success'> role [code=$role_code] created successfully for submodule $submod_obj (id=$id_sub_mod)</div>";
                                            }
                                            $arole_arr[$role_code]->set("bfunction_mfk","");
                                            $parentRoleObj = Arole::getAssociatedRoleForSubModule($currApplicationId,$submod_obj->hetParent());
                                            if($parentRoleObj) $arole_arr[$role_code]->set("parent_arole_id", $parentRoleObj->getId());
                                            $arole_arr[$role_code]->update();
                                            
                                            $lkp_role_code =  "lkp-module-$id_sub_mod";
                                            list($new_role, $arole_arr[$lkp_role_code]) = Arole::findOrCreateArole($currApplicationId,$lkp_role_code,"البيانات المرجعية","Lookup","البيانات المرجعية","Lookup",30);
                                            if(!$arole_arr[$lkp_role_code])
                                            {
                                                 throw new AfwRuntimeException("for table=$atb_obj submodule=$submod_obj($atb_id_sub_module) the lookup role_code $lkp_role_code has no role object created !");
                                            }
                                            $arole_arr[$lkp_role_code]->set("bfunction_mfk","");
                                            $arole_arr[$lkp_role_code]->set("parent_arole_id",$arole_arr[$role_code]->getId());
                                            $arole_arr[$lkp_role_code]->update();
                                            if($new_role) $new_role_count++; 
                                            
                                            $arole_arr[$role_code]->module_associated = $submod_obj;
                                            $arole_arr[$role_code]->nbTbs = count($at_list); 
                                            $arole_arr[$lkp_role_code]->module_associated = $submod_obj;
                                            $arole_arr[$lkp_role_code]->nbTbs = 0;
                                     }
                                     
                                     
                                     
                                     $atb_obj_class = $atb_obj->getTableClass();
                                     $atb_obj_desc =  $atb_obj->getVal("titre_short");
                                     $atb_obj_name =  $atb_obj->getVal("titre_u");
                                     if(!$atb_obj_name) $atb_obj_name = "مسمى سجل مفقود جدول-".$atb_obj->getId();
                                     $atb_obj_desc_en =  $atb_obj->getVal("titre_short_en");
                                     $atb_obj_name_en =  $atb_obj->getVal("titre_u_en");  
                                     if(!$atb_obj_name_en) $atb_obj_name_en = "no-tu-atable-".$atb_obj->getId();
                                     if($atb_obj->isOriginal()) 
                                     {
                                             $atb_obj->beforeMAJ($atb_obj->getId(), $fields_updated=null);
                                             $atb_obj->update();
                                             $bf_arr = $atb_obj->createFrameWorkScreens($framework);
                                             $screens_count += count($bf_arr);
                                             $atb_obj_cat = $atb_obj->tableCategory();
                                             $atb_obj_name = $atb_obj->getVal("atable_name");
                                             if(!count($bf_arr))  $out_scr .= "<br><div class='error'>$atb_obj_cat table : <b>[$atb_obj_name($atb_id)]</b> has no screen </div> <br>";
                                             else
                                             {
                                                     foreach($bf_arr as $bf_id => $bf_data)
                                                     {
                                                          if($bf_id>0)
                                                          {
                                                                  $bf = $bf_data["bf"];
                                                                  $bf_new = $bf_data["bf_new"];
                                                                  $menu = $bf_data["menu"];
                                                                  
                                                                  if(!$arole_arr[$role_code])
                                                                  {
                                                                       throw new AfwRuntimeException("for table $atb_obj_name : arole_arr[$role_code] not defined : submod($atb_id_sub_module / $id_sub_mod / $submod_obj)");
                                                                  }
                                                                  
                                                                  $arole_arr[$role_code]->addBF($bf->getId());
                                                                  if($menu)
                                                                  {
                                                                      if($atb_obj->_isLookup())
                                                                      {
                                                                           $role_id = $arole_arr[$role_code]->getId();
                                                                           $lkp_role_id = $arole_arr[$lkp_role_code]->getId();
                                                                           
                                                                           $log = "<br>table $atb_obj is lookup, need to to add bf : $bf($bf_id) ";
                                                                           $log .= "<br>role($role_id) : mfk before ". $arole_arr[$role_code]->getVal("bfunction_mfk");
                                                                           $log .= "<br>lkp role($lkp_role_id) : mfk before ". $arole_arr[$lkp_role_code]->getVal("bfunction_mfk");
                                                                           $arole_arr[$role_code]->addRemoveInMfk("bfunction_mfk",array(), array($bf->getId()));
                                                                           $arole_arr[$lkp_role_code]->addRemoveInMfk("bfunction_mfk",array($bf->getId()), array());
                                                                           $arole_arr[$lkp_role_code]->nbTbs++;
                                                                           
                                                                           
                                                                           $log .= "<br>role($role_id) : mfk after ". $arole_arr[$role_code]->getVal("bfunction_mfk");
                                                                           $log .= "<br>lkp role($lkp_role_id) : mfk after ". $arole_arr[$lkp_role_code]->getVal("bfunction_mfk");
                                                                           // $log .= "<br>".var_export($arole_arr[$lkp_role_code],true);
                                                                           // die($log);
                                                                           $out_scr .= "<div class='information'> in lookup_role bf=$bf log=$log </div>";
                                                                      }
                                                                      else
                                                                      {
                                                                           $arole_arr[$role_code]->addRemoveInMfk("bfunction_mfk",array($bf->getId()), array());
                                                                      }
                                                                  }
                                                                  else
                                                                  {
                                                                       $mfk_before = $arole_arr[$role_code]->getVal("bfunction_mfk");
                                                                       $arole_arr[$role_code]->addRemoveInMfk("bfunction_mfk",array(), array($bf->getId()));
                                                                       $mfk_after = $arole_arr[$role_code]->getVal("bfunction_mfk");
                                                                       $role_name = $arole_arr[$role_code]->getDisplay($lang);
                                                                       if($mfk_before <> $mfk_after)
                                                                       {
                                                                           $out_scr .= "<div class='warning'> تم حذف الوظيفة$bf من الدور الوظيفي($role_name - $role_code - $role_id) (قبل:$mfk_before | بعد:$mfk_after)</div><br>";
                                                                       }
                                                                       
                                                                  }
                        
                                                                  $out_scr .= "<br>bf : <b>$bf</b> => new=$bf_new, menu=$menu<br>";                                            
                                                                  if($bf_new) $new_bf_count++;
                                                                  else $updated_bf_count++;
                                                          }
                                                          else $ignored_count++;
                                                     }
                                                     
                                                     if($bf_arr[-1]) $out_scr .= "<div class='warning'> ignored for $atb_obj_cat table : <b>[$atb_obj_name($atb_id)]</b> : ".var_export($bf_arr[-1],true)." </div>";
                                             }
                                     }
                                     else
                                     {
                                             // @todo rafik : case of rfw pages
                                             $to_implement_count++;
                                     }
                                     //$atb_obj->getVal("atable_name")
                                                
                        }
                        
                        $my_roles_arr= array();
                        $my_roles_names_arr= array();
                        
                        foreach($arole_arr as $role_code => $arole_item)
                        {
                             
                             if($arole_item->getVal("arole_type_id")==10)
                             {
                                $my_roles_names_arr[] = $arole_item->getDisplay($lang);
                                $my_roles_arr[] = $arole_item->getId();
                             } 
                             
                             
                             if($arole_arr[$role_code]->nbTbs==0)
                             {
                                $arole_item->set("avail","N");
                             }
                             $module_parent = $arole_arr[$role_code]->module_associated->getParent();
                             $parent_role_code = "module-".$module_parent->getId(); 
                             if($arole_arr[$parent_role_code])
                             {
                                 $arole_item->set("parent_arole_id",$arole_arr[$parent_role_code]->getId());
                                 
                                 // $arole_arr[$parent_role_code]->addRemoveInMfk("arole_mfk",array($arole_item->getId()), array());
                                 // $arole_arr[$parent_role_code]->update();
                             }
                             
                             $arole_item->update();
                        }
                        
                        list($my_org_id, $my_module_id, $mau_found) = $objme->hasModule($currmod);
                        
                        if(count($my_roles_arr>0)) 
                        {
                             $my_roles_names = implode(" <br> ",$my_roles_names_arr);
                             $my_roles = ",".implode(",",$my_roles_arr).",";
                             $out_scr .= "<div class='information'> roles will be assigned to you $objme for module $currmod : <br>$my_roles_names </div>";
                        } 
                        else
                        {
                            $my_roles = "";
                            $out_scr .= "<div class='warning'> empty roles might be assigned to you $objme for module $currmod </div>";
                        }
                        
                        if(!$mau_found)
                        {
                             $mau_found = $objme->giveMeModule($currmod,$my_roles); 
                        }
                        else
                        {
                             if($my_roles and (!trim($mau_found->getVal("arole_mfk"),","))) 
                             {
                                     $mau_found->set("arole_mfk",$my_roles);
                                     $mau_found->update();
                             }
                             
                        }
                        
                        $out_scr .= "<br>Tables treated : $at_list_count, screens : $screens_count, new BF : $new_bf_count, updated BF : $updated_bf_count, ignored : $ignored_count, new roles : $new_role_count, to-implement cases : $to_implement_count";
                        
               }
               else
               {
                        $out_scr .= "no tables in module $currApplicationId !!";
               }
               
           }
           else
           {
               $out_scr .= "define system for module $currApplicationId !!";
           }
   }
*/       
?>