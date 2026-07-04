<?php

/**
 * @var string $company
 * @var boolean $customer_authenticate
 */

$login_dbg = array();
$msg = "";
$user_name_c = "";
$user_name = "";
$user_or_email = "";
$password = "";
if (!isset($login_page_options)) $login_page_options = AfwSession::config("login_page_options", array());
if (AfwSession::userIsAuthenticated()) {
        header("Location: index.php");
} elseif (($_POST["mail"]) and ($_POST["pwd"]) and ($_POST["loginGo"])) {
        if (isset($debugg_login_in_file) and $debugg_login_in_file) {
                AFWDebugg::startDebuggPage();
        }
        AfwSession::resetSession("main_company");

        $user_or_email = $_POST["mail"];
        $password = $_POST["pwd"];
        if ($_POST["company"]) AfwSession::setCurrentCompany($_POST["company"]);
        // die("debugg rafik _POST=[".var_export($_POST,true)."] and _SESSION = ".var_export($_SES SION,true));
        // UmsLoginService::umsAuthentication below if succeeded will 
        // complete the authentication and redorect to home page
        // if failed the error message will be returned inside the array $tokens
        // die("before login _POST=".var_export($_POST,true));
        $tokens = UmsLoginService::umsAuthentication($user_or_email, $password);
        //die("after login tokens=".var_export($tokens,true));
        if($tokens["connected"] and !$tokens["authenticated"] and $tokens["two_factor_authentication"]) {
                // user need two_factor_authentication so redirect to two_factor_authentication page
                $two_factor_authentication = $tokens["two_factor_authentication"];
                $user_name_logged_in = $tokens["user_name_logged_in"];
                $user_id_logged_in = $tokens["user_id_logged_in"];
                $two_factor_authentication_page = "login_" . $two_factor_authentication . ".php";
                return include($two_factor_authentication_page);
        }
} elseif ($_POST["otp_verify_code"] and $_POST["user_name_logged_in"]) {
    $otp_info_export = "otp verifying sent code";
    
    $otp_ok = true;
    if (AfwSession::getSessionVar("user_OTP") == $_POST["otp_verify_code"]) {
        $user_name_logged_in = $_POST["user_name_logged_in"]; 
        // $userObj = CrmCustomer::loadByIdn($user_id); 
        list($user_found, $user_not_found_reason, $user_infos, $login_dbg[]) = UfwLoginUtilities::db_retrieve_user_info($user_name_logged_in);
        if ($user_found and $user_infos) AfwSession::userHasBeenAuthenticated($user_infos);
        else $otp_verify_msg = "حدث خطأ أثناء التحقق من الرمز المدخل ربما أن هذا المستخدم غير موجود في قاعدة البيانات : $user_name_logged_in : " . $user_not_found_reason;
    } else {
        $otp_verify_msg = "الرمز المدخل غير صحيح";
        
        if(!AfwSession::config("MODE_DEVELOPMENT", false)) $otp_verify_msg .= "<!-- ".AfwSession::getSessionVar("user_OTP") . " != " . $_POST["otp_verify_code"]." -->";
    }
    $tokens["message"] = $otp_verify_msg;
    
} else {
        $msg = "";
        $tokens = [];
        // $tokens["message"] = "Please login";
}

$tokens["action_page"] = "login.php";



$logbl = substr(md5($_SERVER["HTTP_USER_AGENT"] . "-" . date("Y-m-d")), 0, 10);
$uri_module = UfwUrlManager::currentURIModule();
$xmodule = AfwSession::getCurrentlyExecutedModule();
$site_name = AfwSession::getCurrentSiteName($lang);
$tokens["module"] = $uri_module;
$tokens["xmodule"] = $xmodule;
$tokens["login_by_sentence"] = AfwLanguageHelper::translateCompanyMessage("You can authenticate by your usual user-name and password", $uri_module, $lang, $company);
$tokens["login_by"] = AfwLanguageHelper::translateCompanyMessage("User-name", $uri_module, $lang, $company);
$tokens["password_label"] = AfwLanguageHelper::translateCompanyMessage("password", $uri_module, $lang, $company);
$tokens["company"] = AfwSession::currentCompany();
$tokens["companies_options"] = AfwHtmlHelper::arrayToSelectOptions(AfwSession::companiesList(), $tokens["company"]);
$tokens["login_title"] = $site_name;
$tokens["site_name"] = $site_name;
if (!$tokens["message"]) $tokens["message"] = "";
$tokens["message"] .= " " . $msg;
$msg = $tokens["message"] = trim($tokens["message"] );
$tokens["no_message_s"] = $msg ? "" : "<!-- ";
$tokens["no_message_e"] = $msg ? "" : " -->";
$company_selection_enabled = AfwSession::config("company_selection_enabled", true);
$tokens["companies_s"] = $company_selection_enabled ? "" : "<!-- ";
$tokens["companies_e"] = $company_selection_enabled ? "" : " -->";

$site_name_show = AfwSession::config("site_name_show", true);
$tokens["site_name_s"] = $site_name_show ? "" : "<!-- ";
$tokens["site_name_e"] = $site_name_show ? "" : " -->";

$figure_show = AfwSession::config("figure_show", true);
$tokens["figure_s"] = $figure_show ? "" : "<!-- ";
$tokens["figure_e"] = $figure_show ? "" : " -->";

$login_banner = AfwSession::config("login_banner", false);
$tokens["login_banner_s"] = $login_banner ? "" : "<!-- ";
$tokens["login_banner_e"] = $login_banner ? "" : " -->";


$tokens["admin_account_jobs"] = AfwSession::config("admin_account_jobs", "المشرف");
$tokens["login_by_gentle_sentence"] = $tokens["login_by_sentence"];
$tokens["logbl"]  = $logbl;
$tokens["login_label"] = AfwLanguageHelper::translateCompanyMessage("Login", $uri_module, $lang, $company);
$tokens["password_reminder_label"] = AfwLanguageHelper::translateCompanyMessage("Forgot password ?", $uri_module, $lang, $company);

$password_reminder = AfwSession::config("password_reminder", false);
$tokens["password_reminder_s"] =  $password_reminder ? "" : "<!-- ";
$tokens["password_reminder_e"] = $password_reminder ? "" : " -->";

$customer_authenticate_code = AfwSession::config("customer_authenticate_code", "");
$tokens["customer_login_s"] =  $customer_authenticate ? "" : "<!-- ";
$tokens["customer_login_e"] = $customer_authenticate ? "" : " -->";




$tokens["customer_code"] = $customer_authenticate_code;
$tokens["customers_title"] = AfwLanguageHelper::translateCompanyMessage("customers", $uri_module, $lang, $company);
$tokens["customer_login_title"]  = AfwLanguageHelper::translateCompanyMessage("Customers Login", $uri_module, $lang, $company);

$customer_register_code = AfwSession::config("customer_register_code", "");
$tokens["customer_register_s"] =  $customer_register_code ? "" : "<!-- ";
$tokens["customer_register_e"] = $customer_register_code ? "" : " -->";

$tokens["register_code"] = $customer_register_code;
$tokens["register_title"] = AfwLanguageHelper::translateCompanyMessage("Signup", $uri_module, $lang, $company);

if (AfwSession::config("MODE_DEVELOPMENT", false) and ($user_name_c == "rboubaker") and ($password == "123")) {
        $tokens["login_debugg_imploded_securized"] = "As MODE_DEVELOPMENT is enabled show log of LDAP : <br>\n" . implode("\n", $login_dbg);
} else $tokens["login_debugg_imploded_securized"] = "";

$tokens["login_data_incomplete"] = AfwLanguageHelper::translateCompanyMessage("Please enter correct login information", $uri_module, $lang, $company);

$login_template = AfwSession::config("login-template", "simple");

$file_dir_name = dirname(__FILE__);
$html_template_file = $file_dir_name . "/tpl/$login_template" . "_login_tpl.php";

echo AfwHtmlHelper::showUsingHzmTemplate($html_template_file, $tokens, $lang);
