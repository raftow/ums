<?php

/**
 * @var string $lang
 * @var string $out_scr
 */

$out_scr .= "<b>Config file : </b><br>";
$out_scr .= AfwSession::log_config($lineSep = "<br>");
$out_scr .= "<b>Session data : </b><br>";
$out_scr .= AfwSession::export_session();
