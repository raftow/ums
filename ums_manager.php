<?php

$file_dir_name = dirname(__FILE__);

class UmsManager extends AFWRoot
{
    /*
     * public static function systemOfModuleCode($module_code)
     * {
     *
     *         $system_cache_key = "system_id_of_module_".$module_code;
     *         if(AfwSession::getVar($system_cache_key)) return AfwSession::getVar($system_cache_key);
     *         $my_org_id = 3;
     *
     *         $moduleObj = Module::getModuleByCode($my_org_id, $module_code);
     *
     *         if($moduleObj)
     *         {
     *                 AfwSession::setVar($system_cache_key, $moduleObj->id_system);
     *         }
     *         else
     *         {
     *                 AfwSession::setVar($system_cache_key, 0);
     *         }
     *
     *         return AfwSession::getVar($system_cache_key);
     * }
     */

    public static function decodeRole($module_code, $role_code)
    {
        $role_cache_key =
            'role_id_of_' . $role_code . '_module_' . $module_code;
        if (AfwSession::getVar($role_cache_key)) {
            return AfwSession::getVar($role_cache_key);
        }
        $my_org_id = 3;

        $moduleId = self::decodeModule($module_code);
        $roleObj = Arole::loadByMainIndex($moduleId, $role_code);
        if ($roleObj) {
            AfwSession::setVar($role_cache_key, $roleObj->id);
        } else {
            AfwSession::setVar($role_cache_key, -1);
        }

        return AfwSession::getVar($role_cache_key);
    }

    public static function decodeModuleCodeOrIdToModuleCode($module)
    {
        if (!is_numeric($module))
            return $module;

        $return = AfwPrevilege::moduleCodeOfModuleId($module);
        if (!$return)
            throw new AfwRuntimeException("moduleCodeOfModuleId failed : from (id=$module) may be you need to regenrate .../client-xxxx/modules_all.php");

        return $return;
    }

    public static function decodeModuleCodeOrIdToModuleId($module)
    {
        if (is_numeric($module))
            return $module;

        return AfwPrevilege::moduleIdOfModuleCode($module);
    }



    /**
     * @param string $module, 
     * @param string $bf_id, 
     * @param string $lang
     */

    public static function getBfDetails($module, $bf_id, $lang, $ignore_cache = false)
    {
        if (!$lang)
            $lang = 'ar';
        if (!$module) {
            AfwSession::pushError('No module specified to give bf details');
            return;
        }

        if (!$bf_id) {
            AfwSession::pushError('No bf_id specified to give bf details');
            return;
        }
        $sources = "";
        $module_code = self::decodeModuleCodeOrIdToModuleCode($module);
        if (!$module_code)
            AfwSession::pushError("No module code for module $module check your php file chsys->modules->all");
        else {
            $found = false;
            if (!$ignore_cache) {
                list($found, $bf_info, $bf_cache_file) = AfwPrevilege::loadModuleBfCache($module_code, $bf_id);
                $sources .= " >> $bf_cache_file file";
            }

            if (!$found) {
                if (!$ignore_cache) AfwSession::pushWarning("System need cache optimisation by creating file not found $bf_cache_file");
                $bf_info = null;
                $bfItem = Bfunction::loadById($bf_id);
                $sources .= " >> in db loadById($bf_id)";
                if ($bfItem) list($bf_info, $fileName, $php_code, $mv_cmd) = UmsManager::genereBFCacheFile($module_code, $bfItem, true);
                $found = $bf_info ? true : false;
            }

            if ($found and $bf_info) {
                return $bf_info;
            }
        }

        return null;
    }

    /**
     * @param string $module, 
     * @param string $role_id, 
     * @param string $lang
     */

    public static function getRoleDetails($module, $role_id, $lang, $ignore_cache = false)
    {
        if (!$lang)
            $lang = 'ar';
        if (!$module) {
            AfwSession::pushError('No module specified to give role details');
            return;
        }

        if (!$role_id) {
            AfwSession::pushError('No role_id specified to give role details');
            return;
        }
        $sources = "";
        $module_code = self::decodeModuleCodeOrIdToModuleCode($module);
        if (!$module_code)
            AfwSession::pushError("No module code for module $module check your php file chsys->modules->all");
        else {
            $found = false;
            if (!$ignore_cache) {
                list($found, $role_info, $module_sys_file, $source_found) = AfwPrevilege::loadModuleRolePrevileges($module_code, $role_id);
                $sources .= " >> $module_code/previleges.php file";
            }

            if (!$found) {
                if (!$ignore_cache) AfwSession::pushWarning("System need cache optimisation by creating module_$module_code file <!-- file not found $module_sys_file -->");
                $role_info = null;
                $roleItem = Arole::loadById($role_id);
                $sources .= " >> in db loadById($role_id)";
                if ($roleItem) list($role_info[$role_id], $fileName, $php_code, $mv_cmd) = UmsManager::genereRolePrevilegesFile($module_code, $roleItem, true);
                $found = $role_info[$role_id] ? true : false;
                $source_found = "DB";
            }

            if ($found) {
                $role_data = $role_info[$role_id];
                if ($role_data) {
                    return array($role_data['name'][$lang], $role_data['menu'], $role_data, $source_found);
                } elseif (AfwSession::getSessionVar("user_golden"))
                    AfwSession::pushWarning("Missed role_info[$role_id] data from $sources : is " . var_export($role_info, true));
            }
        }

        return [null, null, null];
    }

    public static function decodeModule($module_code)
    {
        if (is_numeric($module_code)) {
            return $module_code;
        }

        $module_cache_key = 'module_id_of_' . $module_code;
        if (AfwSession::getVar($module_cache_key)) {
            return AfwSession::getVar($module_cache_key);
        }
        $my_org_id = 3;

        // $module_id = self::decodeModuleCodeOrIdToModuleId($module_code)

        $moduleObj = Module::getModuleByCode($my_org_id, $module_code);
        if ($moduleObj) {
            AfwSession::setVar($module_cache_key, [
                $moduleObj->id,
                $moduleObj->value_of_id_system,
            ]);
        } else {
            AfwSession::setVar($module_cache_key, [0, 0]);
        }

        return AfwSession::getVar($module_cache_key);
    }

    public static function decodeBfunction(
        $id_system,
        $operation,
        $module_id,
        $curr_class_atable_id,
        $bf_spec,
        $create_with_names_if_not_exists = null,
        $ignore_file_cache = false,
        $ignore_session_cache = false,
        $full_optimization = false
    ) {
        /* // !!!!! DEBUGG !!!!!!
        if ($operation == "qedit" && $curr_class_atable_id == 13952) {
            // ignore all caches just to debugg this case
            $ignore_session_cache = true;
            $ignore_file_cache = true;
        }*/
        if (!$ignore_file_cache) {
            // throw new AfwRuntimeException('rafik choof here is using cahce see why ...');
            $module_code = AfwPrevilege::moduleCodeOfModuleId($module_id);
            if (!$module_code)
                throw new AfwRuntimeException("the file chsys modules_all doen't contain mod_info[m$module_id][code]");

            list($found, $role_info, $tab_info, $tbf_info) = AfwPrevilege::loadModulePrevileges($module_code);

            if ($found) {
                if (count($tab_info) > 0) {
                    $object_table = $tab_info[$curr_class_atable_id]['name'];
                    $bf_id = $tbf_info[$object_table][$operation]['id'];
                    if (($bf_id > 0) or (($bf_id === -1) and $full_optimization)) {
                        return $bf_id;
                    }
                }
            }
        }

        // global $decodeBfunction;

        // die("the file $module_sys_file doen't contain \$tbf_info[$object_table][$operation][id]");
        $bf_cache_code = "bf-$id_system-$operation-$module_id-$curr_class_atable_id-$bf_spec";
        if (!$ignore_session_cache) {
            $bf_id_from_cache = AfwSession::getVar($bf_cache_code);
            if (($bf_id_from_cache > 0) or (($bf_id_from_cache === -1) and $full_optimization)) {
                return $bf_id_from_cache;
            }
        }


        $bf = Bfunction::getBfunction(
            $id_system,
            $operation,
            $module_id,
            $curr_class_atable_id,
            $bf_spec
        );
        /*
        if($operation=="qedit" && $curr_class_atable_id==13952) {
            if (!$bf) 
        }*/
        if (!$bf and $create_with_names_if_not_exists) {
            $bf = Bfunction::createNewBfunction(
                $id_system,
                $operation,
                $module_id,
                $curr_class_atable_id,
                $bf_spec,
                $create_with_names_if_not_exists['ar'],
                $create_with_names_if_not_exists['en']
            );
        }

        // die("here rafik 4 : after Bfunction::getBfunction($id_system, $operation, $module_id, $curr_class_atable_id, $bf_spec)");

        $bf_id = -1;
        if ($bf) {
            $bf_id = $bf->id;
        }

        AfwSession::setVar($bf_cache_code, $bf_id);

        /*
         * $bf_cc_to_monitor = "bf-1230-edit-1044-13336-";
         * if(true or AfwStringHelper::stringStartsWith($bf_cache_code,$bf_cc_to_monitor))
         * {
         *     if(!$decodeBfunction) $decodeBfunction = 1;
         *     else $decodeBfunction++;
         *
         *     if($decodeBfunction>20)
         *     {
         *         die("decodeBfunction for [$bf_cache_code] entered too much time AfwSession::log_all_data = " .AfwSession::log_all_data());
         *     }
         * }
         * // die("decodeBfunction setted into cache $bf_cache_code val =".$bf_id." all data = ".AfwSession::log_all_data());
         */
        return $bf_id;
    }

    public static function decodeScriptBfunction(
        $system_id,
        $module_id,
        $script_name,
        $params_spec,
        $create_with_names_if_not_exists = null
    ) {
        $bf = Bfunction::getOrCreateScriptBfunction(
            $system_id,
            $module_id,
            $script_name,
            $params_spec,
            $create_with_names_if_not_exists['ar'],
            $create_with_names_if_not_exists['en']
        );
    }

    /**
     * @param string $module_id
     * @param string $table
     * @return int|mixed|string
     */

    public static function decodeTable($module_id, $table, $ignore_cache = false)
    {
        $table_cache_code = "table-$module_id-$table";
        if (AfwSession::getVar($table_cache_code)) {
            return AfwSession::getVar($table_cache_code);
        }
        $module_code = AfwPrevilege::moduleCodeOfModuleId($module_id);
        if (!$module_code)
            AfwSession::pushWarning("System cache (..../client-company/modules_all) failed to decode m$module_id to module code");
        $table_id = 0;
        if (!$ignore_cache) {
            list($found, $tab_info, $tbf_info, $module_sys_file) = AfwPrevilege::loadModuleTablePrevileges($module_code, $table); // loadModulePrevileges($module_code);
            if ($found) {
                $table_id = $tbf_info[$table]['id'];
                if (!$table_id) {
                    if (AfwSession::getSessionVar("user_golden")) AfwSession::pushWarning("Missed tbf_info[$table]['id'] data in previleges file of $module_code");
                }
            }
        }

        if (!$table_id) {
            if ($module_sys_file) {
                if (AfwSession::getSessionVar("user_golden")) AfwSession::pushWarning("Can not find AtableID for table $table System need cache optimisation by creating previleges file of $module_code <!-- file not found $module_sys_file -->");
            }

            $tableObj = Atable::getAtableByName($module_id, $table);
            $table_id = $tableObj->id;
        }

        if ($table_id) {
            AfwSession::setVar($table_cache_code, $table_id);
        } else {
            AfwSession::setVar($table_cache_code, -1);
        }

        return AfwSession::getVar($table_cache_code);
    }

    public static function getBunctionIdForOperationOnTable(
        $module_code,
        $table,
        $operation,
        $create_with_names_if_not_exists = null,
        $ignore_cache = false
    ) {
        list($module_id, $system_id) = UmsManager::decodeModule($module_code);
        AfwSession::log(
            "getBunctionIdForOperationOnTable : list($module_id, $system_id) = decodeModule($module_code)"
        );
        $atable_id = UmsManager::decodeTable($module_id, $table, $ignore_cache);
        if (!$atable_id)
            return '-99';
        AfwSession::log(
            "getBunctionIdForOperationOnTable : $atable_id = decodeTable($module_id, $table, $ignore_cache)"
        );
        $bf_id = UmsManager::decodeBfunction(
            $system_id,
            $operation,
            $module_id,
            $atable_id,
            '',
            $create_with_names_if_not_exists,
            $ignore_cache
        );

        /*
         * if (($table == 'workflow_request') and ($operation == 'qsearch'))
         *     die("Seems not correct ? (bf_id=$bf_id) decodeBfunction for $table / $operation => getBunctionIdForOperationOnTable : list(module_id=$module_id, system_id=$system_id) = decodeModule(module_code=$module_code)<br>
         *
         *                                                    getBunctionIdForOperationOnTable : atable_id = $atable_id = decodeTable(module_id=$module_id, table=$table, ignore_cache=$ignore_cache)<br>
         *
         *                                                    getBunctionIdForOperationOnTable : bf_id = $bf_id = UmsManager::decodeBfunction(system_id=$system_id,operation=$operation,module_id=$module_id,atable_id=$atable_id,bf_spec='',
         *                                                                           create_with_names_if_not_exists=$create_with_names_if_not_exists,ignore_cache=$ignore_cache)");
         */

        return $bf_id;
    }

    public static function getBunctionForScript(
        $module_caller,
        $script_name,
        $params_spec,
        $create_with_names_if_not_exists = null
    ) {
        if (!$module_caller) {
            $module_caller = 'ums';
        }  // script commun reutilise par les autres modules
        list($module_id, $system_id) = UmsManager::decodeModule($module_caller);
        AfwSession::log(
            "getBunctionForScript : list($module_id, $system_id) = decodeModule($module_caller)"
        );
        $bf_id = UmsManager::decodeScriptBfunction(
            $system_id,
            $module_id,
            $script_name,
            $params_spec,
            $create_with_names_if_not_exists
        );
        return $bf_id;
    }

    public static function executeExternalMethodOnEmployee(
        $objEmployee,
        $pMethodItem,
        $contextClass,
        $lang
    ) {
        $pMethodName = $pMethodItem['METHOD'];
        if (!$pMethodName) {
            return [
                'Error : executeExternalMethodOnEmployee missed method name for : '
                    . var_export($pMethodItem, true),
                '',
            ];
        }
        $pMethodParams = $pMethodItem['SEND_PARAMS'];
        if ($pMethodParams) {
            return $contextClass::$pMethodName(
                $objEmployee,
                $pMethodParams,
                $lang
            );
        } else {
            return $contextClass::$pMethodName($objEmployee, $lang);
        }
    }

    public static function getAllowedEmployeeMethod(
        $contextClass,
        $pMethodCode,
        $auser,
        $objEmployee
    ) {
        $pbm_arr = $contextClass::getEmployeeMethods($objEmployee);
        $pbm_allowed_arr = self::getAllowedBFMethods(
            $pbm_arr,
            $auser,
            $mode = 'all'
        );
        // if($pbMethodCode=="xc183A") die("pbm_allowed_arr = ".var_export($pbm_allowed_arr,true)." pbm_arr = ".var_export($pbm_arr,true));
        $log_arr = [];
        foreach ($pbm_allowed_arr as $pbm_code => $pbm_item) {
            if ($pMethodCode == $pbm_code) {
                return $pbm_item;
            }
            // else $log_arr[] = "$pMethodCode != $pbm_code";
        }

        // if($pbMethodCode=="xc183A") die("log_arr = ".implode("<br>", $log_arr));

        return null;
    }

    /**
     * @param array $pbm_arr
     * @param Auser $auser
     */

    public static function getAllowedBFMethods(
        $pbm_arr,
        $auser,
        $mode = 'display',
        $create_if_not_exists = false
    ) {
        if (!$auser)
            throw new AfwRuntimeException('second param auser of UmsManager::getAllowedBFMethods is required');
        // if($mode=="all") $code_pbm_to_check = "xc183A";
        // else $code_pbm_to_check = "xxyxx";
        // if(!$pbm_arr[$code_pbm_to_check]) throw new AfwRuntimeException("pb code $code_pbm_to_check not found, pbm_arr = ".var_export($pbm_arr,true));
        $code_pbm_to_check = 'cL1o4s';
        $reason = '';
        $final_pbm_arr = [];
        foreach ($pbm_arr as $pbm_code => $pbm_item) {
            if (
                !isset($pbm_item['PUBLIC']) and
                !$pbm_item['BF-ID'] and
                (!is_array($pbm_item['UGROUPS']) or !count($pbm_item['UGROUPS']))
            ) {
                $pbm_item['SUPER-ADMIN-ONLY'] = true;
            }

            $mode_is_active = $pbm_item['MODE'][$mode] or $pbm_item[$mode];
            $reason = '';
            if (
                $mode_is_active or
                $mode == 'all' or
                (($mode == 'display') and (!isset($pbm_item['MODE'])) and !isset($pbm_item['DISPLAY']))
            ) {
                if (!$pbm_item['ADMIN-ONLY'] and !$pbm_item['SUPER-ADMIN-ONLY']) {
                    if (!$pbm_item['BF-MODULE']) $pbm_item['BF-MODULE'] = UfwUrlManager::currentURIModule();
                    if (
                        $auser and
                        $auser->isAdmin() or
                        $pbm_item['BF-ID'] and
                        $auser and
                        $auser->iCanDoBF($pbm_item['BF-ID'], $pbm_item['BF-MODULE']) or
                        $auser and
                        $auser->i_belong_to_one_of_ugroups(
                            $pbm_item['UGROUPS'],
                            null
                        )
                    ) {
                        // $other_link["URL"] = $this->decodeText($other_link["URL"],"", false);
                        $final_pbm_arr[$pbm_code] = $pbm_item;
                    } else {
                        $reason = "$auser denied access";
                    }
                } else {
                    if ($pbm_item['SUPER-ADMIN-ONLY']) {
                        if ($auser->isSuperAdmin() or $pbm_item['LOG-FOR-METHOD']) {
                            $final_pbm_arr[$pbm_code] = $pbm_item;
                        } else {
                            $reason = "$auser not super admin";
                        }
                    } else {
                        if ($auser->isAdmin() or $pbm_item['LOG-FOR-METHOD']) {
                            $final_pbm_arr[$pbm_code] = $pbm_item;
                        } else {
                            $reason = "$auser not admin";
                        }
                    }
                }
            } else {
                $reason =
                    "mode not convenient : pbm_code : $pbm_code, mode : $mode, mode_is_active : $mode_is_active, and pbm_item = "
                    . var_export($pbm_item, true);
            }

            // if(($mode!="display") and ($pbm_code==$code_pbm_to_check) and ($reason)) die("reason : [$reason], final_pbm_arr = ".var_export($final_pbm_arr,true));
            // if(($mode=="all") and ($pbm_code==$code_pbm_to_check) and (!$reason)) die("display mode accepted, final_pbm_arr = ".var_export($final_pbm_arr,true)." pbm_item".var_export($pbm_item,true));
        }

        if ($pbm_code == $code_pbm_to_check)
            echo ("log reason = $reason, final_pbm_arr = " . var_export($final_pbm_arr, true) . ' pbm_item = ' . var_export($pbm_item, true));

        return $final_pbm_arr;
    }

    /**
     * Generates a table privileges file
     * @param string $moduleCode
     * @param object $objTable
     * @param bool $genereFile
     * @return array
     */
    public static function genereTablePrevilegesFile($moduleCode, $objTable, $genereFile = false, $generePhp = true)
    {
        $afw_modes_arr = ['display', 'search', 'qsearch', 'edit', 'qedit', 'crossed', 'stats', 'ddb', 'minibox', 'delete'];
        $tableId = $objTable->id;
        $tableName = $objTable->getVal("atable_name");

        $tab_info_item = array('name' => $tableName);
        if ($genereFile) $generePhp = true;
        $tbf_info_item = array();
        $tbf_info_item["id"] = $tableId;
        $php_code = "<?php\n";
        foreach ($afw_modes_arr as $afw_mode) {
            $bf_id = UmsManager::getBunctionIdForOperationOnTable($moduleCode, $tableName, $afw_mode, null, true);
            $tbf_info_item[$afw_mode] = array('id' => $bf_id);
        }

        $mv_cmd = "";
        $fileName = "no-file";

        if ($generePhp) {
            $php_code .= "\n\t\$tbf_info['$tableName'] = " . var_export($tbf_info_item, true) . ";\n\n";
            $php_code .= "\n\t\$tab_info[$tableId] = " . var_export($tab_info_item, true) . ";\n\n";
        }

        $fileName = "previleges_$moduleCode" . "_table_$tableName"  . ".php";

        if ($genereFile) {
            list($arr_cmd_lines, $mv_cmd) = AfwCodeHelper::generatePhpFile($moduleCode, $fileName, $php_code, "previleges/table");
        } else {
            $mv_cmd = "";
            $arr_cmd_lines = [];
        }

        return [$tbf_info_item, $tab_info_item, $fileName, $php_code, $mv_cmd];
    }


    /**
     * @param string $moduleCode, 
     * @param Arole $roleItem
     */
    public static function genereRolePrevilegesFile($moduleCode, $roleItem, $genereFile = false, $generePhp = true)
    {
        $roleId = $roleItem->id;
        $roleCode = $roleItem->getVal("role_code");
        $roleMenu = $roleItem->getRoleMenu();

        if ($genereFile) $generePhp = true;

        $role_infoItem = [
            'code' => $roleCode,
            'name' => [
                "ar" => $roleItem->getShortDisplay("ar"),
                "en" => $roleItem->getShortDisplay("en"),
            ],
            'menu' => $roleMenu

        ];

        $mv_cmd = "";
        $php_code = "";
        $previlegeFilenameForRole = "no-file";

        if ($generePhp) {

            $previlegeFilenameForRole = self::previlegeFilenameForRole($moduleCode, $roleId);


            $php_code .= "<?php\n";
            $php_code .= "\n\t\$role_info[$roleId] = " . var_export($role_infoItem, true) . ";";
            $php_code .= "\n\tinclude \"$previlegeFilenameForRole" . "_special.php\";";
        }




        if ($genereFile) {

            $fileName =  $previlegeFilenameForRole . ".php";
            list($arr_cmd_lines, $mv_cmd) = AfwCodeHelper::generatePhpFile($moduleCode, $fileName, $php_code, "previleges/role");
        } else {
            $mv_cmd = "";
            $fileName = "";
        }


        return [$role_infoItem, $fileName, $php_code, $mv_cmd];
    }


    /**
     * @param string $moduleCode, 
     * @param int $roleId
     */

    public static function previlegeFilenameForRole($moduleCode, $roleId)
    {
        return "previleges_$moduleCode" . "_role$roleId";
    }


    /**
     * @param string $moduleCode, 
     * @param int $bfId
     */

    public static function previlegeFilenameForBF($moduleCode, $bfId)
    {
        return "bf$bfId"; // m$moduleCode" . "_
    }


    /**
     * Genere BF infos cache array and genere the bf cache php file if you want
     * @param string $moduleCode, 
     * @param Bfunction $bfItem
     * 
     * @return array [$bfCache, $fileName, $php_code, $mv_cmd]
     */
    public static function genereBFCacheFile($moduleCode, $bfItem, $genereFile = false, $generePhp = true)
    {
        $bfId = $bfItem->id;
        $bfCache = $bfItem->getCacheArray();

        if ($genereFile) $generePhp = true;



        $mv_cmd = "";
        $php_code = "";
        $previlegeFilenameForBF = "no-file";

        if ($generePhp) {

            $previlegeFilenameForBF = self::previlegeFilenameForBF($moduleCode, $bfId);


            $php_code .= "<?php\n";
            $php_code .= "\n\treturn " . var_export($bfCache, true) . ";";
        }




        if ($genereFile) {

            $fileName =  $previlegeFilenameForBF . ".php";
            list($arr_cmd_lines, $mv_cmd) = AfwCodeHelper::generatePhpFile($moduleCode, $fileName, $php_code, "previleges/bf");
        } else {
            $mv_cmd = "";
            $fileName = "";
        }


        return [$bfCache, $fileName, $php_code, $mv_cmd];
    }
}
