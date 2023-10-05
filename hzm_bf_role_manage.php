<?php
      
      
      
      
      
      if(!$rol) 
      {
            $out_scr = "define role you want to manage please";
            return;
      }
      
      if(!$lang) $lang = "ar";
       
      $aroleObj = new Arole();
      
      
      if(!$aroleObj->load($rol)) 
      {
            $out_scr = "the role you want to manage does not exist";
            return;
      }

      $aroleId = $aroleObj->getId();      
      $aroleName = $aroleObj->getDisplay($lang);
      
      $moduleObj = $aroleObj->hetModule();
      if(!$moduleObj) 
      {
            $out_scr = "please define module of the role $aroleObj.";
            return;
      }
      
      $subModList = $moduleObj->get("smd");
      if(!$subm)
      {
          $fsubmObj = reset($subModList);
          if($fsubmObj) $subm = $fsubmObj->getId();
          else {
             $subm = $moduleId;
             $fsubmObj = $moduleObj;
          }
      }
      else
      {
          $fsubmObj = $subModList[$subm];
      }
      
      
      $moduleId = $moduleObj->getId();
      $moduleName = $moduleObj->getDisplay($lang);
      $subModuleName = $fsubmObj->getDisplay($lang);
      
      
      
      $current_mod_submod = "$moduleName / $subModuleName";
      
      if(!$framework) $framework = $MODULE_FRAMEWORK[$moduleId];;
      if(!$framework) $framework = 1; //@todo : temporary
      if(!$framework) 
      {
            $out_scr = "define framework for module $moduleId please";
            return;
      }
      //else die("framework = $framework"); 

      if($bfrm_submit)
      {
           list($added_count, $removed_count, $menu_added_count, $menu_removed_count) = $aroleObj->saveTableRightsMatrice($framework, $_POST, $subm);
           $_SESSION["success"] = "added records:$added_count, removed records:$removed_count, menu_added:$menu_added_count, menu_removed:$menu_removed_count";
      }

      
      $tbrg_mat = $aroleObj->getTableRightsMatrice($framework, $subm);

      $aroleAllBFList = $aroleObj->getAllBFs();
      //die("<br> var_export of aroleAllBFList".var_export($aroleAllBFList,true));

      if($tbrg_mat["error"])
      {
           $out_scr = "the rights matrix can not be constructed : ".$tbrg_mat["error"];
           return;
      }
      
      $datatable_on = true;
      
     
      //die("count(tbrg_mat) = " . count($tbrg_mat)." tbrg_mat = ".var_export($tbrg_mat,true));
      
      
      
      include("$file_dir_name/../pag/framework_${framework}_specification.php");

      ob_start();

?>
<form method="post" action="main.php">
<center>
<table style="width: 63%;">
<tbody><tr>  
<td style="padding-top: 15px;">
<div style="font-weight: bold;font-size: 16px;"> صلاحيات الدور الوظيفي '<?=$aroleName?>'   على جداول </div>
</td>

<td style="padding-top: 5px;">
<?
   if(count($subModList)>0)
   {
           //$btns_all = "<br>";
           // use bootstrap design version if many links
           $btns_all .= "<div class='btn-group'>";
           $btns_all .= "  <button type='button' class='btn btn-primary'>$current_mod_submod</button>";
           $btns_all .= "  <button type='button' class='btn-primary dropdown-toggle' data-toggle='dropdown'>";
           $btns_all .= "    <span class='caret'></span>";
           $btns_all .= "  </button>";
           $btns_all .= "  <ul class='dropdown-menu' role='menu'>";
           foreach($subModList as $subModId => $subModObj)
           {
                if($subModId != $subm)
                {
                        $o_url = "main.php?Main_Page=hzm_bf_role_manage.php&rol=$aroleId&subm=$subModId";
                        $o_tit = "وحدة ". $subModObj->getDisplay($lang);
                        $btns_all .= "    <li><a href='$o_url'>$o_tit</a></li>";
                }
           }   
           $btns_all .= "  </ul>";
           $btns_all .= "</div>";
           echo $btns_all;
   }
   else
   {
         echo "No sub modules for module : $moduleObj ($moduleId)";
   }
?>
<input type="hidden" name="Main_Page" id="Main_Page" value="hzm_bf_role_manage.php">
<input type="hidden" name="rol" value="<?=$aroleId?>">
<input type="hidden" name="subm" value="<?=$subm?>">

</td>
</tr>
</tbody>
</table>
</center>

<br>
<table class="display dataTable" cellspacing="3" cellpadding="4">
<thead>
<tr>
        <th class="xqe_hf_z" align="center">الجدول</th>
<?
$alt = "z";
//die("count(framework_mode_list) = " . count($framework_mode_list)." framework_mode_list = ".var_export($framework_mode_list,true));
foreach($framework_mode_list as $framework_mode => $framework_mode_item)
{
       if($alt == "z") $alt = "x";
       else $alt = "z";
?>        
        <th class="xqe_hf_<?=$alt?>" align="center"><?=$framework_mode_item["label"][$lang]?></th>
<?
}
?>
</tr>
</thead>
<tbody>
<?
$odd = "odd";

foreach($tbrg_mat as $tblId => $tblSubMat)
{
   if($odd == "odd") $odd = "even"; 
   else $odd = "odd";

   $alt = "z";
?>
<tr>
   <td class="xqe_<?=$odd?>_<?=$alt?>" align="center"><?=$tblSubMat["obj"]?></td>
<?   
foreach($framework_mode_list as $framework_mode => $framework_mode_item)
{
    $bf_data = $tblSubMat[$framework_mode];
    if($alt == "z") $alt = "x";
    else $alt = "z";
?>        
  <td class="xqe_<?=$odd?>_<?=$alt?>" align="center">
<?
    
    if(($bf_data["bf"]) and (is_object($bf_data["bf"])))
    {
       $checkbox_name = "chk_".$framework_mode."_".$tblId;
       $bf_id_input_name = "bf_id_".$framework_mode."_".$tblId;
       
       $bf_id = $bf_data["bf"]->getId();
       $bf_data_arole_id = $bf_data["arole_id"];
       $bf_data_menu = $bf_data["menu"];
       /*
       if($bf_id==101663)
       {
       
       }*/
       
       if($aroleAllBFList[$bf_id])
       {
          $checkbox_checked = "checked";
          $checkbox_value = "1";
       }
       else
       {
          $checkbox_checked = "";
          $checkbox_value = "";
       }
       
       
       $aroleObj_HasAsSpecialBF = false; //  --> because obsoleting : $aroleObj->HasAsSpecialBF($bf_id)
       
        // if checked and it is a sub-menu for this role so can not be unchecked (picture)
        if($checkbox_checked and $aroleObj_HasAsSpecialBF)
        {
?>        
             <img src="../images/redc_d.png">
             <input type="hidden" value="1" id="<?=$checkbox_name?>" name="<?=$checkbox_name?>">
<?  
        }
        else
        {
?>        
              <input type="checkbox" value="1"  id="<?=$checkbox_name?>" name="<?=$checkbox_name?>" <?=$checkbox_checked?> class="<?=$checkbox_extra_class?>">
<?  
        }
?>  
        <input type="hidden" value="<?=$checkbox_value?>" id="old_<?=$checkbox_name?>" name="old_<?=$checkbox_name?>">
        <input type="hidden" value="<?=$bf_id?>" id="<?=$bf_id_input_name?>" name="<?=$bf_id_input_name?>">
<?
    }
    else echo "&nbsp;"
?>
  </td>
<?    
}
?>
</tr>
<?
}   
?>
</tfoot></table>
<br>
<br>
<center>
<table cellspacing="8" cellpadding="10">
<tbody>
<tr class="table_obj">
  <td>
    <br><input type="submit" name="bfrm_submit" id="bfrm_submit" class="bluebtn btn fright" value="&nbsp;حفظ التعديلات&nbsp;" width="200px" height="30px">
  </td>
</tr>
</tbody>
</table>
</center>
</form>

<?
        $out_scr = ob_get_clean();
?>