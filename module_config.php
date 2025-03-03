<?php
                /*
                global $boucle_inf, $boucle_inf_arr;
                
                if(!$boucle_inf)
                {
                   $boucle_inf = 0;
                   $boucle_inf_arr = array();
                }
                $this_getId = "config";
                $this_table = "ums";
                $boucle_inf_arr[$boucle_inf] = "module_config [$this_table,$boucle_inf]";
                $boucle_inf++;
                
                if($boucle_inf > 50)
                {
                      throw new AfwRuntimeException("heavy page halted after $boucle_inf enter to module_config in one request, ".var_export($boucle_inf_arr,true));
                }*/
                
                $TECH_FIELDS = array();
                $MODULE = "ums";
                $THIS_MODULE_ID = 18;
                $MODULE_FRAMEWORK[$THIS_MODULE_ID] = 1;
                
        	$TECH_FIELDS[$MODULE]["CREATION_USER_ID_FIELD"]="id_aut";
        	$TECH_FIELDS[$MODULE]["CREATION_DATE_FIELD"]="date_aut";
        	$TECH_FIELDS[$MODULE]["UPDATE_USER_ID_FIELD"]="id_mod";
        	$TECH_FIELDS[$MODULE]["UPDATE_DATE_FIELD"]="date_mod";
        	$TECH_FIELDS[$MODULE]["VALIDATION_USER_ID_FIELD"]="id_valid";
        	$TECH_FIELDS[$MODULE]["VALIDATION_DATE_FIELD"]="date_valid";
        	$TECH_FIELDS[$MODULE]["VERSION_FIELD"]="version";
        	$TECH_FIELDS[$MODULE]["ACTIVE_FIELD"]="avail";
                
                
                $TECH_FIELDS_TYPE = array("id_aut"=>"FK", "date_aut"=>"DATETIME", "id_mod"=>"FK", "date_mod"=>"DATETIME", "id_valid"=>"FK", "date_valid"=>"DATE", "version"=>"INT");
                
                $LANGS_MODULE = array("ar"=>true,"fr"=>false,"en"=>true);
                
                $MENU_ICONS[30] = "cogs";
                $MENU_ICONS[32] = "users";
                $MENU_ICONS[28] = "building-o";
                
                
                $login_by = "اسم المستخدم";
                
                $date_pos_left = "40%";
                $date_pos_top = "1.5%";
                $date_color = "#294eb9";
                $date_bgcolor = "rgba(255, 255, 255, 0.32)";
                $header_bg_color = "#fff";
                //$date_font_weight = "bold";
                //$date_color = "#1e620b";
                $date_font_size = "14px";
                $date_font_family = "maghreb";                 
                
                $MODE_DEVELOPMENT = true;                
                $module_config_token["file_types"] = "1,2,3,4,5,6,14";
                
                $front_header = true;
                $front_application = true;
                // $config["img-path"] = "../exte-rnal/pic/";
                // $config["img-company-path"] = "../exte-rnal/pic/";
                
                $display_in_edit_mode["*"] = true;
                $jstree_activate = true;
                $header_style = "header_thin";                               
                
?>