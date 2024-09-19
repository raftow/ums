<?php
// ------------------------------------------------------------------------------------
// mysql> alter table c0ums.city change  id_valid id_valid int NULL;
// mysql> alter table c0ums.city change date_valid date_valid datetime NULL;

// for cities without symbol we take same symbol as nearest city 
// في حال عدم وجود مدينتكم في القائمة أدناه نرجو تكرمكم بتعيين المدينة الأقرب، حيث ان الهدف من ذلك هو تحديد فرع الوزارة الذي يخدم هذه المدينة.
// مثال: مدينة الخبر تتبع منطقة الشرقية الفرع الأقرب لها فرع الوزارة بالدمام يتم تعيين مدينة الدمام
// MariaDB [c0license]> create table c0ums.tmp_city as select * from c0ums.city;
// MariaDB [c0license]> update c0ums.city c set symbol = (select min(symbol) from c0ums.tmp_city c2 where c2.region_id = c.region_id) where symbol is null;
// alter table c0ums.city add unique index ui(lookup_code);
// alter table c0ums.city add moe_code varchar(10);
                
$file_dir_name = dirname(__FILE__); 
                
// old include of afw.php

class City extends AFWObject{

        public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null;
	
	public function __construct(){
		parent::__construct("city","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 15;
                $this->DISPLAY_FIELD = "city_name";
                $this->ORDER_BY_FIELDS = "city_name";
                $this->enableOtherSearch = true;
                $this->IS_LOOKUP = true; 
                $this->ignore_insert_doublon = true;
                $this->UNIQUE_KEY = array('lookup_code');
                $this->public_display = true;
                /*
                $btr_html = _back_trace();
                global $city_construcotr_counter;
                if(!$city_construcotr_counter) $city_construcotr_counter = 0;
                $city_construcotr_counter++;
                AfwSession::logHzm("", "city", "city::construcotr[$city_construcotr_counter] : <br>".$btr_html);
                */
	}
        /*
        public function instanciated($numInstance)
        {
             AfwSession::logHzm("", "city", "city::instanciated[$numInstance]");
             return true;
        }
        */

        public static function loadAll($country_id=0, $where="")
        {
           $obj = new City();
           $obj->select("avail",'Y');
           if($country_id) $obj->select("country_id",$country_id);
           if($where) $obj->where($where);
 
           $objList = $obj->loadMany();
 
           return $objList;
        }

        public static function loadById($id)
        {
           $obj = new City();
           if($obj->load($id))
           {
                return $obj;
           }
           else return null;
        }
        
        public static function findCity($lookup_code, $city_name, $region_id, $find_only_by_name=false)
        {
           $obj = new City();
           if(!$city_name) throw new AfwRuntimeException("loadByMainIndex : city_name is mandatory field");
 
           $obj->select("city_name",$city_name);     
           if($obj->load())
           {
                if($lookup_code) $obj->set("lookup_code",$lookup_code);
                if($region_id) $obj->set("region_id",$region_id);
                $obj->activate();
                return $obj;
           }

           if($find_only_by_name) return null;

           if(!$lookup_code) throw new AfwRuntimeException("loadByMainIndex : lookup_code is mandatory field [$lookup_code/$city_name/$region_id]");
           if(!$region_id) throw new AfwRuntimeException("loadByMainIndex : region_id is mandatory field");

           unset($obj);
           $obj = new City();
           $obj->select("lookup_code",$lookup_code);
 
           if($obj->load())
           {
                $obj->set("city_name",$city_name);
                $obj->set("region_id",$region_id);
                $obj->activate();
                return $obj;
           }
           else
           {
                $obj->set("lookup_code",$lookup_code);
                $obj->set("city_name",$city_name);
                $obj->set("region_id",$region_id);
                $obj->insert();
                $obj->is_new = true;
                return $obj;
           }
 
        }
        
        public function fld_CREATION_USER_ID()
        {
                return  "id_aut";
        }

        public function fld_CREATION_DATE()
        {
                return  "date_aut";
        }

        public function fld_UPDATE_USER_ID()
        {
                return  "id_mod";
        }

        public function fld_UPDATE_DATE()
        {
                return  "date_mod";
        }
        
        public function fld_VALIDATION_USER_ID()
        {
                return  "id_valid";
        }

        public function fld_VALIDATION_DATE()
        {
                return  "date_valid";
        }
        
        public function fld_VERSION()
        {
                return  "version";
        }

        public function fld_ACTIVE()
        {
                return  "avail";
        }

        public function getMyPicture()
        {
               return "cities/".$this->symbol.".png"; 
        }

        public static function findCityIdFromListOfNames($city_name_arr, $activate_if_found=false)
        {
                $obj = new City();
                $where_arr = [];
                foreach($city_name_arr as $city_name)
                {
                        $where_arr[] = "city_name = _utf8'$city_name'";
                        $where_arr[] = "city_name_en = _utf8'$city_name'";
                }
                
                $where_imploded = "(".implode(" or ", $where_arr).")";
                $obj->where($where_imploded);           

                if($obj->load())
                {
                        if($activate_if_found) $obj->activate();
                        return $obj->id;
                }


                return 0;
        }

        public static function getCityIdFromName($string)
        {
                global $CITY_ARR;
                if (!$CITY_ARR) $CITY_ARR = array();
                
                if ($CITY_ARR[$string]) {
                        $obj_id = $CITY_ARR[$string];
                        $obj_new = false;
                } else {
                        $obj = City::findCity($lookup_code = null, $string, $region_id = null, $find_only_by_name = true);
                        if (!$obj) $obj_id = 0;
                        else $obj_id = $obj->id;
                        unset($obj);
                }

                if(!$obj_id)
                {
                        // search for similar arabic words
                        $string_arr = AfwStringHelper::similarArabicWords($string);
                        $obj_id = City::findCityIdFromListOfNames($string_arr);
                }
                else
                {
                        $string_arr = [];
                        $string_arr[] = $string;
                }
                
                if($obj_id)
                {
                        $CITY_ARR[$string] = $obj_id;                        
                }
                
                return array($obj_id, $string_arr);
        }


        public function beforeDelete($id,$id_replace) 
        {
                return true;
        }
}
