<?php

class AroleArTranslator
{
        public static function initData()
        {
                $trad = [];
                $trad["arole"]["step1"] = "البيانات الأساسية";
                $trad["arole"]["step2"] = "البيانات التكميلية";
                $trad["arole"]["step3"] = "الصلاحيات الفرعية";
                $trad["arole"]["step4"] = "الوظائف الفرعية";
                $trad["arole"]["step5"] = "قصص المستخدم";
                $trad["arole"]["step6"] = "الانتفاع بها";

                $trad["arole"]["titre"] = "وصف الصلاحية";
                $trad["arole"]["titre_short"] = "مسمى الصلاحية";
                $trad["arole"]["titre_en"] = "الوصف بالانجليزي";
                $trad["arole"]["titre_short_en"] = "المسمى بالانجليزي";
                $trad["arole"]["system_id"] = "النظام";
                $trad["arole"]["module_id"] = "التطبيق";
                $trad["arole"]["arole.single"] = "صلاحية";
                $trad["arole"]["arole.new"] = "جديدة";
                $trad["arole"]["arole"] = "الصلاحيات";
                // obsolete $trad["arole"]["bfunction_mfk"] = "ما في القائمة من وظائف خاصة (غير الكرود)";
                $trad["arole"]["childList"] = "الصلاحيات الفرعية";
                $trad["arole"]["rbfList"] = "الوظائف الفرعية المعروضة في القائمة";
                $trad["arole"]["all_rbfList"] = "جميع الوظائف الفرعية";
                $trad["arole"]["userStoryList"] = "قصص المستخدم";

                // $trad["arole"]["arole_mfk"] = "مجموعات الخدمات الفرعية";
                $trad["arole"]["parent_arole_id"] = "الصلاحية الأم";

                $trad["arole"]["auser_mfk"] = "من ينتفع بهذه الصلاحية";

                $trad["arole"]["arole_type_id"] = "نوع الصلاحية";
                $trad["arole"]["role_code"] = "رمز الصلاحية";

                $trad["arole"]["childListCount"] = "عدد الصلاحيات الفرعية";
                $trad["arole"]["all_rbfListCount"] = "عدد الوظائف الفرعية";

                return $trad;
        }

        public static function getInstance()
        {
                if (false) return new AroleEnTranslator();
                return new Arole();
        }
}
