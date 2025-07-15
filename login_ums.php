<?php
if(!$action_page) $action_page = "login.php";
$login_dbg = array();
$msg = "";
if(!$login_page_options) $login_page_options = AfwSession::config("login_page_options", array());
if(AfwSession::userIsAuthenticated()) 
{
        header("Location: index.php");
} 
elseif(($_POST["mail"]) and ($_POST["pwd"]) and ($_POST["loginGo"]))
{        
        if($debugg_login_in_file)
        {
                AFWDebugg::startDebuggPage();
        }
        AfwSession::resetSession();

        $user_or_email = $_POST["mail"];
        $password = $_POST["pwd"];
        
        // UmsLoginService::umsAuthentication below if succeeded will 
        // complete the authentication and redorect to home page
        // if failed the error message will be returned inside the array $tokens
        $tokens = UmsLoginService::umsAuthentication($user_or_email, $password);
}
else
{
        $user_name_c = "";
        $user_name = "";
        $msg = "";
        $tokens = [];
}
$logbl = substr(md5($_SERVER["HTTP_USER_AGENT"] . "-" . date("Y-m-d")),0,10);
$uri_module = AfwUrlManager::currentURIModule();
$xmodule = AfwSession::getCurrentlyExecutedModule();
$site_name = AfwSession::getCurrentSiteName($lang);
$tokens["module"] = $uri_module;
$tokens["xmodule"] = $xmodule;
$tokens["login_by_sentence"] = AfwLanguageHelper::translateCompanyMessage("You can authenticate by your usual user-name and password", $uri_module, $lang, $company);
$tokens["login_by"] = AfwLanguageHelper::translateCompanyMessage("User-name", $uri_module, $lang, $company);
$tokens["password_label"] = AfwLanguageHelper::translateCompanyMessage("password", $uri_module, $lang, $company);
$tokens["company"] = AfwSession::currentCompany();
$tokens["login_title"] = $site_name;
$tokens["site_name"] = $site_name;
if($tokens["message"]) $msg = $tokens["message"];
$tokens["message"] = $msg;
$tokens["no_message_s"] = $msg ? "" : "<!-- ";
$tokens["no_message_e"] = $msg ? "" : " -->";
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

if(AfwSession::config("MODE_DEVELOPMENT",false) and ($user_name_c=="rboubaker") and ($pwd=="123")) 
{
    $tokens["login_debugg_imploded_securized"] = "As MODE_DEVELOPMENT is enabled show log of LDAP : <br>\n".implode("\n", $login_dbg);
}
else $tokens["login_debugg_imploded_securized"] = "";

$tokens["login_data_incomplete"] = AfwLanguageHelper::translateCompanyMessage("Please enter correct login information", $uri_module, $lang, $company); 

$login_template = AfwSession::config("login-template", "default");

$file_dir_name = dirname(__FILE__);
$html_template_file = $file_dir_name."/tpl/$login_template"."_login_tpl.php";

echo AfwHtmlHelper::showUsingHzmTemplate($html_template_file, $tokens, $lang);

