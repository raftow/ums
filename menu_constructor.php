obsolete old menu constructor
<?php
/*
      if(!$menu_class_ul) $menu_class_ul = "prog-ul";
      
      $html = "<div class='innercontainer'>\n";

      foreach($theme as $theme_id => $theme_title)
      {
                  $acc_list_html = "";
                  if($theme_title) $html .= "<h5 class='bluetitle'><i></i>$theme_title</h5>\n";                
                  foreach($subtheme[$theme_id] as $subtheme_id => $subtheme_title)
                  {
                       
                       $st_class = $subtheme_class[$theme_id][$subtheme_id];
                       $stt_class = $subtheme_title_class[$theme_id][$subtheme_id];
                       if(!$st_class) $st_class = "front";
                       if(!$stt_class) $stt_class = "gear";
                       
                       $acc_list_html .= "\$( \"#accordion$subtheme_id\" ).accordion({
                      collapsible: true
                    });\n\n";
                       
                       $html .= "
        <h3 class='greentitle'><i></i>$subtheme_title</h3>
        <div class='subcontainer'>\n
        <div class='col-12'>\n
        <ul class='$menu_class_ul settingsul'>\n";
                       foreach($men u[$theme_id][$subtheme_id] as $menu_id => $menu_item)
                       {
                               $menu_afw  = $menu_item["afw"];
                               $menu_mod  = $menu_item["mod"];
                               $menu_operation  = $menu_item["operation"];
                               
                               if(((!$objme) or (!$objme->isAdmin())) and ($menu_afw and $menu_mod and $menu_operation))
                               {
                                    $myObj = new $menu_afw();
                                    list($can_see_menu,$bf_id, $reason) = $myObj->userCan($objme, $menu_mod, $menu_operation);    
                               }
                               else $can_see_menu = true;
                               
                               if($can_see_menu)
                               {
                                       $menu_title  = $menu_item["titre"];
                                       $menu_page  = $menu_item["page"];
                                       $menu_png  = $menu_item["png"];
                                       $menu_class  = $menu_item["class"];
                                       $target_b = $menu_item["target"];
                                       
                                       if($target_b) $target_balise = "target='$target_b'"; else $target_balise = "";       
                                       $html .= "
                                                        <li>
                						<div class='progcard'>
                							<div><a class='$menu_class' $target_balise href='$menu_page' onclick='return true'>
                									<span class='txticon'><img src='$menu_png' width=32/></span>
                									<span class='prog-name'>$menu_title</span></a>
                							</div>
                
                						</div>
                					</li>\n";
                               }                     
                       }
                       $html .= "
                                </ul>
                                   <div class='clear'></div>
        </div>
        </div>
        
        
        ";
               
                  }
      }
      $html .= "</div>";
      

      echo $html;*/
?>