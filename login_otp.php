<?php

/**
 * otp login page
 * @var array $config_arr
 * @var int $user_id_logged_in
 * @var array $NOM_SITE the site name in different languages
 * @var array $DESC_SITE the site description in different languages
 * @var string $otp_verify_msg the message to show to user in case of error or any 
 *             after login form (used to show error message in case of error in login form filling)
 * 
 * @var string $auser_id the customer id (used in case of login by email or mobile without idn, then we get the idn by customer id and we put it in hidden field to be able to use it in next step which is verification code sending)
 */

$otp_verify_msg = "";
$sms_info_export = "";
$sms_ok = false;
$file_dir_name = dirname(__FILE__);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);



// $logbl = substr(md5($_SERVER["HTTP_USER_AGENT"] . "-" . date("Y-m-d")),0,10);

if (!$lang) $lang = "ar";
$module_dir_name = $file_dir_name;

require_once("$file_dir_name/../lib/afw/core/afw_autoloader.php");
$uri_module = UfwUrlManager::currentURIModule();
AfwAutoLoader::addModule($uri_module);

AfwSession::startSession();


if (!$uri_module) die("site code not defined !!!");
else {
    $ini_file_path = "$file_dir_name/../$uri_module/ini.php";
    include($ini_file_path);
    if (!$NOM_SITE) die("OTP LOGIN : web site not configured correctly !!! review your $uri_module module ini file : $ini_file_path : ".highlight_file($ini_file_path, true));
    include("$file_dir_name/../$uri_module/module_config.php");
}

include("$file_dir_name/../$uri_module/application_config.php");
AfwSession::initConfig($config_arr, "system", "$file_dir_name/../$uri_module/application_config.php");


// if(!$simulate_sms_to_mobile) die("simulate_sms_to_mobile not configured or not initialized !!! ".var_export($config_arr,true));

$nom_site = $NOM_SITE[$lang];
$desc_site = $DESC_SITE[$lang];

$debugg_login = false;
$debugg_after_login = true;
$debugg_after_golden_or_db = true;
$debugg_after_session_created = true;

$customer_msg = "";
$gender_id = 1;
$gender_id_selected_2 = "";
$gender_id_selected_1 = "selected";

require_once("$file_dir_name/../config/global_config.php");
// 
$otp_verify_the_message = "";
$otp_info_export = ".... starting ....";
$otp_destination = "Not yet";
/** 
 * @var array $tokens
 */
$tokens["otp_verify_the_message"] =  "";
if (AfwSession::userIsAuthenticated()) {
    header("Location: index.php");
}  else {
    $sms_mobile = "";

    // random code
    $user_OTP = UfwSmsSender::verifyCode();
    AfwSession::setSessionVar("user_OTP", $user_OTP);
    $otp_verify_the_subject = "رمز التحقق";
    $otp_verify_the_message = $otp_verify_the_subject . " " . $user_OTP;

    // $app_name = AfwSession::config("application_name", "adm");

    $simulate_sms_to_mobile = AfwSession::config("simulate_sms_to_mobile", null);
    $objUser = Auser::loadById($user_id_logged_in);
    if ($simulate_sms_to_mobile) $sms_mobile = $simulate_sms_to_mobile;
    else {
        
        if ($objUser) $sms_mobile = $objUser->getVal("mobile");
    }

    $simulate_email = AfwSession::config("simulate_email", null);

    if ($simulate_email) $email_adress = $simulate_email;
    else {
        if ($objUser) $email_adress = $objUser->getVal("email");
    }



    // send SMS to customer 
    $otp_show_in_page = AfwSession::config("otp-show-in-page", true);
    
    if ($otp_show_in_page) {
        $tokens["otp_verify_the_message"] =  $otp_verify_the_message;
        $otp_ok = true;
        $otp_info = ["result" => "shown in page momken-console"];
        $otp_info_export = var_export($otp_info, true);
        $otp_destination = "الصفحة"; //  (كنسول المتصفح)
    } else {
        $otpSendMethod = AfwSession::config("otp-send-method", "sendNotification");
        $otp_destination = "";
        if ($sms_mobile) $otp_destination = "الجوال " . UfwSmsSender::partialShowMobile($sms_mobile);
        if ($email_adress) {
            if($otp_destination) $otp_destination .= " و ";
            $otp_destination .= "البريد الالكتروني ". UfwSmsSender::partialShowEmail($email_adress);
        }
        $payLoad = [
            "mobile" => $sms_mobile,
            "email" => $email_adress,
            "body" => $otp_verify_the_message,
            "subject" => $otp_verify_the_subject,
        ];
        list($otp_ok, $otp_info) = UfwSmsSender::$otpSendMethod($payLoad);
        if ((!$otp_ok) and (!$otp_info)) {
            $otp_info_export = "call to UfwSmsSender::$otpSendMethod failed without known reason, payload = " . var_export($payLoad, true);
        } else $otp_info_export = var_export($otp_info, true);
    }
}

$tokens["otp_destination"] = $otp_destination;
$tokens["otp_ok"] = $otp_ok;
$tokens["otp_info_export"] = $otp_info_export;
$tokens["otp_verify_msg_s"] = ($otp_verify_msg or $otp_verify_the_message) ? "" : "<!-- ";
$tokens["otp_verify_msg_e"] = ($otp_verify_msg or $otp_verify_the_message) ? "" : " -->";

$tokens["otp_verify_msg"] = $otp_verify_msg;

$login_template = AfwSession::config("login-template", "simple");

$file_dir_name = dirname(__FILE__);
$html_template_file = $file_dir_name . "/tpl/$login_template" . "_login_otp_tpl.php";

echo AfwHtmlHelper::showUsingHzmTemplate($html_template_file, $tokens, $lang);