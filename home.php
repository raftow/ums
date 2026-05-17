<?php

/**
 * @var string $lang
 * @var string $out_scr
 */
$file_dir_name = dirname(__FILE__);

require_once("$file_dir_name/../config/global_config.php");

$datatable_on = 1;
$limite = 0;
$genere_xls = 0;

$arr_sql_conds = array();
$arr_sql_conds[] = "me.active='Y'";
$objme = AfwSession::getUserConnected();
$myEmplId = $objme->getEmployeeId();


if (!$lang) $lang = AfwLanguageHelper::getGlobalLanguage();
if (!$lang) $lang = "ar";
// $out_scr .= Page::showPage("store", "main-page", $lang);



$out_scr .= "<div id='page-content-wrapper' class='qsearch_page'><div class='row row-filter-request'>";

// customer number increasing (cni)

if (true) {
  $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1>احصائيات المستخدمين</h1></div>";
  $out_scr .= "<canvas id=\"cni\" style=\"width:100%;max-width:900px;margin:auto\"></canvas>";
  $out_scr .= AfwChartHelper::oniChartScript("Auser", "cni", "line", -10, 0, 1, 'y', 'year', '');
}

if (true) {
  $out_scr .= "<div class='qfilter col-sm-10 col-md-10 pb10'><h1>احصائيات الصلاحيات على التطبيقات</h1></div>";
  $out_scr .= "<canvas id=\"rni\" style=\"width:100%;max-width:900px;margin:auto\"></canvas>";
  $out_scr .= AfwChartHelper::oniChartScript("ModuleAuser", "rni", "line", -10, 0, 1, 'y', 'year', '', ['min' => 50, 'max' => 150]);
}


$out_scr .= "</div>";
// Generations
