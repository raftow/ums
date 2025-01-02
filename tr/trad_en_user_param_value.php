<?php

class UserParamValueEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["user_param_value"]["userparamvalue.single"] = "User param value";
		$trad["user_param_value"]["userparamvalue.new"] = "new";
		$trad["user_param_value"]["user_param_value"] = "User param values";
		$trad["user_param_value"]["avail"] = "Active";
		$trad["user_param_value"]["value"] = "???? ???????";
        // steps
		$trad["user_param_value"]["step1"] = "step1";
		$trad["user_param_value"]["step2"] = "step2";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new UserParamValueArTranslator();
		return new UserParamValue();
	}
}