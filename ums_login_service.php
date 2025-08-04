<?php

// old require of afw_root 

class UmsLoginService extends AFWRoot
{
        public static function umsAuthentication($user_or_email, $password, $user_or_email_lower_case = true, $hardSecureCleanString = true)
        {
                $authenticationData = [];
                if ($user_or_email_lower_case) $user_or_email = strtolower($user_or_email);
                if ($hardSecureCleanString) $email_initial = AfwStringHelper::hardSecureCleanString($user_or_email);
                list($user_name_c, $user_domain_c) = explode("@", $user_or_email);


                if ($user_domain_c) {
                        if (!AfwLoginUtilities::isInternalDomain($user_domain_c)) {
                                $user_name_c  = $email_initial;
                                $this_user_is_internal = false;
                        } else {
                                $this_user_is_internal = true;
                        }
                } else {
                        $all_users_are_internal = AfwSession::config("all_users_are_internal", false);
                        if (!$all_users_are_internal) $this_user_is_internal = Auser::isInternal($user_name_c);
                        else $this_user_is_internal = true;
                }

                // die("rafik 1 : $user_name_c, $password");
                // 1. try Active directory first (if enabled)
                list($user_connected, $user_not_connected_reason, $info, $login_dbg[]) = AfwLoginUtilities::ldap_login($user_name_c, $password);
                // die()
                // 2. try database or golden login after
                if (!$user_connected) {
                        //die("rafik 2 reason=$user_not_connected_reason, info=$info login_dbg=".var_export($login_dbg,true));
                        $login_dbg[] = "try to db_or_golden_login";
                        list($user_connected, $user_not_connected_reason, $user_infos, $login_dbg[]) = AfwLoginUtilities::db_or_golden_login($user_name_c, $password);
                        $user_found = $user_connected;
                        // die("rafik 3 user_connected=$user_connected reason=$user_not_connected_reason, info=$user_infos login_dbg=".var_export($login_dbg,true));

                } else {
                        $user_name_ldap =  $info["samaccountname"][0];
                        if ($user_name_ldap) {
                                $login_dbg[] = "try to db_retrieve_user_info with ldap user name : $user_name_ldap";
                                list($user_found, $user_not_found_reason, $user_infos, $login_dbg[]) = AfwLoginUtilities::db_retrieve_user_info($user_name_ldap);
                                if (!$user_found) {
                                        $email =  $info["mail"][0];
                                        list($firstname, $fathername, $lastname) = explode(" ", $info["displayname"][0]);
                                        $login_dbg[] = "Auser::findOrCreateUser($user_name_ldap, $email, $firstname, $fathername, $lastname)";
                                        $usr = Auser::findOrCreateUser($user_name_ldap, $email, $firstname, $fathername, $lastname);

                                        list($user_connected, $user_not_connected_reason, $user_infos, $login_dbg[]) = AfwLoginUtilities::db_retrieve_user_info($user_name_ldap);
                                } else {
                                        $login_dbg[] = "user $user_name_ldap found :" . var_export($user_infos, true);
                                }
                        } else {
                                $user_connected = false;
                                $user_found = false;
                                $user_not_connected_reason = $user_not_found_reason = AfwLanguageHelper::tt("result of LDAP query doesn't contain the username");
                                //$
                                $login_dbg[] = $user_not_connected_reason;
                        }
                }

                if ($user_found and $user_infos) {
                        $username = $user_infos["username"];
                        $mobile = $user_infos["mobile"];
                        $email = $user_infos["email"];
                }

                $html_debugg_login = AfwSession::config("html_debugg_login", true);
                $debugg_login = AfwSession::config("debugg_login", true);
                $debugg_throw_exception = AfwSession::config("debugg_throw_exception", "");
                $debugg_after_login = AfwSession::config("debugg_after_login", true);
                $debugg_after_ldap = AfwSession::config("debugg_after_ldap", true);
                $debugg_after_golden_or_db = AfwSession::config("debugg_after_golden_or_db", true);
                $debugg_after_session_created = AfwSession::config("debugg_after_session_created", true);
                $debugg_login_in_file = AfwSession::config("debugg_login_in_file", false);
                $x_module_means_company = AfwSession::config("x_module_means_company", false);
                $required_modules = AfwSession::config("required_modules", []);
                // die("dbg x_module_means_company=$x_module_means_company ".AfwSession::log_config());
                $uri_module = AfwUrlManager::currentURIModule();
                $main_module = AfwSession::config("main_module", "");

                if ($debugg_login and (!$user_connected) and ($debugg_login == $username)) {
                        $login_dbg[] = "login failed, user infos = " . var_export($user_infos, true);
                        if ($html_debugg_login) {
                        } elseif ($debugg_after_golden_or_db) {
                                throw new AfwRuntimeException("ERROR : SQL/GOLDEN LOGIN FAILED :<br>\n" . implode("<br>\n", $login_dbg));
                        }
                }

                // 
                if ($user_connected) {        // load infos from HR
                        $emp_num = "00";
                        $hasseb_num = AfwStringHelper::left_complete_len($emp_num, 7, "0");

                        if ($username) {
                                $check_employee_from_external_system = AfwSession::config("check_employee_from_external_system", false);
                                if ($check_employee_from_external_system and ($all_users_are_internal or $this_user_is_internal)) {
                                        if ($debugg_login) {
                                                AFWDebugg::log("loading And Update Employee Object From External HR System : starting ...");
                                        }


                                        list($employee, $log_ehr) = Employee::loadAndUpdateFromExternalHRSystem($username, $hasseb_num);

                                        if ($email and (!$employee)) {
                                                $employee = Employee::loadByEmail(1, $email);
                                        }

                                        if ($debugg_login and false) {
                                                echo ("returned : " . $log_ehr);
                                                echo ("employee = " . var_export($employee, true));
                                                echo ("load And Update Employee Object From External HR System : end.");
                                                die("php-rafik arrived to Employee::loadAndUpdateFromExternalHRSystem");
                                        }

                                        if ($employee and (!$employee->error) and ($employee->getId() > 0)) {
                                                if (!$employee->is_new) {
                                                        // rafik 26 april 2021,
                                                        // the condition above because if the employee is new no 
                                                        // need to do updateMyUserInformation 
                                                        // because already done in employee::beforeMaj
                                                        //

                                                        if ($debugg_login) {
                                                                AFWDebugg::log("update My User Information : starting ...");
                                                        }
                                                        $employee->updateMyUserInformation();
                                                        if ($debugg_login) {
                                                                AFWDebugg::log("update My User Information : end.");
                                                        }
                                                }
                                        } else {
                                                if ($employee instanceof  AFWObject) {
                                                        if ($employee->error) $login_dbg[] = " employee error : " . $employee->error;
                                                        if (!$employee->getId()) $login_dbg[] = " employee empty !!!";

                                                        if ($debugg_login) {
                                                                AFWDebugg::log("<b>!!!!!!!!!!!!!!! USER LOGGED OUT because UKNKOWN IN HR SYSTEM --------------- </b>\n");
                                                                if ($employee and $employee->error and $debugg_throw_exception) {
                                                                        throw new AfwRuntimeException("Employee::loadAndUpdateFromExternalHRSystem Error : " . $employee->error . "\n");
                                                                }
                                                        }
                                                }
                                                $user_not_connected_reason = "Employee::loadAndUpdateFromExternalHRSystem($username, $hasseb_num) failed : 
                                                                                  employee : " . var_export($employee, true);
                                                $login_dbg[] = $user_not_connected_reason;
                                                $user_connected = false;
                                        }
                                } else {
                                        $employee_org_id = 0;
                                        if ($email) {
                                                if ($x_module_means_company and ($main_module != $uri_module) and (!in_array($uri_module, $required_modules))) {

                                                        // die("trying to find company with hrm code - $uri_module");
                                                        $employeeOrg = Orgunit::loadByHRMCode($uri_module);
                                                        if ($employeeOrg) $employeeOrgId = $employeeOrg->getId();
                                                        else throw new AfwRuntimeException("unable to find company with hrm code [$uri_module] 
                                                                                        or it is not allowed to access the system");
                                                        $employee_org_id = $employeeOrgId;
                                                        // @todo disable temp : if((!$employee) or ($employee_org_id != $employeeOrgId)) $user_connected = false;
                                                }
                                                //die("email=$email");
                                                $employee = Employee::loadByEmail($employee_org_id, $email);
                                                // die("Employee::loadByEmail($employee_org_id, $email) => ".var_export($employee,true));
                                                // $employee = null;
                                                if ($employee) $employee_org_id = $employee->getVal("id_sh_org");
                                        }
                                }

                                if ($user_connected) {
                                        $server_db_prefix = AfwSession::currentDBPrefix();
                                        //die("rafik 5 : user is connected");
                                        $user_infos = AfwDatabase::db_recup_row("select id, avail, firstname, email 
                                                            from $server_db_prefix" . "ums.auser 
                                                            where avail = 'Y' and username='$username' limit 1");
                                        //die("rafik 6 : user_infos is ".var_export($user_infos,true));        
                                        $after_login_dbg = "<b>------------------------------- AFTER LOGIN USER INFOS for $username ---------------------------</b>\n";
                                        $after_login_dbg .= var_export($user_infos, true);

                                        if ($debugg_after_login) {
                                                if ($debugg_login) {
                                                        AFWDebugg::log($after_login_dbg);
                                                }
                                        }
                                }
                        } else {
                                if ($debugg_login and $debugg_throw_exception) {
                                        throw new AfwRuntimeException("ERROR : <b>!!!!!!!!!!!!!!! USER NAME EMPTY AND CONNECTED : 
                                                                   SHOULD BE IMPOSSIBLE logged out--------------- </b>\n" . implode("<br>\n", $login_dbg));
                                }
                                $user_connected = false;
                                $user_not_connected_reason = "user name not defined";
                        }

                        //die("s=$time_s  e=$time_e ");
                        if ($user_connected) {
                                $last_page = AfwSession::getSessionVar("lastpage");
                                $lastget = AfwSession::getSessionVar("lastget");
                                if (is_array($lastget) and count($lastget) > 0) {
                                        $last_page .= "?redir=1";
                                        foreach ($lastget as $param => $paramval) $last_page .= "&$param=$paramval";
                                }

                                //effacer les var d'une eventuelle session précédente
                                AfwSession::resetSession();

                                foreach ($user_infos as $col => $val) {
                                        AfwSession::setSessionVar("user_$col", $val);
                                }
                                //die("rafik 7 : last_page=[$last_page]");
                                // $objme = AfwSession::getUserConnected();
                                // die("rafik 8 : user_id=".AfwSession::getSessionVar("user_id")." objme=".var_export($objme,true));
                                if (($last_page) and ($last_page != "login.php")) {
                                        header("Location: " . $last_page);
                                } else {
                                        //$objme = AfwSession::getUserConnected();
                                        //die("rafik 9 : login success : user_id=".AfwSession::getSessionVar("user_id")." objme=".var_export($objme,true));
                                        header("Location: index.php");
                                }
                                exit();
                        } else {
                                if ($debugg_login) {
                                        AFWDebugg::log("!!!!!!!   login failed  !!!!!!!!");
                                        if ($debugg_throw_exception and ($debugg_login == $username)) die("!!!!!!!   login failed  !!!!!!!! </b>\n" . implode("<br>\n", $login_dbg));
                                }
                        }
                }

                if (!$user_connected) {
                        $msg = "يوجد خطأ في كلمة المرور أو اسم المستخدم. الرجاء التأكد من البيانات المدخلة";
                        if ($user_not_connected_reason) $msg .= "<!-- " . $user_not_connected_reason." -->";
                        $authenticationData["message"] = $msg;
                }

                return $authenticationData;
        }        
}
