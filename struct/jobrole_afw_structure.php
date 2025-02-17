<?php 
        class UmsJobroleAfwStructure
        {
                public static $DB_STRUCTURE = array(

                        
			'id' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'PK',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_domain' => array(
				'TYPE' => 'INT', 'SHOW' => true,  'RETRIEVE' => true,  'SEARCH' => true,  'QSEARCH' => true,  'EDIT' => true,  'MANDATORY' => true,  
				'WHERE' => "", 
				 'SHORTNAME' => 'domain', 
				'RELATION' => 'OneToMany',  'STEP' => 1,  'SEARCH-BY-ONE' => true,  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'jobrole_code' => array('IMPORTANT' => 'IN',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'MANDATORY' => true, 'QEDIT' => true,  
				'SIZE' => '24',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'titre_short' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => true,  'SIZE' => 64,  
				'TYPE' => 'TEXT',  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_short_en' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 64,  
				'TYPE' => 'TEXT',  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'UTF8' => true,  
				'SIZE' => 'AREA',  
				'TYPE' => 'TEXT',  'DIR' => 'rtl',  'ROWS' => 18,  'COLS' => 50,  'SHORTNAME' => 'description',  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_en' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  'UTF8' => false,  
				'SIZE' => 'AREA',  
				'TYPE' => 'TEXT',  'DIR' => 'ltr',  'ROWS' => 18,  'COLS' => 50,  'SHORTNAME' => 'description_en',  'STEP' => 1,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'jobAroleList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'job_arole',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'jobrole_id',  'SHORTNAME' => 'roles',  'MANDATORY' => true,  'ERROR-CHECK' => true,  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'NO-LABEL' => false,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'myRoles' => array(
				'TYPE' => 'FK',  'ANSWER' => 'arole',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'FORMULA',  'SUPER_CATEGORY' => 'ITEMS',  'SHOW' => true,  'FORMAT' => 'tree',  'LINK_COL' => 'parent_arole_id',  'ITEMS_COL' => 'childList',  'FEUILLE_COL' => 'rbfList',  'FEUILLE_COND_METHOD' => '_isMenu',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => false,  'BUTTONS' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),
		/*		
		'jobGoalList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'goal',  'ANSMODULE' => 'b au',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'jobrole_id',  'SHORTNAME' => 'goals',  'MANDATORY' => true,  'ERROR-CHECK' => true,  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'NO-LABEL' => false,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'goalConcernList' => array(
				'TYPE' => 'FK',  'ANSWER' => 'goal_concern',  'ANSMODULE' => 'b au',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'jobrole_id',  
				'WHERE' => "", 
				 'SHOW' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'ICONS' => true,  'DELETE-ICON' => true,  'BUTTONS' => true,  'NO-LABEL' => false,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'otherGoalList' => array(
				'TYPE' => 'MFK',  'ANSWER' => 'goal',  'ANSMODULE' => 'b au',  
				'CATEGORY' => 'FORMULA',  'SHOW' => false,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'READONLY' => true,  'PHP_FORMULA' => 'list_extract.goalConcernList.goal_id.',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => false,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),*/

		'mainApplication' => array(
				'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),
/*
		'mainGoal' => array(
				'TYPE' => 'FK',  'ANSWER' => 'goal',  'ANSMODULE' => 'b au',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'lookupGoal' => array(
				'TYPE' => 'FK',  'ANSWER' => 'goal',  'ANSMODULE' => 'b au',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'statsGoal' => array(
				'TYPE' => 'FK',  'ANSWER' => 'goal',  'ANSMODULE' => 'b au',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),*/

		'is_finished' => array(
				'TYPE' => 'YN',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => false,  'QEDIT' => false,  'READONLY' => true,  'PHP_FORMULA' => 'method...finished',  'STEP' => 2,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_sh_org' => array(
				'TYPE' => 'FK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'WHERE' => "id_sh_type=6", 
				 'SHORTNAME' => 'org',  
				'DEPENDENT_OFME' => array (
  0 => 'id_sh_div',
),  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'id_sh_div' => array(
				'TYPE' => 'FK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'WHERE' => "id_sh_org=§id_sh_org§ and id_sh_type in (3,4)", 
				 'SHORTNAME' => 'div',  'DEPENDENCY' => 'id_sh_org',  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'avail' => array('IMPORTANT' => 'IN',  'SHOW-ADMIN' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'DEFAUT' => 'Y',  
				'TYPE' => 'YN',  'STEP' => 3,  'SHOW' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'is_ok' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => false,  'READONLY' => true,  'NO-ERROR-CHECK' => true,  'STEP' => 3,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
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
                                                                'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),

                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 
                                                                'TOKEN_SEP'=>"§", 'READONLY'=>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
                ); 
        } 
?>