<?php
$file_dir_name = dirname(__FILE__);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);

$lang = "ar";

require_once("$file_dir_name/../lib/afw/afw_autoloader.php");

$module_dir_name = $file_dir_name;


        
AfwSession::startSession();

$uri_module = AfwUrlManager::currentURIModule();

include_once ("$file_dir_name/../$uri_module/application_config.php");
AfwSession::initConfig($config_arr);
$NOM_SITE = AfwSession::config("application_name","This Application");


require_once("$file_dir_name/../external/db.php");
// 

include("$file_dir_name/../lib/hzm/web/hzm_header.php");

$message = "Acess denied.    /    عملية غير مسموح بها";
if($MODE_DEVELOPMENT)
{
?>

<center>
<br>
<br>
<div class="alert alert-danger alert-dismissable" role="alert" ><?php echo $message;?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
<div class="warning">
للأسف لا توجد عندك صلاحية للتمتع بهذه الخدمة .<br> 
نرجوا منكم التواصل مع المشرف.<br>
Sorry you dont have authorisation to do this action.<br> 
Please contact administrator.<br>
<br>
<br>
<table cellspacing="8px" cellpadding="10px" class="grid" style="background-color: #efefef;border: 1px #000;border-style: solid;padding: 10px;">

<tr><th>المشرف / Administrator</th><td>yyyyyyyyyyyyy</td></tr>
<tr><th>تحويلة / Extension</th><td>xxxxx</td></tr>
<tr><th>البريد الاكتروني/ Email</th><td>.........................</td></tr>
<tr><th>معرف المستخدم / User ID</th><td><? if($objme) echo $objme->getId()?></td></tr>
<tr><th>الخدمة المطلوبة / Requested service</th><td><?php echo AfwSession::pullSessionVar("operation")?></td></tr>
<tr><th>النتيجة / Result</th><td><?php echo AfwSession::pullSessionVar("result")?></td></tr>
<tr><th>التقرير / report </th><td><?php echo AfwSession::pullSessionVar("report")?></td></tr>
<tr><th>بيانات فنية أخرى </th><td><?php echo AfwSession::pullSessionVar("other_log")?></td></tr>
</table> 
</center>
<br>
</div>
<br>
<?
        echo "<br>userCan table <br>";
        echo var_export($objme->userCanTable,true);
        
        
        echo "<br>iCanDoOperationLog <br>";
        echo $objme->showArr($objme->iCanDoOperationLog);
        
        echo "<br>iCanDoBFLog <br>";
        echo $objme->showArr($objme->iCanDoBFLog);
        
        echo "<br>myBFListOfID table <br>";
        echo $objme->showArr($objme->myBFListOfID);
        
        echo "<br>Me details <br>";
        echo $objme->showMyProps();
        echo "<br>Session details <br>";
        echo AfwSession::logSessionData(true);
        echo "<br>\n".AfwShowHelper::showObject($objme,"html");
}


?>
