<?php

class UmsObject extends AFWObject{

        public function getTimeStampFromRow($row,$context="update", $timestamp_field="")
        {
                if(!$timestamp_field) return $row["synch_timestamp"];
                else return $row[$timestamp_field];
        }


        public static function code_of_domain_enum($lkp_id=null)
        {
            global $lang;
            if($lkp_id) return self::domain()['code'][$lkp_id];
            else return self::domain()['code'];
        }

        public static function name_of_domain_enum($domain_enum, $lang="ar")
        {
            return self::domain()[$lang][$domain_enum];            
        }
        
        public static function prepareLog($log)
        {

            global $immediate_output, $immediate_output_nb;
            if($immediate_output) 
            {  
                if(!$immediate_output_nb) $immediate_output_nb = 0;
                echo $log; 
                $immediate_output_nb++; 
                if($immediate_output_nb>50) throw new AfwRuntimeException("MAX OUTPUT REACHED");
            }
            return $log;
        }
        
        
        public static function list_of_domain_enum()
        {
            global $lang;
            return self::domain()[$lang];
        }
        
        public static function domain()
        {
                $arr_list_of_domain = array();
                
                        
                $arr_list_of_domain["ar"][3] = " تحليل وتصميم النظم";
                $arr_list_of_domain["en"][3] = "system analysis & design";
                $arr_list_of_domain["code"][3] = "pag";
                
                
                $arr_list_of_domain["ar"][12] = "إدارة الأعمال";
                $arr_list_of_domain["en"][12] = "Business";
                $arr_list_of_domain["code"][12] = "BM";
                
                
                $arr_list_of_domain["ar"][24] = "إدارة التراخيص";
                $arr_list_of_domain["en"][24] = "licenses management";
                $arr_list_of_domain["code"][24] = "license";
                
                
                $arr_list_of_domain["ar"][18] = "إدارة المحتوى";
                $arr_list_of_domain["en"][18] = "Content Management";
                $arr_list_of_domain["code"][18] = "CMS";
                
                
                $arr_list_of_domain["ar"][17] = "الموارد والأصول";
                $arr_list_of_domain["en"][17] = "resources & assets";
                $arr_list_of_domain["code"][17] = "sdd";
                
                
                $arr_list_of_domain["ar"][11] = "الإعلام والعلاقات العامة";
                $arr_list_of_domain["en"][11] = "Public Relations";
                $arr_list_of_domain["code"][11] = "MCC";
                
                
                $arr_list_of_domain["ar"][23] = "البحوث والدراسات";
                $arr_list_of_domain["en"][23] = "Research and Studies";
                $arr_list_of_domain["code"][23] = "enq_common";
                
                
                $arr_list_of_domain["ar"][6] = "التخطيط";
                $arr_list_of_domain["en"][6] = "Planning";
                $arr_list_of_domain["code"][6] = "PLANNING";
                
                
                $arr_list_of_domain["ar"][4] = "التدريب التقني";
                $arr_list_of_domain["en"][4] = "TVT";
                $arr_list_of_domain["code"][4] = "TVT";
                
                
                $arr_list_of_domain["ar"][20] = "التدريب الصيفي";
                $arr_list_of_domain["en"][20] = "summer training";
                $arr_list_of_domain["code"][20] = "SUMMER";
                
                
                $arr_list_of_domain["ar"][2] = "إدارة الطلاب والمدارس";
                $arr_list_of_domain["en"][2] = "education";
                $arr_list_of_domain["code"][2] = "SIS";
                
                
                $arr_list_of_domain["ar"][25] = "التسجيل والقبول";
                $arr_list_of_domain["en"][25] = "application & admission";
                $arr_list_of_domain["code"][25] = "adm";
                
                
                $arr_list_of_domain["ar"][8] = "الصحة";
                $arr_list_of_domain["en"][8] = "Health";
                $arr_list_of_domain["code"][8] = "HEALTH";
                
                
                $arr_list_of_domain["ar"][1] = "المجالات العامة";
                $arr_list_of_domain["en"][1] = "general";
                $arr_list_of_domain["code"][1] = "GENERAL";
                
                
                $arr_list_of_domain["ar"][21] = "المسابقات";
                $arr_list_of_domain["en"][21] = "Competitions";
                $arr_list_of_domain["code"][21] = "TALENT";
                
                
                $arr_list_of_domain["ar"][19] = "المناهج التعليمية";
                $arr_list_of_domain["en"][19] = "Studies programs";
                $arr_list_of_domain["code"][19] = "MANAHEJ";
                
                
                $arr_list_of_domain["ar"][10] = "الموارد البشرية";
                $arr_list_of_domain["en"][10] = "Human Ressource";
                $arr_list_of_domain["code"][10] = "HR";
                
                
                $arr_list_of_domain["ar"][7] = "الميزانية";
                $arr_list_of_domain["en"][7] = "Budget";
                $arr_list_of_domain["code"][7] = "BUDGET";
                
                
                $arr_list_of_domain["ar"][14] = "النقل والمواصلات";
                $arr_list_of_domain["en"][14] = "transportation";
                $arr_list_of_domain["code"][14] = "TRANSPORT";
                
                
                $arr_list_of_domain["ar"][16] = "تبادل الخبرات";
                $arr_list_of_domain["en"][16] = "share exp-self dev";
                $arr_list_of_domain["code"][16] = "ESD";
                
                
                $arr_list_of_domain["ar"][9] = "الصلاحيات على التطبيقات";
                $arr_list_of_domain["en"][9] = "IT-UMS";
                $arr_list_of_domain["code"][9] = "IT-UMS";
                
                
                $arr_list_of_domain["ar"][5] = "صيانة النظم";
                $arr_list_of_domain["en"][5] = "IT - system support";
                $arr_list_of_domain["code"][5] = "IT-SUPPORT";
                
                
                $arr_list_of_domain["ar"][13] = "خدمة العملاء";
                $arr_list_of_domain["en"][13] = "Customer service";
                $arr_list_of_domain["code"][13] = "CRM";
                
                
                $arr_list_of_domain["ar"][15] = "شركات الأسفار";
                $arr_list_of_domain["en"][15] = "Travel company";
                $arr_list_of_domain["code"][15] = "TRAVEL";
                
                
                $arr_list_of_domain["ar"][22] = "طباعة بطاقات الاشتراك";
                $arr_list_of_domain["en"][22] = "member cards print";
                $arr_list_of_domain["code"][22] = "card";

                
                return $arr_list_of_domain;
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