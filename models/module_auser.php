<?php
// create unique index uk_module_auser on module_auser(id_module,id_auser);
// delete from module_auser where id_module is null or id_module = 0;
// alter table  module_auser change id_module id_module int NOT NULL;
// update auser set date_aut='2000-01-01' where date_aut is null;
// alter table auser change id id bigint auto_increment;
// alter table  module_auser change id_auser id_auser bigint NOT NULL;


 
                
// old include of afw.php

class ModuleAuser extends AFWObject{

	public static $DATABASE		= ""; 
     public static $MODULE		    = "ums"; 
     public static $TABLE			= ""; 
     public static $DB_STRUCTURE = null; 
     
     
     
     public function __construct($tablename="module_auser"){
               parent::__construct($tablename,"id","ums");
               UmsModuleAuserAfwStructure::initInstance($this);
          }
          
          public function getDisplay($lang = 'ar')
          {
                    $fn = "صلاحيات ";
                    if(($this->getVal("id_auser")>0) and ($this->getVal("id_module")>0))
                    {
                         $fn .= trim($this->getUser()->getDisplay($lang)). " على ";
                         $fn .= trim($this->getModule()->getDisplay($lang));
                    }     
                    else
                         $fn .= "موظف";     
                    
                    
                    return $fn;
          }
          
          
          public static function virtualModuleAuser($id_module, $id_auser, $arole_mfk)
          {
               $obj = new ModuleAuser();
               $obj->set("id_module",$id_module);
               $obj->set("id_auser",$id_auser);
               $obj->set("arole_mfk",$arole_mfk);

               $obj->is_virtual = true;
               
               return $obj;
          }
          
          public static function loadByMainIndex($id_module, $id_auser,$create_obj_if_not_found=false)
          {
               if (!$id_module) throw new AfwRuntimeException("loadByMainIndex : id_module is mandatory field");
               if (!$id_auser)  throw new AfwRuntimeException("loadByMainIndex : id_auser is mandatory field");

               $obj = new ModuleAuser();
               $obj->select("id_module",$id_module);
               $obj->select("id_auser",$id_auser);

               if($obj->load())
               {
                    if($create_obj_if_not_found) $obj->activate();
                    return $obj;
               }
               elseif($create_obj_if_not_found)
               {
                    // die("failed to find id_module=$id_module and id_auser=$id_auser");
                    $obj->set("id_module",$id_module);
                    $obj->set("id_auser",$id_auser);

                    $obj->insert();
                    // die("inserted id_module=$id_module and id_auser=$id_auser");
                    $obj->is_new = true;
                    return $obj;
               }
               else return null;
               
          }
          
          public function beforeDelete($id,$id_replace) 
          {
               
     
               if($id)
               {   
                    if($id_replace==0)
                    {
                    $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - not deletable 
     
     
                    $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK part of me - deletable 
     
     
                    // FK not part of me - replaceable 
     
     
     
                    // MFK
     
                    }
                    else
                    {
                         $server_db_prefix = AfwSession::config("db_prefix","default_db_"); // FK on me 
     
     
                         // MFK
     
     
                    } 
                    return true;
               }    
          }

          public function calcRightsDiv()
          {
               $lang = AfwLanguageHelper::getGlobalLanguage();
               global $MODE_SQL_PROCESS_LOURD, $nb_queries_executed;
               $old_nb_queries_executed = $nb_queries_executed;
               $old_MODE_SQL_PROCESS_LOURD = $MODE_SQL_PROCESS_LOURD;
               $MODE_SQL_PROCESS_LOURD = true;

               $objme = AfwSession::getUserConnected();

               

               $userItem = $this->getUser();
               if(!$userItem) return "";
               $moduleItem = $this->getModule();
               if(!$moduleItem or !$moduleItem->id) return "";

               $moduleCode = $moduleItem->getVal("module_code");
               $tableList = $moduleItem->getAllMyTables(true);
               $myId = $this->id;

               $html = "<div class='mau-rights mau-on-$moduleCode'>";
               $html .= "<table class='grid' float='right' dir='rtl'>\n";

               $head = "";
               $head .= "<thead>\n";
               $head .= "<tr>\n";
               $head .= "  <th class='rtd tb'>الجدول</td>\n";
               $head .= "  <th class='rtd ed'>تعديل</td>\n";
               $head .= "  <th class='rtd vw'>مشاهدة</td>\n";
               $head .= "  <th class='rtd dl'>حذف</td>\n";
               $head .= "  <th class='rtd qe'>تعديل سريع</td>\n";
               $head .= "  <th class='rtd qs'>بحث سريع</td>\n";
               $head .= "</tr>\n";
               $head .= "</thead>\n";

               $html .= $head;

               $checked_picture = "<img src='../lib/images/on-blue.png'>";
               $cl = "item";
               $rows = 0;
               foreach($tableList as $tableItem)
               {
                    
                    $tableId = $tableItem->id;
                    $tableName = $tableItem->getDisplay($lang);
                    $tableCode = $tableItem->getVal("atable_name");

                    $tableEdit = $userItem->iCanDoOperation($moduleCode, $tableCode, "edit", true) ? $checked_picture : ""; // $moduleCode, $tableCode, no edit
                    $tableView = $userItem->iCanDoOperation($moduleCode, $tableCode, "display", true) ? $checked_picture : "";
                    $tableDelete = $userItem->iCanDoOperation($moduleCode, $tableCode, "delete", true) ? $checked_picture : "";
                    $tableQEdit = $userItem->iCanDoOperation($moduleCode, $tableCode, "qedit", true) ? $checked_picture : "";
                    $tableQSearch = $userItem->iCanDoOperation($moduleCode, $tableCode, "qsearch", true) ? $checked_picture : "";

                    if($tableEdit or $tableView or $tableDelete or $tableQEdit or $tableQSearch)
                    {
                         $html .= "<tr class='$cl tb-$tableId'>\n";
                         $html .= "  <td class='rtd tb'>$tableName</td>\n";
                         $html .= "  <td class='rtd ed'>$tableEdit</td>\n";
                         $html .= "  <td class='rtd vw'>$tableView</td>\n";
                         $html .= "  <td class='rtd dl'>$tableDelete</td>\n";
                         $html .= "  <td class='rtd qe'>$tableQEdit</td>\n";
                         $html .= "  <td class='rtd qs'>$tableQSearch</td>\n";
                         $html .= "</tr>\n";
                         if($cl == "item") $cl = "altitem";
                         else $cl = "item";
     
                         $rows++;
                    }
                    
                    if($rows==10)
                    {
                         $html .= $head;
                         $rows = 0;
                    }
               }
               $html .= "</table>";
               $html .= "</div>";

               $MODE_SQL_PROCESS_LOURD = $old_MODE_SQL_PROCESS_LOURD;
               $nb_queries_executed = $old_nb_queries_executed;

               return $html;

          }

          public function myShortNameToAttributeName($attribute){
               if($attribute=="user") return "id_auser";
               if($attribute=="module") return "id_module";
               if($attribute=="roles") return "arole_mfk";
               return $attribute;
          }
}
?>