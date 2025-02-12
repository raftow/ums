<?php 

     
        class UmsUserParamValueAfwStructure
        {
                // token separator = §
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof UserParamValue ) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                                $obj->DISPLAY_FIELD = "";
                                
                                // $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                                $obj->ORDER_BY_FIELDS = "user_param_id, company_orgunit_id, department_orgunit_id, division_orgunit_id, employee_id";
                                 
                                
                                
                                $obj->UNIQUE_KEY = array('user_param_id','company_orgunit_id','department_orgunit_id','division_orgunit_id','employee_id');
                                $obj->editByStep = true;
                $obj->editNbSteps = 2;
                $obj->showQeditErrors = true;
                $obj->showRetrieveErrors = true;
                $obj->general_check_errors = true;
                                // $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
                                $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'UserParamValue',"submit"=>true);
                        }
                        else 
                        {
                                UserParamValueArTranslator::initData();
                                UserParamValueEnTranslator::initData();
                        }
                }
                
                
                public static $DB_STRUCTURE =  
     array(
                'id' => array('SHOW' => true, 'RETRIEVE' => true, 'EDIT' => false, 'TYPE' => 'PK'),

		
		'user_param_id' => array('STEP' => 1,  'SHORTNAME' => 'param',  'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 40,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => true,  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'user_param',  'ANSMODULE' => 'ums',  
				'RELATION' => 'OneToMany',  'READONLY' => true, 
				'CSS' => 'width_pct_50', ),

		'company_orgunit_id' => array('STEP' => 1,  'SHORTNAME' => 'orgunit',  
				'WHERE' => "id_sh_type in (5,6,7,8)", 
				 'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 40,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  
				'RELATION' => 'ManyToOne',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'department_orgunit_id' => array('STEP' => 1,  'SHORTNAME' => 'plan',  
				'WHERE' => "id_sh_parent = §company_orgunit_id§ and id_sh_type in (9,11,13,14,16)", 
				 'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 40,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  
				'RELATION' => 'ManyToOne',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'division_orgunit_id' => array('STEP' => 1,  'SHORTNAME' => 'orgunit',  
				'WHERE' => "id_sh_parent = §department_orgunit_id§ and id_sh_type in (3,4,9,10,15)", 
				 'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 40,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'orgunit',  'ANSMODULE' => 'hrm',  
				'RELATION' => 'ManyToOne',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'employee_id' => array('STEP' => 1,  'SHORTNAME' => 'employee',  
				'WHERE' => "company_orgunit_id = §company_orgunit_id§
                                                           and ((§division_orgunit_id§ = 0) or (division_orgunit_id = §division_orgunit_id§))          
                                                           and ((§ugroup_id§ = 0) or (ugroup_id = §ugroup_id§))", 
				 'SEARCH' => true,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => true,  'QEDIT' => true,  
				'SIZE' => 40,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'employee',  'ANSMODULE' => 'ums',  
				'RELATION' => 'ManyToOne',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'avail' => array('STEP' => 1,  'SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => true,  
				'EDIT' => false,  'QEDIT' => false,  
				'SIZE' => 9999,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'YN',  'DEFAUT' => 'Y',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'value' => array('STEP' => 2,  'SEARCH' => true,  'QSEARCH' => true,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => true,  'QEDIT' => false,  
				'SIZE' => 255,  'MAXLENGTH' => 255,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'MANDATORY' => true,  'UTF8' => true,  
				'TYPE' => 'TEXT',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'id_aut' => array('SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => false,  'QEDIT' => false,  
				'SIZE' => 9999,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',  'AUTOCOMPLETE' => true,  
				'RELATION' => 'ManyToOne',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'date_aut' => array('SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => false,  'QEDIT' => false,  
				'SIZE' => 9999,  'MAXLENGTH' => 10,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'GDAT',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'id_mod' => array('SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => false,  'QEDIT' => false,  
				'SIZE' => 9999,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',  'AUTOCOMPLETE' => true,  
				'RELATION' => 'ManyToOne',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'date_mod' => array('SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => false,  'QEDIT' => false,  
				'SIZE' => 9999,  'MAXLENGTH' => 10,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'GDAT',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'id_valid' => array('SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => false,  'QEDIT' => false,  
				'SIZE' => 9999,  'MAXLENGTH' => 32,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',  'AUTOCOMPLETE' => true,  
				'RELATION' => 'ManyToOne',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

		'date_valid' => array('SEARCH' => false,  'QSEARCH' => false,  'SHOW' => true,  'AUDIT' => false,  'RETRIEVE' => false,  
				'EDIT' => false,  'QEDIT' => false,  
				'SIZE' => 9999,  'MAXLENGTH' => 10,  'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",  'UTF8' => false,  
				'TYPE' => 'GDAT',  'READONLY' => false, 
				'CSS' => 'width_pct_50', ),

                
                'id_aut'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false,  'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'date_aut'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'id_mod'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'date_mod'         => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, "TECH_FIELDS-RETRIEVE" => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'id_valid'       => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'FK', 'ANSWER' => 'auser', 'ANSMODULE' => 'ums', 'FGROUP' => 'tech_fields'),
                'date_valid'       => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'DATETIME', 'FGROUP' => 'tech_fields'),
                'avail'             => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
                'version'            => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'INT', 'FGROUP' => 'tech_fields'),
                'draft'             => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),
                'update_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'delete_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'display_groups_mfk' => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'ANSWER' => 'ugroup', 'ANSMODULE' => 'ums', 'TYPE' => 'MFK', 'FGROUP' => 'tech_fields'),
                'sci_id'            => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'QEDIT' => false, 'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),
                'tech_notes' 	      => array('STEP' =>99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 'TOKEN_SEP'=>"§", 'READONLY' =>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
	);  
    
         }
    


// errors 

