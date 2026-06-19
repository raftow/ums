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

                $trad["arole"]["arole.single"] = "مجموعة";
                $trad["arole"]["arole.new"] = "جديدة";
                $trad["arole"]["arole"] = "المجموعات";
                // obsolete $trad["arole"]["bfunction_mfk"] = "ما في القائمة من وظائف خاصة (غير الكرود)";
                $trad["arole"]["childList"] = "المجموعات الفرعية";
                $trad["arole"]["rbfList"] = "الوظائف الفرعية المعروضة في القائمة";
                $trad["arole"]["all_rbfList"] = "جميع الوظائف الفرعية";
                $trad["arole"]["userStoryList"] = "قصص المستخدم";

                // $trad["arole"]["arole_mfk"] = "مجموعات الخدمات الفرعية";
                $trad["arole"]["parent_arole_id"] = "المجموعة الأم";

                $trad["arole"]["auser_mfk"] = "من ينتفع بهذه المجموعة";
                $trad["arole"]["jobAroleList"] = "المسؤليات التي تستخدم هذه المجموعة";

                $trad["arole"]["arole_type_id"] = "نوع المجموعة";
                $trad["arole"]["role_code"] = "رمز المجموعة";

                $trad["arole"]["childListCount"] = "عدد المجموعات الفرعية";
                $trad["arole"]["all_rbfListCount"] = "عدد الوظائف الفرعية";

                return $trad;
        }

        public static function getInstance()
        {
                if (false) return new AroleEnTranslator();
                return new Arole();
        }
}
