<?php

class AroleEnTranslator{
    public static function initData()
    {
        $trad = [];

		$trad["arole"]["arole.single"] = "Arole";
		$trad["arole"]["arole.new"] = "new";
		$trad["arole"]["arole"] = "Aroles";
		$trad["arole"]["id_valid"] = "Validated by";
		$trad["arole"]["date_valid"] = "Validated at";
		$trad["arole"]["titre_short"] = "Short title";
		$trad["arole"]["titre"] = "Title";
        // steps
		$trad["arole"]["step1"] = "step1";
		$trad["arole"]["step2"] = "step2";
		$trad["arole"]["step3"] = "step3";
		$trad["arole"]["step4"] = "step4";
		$trad["arole"]["step5"] = "step5";
		$trad["arole"]["step6"] = "step6";
        return $trad;
    }

    public static function getInstance()
	{
        if(false) return new AroleArTranslator();
		return new Arole();
	}
}