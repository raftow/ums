<?php
$out_scr .= "<div class='hzm3-row-padding hzm3-center hzm3-small hzm_home_bloc' style='margin:0 -16px'>";
$objme = AfwSession::getUserConnected();
if ($objme) {
  $iamAdmin = $objme->isAdmin();
  $myLevel = $iamAdmin ? 0 : $objme->getVal("hierarchy_level_enum");
  $myName = $objme->getDisplay($lang);
  $myId = $objme->id;
} else {
  $iamAdmin = false;
  $myLevel = 999999;
  $myName = "None-authenticated";
  $myId = "0";
}

if (!$a) {
  $module = $a = "ums";
} else {
  $module_id = $a;
  if ($module_id) {
    $module = UmsManager::decodeModuleCodeOrIdToModuleCode($module_id);
    if (!$module) throw new AfwRuntimeException("UmsManager::decodeModuleCodeOrIdToModuleCode failed from id=($module_id)");
  }
}

if ($r == "control") {
  $uri_module = AfwUrlManager::currentURIModule();
  $control_panel_title = AfwLanguageHelper::tarjemText("control panel", $lang);
  $options_title = AfwLanguageHelper::tarjemText("options", $lang);
  $upload_files_title = AfwLanguageHelper::tarjemText("upload files", $lang);
  $my_account_title = AfwLanguageHelper::tarjemText("my account", $lang);
  $command_line = AfwLanguageHelper::tarjemText("command-line", $lang);
  $s12 = "s12";
  $out_scr .= "<h3> $control_panel_title </h3>";
  $out_scr .= "<div id='menu-item-control-options' class='bf hzm-menu-item hzm3-col l3 m3 $s12'>
                                <a class='hzm3-button hzm3-light-grey hzm3-block' href='main.php?Main_Page=toggle_option.php&My_Module=ums' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                    <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                      <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                        <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-settings\"></i>
                                      </div>
                                    </div>
                                    <div class='hzm4-title'>$options_title</div>
                                </a>
                             </div>";
  if ($iamAdmin or AfwSession::config("allow_upload_for_all", false) or ($myLevel <= AfwSession::config("allow_upload_for_level", 999))) {
    $out_scr .= "<div id='menu-item-files-upload' class='bf hzm-menu-item hzm3-col l3 m3 $s12'>
                                      <a class='hzm3-button hzm3-light-grey hzm3-block' href='afw_my_files.php' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                          <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                            <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                              <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-std fa-cloud-upload\"></i>
                                            </div>
                                          </div>
                                          <div class='hzm4-title'>$upload_files_title</div>
                                      </a>
                                  </div>";
  }
  $out_scr .= "<div id='menu-item-myaccount' class='bf hzm-menu-item hzm3-col l3 m3 $s12'>
                                <a class='action_lourde hzm3-button hzm3-light-grey hzm3-block' href='user_account.php' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                    <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                      <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                        <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-std fa-user\"></i>
                                      </div>
                                    </div>
                                    <div class='hzm4-title'>$my_account_title</div>
                                </a>
                             </div>        
                             
                             ";

  if ($uri_module == "pag") {
    $out_scr .= "<div id='menu-item-cline' class='bf hzm-menu-item hzm3-col l3 m3 $s12'>
                             <a class='action_lourde hzm3-button hzm3-light-grey hzm3-block' href='cline_go.php' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                 <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                   <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                     <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-std fa-solid fa-bolt\"></i>
                                   </div>
                                 </div>
                                 <div class='hzm4-title'>$command_line</div>
                             </a>
                          </div>        
                          
                          ";
  }
} elseif ($r) {

  list($role_item_display, $menu_folder, $role_data) = UmsManager::getRoleDetails($a, $r, $lang);
  // die("rafik see menu_folder = ".var_export($menu_folder,true));
  $role_item_display = AfwReplacement::trans_replace($role_item_display, $module, $lang);
  /**
   * @var array $menu_folder
   */
  if ($role_item_display and $menu_folder) {
    $out_scr .= "<h3>" . $role_item_display . "</h3>";
    $count_all = count($menu_folder["items"]) + count($menu_folder["sub-folders"]);
    if ($count_all > 20) $s12 = "s3";
    elseif ($count_all > 3) $s12 = "s6";
    else $s12 = "s12";
    foreach ($menu_folder["items"] as $menu_folder_item_id => $menu_folder_item) {
      $menu_item_id = $menu_folder_item["id"];
      $menu_item_level = $menu_folder_item["level"];
      $menu_item_title = $menu_folder_item["menu_name_$lang"];
      if (!$menu_item_title) $menu_item_title = $menu_folder_item["menu_name"];
      $menu_item_title = AfwReplacement::trans_replace($menu_item_title, $module, $lang);

      if ($menu_item_level >= $myLevel) {
        $out_scr .= "<!-- OK => $menu_item_title BFID=$menu_item_id BFL=$menu_item_level >= UHL=$myLevel (User=$myName ID=$myId)-->";

        $menu_item_icon = $menu_folder_item["icon"];

        if ((!$menu_item_icon) and $menu_icons_arr[$menu_item_id]) $menu_item_icon = $menu_icons_arr[$menu_item_id];
        if (!$menu_item_icon) $menu_item_icon = "globe icon-$menu_item_id";

        $menu_item_page = $menu_folder_item["page"] . "&r=$r";
        $menu_item_css = $menu_folder_item["css"];

        $out_scr .= "<div id='menu-item-$menu_item_id' class='$menu_item_css hzm-menu-item hzm3-col l3 m3 $s12'>
                                <a class='action_lourde hzm3-button hzm3-light-grey hzm3-block' href='$menu_item_page' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                    <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                      <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                        <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-fm hzm-icon-$menu_item_icon\"></i>
                                      </div>
                                    </div>
                                    <div class='hzm4-title'>$menu_item_title</div>
                                </a>
                             </div>";
      } else {
        $out_scr .= "<!-- NOT-OK => $menu_item_title BFID=$menu_item_id BFL=$menu_item_level < UHL=$myLevel (User=$myName ID=$myId)-->";
      }
    }
    foreach ($menu_folder["sub-folders"] as $menu_sub_folder_id => $menu_sub_folder) {
      if (($iamAdmin) or (!$menu_sub_folder["need_admin"])) {
        $menu_folder_title = $menu_sub_folder["menu_name"];

        $menu_folder_title = AfwReplacement::trans_replace($menu_folder_title, $module, $lang);

        $menu_folder_id = $menu_sub_folder["id"];
        $menu_folder_page = $menu_sub_folder["page"];
        $menu_folder_css = $menu_sub_folder["css"];

        $out_scr .= "<div id='menu-folder-$menu_sub_folder_id' class='$menu_folder_css hzm-menu-folder hzm3-col l3 m3 s12'>
                                         <a class='hzm3-button hzm3-light-grey hzm3-block' href='$menu_folder_page' style='white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px'>
                                            <div class=\"hzm-width-100 hzm-text-center hzm_margin_bottom \">
                                              <div class=\"hzm-vertical-align hzm-container-center hzm-custom hzm-custom-icon-container only-border border-primary\">
                                                <i class=\"hzm-container-center hzm-vertical-align-middle hzm-icon-folder\"></i>
                                              </div>
                                            </div>
                                            <div class='hzm4-title'>$menu_folder_title</div>
                                          </a>
                                     </div>";
      }
    }
  } else {
    $out_scr .= "role details not found for role_id=$r and app_id=$a ";
    $out_scr .= " <!-- role_data = " . var_export($role_data, true) . " -->";
    // $out_scr .=" <!-- role_info = ".var_export($role_info,true)." -->";
  }
}






$out_scr .= "</div>";
