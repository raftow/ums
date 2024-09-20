<?php

$file_dir_name = dirname(__FILE__);
     
include "$file_dir_name/../ums/module_options.php";
include "$file_dir_name/../$MODULE/special_module_options.php";
      
      $r = "control";
      $objme = AfwSession::getUserConnected();
      if(!is_object($objme)) 
      {
          $out_scr .= "You are not logged";
      }
      else
      {
          $lang = AfwLanguageHelper::getGlobalLanguage(); 
          if($option)
          {
                $option_word = $objme->tr("the control option");

                $option_translated = $options_arr[$option][$lang];
                if(!$option_translated) $option_translated = $option;
            
                AfwSession::toggleOption($option);
                  
                if(AfwSession::hasOption($option)) $option_status = $objme->tr("has been enabled");
                else $option_status = $objme->tr("has been disabled");
                  
                AfwSession::pushSuccess("$option_word { $option_translated } $option_status");
          }
      }
     

     $out_scr .= "<div class='hzm_intro modal-dialog home_title'>خيارات التحكم</div>";
     $out_scr .= "<div class='hzm_intro modal-dialog home_help'>انقر لتفعيل الخيار أو تعطيله</div>";

     $out_scr .= "<div class='ul-options'>";
     if(!$lang) $lang = "ar";
     // die("lang=$lang options_arr = ".var_export($options_arr,true));
     foreach($options_arr as $option_code => $option_props) 
     {
             if((!$option_props["admin"]) or ($objme->isAdmin()))
             {
           
               if(AfwSession::hasOption($option_code))
               {
                     $options_status = "checked";
                     $options_class = "optionenabled";
               }
               else
               {
                     $options_status = "unchecked";
                     $options_class = "optiondisabled";
               }
               
               $out_scr .= "<div id='menu-item-control-options-$option_code' class='bf hzm-menu-item hzm3-col l3 m3 s12 $options_class'>
                                                <a class='hzm3-button hzm3-light-grey hzm3-block' href='main.php?Main_Page=toggle_option.php&option=$option_code&My_Module=ums' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                                    <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                                      <div class=\"hzm-vertical-align hzm-container-center $options_class hzm-custom hzm-custom-icon-container only-border border-primary\">
                                                        <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-$options_status\"></i>
                                                      </div>
                                                    </div>
                                                    $option_props[$lang]
                                                </a>
                                        </div>";
             }
     }
     $out_scr .= "</div><!--ul-options-close-->";
     

     