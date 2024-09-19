<?php
$file_dir_name = dirname(__FILE__);
set_time_limit(8400);
ini_set('error_reporting', E_ERROR | E_PARSE | E_RECOVERABLE_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);


 
if(!$action_page) $action_page = "login.php";

$logbl = substr(md5($_SERVER["HTTP_USER_AGENT"] . "-" . date("Y-m-d")),0,10);


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

require_once ("$file_dir_name/../external/db.php");
// here old require of common.php

// enable this in prod
/*
$html_debugg_login = false;  
$debugg_login = false;
$debugg_login_die = false; 
$debugg_after_login = false;
$debugg_after_ldap = false;
$debugg_after_golden_or_db = false;
$debugg_after_session_created = false;*/

// enable this in dev
$html_debugg_login = true;  
$debugg_login = true;
$debugg_login_die = ""; 
$debugg_after_login = true;
$debugg_after_ldap = true;
$debugg_after_golden_or_db = true;
$debugg_after_session_created = true;

$server_db_prefix = AfwSession::config("db_prefix","c0");
$check_employee_from_external_system = AfwSession::config("check_employee_from_external_system",false);
$all_users_are_internal = AfwSession::config("all_users_are_internal",false);
$login_dbg = array();
$msg = "";
if(!$login_page_options) $login_page_options = AfwSession::config("login_page_options", array());
if(AfwSession::userIsConnected()) 
{
        header("Location: index.php");
} 
elseif(($_POST["mail"]) and ($_POST["pwd"]) and ($_POST["loginGo"]))
{
        $DEBUGG_SQL_DIR = AfwSession::config("DEBUGG_SQL_DIR",$START_TREE);
        $dtm = date("YmdHis");
        $my_debug_file = "debugg_before_login_$logbl"."_$dtm.log";
        if($debugg_login_in_file)
        {
                //die("AFWDebugg::initialiser(".$DEBUGG_SQL_DIR.$my_debug_file.")");
                AFWDebugg::initialiser($DEBUGG_SQL_DIR,$my_debug_file);
                AFWDebugg::setEnabled(true);
        }
        AfwSession::resetSession();

        $email_initial = AfwStringHelper::hardSecureCleanString(strtolower($_POST["mail"]));

  
        list($user_name_c, $user_domain_c) = explode("@", $email_initial);
        $pwd_c = $_POST["pwd"];

        if($user_domain_c)
        {
                if(!AfwLoginUtilities::isLDAPDomain($user_domain_c))
                {
                        $user_name_c  = $email_initial;
                        $this_user_is_internal = false;
                }
                else
                {
                        $this_user_is_internal = true;
                }
        }
        else
        {
                if(!$all_users_are_internal) $this_user_is_internal = Auser::isInternal($user_name_c);
                else $this_user_is_internal = true;
        }
        
        // die("rafik 1 : $user_name_c, $pwd_c");
        // 1. try Active directory first (if enabled)
        list($user_connected, $user_not_connected_reason, $info, $login_dbg[]) = AfwLoginUtilities::ldap_login($user_name_c, $pwd_c);
        // die()
        // 2. try database or golden login after
        if(!$user_connected)
        {
                //die("rafik 2 reason=$user_not_connected_reason, info=$info login_dbg=".var_export($login_dbg,true));
                $login_dbg[] = "try to db_or_golden_login";
                list($user_connected, $user_not_connected_reason, $user_infos, $login_dbg[]) = AfwLoginUtilities::db_or_golden_login($user_name_c, $pwd_c);
                $user_found = $user_connected;
                //die("rafik 3 user_connected=$user_connected reason=$user_not_connected_reason, info=$user_infos login_dbg=".var_export($login_dbg,true));
                
        }
        else
        {
                $user_name_ldap =  $info["samaccountname"][0];  
                if($user_name_ldap) 
                {
                        $login_dbg[] = "try to db_retrieve_user_info with ldap user name : $user_name_ldap"; 
                        list($user_found, $user_not_found_reason, $user_infos, $login_dbg[]) = AfwLoginUtilities::db_retrieve_user_info($user_name_ldap);
                        if(!$user_found)
                        {
                                $email =  $info["mail"][0];
                                list($firstname, $fathername, $lastname) = explode(" ", $info["displayname"][0]);
                                $login_dbg[] = "Auser::findOrCreateUser($user_name_ldap, $email, $firstname, $fathername, $lastname)"; 
                                $usr = Auser::findOrCreateUser($user_name_ldap, $email, $firstname, $fathername, $lastname);
                                
                                list($user_connected, $user_not_connected_reason, $user_infos, $login_dbg[]) = AfwLoginUtilities::db_retrieve_user_info($user_name_ldap);
                        }
                        else
                        {
                                $login_dbg[] = "user $user_name_ldap found :".var_export($user_infos,true);  
                        }
                }  
                else
                {
                        $user_connected = false;
                        $user_found = false;
                        $user_not_connected_reason = $user_not_found_reason = AfwLanguageHelper::tt("result of LDAP query doesn't contain the username");
                        //$
                        $login_dbg[] = $user_not_connected_reason;
                }

                
        }

        if($user_found and $user_infos)
        {
                $username = $user_infos["username"];
                $mobile = $user_infos["mobile"];
                $email = $user_infos["email"];
        }
        
        
        
        if($debugg_login and $debugg_after_golden_or_db and (!$user_connected) and ($debugg_login==$username))
        {        
                $login_dbg[] = "login failed, user infos = ".var_export($user_infos,true);
                AfwStructureHelper::dd("ERROR : SQL/GOLDEN LOGIN FAILED :<br>\n".implode("<br>\n", $login_dbg), $debugg_login_die);
        }
        
        // 
        if($user_connected)
        {        // load infos from HR
                $emp_num = "00";
                $hasseb_num = left_complete_len($emp_num, 7, "0");
                
                if($username)
                {
                        if($check_employee_from_external_system and ($all_users_are_internal or $this_user_is_internal))
                        {
                                if($debugg_login) 
                                {
                                        AFWDebugg::log("loading And Update Employee Object From External HR System : starting ...");
                                } 
                                
                                
                                list($employee, $log_ehr) = Employee::loadAndUpdateFromExternalHRSystem($username, $hasseb_num);

                                if($email and (!$employee))
                                {
                                        $employee = Employee::loadByEmail(1, $email);
                                }

                                if($debugg_login and false) 
                                {
                                        echo("returned : ".$log_ehr);
                                        echo("employee = ".var_export($employee,true));
                                        echo("load And Update Employee Object From External HR System : end.");
                                        die("php-rafik arrived to Employee::loadAndUpdateFromExternalHRSystem");
                                }

                                if($employee and (!$employee->error) and ($employee->getId()>0))
                                {
                                        if(!$employee->is_new) 
                                        {
                                                // rafik 26 april 2021,
                                                // the condition above because if the employee is new no 
                                                // need to do updateMyUserInformation 
                                                // because already done in employee::beforeMaj
                                                //
                                                
                                                if($debugg_login) 
                                                {
                                                        AFWDebugg::log("update My User Information : starting ...");
                                                }
                                                $employee->updateMyUserInformation();
                                                if($debugg_login) 
                                                {
                                                        AFWDebugg::log("update My User Information : end.");
                                                }
                                                
                                        }        
                                        
                                }
                                else 
                                {
                                        if($employee instanceof  AFWObject)
                                        {
                                                if($employee->error) $login_dbg[] = " employee error : ".$employee->error;
                                                if(!$employee->getId()) $login_dbg[] = " employee empty !!!";

                                                if($debugg_login) 
                                                {
                                                        AFWDebugg::log("<b>!!!!!!!!!!!!!!! USER LOGGED OUT because UKNKOWN IN HR SYSTEM --------------- </b>\n");
                                                        if($employee and $employee->error and $debugg_login_die) die("Employee::loadAndUpdateFromExternalHRSystem Error : ".$employee->error."\n");
                                                }
                                        }
                                        $user_not_connected_reason = "Employee::loadAndUpdateFromExternalHRSystem($username, $hasseb_num) failed : employee : ".var_export($employee,true); 
                                        $login_dbg[] = $user_not_connected_reason;
                                        $user_connected = false;
                                }
                        }
                        else
                        {
                                $employee_org_id = 0;
                                if($email)
                                {
                                        if($x_module_means_company and ($MODULE != $uri_module))
                                        {
                                                
                                                // die("trying to find company with hrm code - $uri_module");
                                                $employeeOrg = Orgunit::loadByHRMCode($uri_module);
                                                if($employeeOrg) $employeeOrgId = $employeeOrg->getId();
                                                else throw new AfwRuntimeException("unable to find company with hrm code [$uri_module] or it is not allowed to access the system");
                                                $employee_org_id = $employeeOrgId;
                                                // @todo disable temp : if((!$employee) or ($employee_org_id != $employeeOrgId)) $user_connected = false;
                                        }
                                        //die("email=$email");
                                        $employee = Employee::loadByEmail($employee_org_id, $email);
                                        // die("Employee::loadByEmail($employee_org_id, $email) => ".var_export($employee,true));
                                        // $employee = null;
                                        if($employee) $employee_org_id = $employee->getVal("id_sh_org");        
                                }
                        }
                        
                        if($user_connected)
                        {
                                //die("rafik 5 : user is connected");
                                $user_infos = recup_row("select id, avail, firstname, email from ${server_db_prefix}ums.auser where avail = 'Y' and username='$username' limit 1");
                                //die("rafik 6 : user_infos is ".var_export($user_infos,true));        
                                $after_login_dbg = "<b>------------------------------- AFTER LOGIN USER INFOS for $username ---------------------------</b>\n";
                                $after_login_dbg .= var_export($user_infos,true);
                                
                                if($debugg_after_login)
                                {        
                                        if($debugg_login) 
                                        {
                                                AFWDebugg::log($after_login_dbg);
                                        } 

                                }
                                
                        }
                        
                }
                else 
                {
                        if($debugg_login and $debugg_login_die) 
                        {
                                AfwStructureHelper::dd("ERROR : <b>!!!!!!!!!!!!!!! USER NAME EMPTY AND CONNECTED : SHOULD BE IMPOSSIBLE logged out--------------- </b>\n".implode("<br>\n", $login_dbg), $debugg_login_die);   
                        }
                        $user_connected = false;
                        $user_not_connected_reason = "user name not defined";
                }
        
                //die("s=$time_s  e=$time_e ");
                if($user_connected)
                {
                        $last_page = AfwSession::getSessionVar("lastpage");
                        $lastget = AfwSession::getSessionVar("lastget");
                        if(is_array($lastget) and count($lastget)>0)
                        {
                                $last_page .= "?redir=1";
                                foreach($lastget as $param => $paramval) $last_page .= "&$param=$paramval";
                        }
        
                        //effacer les var d'une eventuelle session précédente
                        AfwSession::resetSession();
                
        		foreach($user_infos as $col => $val) 
                        {
        			AfwSession::setSessionVar("user_$col",$val);
        		}
        		//die("rafik 7 : last_page=[$last_page]");
                        // $objme = AfwSession::getUserConnected();
                        // die("rafik 8 : user_id=".AfwSession::getSessionVar("user_id")." objme=".var_export($objme,true));
        		if(($last_page) and ($last_page!="login.php"))
        		{
                             header("Location: ".$last_page);
                        }
                        else
                        { 
                                //$objme = AfwSession::getUserConnected();
                                //die("rafik 9 : login success : user_id=".AfwSession::getSessionVar("user_id")." objme=".var_export($objme,true));
                                header("Location: index.php");
                        }
                        exit();     
		}
                else
                {
                       if($debugg_login) 
                       {
                                AFWDebugg::log("!!!!!!!   login failed  !!!!!!!!");
                                if($debugg_login_die and ($debugg_login==$username)) die("!!!!!!!   login failed  !!!!!!!! </b>\n".implode("<br>\n", $login_dbg));
                       }
                }
		
	} 
        
        if(!$user_connected) 
        {
		$msg = "يوجد خطأ في كلمة المرور أو اسم المستخدم. الرجاء التأكد من البيانات المدخلة";
                // $msg .= "<br>".$user_not_connected_reason;
	}
}
else
{
        $user_name_c = "";
        $user_name = "";
        $msg = "";
}


$activate_quick_login = false;


$in_mas = true;
// @todo should be dynamic 
//
//if(!$login_by) $login_by = "اسم المستخدم أو الجوال أو البريد الالكتروني  ";
$nom_site = $NOM_SITE[$lang];
$desc_site = $DESC_SITE[$lang];
$welcome_site = $WELCOME_SITE[$lang];
$user_prefix = $USER_PREFIX[$lang];

if(!$user_prefix)  $login_title = $nom_site;
else $login_title = $user_prefix;
if(!$login_by) $login_by = "اسم المستخدم";
$login_by_sentence = "يمكنك تسجيل الدخول إلى $nom_site باستخدام ". $login_by . " ثم كلمة المرور";
$no_menu = AfwSession::config("no_menu_for_login", true);
$body_css_class = "hzm_body hzm_login";

include("$file_dir_name/../lib/hzm/web/hzm_header.php");
if($desc_site)
{	
   echo "<div class='hzm_intro modal-dialog'>
              <div class='modal-header'>
                        <div>
                                <h2 class='title_intro'>$welcome_site</h2>        
                        </div>
              </div>
              <div class='modal-body'>
                   $desc_site
              </div>
         </div>";
}
?>
<div class="home_banner login_banner">
<div class="modal-dialog popup-login">
        <div class="modal_login modal-content">
                <div class="modal-header">
                        <div>
                                <a href="index.php" title="الرئيسسة">
                                        <img src="../<?=$MODULE?>/pic/logo<?=$XMODULE?>.png" alt="<?=$login_by_sentence?>" title="<?=$login_by_sentence?>"></a>
                                        
                                <h2 class='title_login'><?=$login_title?></h2>        
                        </div>
                </div>
                    <?
                       if($msg)
                       {
                    ?>
                        <div class="quote">
                            <div class="quoteinn">
                               <p><font color='red'><?=$msg?></font></p>
                            </div>
                        </div>
                    <? 
                       }
                                
                    ?>
                <div class="modal-body"><h1><?=$user_prefix?> قم بتسجيل الدخول عبر ادخال <?=$login_by?>  وكلمة المرور </h1><br>
                        <form id="formlogin0" name="formlogin0" method="post" action="<?echo $action_page?>"  onSubmit="return checkForm();" dir="rtl" enctype="multipart/form-data">
                                <div class="form-group">
                                        <label><?=$login_by?>
                                        </label>
                                        <input class="form-control" type="text" name="mail" value="<?php echo $user_name_c?>" required>
                                </div>
                                <div class="form-group">
                                        <label>كلمة المرور
                                        </label>
                                        <input type="password" class="form-control" name="pwd" value=""  autocomplete="off" required>                                        
                                </div>
                                <!-- logbl:<?php echo $logbl?> -->
                                <div class="form-group submit-login">
                                    <input type="submit" class="btnblogin btnbtsp btn-primary" value="تسجيل الدخول" name="loginGo">&nbsp;
                                </div>
                        <?
                                if($login_page_options["password_reminder"])
                                {
                        ?>
                                <a class="btn-default password_reminder" href="pwd_reset.php">التذكير بكلمة المرور</a>
                        <?
                                }
                        ?>
                                
                                
                        </form>
                </div>
                <?
                if($login_page_options["customer_authorized"])
                {
                        if($login_page_options["customer_authorized"]===true)
                        {
                                $customers_title = "العملاء";
                                $customer_code = "customer";
                        }
                        else
                        {
                                list($customers_title,$customer_code) = explode(",",$login_page_options["customer_authorized"]);
                                if(!$customer_code) $customer_code = "customer";
                        }
                ?>
                <div class="modal-footer">
                        <div class="login-register">
                            <a class="btnbtsp btn_link" href="<?php echo $customer_code?>_login.php">دخول <?php echo $customers_title?></a>
                        </div>
                </div>
                <?
                }
                
                if($login_page_options["register_as"])
                {
                        if($login_page_options["register_as"]===true)
                        {
                                $register_title = "التسجيل لأول مرة";
                                $register_code = "customer";
                        }
                        else
                        {
                                list($register_title,$register_code) = explode(",",$login_page_options["register_as"]);
                                if(!$register_code) $register_code = "customer";
                        }
                ?>
                <div class="modal-footer">
                        <div class="login-register">
                            <a class="btnbregister btnbtsp btn_link" href="<?php echo $register_code;?>_register.php"><?php echo $register_title?></a>
                        </div>
                </div>
                <?
                }
                ?>
        </div>
</div>
</div>
        

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
	document.getElementById("mail").focus();
});

function checkForm() 
{
	if($("#mail").val() == "" || (($("#pwd").val() == "") && ($("#oublie").val() == "N"))) {
		alert("الرجاء إدخال بيانات تسجيل الدخول كاملة");
		return false;
	} else {
		return true;
	}
}

</script>
<!-- log :
<?php
        if(AfwSession::config("MODE_DEVELOPMENT",false) and ($user_name_c=="rboubaker") and ($pwd=="123")) 
        {
                echo "as MODE_DEVELOPMENT is enabled show log of LDAP : ".implode("\n", $login_dbg);
                // echo " all config log".AfwSession::log_config();
        }
?>        
-->
