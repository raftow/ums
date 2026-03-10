<?php
// IMPORTANT !!!!!!!!
// keep $file_dir_name variable not defined here but coming from each module's main.php file
include_once ("$file_dir_name/ini.php");
include_once ("$file_dir_name/module_config.php"); 
require("$file_dir_name/../lib/afw/afw_main_page.php"); 
if($_REQUEST["Main_Page"])
{
    $Main_Page = $_REQUEST["Main_Page"];
}
else
{
    $Main_Page = "home.php";
}

$table = null;
if(isset($_REQUEST["cl"])) {
    require("$file_dir_name/../lib/afw/helpers/afw_string_helper.php"); 
    $table = AfwStringHelper::classToTable($_REQUEST["cl"]);
}
if(!$table) $table = "all";
$options = AfwMainPage::getDefaultOptions($Main_Page, $MODULE, $table);

AfwMainPage::echoMainPage($MODULE, $Main_Page, $file_dir_name, $options);