<?php 
		class UmsAuserAfwStructure
        {
			public static function initInstance($obj)
			{
				if($obj instanceof Auser)
				{
					$obj->copypast = true;
					$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 20;
					$obj->ORDER_BY_FIELDS = "firstname,lastname";
					$obj->FORMULA_DISPLAY_FIELD = "concat(IF(ISNULL(firstname), '', firstname) , ' ' , IF(ISNULL(f_firstname), '', f_firstname) , ' ' , IF(ISNULL(lastname), '', lastname))";
					$obj->popup = false;
					$obj->UNIQUE_KEY = array('email');
					$obj->editByStep = true;
					$obj->editNbSteps = 5;
					$obj->showQeditErrors = true;
					$obj->showRetrieveErrors = true;
					$obj->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
				}				
			}

			

            public static $DB_STRUCTURE = array(

                        
			'id' => array(
				'TYPE' => 'PK',  
				'CATEGORY' => '',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => false,  'FGROUP' => '',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'email' => array(
				'TYPE' => 'TEXT',  'EDIT' => true,  'MANDATORY' => true,  'SHOW' => true,  'RETRIEVE' => true, 'QSEARCH' => true, 'SEARCH' => true, 
				'ROLES' => '',  'DEFAUT' => '',  'SIZE' => 64,  'FORMAT' => 'he',  'FGROUP' => '',  'READONLY' => false, 
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,  'DEFAUT' => '', 
				),

			'username' => array(
				'TYPE' => 'TEXT',  'EDIT' => true,  'MANDATORY' => true,  'QSEARCH' => true,  'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'SIZE' => 64,  'FGROUP' => '',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'nomcomplet' => array(
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,   'SEARCH' => true,  'RETRIEVE' => true,  'UTF8' => true,  'EDIT' => false,  
				'FIELD-FORMULA' => "concat(IF(ISNULL(firstname), '', firstname) , ' ' , IF(ISNULL(f_firstname), '', f_firstname) , ' ' , IF(ISNULL(lastname), '', lastname))",  
				'FGROUP' => '',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'lang_id' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 40,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION', 'FUNCTION_COL_NAME'=>'language_enum',  'DEFAUT' => 1,  'SHORTNAME' => 'lang',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 1, 
				),

			'genre_id' => array(
				'TYPE' => 'ENUM',  'ANSWER' => '1,ذكر|2,أنثى',  'EDIT' => true,  'QEDIT' => false,  'SHOW' => true,  'RETRIEVE' => false,  'SEARCH' => false,  'DEFAUT' => 1,  'SHOW-ADMIN' => true,  'ROLES' => 6,  'FGROUP' => '',  'ANSMODULE' => 'ums',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 1, 
				),

			'country_id' => array('SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'country',  'ANSMODULE' => 'ums',  'DEFAUT' => 0,  'FGROUP' => '',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 0, 
				),

			'firstname' => array(
				'TYPE' => 'TEXT',  'EDIT' => true,  'SHOW' => true,  'RETRIEVE' => false,  'UTF8' => true,  
				'SEARCH' => true, 'QSEARCH' => true, 
				'SIZE' => 32,  'FGROUP' => '',  'MANDATORY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'f_firstname' => array(
				'TYPE' => 'TEXT',  'EDIT' => true,  'QEDIT' => true,  'SHOW' => true,  'RETRIEVE' => false,  
				'SEARCH' => true, 'QSEARCH' => true, 
				'UTF8' => true,  'SIZE' => 32,  'FGROUP' => '',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'lastname' => array(
				'TYPE' => 'TEXT',  'EDIT' => true,  'SHOW' => true,  'RETRIEVE' => false,  'UTF8' => true,  
				'SEARCH' => true, 'QSEARCH' => true, 
				'SIZE' => 32,  'MANDATORY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'idn_type_id' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 40,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'idn_type',  'ANSMODULE' => 'ums',  'DEFAUT' => 0,  'MANDATORY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,  'DEFAUT' => 0, 
				),

			'idn' => array('SEARCH' => true, 'QSEARCH' => true,  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 20,  
				'TYPE' => 'TEXT',  'MANDATORY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true, 
				),

			'hierarchy_level_enum' => array('SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'SIZE' => 40,  'SEARCH-ADMIN' => true,  'SHOW-ADMIN' => true,  'EDIT-ADMIN' => true,  'UTF8' => false,  
				'TYPE' => 'ENUM',  'ANSWER' => 'FUNCTION',   'DEFAUT' => 1,  'SHORTNAME' => 'lang',  
				'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  'MANDATORY' => true,
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 1, 
				),	

			'pwd' => array(
				'TYPE' => 'TEXT',  'DEFAUT' => true,  'SHOW-ADMIN' => true,  'READONLY' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => '',  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),

			'mobile' => array('STEP' => 2,  
				'TYPE' => 'TEXT',  'EDIT' => true,  'QEDIT' => false,  'SHOW' => true,  'RETRIEVE' => true, 
				'ROLES' => '',  'DEFAUT' => '05',  'SIZE' => 16,  'CSS-DISPLAY' => 'mobile',  'FGROUP' => 'work_contact', 
				'MANDATORY' => true,  'SEARCH' => true, 'QSEARCH' => true, 'FORMAT' => 'SA-MOBILE',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'ERROR-CHECK' => true,  'DEFAUT' => '05', 
				),

			'address' => array('STEP' => 2,  
				'TYPE' => 'TEXT',  'SHOW' => true,  'EDIT' => true,  'QEDIT' => false,  'UTF8' => true,  
				'SIZE' => 120,  'FGROUP' => 'work_contact',  'TITLE_AFTER' => 'المملكة العربية السعودية',  
				'HELP' => "إذا لم تكن قد قمت به سابقا فبادر الآن بتسجيل عنوانك الوطني تنفيذاً لقرار مجلس الوزراء رقم (252) بتاريخ 1434/7/24هـ من <a target='_na' href='https://www.sp.com.sa/ar/NationalAddress/Pages/NationalAddress.aspx'>هنا</a>",  
				'QSEARCH' => true, 'SEARCH' => true, 'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'cp' => array('STEP' => 2,  'SEARCH' => true,  'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 20,  'UTF8' => true,  
				'TYPE' => 'TEXT',  'FGROUP' => 'work_contact',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'quarter' => array('STEP' => 2,  'SEARCH' => true, 'QSEARCH' => true, 'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => false, 
				 'SIZE' => 20,  'UTF8' => true,  
				'TYPE' => 'TEXT',  'FGROUP' => 'work_contact',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'city_id' => array('STEP' => 2, 'QSEARCH' => true, 'SEARCH' => true,  'SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'SHORTNAME' => 'city',  'ANSWER' => 'city',  'ANSMODULE' => 'ums',  'DEFAUT' => 0,  'FGROUP' => 'work_contact',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 0, 
				),

		'mau' => array('STEP' => 3,  
				'TYPE' => 'FK',  'ANSWER' => 'module_auser',  'ANSMODULE' => 'ums',  
				'CATEGORY' => 'ITEMS',  'ITEM' => 'id_auser',  'NO-CACHE' => false,  
				'WHERE' => "", 
				 'SHOW' => true,  'ICONS' => true,  'DELETE-ICON' => true,  'FORMAT' => 'retrieve',  'EDIT' => false,  'NO-LABEL' => true,  'FGROUP' => 'mau',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'rights' => array('STEP' => 5,  
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true, 'MINIBOX' => true,  'READONLY' => true,  'CAN-BE-SETTED' => false,  'SIZE' => 255,  'INPUT_WIDE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

		'php' => array('STEP' => 4,  
				'TYPE' => 'TEXT',  
				'CATEGORY' => 'FORMULA',  'SHOW' => true,  'EDIT' => true, 'MINIBOX' => false,  'READONLY' => true,  'CAN-BE-SETTED' => false,  'SIZE' => 255,  'INPUT_WIDE' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
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
                                                                'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),

                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 
                                                                'TOKEN_SEP'=>"§", 'READONLY'=>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
                ); 
        } 
?>