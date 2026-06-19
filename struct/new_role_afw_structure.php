<?php


class UmsNewRoleAfwStructure
{
	// token separator = §
	public static function initInstance(&$obj)
	{
		if ($obj instanceof NewRole) {
			$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
			$obj->DISPLAY_FIELD_BY_LANG = ['ar' => "new_role_name_ar", 'en' => "new_role_name_en"];

			// $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
			$obj->ORDER_BY_FIELDS = "system_id, module_id, new_role_code";

			$obj->UNIQUE_KEY = array('system_id', 'module_id', 'new_role_code');
			$obj->editByStep = true;
			$obj->editNbSteps = 6;
			$obj->showQeditErrors = true;
			$obj->showRetrieveErrors = true;
			$obj->general_check_errors = true;
			// $obj->after_save_edit = array("class"=>'NewRole',"attribute"=>'xxxx_id', "currmod"=>'ums',"currstep"=>2);
			$obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'ums', "class" => 'NewRole', "submit" => true);
		} else {
			NewRoleArTranslator::initData();
			NewRoleEnTranslator::initData();
		}
	}

	/**
	 * DB_STRUCTURE is the main source of configuration for the class 
	 *    it is used in all the modules and methods to know how 
	 *    to handle the class attributes
	 * @var array
	 */

	public static $DB_STRUCTURE =
	array(
		'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

		'domain_id' => array(
			'STEP' => 1,
			'SHORTNAME' => 'domain',
			'SEARCH' => false,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => true,
			'SIZE' => 32,
			'MAXLENGTH' => 32,
			'MANDATORY' => true,
			'UTF8' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'domain',
			'ANSMODULE' => 'cmn',
			'DEPENDENT_OFME' => array(
				0 => 'module_id',
				1 => 'jobrole_id',
			),
			'RELATION' => 'OneToMany',
			'READONLY' => true,
			'EDIT_IF_EMPTY' => true,
			'CSS' => 'width_pct_50',
		),

		'system_id' => array(
			'STEP' => 1,
			'SHORTNAME' => 'system',
			'SEARCH' => false,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => true,
			'SIZE' => 40,
			'MAXLENGTH' => 40,
			'MANDATORY' => true,
			'UTF8' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'module',
			'ANSMODULE' => 'ums',
			'WHERE' => "id_module_type in (4,7) ",
			'DEPENDENT_OFME' => array(
				0 => 'module_id',
			),
			'RELATION' => 'OneToMany',
			'READONLY' => true,
			'EDIT_IF_EMPTY' => true,
			'DNA' => true,
			'CSS' => 'width_pct_50',
		),

		'module_id' => array(
			'STEP' => 1,
			'SHORTNAME' => 'module',
			'SEARCH' => false,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => true,
			'SIZE' => 40,
			'MAXLENGTH' => 40,
			'MANDATORY' => true,
			'UTF8' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'module',
			'ANSMODULE' => 'ums',
			'WHERE' => "id_pm = §domain_id§ and id_module_type = 5 and id_system = §system_id§",

			'DEPENDENCIES' => array(0 => 'domain_id', 1 => 'system_id',),
			'RELATION' => 'OneToMany',
			'READONLY' => true,
			'EDIT_IF_EMPTY' => true,
			'DNA' => true,
			'CSS' => 'width_pct_50',
		),

		'new_role_code' => array(
			'STEP' => 1,
			'SEARCH' => true,
			'QSEARCH' => true,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => true,
			'EDIT' => true,
			'QEDIT' => true,
			'SIZE' => 16,
			'MAXLENGTH' => 16,
			'MIN-SIZE' => 3,
			'CHAR_TEMPLATE' => "ALPHABETIC,UNDERSCORE",
			'MANDATORY' => true,
			'UTF8' => true,
			'TYPE' => 'TEXT',
			'READONLY' => true,
			'EDIT_IF_EMPTY' => true,
			'CSS' => 'width_pct_50',
		),


		'new_role_name_ar' => array(
			'STEP' => 2,
			'SEARCH' => true,
			'QSEARCH' => true,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => true,
			'EDIT' => true,
			'QEDIT' => true,
			'SIZE' => 64,
			'MAXLENGTH' => 64,
			'MIN-SIZE' => 6,
			'CHAR_TEMPLATE' => "ARABIC-CHARS,SPACE",
			'MANDATORY' => true,
			'UTF8' => true,
			'TYPE' => 'TEXT',
			'READONLY' => false,
			'CSS' => 'width_pct_50',
		),

		'new_role_desc_ar' => array(
			'STEP' => 2,
			'SEARCH' => true,
			'QSEARCH' => true,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => true,
			'SIZE' => 196,
			'MAXLENGTH' => 196,
			'MIN-SIZE' => 12,
			'CHAR_TEMPLATE' => "ALL",
			'MANDATORY' => true,
			'UTF8' => true,
			'TYPE' => 'TEXT',
			'READONLY' => false,
			'CSS' => 'width_pct_50',
		),

		'new_role_name_en' => array(
			'STEP' => 2,
			'SEARCH' => true,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => true,
			'EDIT' => true,
			'QEDIT' => false,
			'SIZE' => 64,
			'MAXLENGTH' => 64,
			'MIN-SIZE' => 6,
			'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
			'MANDATORY' => true,
			'UTF8' => false,
			'TYPE' => 'TEXT',
			'READONLY' => false,
			'CSS' => 'width_pct_50',
		),

		'new_role_desc_en' => array(
			'STEP' => 2,
			'SEARCH' => true,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => false,
			'SIZE' => 196,
			'MAXLENGTH' => 196,
			'MIN-SIZE' => 12,
			'CHAR_TEMPLATE' => "ALL",
			'MANDATORY' => true,
			'UTF8' => false,
			'TYPE' => 'TEXT',
			'READONLY' => false,
			'CSS' => 'width_pct_50',
		),

		'jobrole_id' => array(
			'STEP' => 2,
			'SHORTNAME' => 'jobrole',
			'SEARCH' => false,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => true,
			'SIZE' => 40,
			'MAXLENGTH' => 40,
			'MANDATORY' => false,
			'UTF8' => false,
			'TYPE' => 'FK',
			'ANSWER' => 'jobrole',
			'ANSMODULE' => 'ums',
			'WHERE' => "id_domain in (1,§domain_id§)",
			'DEPENDENCIES' => array(
				0 => 'domain_id',
			),
			'RELATION' => 'OneToMany',
			'READONLY' => false,
			'DNA' => true,
			'CSS' => 'width_pct_50',
		),



		'atable_mfk' => array(
			'STEP' => 3,
			'SHORTNAME' => 'atables',
			'SEARCH' => false,
			'QSEARCH' => false,
			'SHOW' => true,
			'AUDIT' => false,
			'RETRIEVE' => false,
			'EDIT' => true,
			'QEDIT' => false,
			'SIZE' => 32,
			'MAXLENGTH' => 32,
			'MANDATORY' => true,
			'UTF8' => false,
			'TYPE' => 'MFK',
			'ANSWER' => 'atable',
			'ANSMODULE' => 'pag',
			'WHERE' => "id_module = §module_id§ and is_entity='Y' and avail = 'Y'",
			'READONLY' => false,
			'CSS' => 'width_pct_100',
		),

		'settings'            => [
			'STEP' => 4,
			'SEARCH' => true,
			'QSEARCH'     => true,
			'SHOW'   => true,
			'AUDIT'      => false,
			'RETRIEVE'          => false,
			'EDIT'                                 => true,
			'QEDIT'       => false,
			'SIZE'                                 => 'AREA',
			'MAXLENGTH' => 3333,
			'MIN-SIZE' => 1,
			'CHAR_TEMPLATE' => 'ALPHABETIC,SPACE',
			'UTF8' => false,
			'TYPE'                                 => 'TEXT',
			'READONLY'  => false,
			'MANDATORY' => true,
			'COLS' => 100,
			'ROWS' => 20,
			'CSS'                                  => 'width_pct_75'
		],

		'divLevels' => array(
			'STEP' => 4,
			'CATEGORY' => 'FORMULA',
			'SHOW' => true,
			'EDIT' => true,
			'DEFAUT' => 'Y',
			'TYPE' => 'TEXT',
			'SIZE' => 'AREA',
			'ROWS' => 16,
			'DISPLAY' => true,
			'NO-LABEL' => true,
			'READONLY' => true,
			'FORMAT' => 'HTML',
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'CSS' => 'width_pct_25',
			'CAN-BE-SETTED' => false,
			'INPUT_WIDE' => true,
		),

		'divResults' => array(
			'STEP' => 5,
			'CATEGORY' => 'FORMULA',
			'SHOW' => true,
			'EDIT' => true,
			'DEFAUT' => 'Y',
			'TYPE' => 'TEXT',
			'SIZE' => 'AREA',
			'ROWS' => 16,
			'DISPLAY' => true,
			'NO-LABEL' => true,
			'READONLY' => true,
			'FORMAT' => 'HTML',
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
			'CSS' => 'width_pct_100',
			'CAN-BE-SETTED' => false,
			'INPUT_WIDE' => true,
		),

		'php_code' => array(
			'TYPE' => 'TEXT',
			'CATEGORY' => 'FORMULA',
			'SHOW' => true,
			'EDIT' => true,
			'QEDIT' => false,
			'READONLY' => true,
			'RETRIEVE' => false,
			'PRE' => true,
			'CSS' => 'width_pct_100',
			'TEXT-ALIGN' => 'left',
			'STEP' => 6,
			'SEARCH-BY-ONE' => '',
			'DISPLAY' => true,
			'DISPLAY-UGROUPS' => '',
			'EDIT-UGROUPS' => '',
		),


		'id_aut'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false,  'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
		'date_aut'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
		'id_mod'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
		'date_mod'         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
		'id_valid'       => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
		'date_valid'       => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
		'avail'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
		'version'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),
		'draft'             => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
		'update_groups_mfk' => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
		'delete_groups_mfk' => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
		'display_groups_mfk' => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
		'sci_id'            => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'scenario_item', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
		'tech_notes' 	      => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 'TOKEN_SEP' => "§", 'READONLY' => true, "NO-ERROR-CHECK" => true, 'FGROUP' => 'tech_fields'),
	);
}
    


// errors 
