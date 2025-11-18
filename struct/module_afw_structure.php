<?php 
        class UmsModuleAfwStructure
        {
			public static function initInstance($obj)
			{
				if($obj instanceof Module)
				{
					$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
					// $obj->IS_LOOKUP = true;
					$obj->editByStep = true;
					$obj->editNbSteps = 13;
					$obj->hzm_vtab_body_height = "100%";
					$obj->hirerachyField = "id_module_parent";
					$obj->showRetrieveErrors = true;
					$obj->styleStep[7] = array("width"=>"80%");
					$obj->styleStep[11] = array("width"=>"88%");
					$obj->styleStep[12] = array("width"=>"88%");
					$obj->UNIQUE_KEY = array('module_code');
					$obj->DISPLAY_FIELD = "titre_short";
				}
				
			}
            
			public static $DB_STRUCTURE = array(

                        
			'id' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => false,  
				'TYPE' => 'PK',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_main_sh' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  'SIZE' => 124,  'QEDIT' => false,  'SHORTNAME' => 'mainsh',  'AUTOCOMPLETE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_short' => array('SHOW' => true,  'SEARCH' => true,  'RETRIEVE-AR' => true,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'SIZE' => 48,  'SHORTNAME' => 'title',  'QEDIT' => true,  'EXCEL' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre' => array('SHOW' => true,  'SEARCH' => true,  'RETRIEVE-AR' => false,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'UTF8' => true,  'QEDIT' => false,  'SIZE' => 64,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_short_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-EN' => true,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 48,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  
				'TYPE' => 'TEXT',  'EXCEL' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_en' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE-EN' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 64,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'TEXT',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'nomcomplet' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'UTF8' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'id_module_type' => array('SHOW' => true,  'SEARCH' => true,  'QSEARCH' => true,  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module_type',  'ANSMODULE' => 'ums',  'SHORTNAME' => 'type',  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50',
				),

		'id_module_status' => array('SHOW' => true,  'SEARCH' => true,  'QSEARCH' => true,  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module_status',  'ANSMODULE' => 'ums',  'DEFAUT' => 1,  'SHORTNAME' => 'status',  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50', 
				),

		'assrole' => array(
				'TYPE' => 'FK',  'ANSWER' => 'arole',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'UTF8' => true,  'EXCEL' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_system' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'SHORTNAME' => 'sys',  
				'WHERE' => "id_module_type in (4,7)", 
				 'SEARCH-BY-ONE' => true,  
				'DEPENDENT_OFME' => array (
  0 => 'id_module_parent',
),  'STEP' => 2,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_module_parent' => array('SHOW' => true,  'RETRIEVE' => false,  'QSEARCH' => false,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'SHORTNAME' => 'parent',  
				'RELATION' => 'OneToMany',  
				'WHERE' => "(id_system=§id_system§) and ((§id_module_type§=5 and id_module_type in (4,7)) or (§id_module_type§=7 and id_module_type=4) or (§id_module_type§=6 and id_module_type in (5,6)))", 
				 
				'WHERE-SEARCH' => "(id_system=§id_system§)", 
				 'SEARCH-BY-ONE' => true,  'STEP' => 2,  'DEPENDENCY' => 'id_system',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_pm' => array('SHOW' => true,  'SHORTNAME' => 'domain',  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'ENUM', 'ANSWER' => 'FUNCTION', 'FUNCTION_COL_NAME' => 'domain_enum',
				'WHERE' => "", 
				 'QEDIT' => true,  
				'RELATION' => 'OneToMany',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'module_code' => array('SHOW' => true,  'SEARCH' => true,  'QSEARCH' => true,  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'SIZE' => 10,  'QEDIT' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'goal' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'UTF8' => true,  
				'SIZE' => 'AREA',  'QEDIT' => false,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'web' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'TEXT',  
				'SIZE' => 'AREA',  'ROWS' => 9,  'QEDIT' => false,  'STEP' => 2,  'DIR' => 'ltr',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'dbengine_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'INT',  'DEFAUT' => 1,  'SHORTNAME' => 'engine',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'dbsystem_id' => array('IMPORTANT' => 'IN',  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 32,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'INT', 'DEFAUT' => 1,  'SHORTNAME' => 'system',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'php_ini' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'PRE' => true,  'SHORTNAME' => 'php',  'SIZE' => 128,  'INPUT_WIDE' => true,  
				'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'php_module' => array('STEP' => 3,  
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true, 'MINIBOX' => true,  'READONLY' => true,  'CAN-BE-SETTED' => false,  'SIZE' => 255,  'INPUT_WIDE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),				

		'php_modules_all' => array('STEP' => 3,  
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true, 'MINIBOX' => true,  'READONLY' => true,  'CAN-BE-SETTED' => false,  'SIZE' => 255,  'INPUT_WIDE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),				


		'tablecount' => array(
				'TYPE' => 'INT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => true,  'UTF8' => true,  'EXCEL' => false,  
				'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'bfcount' => array(
				'TYPE' => 'INT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'UTF8' => true,  'EXCEL' => false,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'ptaskcount' => array(
				'TYPE' => 'INT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'UTF8' => true,  'EXCEL' => false,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'allModules' => array(
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'id_system',  'SEARCH-BY-ONE' => '',  'DISPLAY' => '',  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'orgs' => array(
				'TYPE' => 'FK',  'ANSWER' => 'module_orgunit',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'id_module',  
				'WHERE' => "", 
				 'NO-LABEL' => true,  'FGROUP' => 'shs',  'SHORTNAME' => 'shs',  'SHOW' => true,  'ROLES' => '',  'FORMAT' => 'retrieve',  'EDIT' => false,  'STEP' => 4,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'orgUnitList' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'STEP' => 4,  'FGROUP' => 'shs',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'applications' => array(
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'id_module_parent',  
				'WHERE' => "id_module_type = 5", 
				 'SHORTNAME' => 'app',  'PILLAR' => false,  'SHOW' => true,  'ROLES' => '',  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => true,  'FGROUP' => 'applications',  'STEP' => 5,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'smd' => array(
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'id_module_parent',  
				'WHERE' => "id_module_type = 6", 
				 'NO-LABEL' => true,  'POLE' => false,  'FGROUP' => 'smd',  'HELP' => 'يتم التقسيم إلى وحدات فرعية باعتبار أهداف النظام ومراعاة للنواحي العملية ومنها تجميع مع بعض الجداول التي يمكن لوظيفة من وظائف مستخدمي  النظام الاطلاع على بياناتها ',  'SHOW' => true,  'ROLES' => '',  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'STEP' => 6,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'allRoles' => array(
				'TYPE' => 'FK',  'ANSWER' => 'arole',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'module_id',  
				'WHERE' => "arole_type_id = 10", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  // was before tree but tree use IFrames not secure
				 //'LINK_COL' => 'parent_arole_id',  'ITEMS_COL' => 'childList',  'FEUILLE_COL' => 'rbfList',  'FEUILLE_COND_METHOD' => '_isMenu',   'IFRAME_BELOW' => true,  
				 'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true, 
				 'FGROUP' => 'aroles',  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

				'allRolesAndSubRoles' => array(
					'TYPE' => 'FK',  'ANSWER' => 'arole',  'ANSMODULE' => 'ums',  
					'CATEGORY' => 'ITEMS',  'ITEM' => 'module_id',  
					'SHOW' => true,  'FORMAT' => 'retrieve',  // was before tree but tree use IFrames not secure
					//'LINK_COL' => 'parent_arole_id',  'ITEMS_COL' => 'childList',  'FEUILLE_COL' => 'rbfList',  'FEUILLE_COND_METHOD' => '_isMenu',   'IFRAME_BELOW' => true,  
					'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true, 
					'FGROUP' => 'aroles',  'STEP' => 777,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
					'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
					),

		'rolesIcons' =>	array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'UTF8' => false,  
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 7,  'READONLY' => true, 'FORMAT' => 'html',
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50', 
				),		

		'allLevels' => array(
				'TYPE' => 'FK',  'ANSWER' => 'ugroup',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'module_id',  
				'WHERE' => "ugroup_type_id = 1 and ugroup_scope_id = 1", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  // was before tree but tree use IFrames not secure
				 //'LINK_COL' => 'parent_arole_id',  'ITEMS_COL' => 'childList',  'FEUILLE_COL' => 'rbfList',  'FEUILLE_COND_METHOD' => '_isMenu',   'IFRAME_BELOW' => true,  
				 'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true, 
				 'FGROUP' => 'aroles',  'STEP' => 7,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),
/*
		@todo rafik, this below if used please move to p a g mdoule not in ums because should be independant of p a g module*/
		'tbs' => array(
				'TYPE' => 'FK',  'ANSWER' => 'atable',  'ANSMODULE' => 'p'.'ag',  
				'CATEGORY' => 'ITEMS',  'ITEM' => '',  'SHORTNAME' => 'tables',  
				'WHERE' => "(id_sub_module = '§id§' or id_module = '§id§' ) and is_lookup='N'", 
				 'SHOW' => true,  'ROLES' => '',  'FORMAT' => 'retrieve',  'EDIT' => false,  'FGROUP' => 'tbs',  
				'DO-NOT-RETRIEVE-COLS' => array (0 => 'id_module',
),  'NO-LABEL' => true,  'BUTTONS' => true,  'PILLAR' => false,  'STEP' => 8,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'lkps' => array(
				'TYPE' => 'FK',  'ANSWER' => 'atable',  'ANSMODULE' => 'p'.'ag',  
				'CATEGORY' => 'ITEMS',  'ITEM' => '',  'SHORTNAME' => 'lookups',  
				'WHERE' => "(id_sub_module = '§id§' or id_module = '§id§' ) and is_lookup='Y' ", 
				 'SHOW' => true,  'ROLES' => '',  'FORMAT' => 'retrieve',  'EDIT' => false,  
				'DO-NOT-RETRIEVE-COLS' => array (
),  'STEP' => 9,  'NO-LABEL' => true,  'BUTTONS' => true,  'PILLAR' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'tome' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'atable',  'ANSMODULE' => 'p'.'ag',  
				'CATEGORY' => 'FORMULA',  
				'WHERE' => "", 
				 'SHOW' => true,  'ROLES' => '',  'EDIT' => false,  'RETRIEVE' => false,  'STEP' => 10,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'anst' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'atable',  'ANSMODULE' => 'p'.'ag',  
				'CATEGORY' => 'FORMULA',  
				'WHERE' => "", 
				 'SHOW' => true,  'ROLES' => '',  'EDIT' => false,  'RETRIEVE' => false,  'STEP' => 10,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'ext_tome' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'atable',  'ANSMODULE' => 'p'.'ag',  
				'CATEGORY' => 'FORMULA',  
				'WHERE' => "", 
				 'SHOW' => true,  'ROLES' => '',  'EDIT' => false,  'RETRIEVE' => false,  'STEP' => 10,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'ext_anst' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'atable',  'ANSMODULE' => 'p'.'ag',  
				'CATEGORY' => 'FORMULA',  
				'WHERE' => "", 
				 'SHOW' => true,  'ROLES' => '',  'EDIT' => false,  'RETRIEVE' => false,  'STEP' => 10,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'main_goal_id' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 40,  
				'TYPE' => 'FK',  'ANSWER' => 'goal',  'ANSMODULE' => 'b'.'au',  'NO-ERROR-CHECK' => true,  
				'WHERE' => "jobrole_id = §id_br§ and module_id in (§id_module_parent§,§id§)", 
				 'DEFAUT' => 0,  'FGROUP' => 'goals_def',  'STEP' => 11,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'applicationGoalList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'goal',  'ANSMODULE' => 'b'.'au',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'module_id',  
				'WHERE' => "", 
				 'FGROUP' => 'goals_def',  'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => false,  'STEP' => 11,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'goalConcernList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'goal_concern',  'ANSMODULE' => 'b'.'au',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'application_id',  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => false,  'STEP' => 11,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'otherGoalList' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'goal',  'ANSMODULE' => 'b'.'au',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'PHP_FORMULA' => 'list_extract.goalConcernList.goal_id.',  'STEP' => 11,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'userStoryList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'user_story',  'ANSMODULE' => 'b'.'au',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'module_id',  'PILLAR' => false,  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'NO-LABEL' => true,  'FGROUP' => 'userStoryList',  'STEP' => 12,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_analyst' => array('SHOW' => true,  'EDIT' => true,  'QEDIT' => false,  'RETRIEVE' => true,  
				'TYPE' => 'FK',  'SHORTNAME' => 'bmjob',  'ANSWER' => 'jobrole',  'ANSMODULE' => 'ums',  'DEFAUT' => 53,  'SIZE' => 40,  
				'WHERE' => "id_domain in (1,3,§id_pm§)", 
				 'FGROUP' => 'jobroles_def',  'STEP' => 13,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_hd' => array('SHOW' => true,  'EDIT' => true,  'QEDIT' => false,  'RETRIEVE' => false,  
				'TYPE' => 'FK',  'SHORTNAME' => 'mmjob',  'ANSWER' => 'jobrole',  'ANSMODULE' => 'ums',  'DEFAUT' => 53,  'SIZE' => 40,  
				'WHERE' => "id_domain in (1,3,§id_pm§)", 
				 'FGROUP' => 'jobroles_def',  'STEP' => 13,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_br' => array('SHOW' => true,  'EDIT' => true,  'QEDIT' => false,  'RETRIEVE' => true,  
				'TYPE' => 'FK',  'SHORTNAME' => 'smjob',  'ANSWER' => 'jobrole',  'ANSMODULE' => 'ums',  'DEFAUT' => 53,  'SIZE' => 40,  
				'WHERE' => "id_domain in (1,3,§id_pm§)", 
				 'FGROUP' => 'jobroles_def',  'STEP' => 13,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'jobrole_mfk' => array('SEARCH' => false,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'SIZE' => 40,  'UTF8' => false,  
				'TYPE' => 'MFK',  'ANSWER' => 'jobrole',  'ANSMODULE' => 'ums',  'SHORTNAME' => 'dispjobs',  
				'WHERE' => "id_domain in (1,3,§id_pm§)", 
				 'EDIT_FGROUP' => true,  'QEDIT_FGROUP' => true,  'FGROUP' => 'jobroles_def',  'STEP' => 13,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'mybfs' => array('STEP' => 13, 
				'TYPE' => 'FK',  'ANSWER' => 'bfunction',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => '',  
				'WHERE' => "curr_class_module_id = §id§", 
				 'NO-LABEL' => true,  'FGROUP' => 'mybfs',  'PILLAR' => false,  'NO-ERROR-CHECK' => true,  
				 'BUTTONS' => true,  'SHOW' => true,  'ROLES' => '',  'FORMAT' => 'retrieve',  'EDIT' => false,  
				 'ICONS' => true,  'DELETE'.'-ICON' => false,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

				
		'bfIcons' =>	array('STEP' => 13, 
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true,  'UTF8' => false,  
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'READONLY' => true, 'FORMAT' => 'html',
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'CSS' => 'width_pct_50', 
				),		

			'avail' => array('STEP' => 99,  'HIDE_IF_NEW' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'DEFAUT' => 'Y',  
				'TYPE' => 'YN',  'FGROUP' => 'tech_fields',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 'Y', 
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
                                                                'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),

                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 
                                                                'TOKEN_SEP'=>"§", 'READONLY'=>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
                ); 
        } 
?>