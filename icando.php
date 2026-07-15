<?php

/**
 * @var string $lang
 * @var string $out_scr
 */
$file_dir_name = dirname(__FILE__);

require_once("$file_dir_name/../config/global_config.php");



$objme = AfwSession::getUserConnected();
$myEmplId = $objme->getEmployeeId();


if (!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
if (!$lang) $lang = "ar";
$module = $_GET["currmod"];
$afwClass = $_GET["cl"];
$id = $_GET["id"];
if (!$module) die("currmod param is required");
AfwAutoLoader::addModule($module);
if (!$afwClass) die("cl param is required");


if ($id) $object = $afwClass::loadById($id);
else $object = new $afwClass();

AfwUmsPagHelper::userCanDoOperationOnObject($object, $objme, 'delete', true, true);

$out_scr .= $objme->getICanDoLog(false);
