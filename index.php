<?php
$direct_dir_name = dirname(__FILE__);
include("$direct_dir_name/ums_start.php");
// $objme = AfwSession::getUserConnected();

$Main_Page = "work.php";
$file_dir_name = dirname(__FILE__);
$MODULE = $My_Module = "ums";
AfwMainPage::echoMainPage($My_Module, $Main_Page, $file_dir_name);

?>