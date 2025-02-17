<?php
$hierarchy_level = [];

if($current_domain == 25) // admission
{
    $hierarchy_level[100]=['ar'=> 'مدير قبول', 'en'=> 'Admission director'];
    $hierarchy_level[400]=['ar'=> 'مشرف قبول', 'en'=> 'Admission supervisor'];
    $hierarchy_level[800]=['ar'=> 'موظف قبول', 'en'=> 'Admission employee'];
    $hierarchy_level[999]=['ar'=> 'موظف مراجعة وثائق', 'en'=> 'Document review employee'];
}

