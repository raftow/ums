<?php


class ScenarioItem extends AFWObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= "scenario_item"; 
        
        public static $DB_STRUCTURE = null; 
        
        
        public function __construct(){
		parent::__construct("scenario_item","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 10;
                $this->DISPLAY_FIELD = "step_name_ar";
                $this->ORDER_BY_FIELDS = "atable_id,step_num, id";
                $this->UNIQUE_KEY = array('atable_id','step_num');
	}
        
        public static function loadById($id)
        {
           $obj = new ScenarioItem();
           $obj->select_visibilite_horizontale();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
 
        public static function loadByMainIndex($atable_id, $step_num, $step_name_ar, $create_obj_if_not_found=false)
        {
 
                if(!$atable_id) throw new AfwRuntimeException("loadByMainIndex : atable_id is mandatory field");
                if(!$step_num) throw new AfwRuntimeException("loadByMainIndex : step_num is mandatory field");
                if(!$step_name_ar) throw new AfwRuntimeException("loadByMainIndex : step_name_ar is mandatory field");

                $obj = new ScenarioItem();
                $obj->select("atable_id",$atable_id);
                $obj->select("step_num",$step_num);
        
                if($obj->load())
                {
                        $obj->set("step_name_ar",$step_name_ar);
                        if($create_obj_if_not_found) $obj->activate();
                        return $obj;
                }
                elseif($create_obj_if_not_found)
                {
                        $obj->set("atable_id",$atable_id);
                        $obj->set("step_num",$step_num);
                        $obj->set("step_name_ar",$step_name_ar);
        
                        $obj->insert();
                        $obj->is_new = true;
                        return $obj;
                }
                else return null;
 
        }
 
 
               
        
        public function getNextStepNum() 
        {
               
               $this->select("atable_id", $this->getVal("atable_id"));
               return $this->func("IF(ISNULL(max(step_num)), -1, max(step_num))+1");
        
        }
        
        public function beforeMAJ($id, $fields_updated) 
        {
                $objme = AfwSession::getUserConnected();
             
                if($this->getVal("step_num")=="") {
                        
                        $this->set("step_num",$this->getNextStepNum());
                }
                
		return true;
	}
        
        public function getPreviousStep()
        {
            $my_tab = $this->get("atable_id");
            return $my_tab->getStepBefore($this);
        }

        public function getNextStep()
        {
            $my_tab = $this->get("atable_id");
            return $my_tab->getStepAfter($this);
        }
        
        public function getRAMObjectData()
        {
                  $category_id = 9;

                  $type_id = 532;
                  
                  $code = "step".$this->getVal("step_num");
                  $name_ar = $this->getVal("step_name_ar");
                  $name_en = $this->getVal("step_name_en");
                  $specification = $this->getVal("help_text");
                  
                  $childs = array();
                  
                  return array($category_id, $type_id, $code, $name_ar, $name_en, $specification, $childs);
        
        } 

        public function fld_CREATION_USER_ID()
        {
                return "id_aut";
        }

        public function fld_CREATION_DATE()
        {
                return "date_aut";
        }

        public function fld_UPDATE_USER_ID()
        {
        	return "id_mod";
        }

        public function fld_UPDATE_DATE()
        {
        	return "date_mod";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
        	return "id_valid";
        }

        public function fld_VALIDATION_DATE()
        {
                return "date_valid";
        }
        
        public function fld_VERSION()
        {
        	return "version";
        }

        public function fld_ACTIVE()
        {
        	return  "avail";
        }
        
        public function isTechField($attribute) {
            return (($attribute=="id_aut") or ($attribute=="date_aut") or ($attribute=="id_mod") or ($attribute=="date_mod") or ($attribute=="id_valid") or ($attribute=="date_valid") or ($attribute=="version"));  
        }
        
        
}
?>