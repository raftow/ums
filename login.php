<?php
if((!isset($MODULE)) or (!$MODULE))
{         
        include_once ("$file_dir_name/ini.php");
        include_once ("$file_dir_name/module_config.php"); 
        
}
$file_dir_name = dirname(__FILE__);
$direct_page = "login_ums.php";
$direct_page_path = dirname(__FILE__); 
require("$file_dir_name/../lib/afw/afw_main_page.php"); 
AfwMainPage::echoDirectPage($MODULE, $direct_page, $direct_page_path);


/* because exists in direct_start
$file_dir_name = dirname(__FILE__);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);


 





if(!$lang) $lang = "ar";
$module_dir_name = $file_dir_name;
require_once("$file_dir_name/../lib/afw/afw_error_handler.php");
require_once("$file_dir_name/../lib/afw/afw_autoloader.php");

$main_module = AfwSession::config("main_module", "");
if($main_module) AfwAutoLoader::addMainModule($main_module);
$uri_module = AfwUrlManager::currentURIModule();       
if($uri_module) AfwAutoLoader::addModule($uri_module);

require_once("$file_dir_name/../$uri_module/ini.php");
require_once("$file_dir_name/../$uri_module/module_config.php");

include_once ("$file_dir_name/../$uri_module/application_config.php");
AfwSession::initConfig($config_arr);
AfwSession::startSession();

require_once ("$file_dir_name/../external/db.php");*/
// 



//$server_db_prefix = AfwSession::config("db_prefix","default_db_");

