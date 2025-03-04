<?php

class UgroupScopeArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["ugroup_scope"]["ugroupscope.single"] = "مجال مجموعة مستخدمين";
		$trad["ugroup_scope"]["ugroupscope.new"] = "جديد(ة)";
		$trad["ugroup_scope"]["ugroup_scope"] = "مجالات مجموعات المستخدمين";
		$trad["ugroup_scope"]["titre_short_ar"] = "المسمى المختصر بالعربية";
		$trad["ugroup_scope"]["titre_short_en"] = "المسمى المختصر بالانجليزية";
		$trad["ugroup_scope"]["ugroup_scope_fn"] = "كود مجال المجموعة";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new UgroupScopeEnTranslator();
		return new UgroupScope();
	}
}