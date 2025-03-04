<?php
class UmsUgroupTypeAfwStructure
{
        // token separator = §
        public static function initInstance(&$obj)
        {
                if ($obj instanceof UgroupType) {
                        $obj->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 5;
                        $obj->DISPLAY_FIELD_BY_LANG = ['ar'=>"titre_short_ar", 'en'=>"titre_short_en",];

                        // $obj->ENABLE_DISPLAY_MODE_IN_QEDIT=true;
                        $obj->ORDER_BY_FIELDS = "titre_short_ar";



                        $obj->UNIQUE_KEY = array('lkp_code');

                        $obj->showQeditErrors = true;
                        $obj->showRetrieveErrors = true;
                        $obj->general_check_errors = true;
                        // $obj->after_save_edit = array("class"=>'Road',"attribute"=>'road_id', "currmod"=>'btb',"currstep"=>9);
                        $obj->after_save_edit = array("mode" => "qsearch", "currmod" => 'adm', "class" => 'UgroupType', "submit" => true);
                } else {
                        UgroupTypeArTranslator::initData();
                        UgroupTypeEnTranslator::initData();
                }
        }

        public static $DB_STRUCTURE = array(


                'id' => array(
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'TYPE' => 'PK',
                        'SEARCH-BY-ONE' => '',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                ),

                'lkp_code' => array(
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'EDIT' => true,
                        'UTF8' => true,
                        'SIZE' => 64,
                        'TYPE' => 'TEXT',
                        'SEARCH-BY-ONE' => '',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'QEDIT' => true,
                ),

                'titre_short_ar' => array(
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'UTF8' => true,
                        'SIZE' => 40,
                        'TYPE' => 'TEXT',
                        'SEARCH-BY-ONE' => '',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'QEDIT' => true,
                ),

                'titre_short_en' => array(
                        'SHOW' => true,
                        'RETRIEVE' => true,
                        'EDIT' => true,
                        'UTF8' => false,
                        'SIZE' => 40,
                        'TYPE' => 'TEXT',
                        'SEARCH-BY-ONE' => '',
                        'DISPLAY' => true,
                        'STEP' => 1,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                        'QEDIT' => true,
                ),

                'avail' => array(
                        'SHOW-ADMIN' => true,
                        'RETRIEVE' => false,
                        'EDIT-ADMIN' => true,
                        'DEFAUT' => 'Y',
                        'EDIT' => true,
                        'TYPE' => 'YN',
                        'SEARCH-BY-ONE' => '',
                        'DISPLAY' => '',
                        'STEP' => 1,
                        'QEDIT' => true,
                        'DISPLAY-UGROUPS' => '',
                        'EDIT-UGROUPS' => '',
                ),

                'id_aut'         => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'TECH_FIELDS-RETRIEVE' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'FGROUP' => 'tech_fields'
                ),

                'date_aut'            => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'TECH_FIELDS-RETRIEVE' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'FGROUP' => 'tech_fields'
                ),

                'id_mod'           => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'TECH_FIELDS-RETRIEVE' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'FGROUP' => 'tech_fields'
                ),

                'date_mod'              => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'TECH_FIELDS-RETRIEVE' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'FGROUP' => 'tech_fields'
                ),

                'id_valid'       => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'FK',
                        'ANSWER' => 'auser',
                        'ANSMODULE' => 'ums',
                        'FGROUP' => 'tech_fields'
                ),

                'date_valid'          => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'GDAT',
                        'FGROUP' => 'tech_fields'
                ),

                /* 'avail'                   => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
//                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),*/

                'version'                  => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'INT',
                        'FGROUP' => 'tech_fields'
                ),

                // 'draft'                         => array('STEP' => 99, 'HIDE_IF_NEW' => true, 'SHOW' => true, 'RETRIEVE' => false, 'EDIT' => false, 
                //                                                                'QEDIT' => false, "DEFAULT" => 'Y', 'TYPE' => 'YN', 'FGROUP' => 'tech_fields'),

                'update_groups_mfk'             => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'ANSWER' => 'ugroup',
                        'ANSMODULE' => 'ums',
                        'TYPE' => 'MFK',
                        'FGROUP' => 'tech_fields'
                ),

                'delete_groups_mfk'             => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'ANSWER' => 'ugroup',
                        'ANSMODULE' => 'ums',
                        'TYPE' => 'MFK',
                        'FGROUP' => 'tech_fields'
                ),

                'display_groups_mfk'            => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'ANSWER' => 'ugroup',
                        'ANSMODULE' => 'ums',
                        'TYPE' => 'MFK',
                        'FGROUP' => 'tech_fields'
                ),

                'sci_id'                        => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'SHOW' => true,
                        'RETRIEVE' => false,
                        'QEDIT' => false,
                        'TYPE' => 'INT', /*stepnum-not-the-object*/
                        'FGROUP' => 'tech_fields'
                ),

                'tech_notes'                         => array(
                        'STEP' => 99,
                        'HIDE_IF_NEW' => true,
                        'TYPE' => 'TEXT',
                        'CATEGORY' => 'FORMULA',
                        "SHOW-ADMIN" => true,
                        'TOKEN_SEP' => "§",
                        'READONLY' => true,
                        "NO-ERROR-CHECK" => true,
                        'FGROUP' => 'tech_fields'
                ),
        );
}
