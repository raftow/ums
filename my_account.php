<?php
     if((!$objme) or (!is_object($objme))) die("user not defined  !!!");
     $css_class = "item";
     
     $html_mau_trs = "";
     //die(var_export($objme->myModules,true));
     foreach($objme->myModules as $module_code => $mau_item_arr)
     {
          //die(var_export($mau_item,true));
          $mau_item = $mau_item_arr[2];
          $module = $mau_item->showAttribute("id_module");
          $roles = $mau_item->showAttribute("arole_mfk");
          
          $html_mau_trs .= "<tr class=\"$css_class\">         
        <td>$module_code</td>
        <td>$module</td>         
        <td>$roles</td>         
</tr>";
          
          if($css_class == "altitem") $css_class = "item";
          else $css_class = "altitem";
     }
     
     
     
     if(!$token_arr) $token_arr = array();
     if(!$trad_erase) $trad_erase = array();
     //die(var_export($token_arr,true));
     $html_i = $objme->showUsingTpl("../ums/tpl/my_account_tpl.php",$trad_erase,$lang, $token_arr);
     
     $html_i = str_replace("[mau_trs]",$html_mau_trs, $html_i);
     
     $out_scr = $html_i;
?>

   
