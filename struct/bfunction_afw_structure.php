<?php 
        class UmsBfunctionAfwStructure
        {
                public static $DB_STRUCTURE = array(

                        
			'id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'PK',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_system' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'SHORTNAME' => 'system',  'SIZE' => 40,  'DEFAUT' => 0,  
				'WHERE' => "id_module_type in (4,7)", 
				 'QEDIT' => false,  'MANDATORY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'bfunction_type_id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'MANDATORY' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'bfunction_type',  'ANSMODULE' => 'ums',  'SEARCH-BY-ONE' => true,  'SIZE' => 40,  'DEFAUT' => 1,  'SHORTNAME' => 'type',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'curr_class_module_id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'SIZE' => 64,  'DEFAUT' => 0,  
				'WHERE' => "id_module_type=5", 
				 'QEDIT' => true,  'SEARCH-BY-ONE' => true,  'MANDATORY' => true,  
				'DEPENDENT_OFME' => array (
  0 => 'curr_class_atable_id',
),  
				'RELATION' => 'OneToMany',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'curr_class_atable_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 64,  
				'TYPE' => 'FK',  'ANSWER' => 'atable',  'ANSMODULE' => 'pag',  'DEFAUT' => 0,  'AUTOCOMPLETE' => true,  'SEARCH-BY-ONE' => true,  'SHORTNAME' => 'table',  
				'WHERE' => "(('§id§'='' or '§id§'='0') or 
                                                          id_module in (§curr_class_module_id§) or
                                                          id_module in (select mu.id_module from c0ums.module_auser mu where mu.id_auser = '§ME§' and mu.avail='Y') or 
                                                          id_module in (select id from c0ums.module where id_system = '§CONTEXT_ID§' and id_module_type=5) )", 
				 'DEPENDENCY' => 'curr_class_module_id',  
				'RELATION' => 'OneToMany',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'bfunction_code' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 32,  'QSEARCH' => true,  'SEARCH' => true,  'MANDATORY' => true,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'parent_bfunction_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false, 
				 'EDIT' => true,  'QEDIT' => false,  'SIZE' => 40,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  
				 'EDIT-ADMIN' => true,  'UTF8' => false,  'AUTOCOMPLETE'=>true,
				'TYPE' => 'FK',  'ANSWER' => 'bfunction',  'ANSMODULE' => 'ums',  'DEFAUT' => 0,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'rbfList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'arole_bf',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'bfunction_id',  
				'WHERE' => "avail='Y'", 
				 'SHOW' => false,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'childList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'bfunction',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'parent_bfunction_id',  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_short' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE-AR' => true,  'EDIT' => true,  'UTF8' => true,  'SIZE' => 40,  'SHORTNAME' => 'title',  
				'TYPE' => 'TEXT',  'QEDIT' => true,  'QSEARCH' => true,  'SEARCH' => true,  'MANDATORY' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'titre_short_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE-EN' => true,  'EDIT' => true,  'UTF8' => false,  'SIZE' => 40,  'SHORTNAME' => 'title_en',  
				'TYPE' => 'TEXT',  'QEDIT' => true,  'QSEARCH' => true,  'SEARCH' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'UTF8' => true,  'SIZE' => 255,  
				'TYPE' => 'TEXT',  'QEDIT' => false,  'QSEARCH' => true,  'SEARCH' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_en' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'UTF8' => false,  'SIZE' => 255,  
				'TYPE' => 'TEXT',  'QEDIT' => false,  'QSEARCH' => true,  'SEARCH' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'file_specification' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 92,  'QSEARCH' => true,  'SEARCH' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'direct_access' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'bf_specification' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 32,  'QSEARCH' => true,  'SEARCH' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'is_special' => array(
				'TYPE' => 'YN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'SEARCH' => false,  
				'CATEGORY' => 'FORMULA',  'SHORTNAME' => 'special',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'call_specification' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'TYPE' => 'TEXT',  'SIZE' => 32,  'QSEARCH' => true,  'SEARCH' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'module_mfk' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'MFK',  'QEDIT' => false,  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'HZM-WIDTH' => 4,  
				'WHERE' => "id_module_type=6 and (id_module_parent=§id_system§ or §id_system§=0)", 
				 'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'arole_mfk' => array(
				'TYPE' => 'MFK',  'RETRIEVE' => true,  'EDIT' => true,  'READONLY' => true,  'SHOW' => true,  'SEARCH' => false,  'FORMAT' => 'retrieve',  
				'CATEGORY' => 'FORMULA',  'ANSWER' => 'arole',  'ANSMODULE' => 'ums',  'HZM-WIDTH' => 4,  'FORMULA_USE_CACHE' => true,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'userStoryList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'user_story',  'ANSMODULE' => 'bau',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'bfunction_id',  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'NO-LABEL' => true,  'FGROUP' => 'userStoryList',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'tobinus' => array(
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'SIZE' => 32,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'FGROUP' => 'userStoryList',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'tobinus_reason' => array(
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'SIZE' => 132,  
				'TYPE' => 'TEXT',  'DEFAUT' => 'N',  'PRE' => true,  'TEXT-ALIGN' => 'left',  'FGROUP' => 'userStoryList',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'public' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  'UTF8' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'N',  'STEP' => 4,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'bf_complexity' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'FLOAT',  'STEP' => 4,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'bf_priority' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'INT',  'STEP' => 4,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'mainGoal' => array('SHOW' => true,  'SIZE' => 40,  
				'TYPE' => 'FK',  'ANSWER' => 'goal',  'ANSMODULE' => 'bau',  'NO-ERROR-CHECK' => true,  
				'CATEGORY' => 'FORMULA',  'DEFAUT' => 0,  'STEP' => 4,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'avail' => array('IMPORTANT' => 'IN',  'SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  'DEFAUT' => 'Y',  'EDIT-ADMIN' => true,  
				'TYPE' => 'YN',  'SEARCH-BY-ONE' => '',  'DISPLAY' => '',  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

                        'id_aut'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'date_aut'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        'id_mod'           => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'date_mod'              => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'TECH_FIELDS-RETRIEVE' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        'id_valid'       => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'date_valid'          => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                'TYPE' => 'GDAT', 'FGROUP' => 'tech_fields'),

                        /* 'avail'                   => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
//                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),*/

                        'version'                  => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),

                        // 'draft'                         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
//                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),

                        'update_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'delete_groups_mfk'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'display_groups_mfk'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 
                                                                'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),

                        'sci_id'                        => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 
                                                                'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'pag', 'FGROUP' => 'tech_fields'),

                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 
                                                                'TOKEN_SEP'=>"§", 'READONLY'=>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
                ); 
        } 
?>