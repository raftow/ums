<?php
    $lang = AfwLanguageHelper::getGlobalLanguage(); 
    if(!$MODULE) $MODULE = UfwUrlManager::currentURIModule();

    $file_dir_name = dirname(__FILE__);
    $objme = AfwSession::getUserConnected(); 
    $email_support_help = AfwSession::config("email_support_help", "");
    $help_title = AfwLanguageHelper::tarjemText("support & help", $lang);
    $out_scr .= "<h3> $help_title </h3>";
    $out_scr .= "______________________________________________<br><!-- start -->";
    if($email_support_help) $out_scr .= AfwLanguageHelper::tarjemMessage("To get support or help about this application please contact this email address", $MODULE, $lang)." : ". $email_support_help;
    else $out_scr .= AfwLanguageHelper::tarjemMessage("This page is under construction", $uri_module, $lang);

    $out_scr .= "______________________________________________<br><!-- end -->";