<?php 
        class UmsUgroupAfwStructure
        {
                // token separator = §
                public static function initInstance(&$obj)
                {
                        if ($obj instanceof Ugroup) 
                        {
                                $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                                $obj->DISPLAY_FIELD = "titre_short_ar";
                                
                                // $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                                $obj->ORDER_BY_FIELDS = "titre_short_ar";
                                
                                $obj->UNIQUE_KEY = array('module_id', 'ugroup_type_id', 'ugroup_scope_id', 'definition');
                                
                                $obj->showQeditErrors = true;
                                $obj->showRetrieveErrors = true;
                                $obj->general_check_errors = true;
                                // $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
                                $obj->after_save_edit = array("mode"=>"qsearch", "currmod"=>'adm', "class"=>'Ugroup',"submit"=>true);
                        }
                        else 
                        {
                                UgroupArTranslator::initData();
                                UgroupEnTranslator::initData();
                        }
                }
                public static $DB_STRUCTURE = array(

                        
			'id' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'PK',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'titre_short_ar' => array(
                                'SEARCH' => true,
                                'QSEARCH' => true,
                                'SHOW' => true,
                                'AUDIT' => false,
                                'RETRIEVE' => true,
                                'EDIT' => true,
                                'QEDIT' => true,
                                'SIZE' => 40,
                                'MAXLENGTH' => 32,
                                'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                                'UTF8' => true,
                                'TYPE' => 'TEXT',
                                'READONLY' => false,
                                'DNA' => true,
                                'CSS' => 'width_pct_50',
                        ),

                        'titre_short_en' => array(
                                'SEARCH' => true,
                                'QSEARCH' => true,
                                'SHOW' => true,
                                'AUDIT' => false,
                                'RETRIEVE' => true,
                                'EDIT' => true,
                                'QEDIT' => true,
                                'SIZE' => 40,
                                'MAXLENGTH' => 48,
                                'MIN-SIZE' => 5,
                                'CHAR_TEMPLATE' => "ALPHABETIC,SPACE",
                                'UTF8' => false,
                                'TYPE' => 'TEXT',
                                'READONLY' => false,
                                'DNA' => true,
                                'CSS' => 'width_pct_50',
                        ),


                        'module_id' => array(
                                'IMPORTANT' => 'IN',
                                'SHOW' => true,
                                'RETRIEVE' => false,
                                'EDIT' => true,
                                'TYPE' => 'FK',
                                'ANSWER' => 'module',
                                'ANSMODULE' => 'ums',
                                'SIZE' => 64,
                                'DEFAUT' => 0,
                                'WHERE' => "id_module_type=5",
                                'QEDIT' => true,
                                'SEARCH-BY-ONE' => true,
                                'MANDATORY' => true,                                
                                'RELATION' => 'OneToMany',
                                'DISPLAY' => true,
                                'STEP' => 1,
                                'DISPLAY-UGROUPS' => '',
                                'EDIT-UGROUPS' => '',
                                'ERROR-CHECK' => true,
                        ),                                

			'ugroup_type_id' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'ugroup_type',  'ANSMODULE' => 'ums',  
                                'SIZE' => 40,  'DEFAUT' => 0,  'SHORTNAME' => 'type',  'SEARCH-BY-ONE' => '',  
                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,    
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'ugroup_scope_id' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'FK',  'ANSWER' => 'ugroup_scope',  'ANSMODULE' => 'ums',  
                                'SIZE' => 40,  'DEFAUT' => 0,  'SHORTNAME' => 'scope',  'SEARCH-BY-ONE' => '',  
                                'DISPLAY' => true,  'STEP' => 1, 'MANDATORY' => true,    
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
				),

			'definition' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
				'TYPE' => 'TEXT',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
				'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 'MANDATORY' => true,   
				),

			'avail' => array('SHOW-ADMIN' => true,  'RETRIEVE' => false,  'EDIT' => false,  'DEFAUT' => 'Y',  
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
                                                                'TYPE' => 'INT', /*stepnum-not-the-object*/ 'FGROUP' => 'tech_fields'),

                        'tech_notes' 	                => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'TYPE' => 'TEXT', 'CATEGORY' => 'FORMULA', "SHOW-ADMIN" => true, 
                                                                'TOKEN_SEP'=>"§", 'READONLY'=>true, "NO-ERROR-CHECK"=>true, 'FGROUP' => 'tech_fields'),
                ); 
        } 
?>