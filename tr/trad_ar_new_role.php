<?php

class NewRoleArTranslator
{
	public static function initData()
	{
		$trad = [];

		$trad["new_role"]["newrole.single"] = "طلب صلاحية";
		$trad["new_role"]["newrole.new"] = "جديد";
		$trad["new_role"]["new_role"] = "طلبات الصلاحيات";
		$trad["new_role"]["system_id"] = "النظام";
		$trad["new_role"]["module_id"] = "التطبيق";
		$trad["new_role"]["new_role_code"] = "رمز الصلاحية";
		$trad["new_role"]["domain_id"] = "قطاع الأعمال";
		$trad["new_role"]["jobrole_id"] = "المسؤولية الوظيفية";
		$trad["new_role"]["new_role_name_ar"] = "مسمى الصلاحية";
		$trad["new_role"]["new_role_desc_ar"] = "جملة وصف الصلاحية";
		$trad["new_role"]["new_role_name_en"] = "مسمى الصلاحية بالانجليزي";
		$trad["new_role"]["new_role_desc_en"] = "وصف الصلاحية بالانجليزي";
		$trad["new_role"]["new_role_html_ar"] = "تحرير الصلاحية";
		$trad["new_role"]["new_role_html_en"] = "تحرير الصلاحية بالانجليزي";
		$trad["new_role"]["atable_mfk"] = "الكيانات المستعملة";
		$trad["new_role"]["settings"] = "إعدادات الاستثناءات";		
		$trad["new_role"]["divResults"] = "نتائج تنفيذ الطلب";


		$trad["new_role"]["step2"] = "المسميات";
		$trad["new_role"]["step3"] = "الإعدادات";
		$trad["new_role"]["step4"] = "النتائج";
		
		

		// steps
		return $trad;
	}

	public static function getInstance()
	{
		if (false) return new NewRoleEnTranslator();
		return new NewRole();
	}
}
