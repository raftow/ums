<?php
   $options_arr["STATS_COMPUTE"] = ["ar"=>"حساب الاحصائيات", "en"=>"compute stats"];
   $options_arr["CHECK_ERRORS"] = ["ar"=>"التثبت من الأخطاء", "en"=>"check errors"];
   $options_arr["GENERAL_CHECK_ERRORS"] = ["ar"=>"التدقيق في الأخطاء", "en"=>"all steps check errors", "admin"=>true];
   // $options_arr["SHOW_ONLY_ERRORS"] = ["ar"=>"عرض الأخطاء فقط في التفاصيل", "en"=>"show only errors in detail data", "admin"=>true];
   $options_arr["PERFORMANCE_ANALYSIS"] = ["ar"=>"تحليل الأداء", "en"=>"performance analysis", "admin"=>true];
   $options_arr["SQL_LOG"] = ["ar"=>"نصوص سكيوال", "en"=>"SQL Log", "admin"=>true];
   $options_arr["UMS_LOG"] = ["ar"=>"تتبع الآثار", "en"=>"Authorisation management log", "admin"=>true];
   $options_arr["FULL_SCREEN"] = ["ar"=>"ملء الشاشة", "en"=>"Full screen"];
   $options_arr["HIJRI_TO_GREG"] = ["ar"=>"تواريخ ميلادية", "en"=>"Gregorian dates"];
   $options_arr["COPY_PAST_M"] = ["ar"=>"نسخ لصق متعدد السطور", "en"=>"Multiple lines copy paste"];
   if($objme and $objme->isSuperAdmin())
   {
      $options_arr["SWITCH_ROOT"] = ["ar"=>"صلاحية الروت", "en"=>"Root previleges"];
   }
   
   
?>