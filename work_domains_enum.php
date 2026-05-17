<?php
AfwAutoLoader::addModule("p"."ag");
$out_scr = "<pre class=\"php\">";
$allDomains = Domain::loadAllLookupObjects();
//die("allDomains=".var_export($allDomains,true));
foreach($allDomains as $domainObj)
{
    $domain_id = $domainObj->id;
    $domain_code = $domainObj->getVal("domain_code");
    $domain_name_ar = $domainObj->getVal("short_name_ar");
    $domain_name_en = $domainObj->getVal("short_name_en");

    //die("domain_name_ar=$domain_name_ar domainObj=".var_export($domainObj,true));

    $out_scr .= "
    \$arr_list_of_domain[\"ar\"][$domain_id] = \"$domain_name_ar\";
    \$arr_list_of_domain[\"en\"][$domain_id] = \"$domain_name_en\";
    \$arr_list_of_domain[\"code\"][$domain_id] = \"$domain_code\";
    
    ";
   
}
$out_scr .= "</pre>";

