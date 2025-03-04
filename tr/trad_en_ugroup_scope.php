<?php

class UgroupScopeEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["ugroup_scope"]["ugroupscope.single"] = "Ugroup scope";
		$trad["ugroup_scope"]["ugroupscope.new"] = "new";
		$trad["ugroup_scope"]["ugroup_scope"] = "Ugroup scopes";
        // steps
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new UgroupScopeArTranslator();
		return new UgroupScope();
	}
}