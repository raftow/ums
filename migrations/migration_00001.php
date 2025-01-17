<?php
if(!class_exists("AfwSession")) die("Denied access");
$server_db_prefix = AfwSession::config("db_prefix", "default_db_");


AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."ums.user_param");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."ums.`user_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aut` int(11) NOT NULL,
  `date_aut`   datetime NOT NULL,
  `id_mod` int(11) NOT NULL,
  `date_mod` datetime NOT NULL,
  `id_valid` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `avail` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   aparameter_name_ar varchar(64)  DEFAULT NULL , 
   aparameter_name_en varchar(64)  DEFAULT NULL , 
   aparam_use_scope_id smallint DEFAULT NULL , 
   customizable char(1) DEFAULT NULL , 
   afield_type_id smallint DEFAULT NULL , 
   answer_table_id smallint DEFAULT NULL , 
   measurement_unit_ar varchar(32)  DEFAULT NULL , 
   measurement_unit_en varchar(32)  DEFAULT NULL , 
   avail char(1) DEFAULT NULL , 
   id_aut int(11) DEFAULT NULL , 
   date_aut datetime DEFAULT NULL , 
   id_mod int(11) DEFAULT NULL , 
   date_mod datetime DEFAULT NULL , 
   id_valid int(11) DEFAULT NULL , 
   date_valid datetime DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1");



// unique index : 
AfwDatabase::db_query("CREATE unique index uk_user_param on ".$server_db_prefix."ums.user_param(aparameter_name_ar,aparameter_name_en,aparam_use_scope_id,customizable,afield_type_id,answer_table_id,measurement_unit_ar,measurement_unit_en,avail,id_aut,date_aut,id_mod,date_mod,id_valid,date_valid)");



AfwDatabase::db_query("DROP TABLE IF EXISTS ".$server_db_prefix."ums.user_param_value");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS ".$server_db_prefix."ums.`user_param_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aut` int(11) NOT NULL,
  `date_aut`   datetime NOT NULL,
  `id_mod` int(11) NOT NULL,
  `date_mod` datetime NOT NULL,
  `id_valid` int(11) DEFAULT NULL,
  `date_valid` datetime DEFAULT NULL,
  `avail` char(1) NOT NULL,
  `draft` char(1) NOT NULL default 'Y',
  `version` int(4) DEFAULT NULL,
  `update_groups_mfk` varchar(255) DEFAULT NULL,
  `delete_groups_mfk` varchar(255) DEFAULT NULL,
  `display_groups_mfk` varchar(255) DEFAULT NULL,
  `sci_id` int(11) DEFAULT NULL,
  
    
   user_param_id int(11) NOT NULL , 
   company_orgunit_id int(11) DEFAULT NULL , 
   department_orgunit_id int(11) DEFAULT NULL , 
   division_orgunit_id int(11) DEFAULT NULL , 
   employee_id int(11) DEFAULT NULL , 
   avail char(1) DEFAULT NULL , 
   value varchar(255)  NOT NULL , 
   id_aut int(11) DEFAULT NULL , 
   date_aut datetime DEFAULT NULL , 
   id_mod int(11) DEFAULT NULL , 
   date_mod datetime DEFAULT NULL , 
   id_valid int(11) DEFAULT NULL , 
   date_valid datetime DEFAULT NULL , 

  
  PRIMARY KEY (`id`)
) ENGINE=innodb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci AUTO_INCREMENT=1");


 
// unique index : 
AfwDatabase::db_query("CREATE unique index uk_user_param_value on ".$server_db_prefix."ums.user_param_value(user_param_id,company_orgunit_id,department_orgunit_id,division_orgunit_id,employee_id)");


