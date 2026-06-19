<?php

	$role_info[390] = array (
  'code' => 'goal-files',
  'name' => 
  array (
    'ar' => 'إدارة المرفقات',
    'en' => 'arole.390',
  ),
  'menu' => 
  array (
    'need_admin' => false,
    'id' => '390',
    'menu_name_ar' => 'إدارة المرفقات',
    'menu_name_en' => 'arole.390',
    'page' => 'main.php?Main_Page=fm.php&a=18&r=390',
    'css' => 'info',
    'icon' => ' icon-390',
    'showme' => true,
    'items' => 
    array (
      104940 => 
      array (
        'id' => '104940',
        'code' => 'f2-a-afile/qsearch',
        'level' => '1',
        'menu_name_ar' => 'الملفات',
        'menu_name_en' => 'Afiles',
        'page' => 'main.php?Main_Page=afw_mode_qsearch.php&cl=Afile&currmod=ums',
        'css' => 'bf',
        'icon' => 'bficon-104940 bfc-',
      ),
    ),
    'otherbfs' => 
    array (
      104935 => 
      array (
        'id' => '104935',
        'code' => 'f2-a-afile/edit',
        'level' => '1',
        'menu_name_ar' => 'إنشاء ملف',
        'menu_name_en' => 'create Afile',
        'page' => 'main.php?Main_Page=afw_mode_edit.php&cl=Afile&currmod=ums',
        'css' => 'bf',
        'icon' => 'bficon-104935 bfc-',
      ),
      104937 => 
      array (
        'id' => '104937',
        'code' => 'f2-a-afile/delete',
        'level' => '1',
        'menu_name_ar' => 'مسح ملف',
        'menu_name_en' => 'delete Afile',
        'page' => 'main.php?Main_Page=afw_mode_delete.php&cl=Afile&currmod=ums',
        'css' => 'bf',
        'icon' => 'bficon-104937 bfc-',
      ),
      104938 => 
      array (
        'id' => '104938',
        'code' => 'f2-a-afile/display',
        'level' => '1',
        'menu_name_ar' => 'عرض تفاصيل ملف',
        'menu_name_en' => 'display details of Afile',
        'page' => 'main.php?Main_Page=afw_mode_display.php&cl=Afile&currmod=ums',
        'css' => 'bf',
        'icon' => 'bficon-104938 bfc-',
      ),
      104939 => 
      array (
        'id' => '104939',
        'code' => 'f2-a-afile/search',
        'level' => '1',
        'menu_name_ar' => 'البحث في الملفات',
        'menu_name_en' => 'Afiles search',
        'page' => 'main.php?Main_Page=afw_mode_search.php&cl=Afile&currmod=ums',
        'css' => 'bf',
        'icon' => 'bficon-104939 bfc-',
      ),
      104940 => 
      array (
        'id' => '104940',
        'code' => 'f2-a-afile/qsearch',
        'level' => '1',
        'menu_name_ar' => 'الملفات',
        'menu_name_en' => 'Afiles',
        'page' => 'main.php?Main_Page=afw_mode_qsearch.php&cl=Afile&currmod=ums',
        'css' => 'bf',
        'icon' => 'bficon-104940 bfc-',
      ),
    ),
    'sub-folders' => 
    array (
    ),
  ),
);
	include "previleges_ums_role390_special.php";