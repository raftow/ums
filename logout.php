<?php
$file_dir_name = dirname(__FILE__);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
if(!$lang) $lang = "ar";

require_once("$file_dir_name/../lib/afw/afw_autoloader.php");
AfwSession::startSession();
AfwSession::logout();

header("Location: index.php");

?>