<?php
$direct_dir_name = dirname(__FILE__);
include("$direct_dir_name/ums_start.php");
$icando = $_GET["icando"];
if ($icando) {
    $Main_Page = "icando.php";
    $file_dir_name = dirname(__FILE__);
    $MODULE = $My_Module = "ums";
    $options = [];
    CmsMainPage::echoMainPage($My_Module, $Main_Page, $file_dir_name);
} else {
    $Main_Page = "home.php";
    $file_dir_name = dirname(__FILE__);
    $MODULE = $My_Module = "ums";
    $options = [];
    $options["dashboard-stats"] = true;
    $options["chart-js"] = true;
    CmsMainPage::echoMainPage($My_Module, $Main_Page, $file_dir_name);
}
