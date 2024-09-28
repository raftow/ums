<?php

class UmsObject extends AFWObject{

        public function getTimeStampFromRow($row,$context="update", $timestamp_field="")
        {
                if(!$timestamp_field) return $row["synch_timestamp"];
                else return $row[$timestamp_field];
        }


        public static function code_of_training_period_enum($lkp_id=null)
        {
            global $lang;
            if($lkp_id) return self::training_period()['code'][$lkp_id];
            else return self::training_period()['code'];
        }

        public static function name_of_training_period_enum($training_period_enum, $lang="ar")
        {
            return self::training_period()[$lang][$training_period_enum];            
        }
        

        
        
        public static function list_of_training_period_enum()
        {
            global $lang;
            return self::training_period()[$lang];
        }
        
        public static function training_period()
        {
                $arr_list_of_training_period = array();
                
                        
                $arr_list_of_training_period["en"][1] = "Morning";
                $arr_list_of_training_period["ar"][1] = "صباحي";
                $arr_list_of_training_period["code"][1] = "Morning";

                $arr_list_of_training_period["en"][2] = "Evening";
                $arr_list_of_training_period["ar"][2] = "مسائي";
                $arr_list_of_training_period["code"][2] = "Evening";

                /*
                $arr_list_of_training_period["en"][3] = "Online";
                $arr_list_of_training_period["ar"][3] = "عن بعد";
                $arr_list_of_training_period["code"][3] = "Online";*/

                
                return $arr_list_of_training_period;
        } 

        public static function list_of_religion_enum()
        {
            global $lang;
            return self::religion_enum()[$lang];
        }
        
        public static function religion_enum()
        {
                $arr_list_of_religion_enum = array();
                
                        
                $arr_list_of_religion_enum["en"][1] = "Islam";
                $arr_list_of_religion_enum["ar"][1] = "الإسلام";
                $arr_list_of_religion_enum["code"][1] = "Islam";

                $arr_list_of_religion_enum["en"][2] = "People of book";
                $arr_list_of_religion_enum["ar"][2] = "أهل الكتاب";
                $arr_list_of_religion_enum["code"][2] = "Book";

                
                $arr_list_of_religion_enum["en"][3] = "Other religion";
                $arr_list_of_religion_enum["ar"][3] = "دين آخر";
                $arr_list_of_religion_enum["code"][3] = "Other";

                
                return $arr_list_of_religion_enum;
        }

        

        public static function list_of_address_type_enum()
        {
            global $lang;
            return self::address_type_enum()[$lang];
        }
        
        public static function address_type_enum()
        {
                $arr_list_of_address_type_enum = array();
                
                $arr_list_of_address_type_enum["en"][1] = "National Address";
                $arr_list_of_address_type_enum["ar"][1] = "العنوان الوطني";
                $arr_list_of_address_type_enum["code"][1] = "NA";
                        
                $arr_list_of_address_type_enum["en"][2] = "Parent Address";
                $arr_list_of_address_type_enum["ar"][2] = "ولي الامر";
                $arr_list_of_address_type_enum["code"][2] = "PA";

                $arr_list_of_address_type_enum["en"][3] = "Work Address";
                $arr_list_of_address_type_enum["ar"][3] = "عنوان العمل";
                $arr_list_of_address_type_enum["code"][3] = "BU";

                
                $arr_list_of_address_type_enum["en"][4] = "Permanent Address";
                $arr_list_of_address_type_enum["ar"][4] = "دائمة";
                $arr_list_of_address_type_enum["code"][4] = "PR";

                $arr_list_of_address_type_enum["en"][4] = "Billing Address";
                $arr_list_of_address_type_enum["ar"][4] = "اصدار الفواتير";
                $arr_list_of_address_type_enum["code"][4] = "BI";

                
                return $arr_list_of_address_type_enum;
        }

        public static function list_of_employer_enum()
        {
            global $lang;
            return self::employer_enum()[$lang];
        }
        
        public static function employer_enum()
        {
                $arr_list_of_employer_enum = array();
                
                $arr_list_of_employer_enum["en"][1] = "Government sector";
                $arr_list_of_employer_enum["ar"][1] = "قطاع حكومي";
                $arr_list_of_employer_enum["code"][1] = "Government";
                        
                $arr_list_of_employer_enum["en"][2] = "Private sector";
                $arr_list_of_employer_enum["ar"][2] = "قطاع خاص";
                $arr_list_of_employer_enum["code"][2] = "Private";

                return $arr_list_of_employer_enum;
        }

        public static function list_of_relationship_enum()
        {
            global $lang;
            return self::relationship_enum()[$lang];
        }
        
        public static function relationship_enum()
        {
                $arr_list_of_relationship_enum = array();
                
                $arr_list_of_relationship_enum["en"][1] = "Parent";
                $arr_list_of_relationship_enum["ar"][1] = "والد(ة)";
                $arr_list_of_relationship_enum["code"][1] = "P";
                        
                $arr_list_of_relationship_enum["en"][2] = "Hasband/wife";
                $arr_list_of_relationship_enum["ar"][2] = "زوج(ة)";
                $arr_list_of_relationship_enum["code"][2] = "H";

                $arr_list_of_relationship_enum["en"][3] = "Friend";
                $arr_list_of_relationship_enum["ar"][3] = "صديق";
                $arr_list_of_relationship_enum["code"][3] = "F";

                
                $arr_list_of_relationship_enum["en"][4] = "Son";
                $arr_list_of_relationship_enum["ar"][4] = "الابن";
                $arr_list_of_relationship_enum["code"][4] = "S";

                $arr_list_of_relationship_enum["en"][5] = "Brother/Sister";
                $arr_list_of_relationship_enum["ar"][5] = "الاخ-ت";
                $arr_list_of_relationship_enum["code"][5] = "B";

                $arr_list_of_relationship_enum["en"][6] = "Grandpa";
                $arr_list_of_relationship_enum["ar"][6] = "الجد";
                $arr_list_of_relationship_enum["code"][6] = "G";

                $arr_list_of_relationship_enum["en"][7] = "Neighbor";
                $arr_list_of_relationship_enum["ar"][7] = "الجار";
                $arr_list_of_relationship_enum["code"][7] = "N";

                $arr_list_of_relationship_enum["en"][8] = "Guardian";
                $arr_list_of_relationship_enum["ar"][8] = "ولي الامر";
                $arr_list_of_relationship_enum["code"][8] = "G";

                
                return $arr_list_of_relationship_enum;
        }



        public static function code_of_language_enum($lkp_id=null)
        {
            global $lang;
            if($lkp_id) return self::language()['code'][$lkp_id];
            else return self::language()['code'];
        }

        

        
        
        
        public static function list_of_language_enum()
        {
            global $lang;
            return self::language()[$lang];
        }
        
        public static function language()
        {
                $arr_list_of_language = array();
                
                
                $arr_list_of_language["en"][1] = "Arabic";
                $arr_list_of_language["ar"][1] = "العربية";
                $arr_list_of_language["code"][1] = "ar";

                $arr_list_of_language["en"][2] = "English";
                $arr_list_of_language["ar"][2] = "الإنجليزية";
                $arr_list_of_language["code"][2] = "en";

                
                
                
                return $arr_list_of_language;
        } 


        

        
        public static function list_of_hierarchy_level_enum()
        {
            global $lang;
            return self::hierarchy_level()[$lang];
        }
        
        public static function hierarchy_level()
        {
                $arr_list_of_hierarchy_level = array();

                $main_company = AfwSession::config("main_company","all");
                $file_dir_name = dirname(__FILE__);        
                include($file_dir_name."/../extra/hierarchy_level-$main_company.php");

                foreach($hierarchy_level as $id => $lookup_row)
                {
                    $arr_list_of_hierarchy_level["ar"][$id] = $lookup_row["ar"];
                    $arr_list_of_hierarchy_level["en"][$id] = $lookup_row["en"];
                }

                
                return $arr_list_of_hierarchy_level;
        }

        public static function pagIsThere()
        {
            $file_dir_name = dirname(__FILE__);
            if(file_exists($file_dir_name.'/../../p'.'ag/index.php'))
            {
                AfwAutoLoader::addModule("p"."ag");
                return true;
            } 
            return false;
        }
            


        public function calcHijri_current()
        {
            return AfwDateHelper::currentHijriDate();
        } 

}