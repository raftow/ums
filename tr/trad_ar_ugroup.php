<?php

class UgroupArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["ugroup"]["ugroup.single"] = "مجموعة مستخدمين";
		$trad["ugroup"]["ugroup.new"] = "جديدة";
		$trad["ugroup"]["ugroup"] = "مجموعات المستخدمين";
		$trad["ugroup"]["titre_short_ar"] = "المسمى المختصر بالعربية";
		$trad["ugroup"]["titre_short_en"] = "المسمى المختصر بالانجليزية";
		$trad["ugroup"]["module_id"] = "التطبيق";
		$trad["ugroup"]["ugroup_type_id"] = "نوع المجموعة";
		$trad["ugroup"]["ugroup_scope_id"] = "مجال المجموعة";
		$trad["ugroup"]["definition"] = "التعريف الفني";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new UgroupEnTranslator();
		return new Ugroup();
	}
}
	
?>