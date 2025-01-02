<?php

class UserParamValueArTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["user_param_value"]["userparamvalue.single"] = "User param value";
		$trad["user_param_value"]["userparamvalue.new"] = "جديد(ة)";
		$trad["user_param_value"]["user_param_value"] = "User param values";
		$trad["user_param_value"]["user_param_id"] = "قيمة المعلمة";
		$trad["user_param_value"]["company_orgunit_id"] = "المنشأة/فرع";
		$trad["user_param_value"]["department_orgunit_id"] = "المنشأة/فرع";
		$trad["user_param_value"]["division_orgunit_id"] = "المنشأة/فرع";
		$trad["user_param_value"]["employee_id"] = "الemployee.single";
		$trad["user_param_value"]["avail"] = "نشط";
		$trad["user_param_value"]["value"] = "قيمة التخصيص";
        // steps
		$trad["user_param_value"]["step1"] = "step1";
		$trad["user_param_value"]["step2"] = "step2";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new UserParamValueEnTranslator();
		return new UserParamValue();
	}
}