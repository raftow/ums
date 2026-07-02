<?php

/**
 * @var string $MODULE
 */
if ((!isset($MODULE)) or (!$MODULE)) {
        include("ums_start.php");
}
$direct_page = "login_ums.php";
$direct_page_path = dirname(__FILE__);
CmsMainPage::echoDirectPage($MODULE, $direct_page, $direct_page_path);