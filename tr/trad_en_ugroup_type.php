<?php

class UgroupTypeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["ugroup_type"]["ugrouptype.single"] = "User group type";
		$trad["ugroup_type"]["ugrouptype.new"] = "new";
		$trad["ugroup_type"]["ugroup_type"] = "User group types";
		
		$trad["ugroup_type"]["titre_short_ar"] = "Short title arabic";
        $trad["ugroup_type"]["titre_short_en"] = "Short title english";
        $trad["ugroup_type"]["lkp_code"] = "Code";
		// steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new UgroupTypeArTranslator();
		return new UgroupType();
	}
}