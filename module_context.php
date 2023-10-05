<?php
        $contextLabel = array("ar"=>"إختيار  النظام","fr"=>"choix du systeme","en"=>"system choice");

        $contextShortLabel = array("ar"=>"", "fr"=>"","en"=>""); 
        
             
        $contextList = array();
     
        
     
        $modul = new Module();
        $modul->where("id_module_type in (4,7)");
        $modul->select("avail","Y");
     
        $modul_list = $modul->loadMany();
        
        foreach($modul_list as $modul_item)
        {
              if($modul_item->getId()>0)
              {
                   $contextList[$modul_item->getId()] = $modul_item;
              }
        }
      
        return $contextList;
?>