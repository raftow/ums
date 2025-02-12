<?php 
        class UmsModuleAuserAfwStructure
        {
			public static function initInstance(&$obj)
			{
				if ($obj instanceof ModuleAuser) 
				{
					$obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 1;
                    $obj->ORDER_BY_FIELDS = "id_module, id_auser, description";
                    $obj->UNIQUE_KEY = array('id_module','id_auser');
                    $obj->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
                    
                    $obj->after_save_edit = array("class"=>'Auser',"attribute"=>'id_auser', "currmod"=>'ums',"currstep"=>3);
				}
			}

            public static $DB_STRUCTURE = array(
						'id' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
							'TYPE' => 'PK',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
							),

						'id_auser' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
							'TYPE' => 'FK',  'ANSWER' => 'auser',  'ANSMODULE' => 'ums',  
							'SHORTNAME' => 'user',  'SIZE' => 40,  'DEFAUT' => 0,  
							'CSS' => 'width_pct_25',  'SEARCH-BY-ONE' => true, 
							'READONLY' => true,  
							'AUTOCOMPLETE' => true,
							'AUTOCOMPLETE-SEARCH' => true,
							'DISPLAY' => true,  'STEP' => 1, 'RELATION' => 'OneToMany', 
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 0, ),

						'id_module' => array('SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
							'TYPE' => 'FK',  'ANSWER' => 'module',  'ANSMODULE' => 'ums',  'SIZE' => 40,  
							'CSS' => 'width_pct_25',  'SHORTNAME' => 'module',  'DEFAUT' => '0',  'SEARCH-BY-ONE' => true,  
							'DEPENDENT_OFME' => array (0 => 'arole_mfk',),  
							'WHERE' => "id_module_type=5", 
							'READONLY' => true, 'DISABLE-READONLY-ADMIN'=>true, 'EDIT_IF_EMPTY'=>true, 'DISPLAY' => true,  'STEP' => 1,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => '0', ),

						'description' => array('SHOW' => true,  'RETRIEVE' => false,  'QEDIT' => false,  'EDIT' => true,  
							'CSS' => 'width_pct_25',  
							'TYPE' => 'TEXT',  'UTF8' => true,  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', ),

						'avail' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  'QEDIT' => true,  
							'CSS' => 'width_pct_25',  'DEFAUT' => 'Y',  
							'TYPE' => 'YN',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '',  'DEFAUT' => 'Y', ),

						'arole_mfk' => array('SHORTNAME' => 'roles',  'SHOW' => true,  'RETRIEVE' => true,  'EDIT' => true,  
							'TYPE' => 'MFK',  'ANSWER' => 'arole',  'ANSMODULE' => 'ums',  
							'WHERE-SEARCH' => "arole_type_id = 10", 
							'DEPENDENCY' => 'id_module',  
							'WHERE' => "module_id = §id_module§ and arole_type_id = 10 and avail='Y'", 
							'LINK_TO_MFK_ITEMS' => 'صلاحية',  'LIST_SEPARATOR' => '، ',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
							'DISPLAY-UGROUPS' => '',  'EDIT-UGROUPS' => '', 
							),

						'open_arole_mfk' => array('SHOW' => true,  'RETRIEVE' => false,  'EDIT' => true,  
							'TYPE' => 'MFK',  'ANSWER' => 'arole',  'ANSMODULE' => 'ums',  
							'WHERE' => "(§id_module§ = '0' or §id_module§ = '' or module_id = §id_module§) and id in ('0§arole_mfk§0')", 
							'LIST_SEPARATOR' => '<br> ',  'SEARCH-BY-ONE' => '',  'DISPLAY' => true,  'STEP' => 1,  
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