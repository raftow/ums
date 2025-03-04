<?php

class UgroupTypeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["ugroup_type"]["ugrouptype.single"] = "نوع مجموعة مستخدمين";
		$trad["ugroup_type"]["ugrouptype.new"] = "جديد";
		$trad["ugroup_type"]["ugroup_type"] = "أنواع مجموعات المستخدمين";
		$trad["ugroup_type"]["lkp_code"] = "الرمز";
		$trad["ugroup_type"]["titre_short_ar"] = "المسمى المختصر بالعربية";
		$trad["ugroup_type"]["titre_short_en"] = "المسمى المختصر بالانجليزية";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new UgroupTypeEnTranslator();
		return new UgroupType();
	}
}