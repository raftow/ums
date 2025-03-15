<?php
$objme = AfwSession::getUserConnected();
if($objme)
{
    $out_scr .= "<div class=\"qfilter col-sm-10 col-md-10 pb10\"><h1>معلومات المستخدم والصلاحيات</h1></div>";
    $out_scr .= AfwShowHelper::showMinibox($objme);
    $myEmplObj = $objme->getEmployee();
    if($myEmplObj)
    {
        $myEmplId = $myEmplObj->getId();
    
        if(!$myEmplId) $out_scr .= "No employee attached to this user account<br>";        
        else 
        {
            $out_scr .= "<div class=\"qfilter col-sm-10 col-md-10 pb10\"><h1>معلومات الموظف</h1></div>";
            $out_scr .= AfwShowHelper::showMinibox($myEmplObj);
        }
    }
    else $out_scr .= "No employee is attached to this user account";
}
else $out_scr .= "Your session is termintated. Please login again ...";
