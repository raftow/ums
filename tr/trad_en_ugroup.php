<?php

class UgroupEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["ugroup"]["ugroup.single"] = "Ugroup";
		$trad["ugroup"]["ugroup.new"] = "new";
		$trad["ugroup"]["ugroup"] = "Ugroups";
		$trad["ugroup"]["titre_short_ar"] = "Short title arabic";
        $trad["ugroup"]["titre_short_en"] = "Short title english";
        $trad["ugroup"]["module_id"] = "Application";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new UgroupArTranslator();
		return new Ugroup();
	}
}