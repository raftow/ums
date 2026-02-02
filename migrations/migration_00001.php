<?php
if (!class_exists("AfwSession")) die("Denied access");
$server_db_prefix = AfwSession::currentDBPrefix();


// 2/2/2026
// alter table ttc_ums.ugroup add module_id int(11) not null default 0;

// 8/1/2026
// update bfunction set hierarchy_level_enum = 999 where bfunction_code like '%/display%';
// update bfunction set hierarchy_level_enum = 999 where bfunction_code like '%/qsearch%';

/*
alter table ttc_ums.module change id_analyst id_analyst int null;
Query OK, 98 rows affected (0.04 sec)
Records: 98  Duplicates: 0  Warnings: 0

alter table ttc_ums.module change id_pm id_pm int null;
Query OK, 98 rows affected (0.03 sec)
Records: 98  Duplicates: 0  Warnings: 0

alter table ttc_ums.module change id_hd id_hd int null;
Query OK, 98 rows affected (0.03 sec)
Records: 98  Duplicates: 0  Warnings: 0

alter table ttc_ums.module change id_br id_br int null;
Query OK, 98 rows affected (0.04 sec)
Records: 98  Duplicates: 0  Warnings: 0

alter table ttc_ums.module change id_main_sh id_main_sh int null;
Query OK, 98 rows affected (0.04 sec)
Records: 98  Duplicates: 0  Warnings: 0

alter table ttc_ums.module change id_module_type id_module_type smallint null;
Query OK, 98 rows affected (0.05 sec)
Records: 98  Duplicates: 0  Warnings: 0

alter table ttc_ums.module change id_module_parent id_module_parent int null;
Query OK, 98 rows affected (0.03 sec)
Records: 98  Duplicates: 0  Warnings: 0

alter table ttc_ums.module change id_module_status id_module_status int null;
*/


AfwDatabase::db_query("DROP TABLE IF EXISTS " . $server_db_prefix . "ums.user_param");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS " . $server_db_prefix . "ums.`user_param` (
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
AfwDatabase::db_query("CREATE unique index uk_user_param on " . $server_db_prefix . "ums.user_param(aparameter_name_ar,aparameter_name_en,aparam_use_scope_id,customizable,afield_type_id,answer_table_id,measurement_unit_ar,measurement_unit_en,avail,id_aut,date_aut,id_mod,date_mod,id_valid,date_valid)");



AfwDatabase::db_query("DROP TABLE IF EXISTS " . $server_db_prefix . "ums.user_param_value");

AfwDatabase::db_query("CREATE TABLE IF NOT EXISTS " . $server_db_prefix . "ums.`user_param_value` (
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
AfwDatabase::db_query("CREATE unique index uk_user_param_value on " . $server_db_prefix . "ums.user_param_value(user_param_id,company_orgunit_id,department_orgunit_id,division_orgunit_id,employee_id)");


/*
create table tmp_dup_afile as select original_name,afile_size,owner_id,stakeholder_id, count(*) as nb, max(id) as keep_id from afile group by original_name,afile_size,owner_id,stakeholder_id having count(*)>1;

delete from afile where original_name in (select original_name from tmp_dup_afile) and id not in (select keep_id from tmp_dup_afile);                                                   Query OK, 354 rows affected (0.37 sec)

create unique index uk_afile on ttc_ums.afile(original_name,afile_size,owner_id,stakeholder_id);
*/
