<?php
// rafik 7/7/21 :
// ALTER TABLE `afile` CHANGE `afile_size` `afile_size` INT(16) NULL DEFAULT NULL; 
// ALTER TABLE `afile` CHANGE `original_name` `original_name` varchar(255); 
// ALTER TABLE `afile` CHANGE `afile_name` `afile_name` varchar(255);


                
// old include of afw.php

class Afile extends AFWObject{

	public static $DATABASE		= ""; 
        public static $MODULE		    = "ums"; 
        public static $TABLE			= ""; 
        public static $DB_STRUCTURE = null; 
        
        public function __construct(){
		parent::__construct("afile","id","ums");
                $this->QEDIT_MODE_NEW_OBJECTS_DEFAULT_NUMBER = 0;
		$this->DISPLAY_FIELD = "afile_name";
                $this->ORDER_BY_FIELDS = "date_aut desc";
                $this->showQeditErrors = true;
                //$this->qedit_minibox = true;
                $this->ENABLE_DISPLAY_MODE_IN_QEDIT = true;
	}
        
        public function getWideDisplay($lang="ar") 
        {
                /*if(!$this->isActive()) $suffix = " (تم التعطيل)";
                else 
                */
                $suffix = "<br>";
                $prefix = "<br>&nbsp;&nbsp;&nbsp;&nbsp;";
                $separator = "<br><br>";
                
                return $prefix. $this->valName() . $separator . $this->valPic_view(). $suffix;   
	}

        public function getDisplay($lang="ar") 
        {
                
                return $this->pictureView("width: auto;height:auto;");   
	}
        
        
        public function getShortDisplay($lang="ar") 
        {
                if(!$this->isActive()) $suffix = "  --             غير مغعل";
                else
                $suffix = "";//" ()".$this->valDownload();
                
                return $this->valName(). $suffix;   
	}
        
        public function getRetrieveDisplay($lang="ar") 
        {
                if(!$this->isActive()) $suffix = "  --             غير مغعل";
                else
                  $suffix = "<br>".$this->valDownload();
                
                return $this->valName(). $suffix;   
	}
        
        /*
        protected function getOtherLinksArray($mode, $genereLog = false, $step="all")      
        {
             $objme = AfwSession::getUserConnected();
             $me = ($objme) ? $objme->id : 0;
           
             
             $otherLinksArray = $this->getOtherLinksArrayStandard($mode, false, $step);  
             if($this->valowner_id()==$me)
             {
                           unset($link);
                           $afile_id = $this->getId();
                           $link = array();
             }
             return $otherLinksArray;          
        }
        */
        
        public function __toString() 
        {
                return $this->getDisplay(). " - " .$this->valOriginal(); //. " (".$this->valSize().")";   
	}
        
        public function getFileHCode() 
        {
               $afile_ext = $this->getVal("afile_ext");
               $afile_size = $this->getVal("afile_size");
               $original_name = $this->getVal("original_name");
               $fhcode = substr(md5($original_name),0,5);
               //die("afile_ext=$afile_ext, afile_size=$afile_size, getFileHCode=".$fhcode);
               return $fhcode; 
        }
        
        public function getNewName() 
        {
             $new_name_prefix = $this->getVal("stakeholder_id")."_".$this->getVal("owner_id");
             if($new_name_prefix == "_") $new_name_prefix = "customer";
             return $new_name_prefix."_".$this->getId()."_".$this->getFileHCode().".".$this->getVal("afile_ext");
	}

        public function getFileHttpPath($relative_path="") 
        {
            
            if(!$relative_path) $relative_path = AfwSession::config("uploads_http_path","");
            
            if($this->getVal("doc_type_id")==9)
                 return $relative_path."/imports";
            else             
                 return $relative_path;
	}
        
        
        
        public function getFormuleResult($attribute, $what='value') 
        {
                $upld_path = AfwSession::config("uploads_http_path",""); 
               
	       switch($attribute) 
               {
                    
                    case "pic_view" :
                            return $this->pictureView();
                             
                    break;
                    case "preview" :
                            return $this->previewMe(0,1000);
                             
                    break;
                    
                    
                    case "afile_date" :
                            list($greg_date,$greg_time) = explode(" ",$this->valdate_aut());
                            return AfwDateHelper::gregToHijri($greg_date);
                             
                    break;
                    
                    case "afile_time" :
                            list($greg_date,$greg_time) = explode(" ",$this->valdate_aut());
                            return substr($greg_time,0,5);
                    break;
                    
                    case "file_path" :
                        $new_name = $this->getNewName();
                        return AfwSession::config("uploads_http_path","")."/$new_name";
                             
                    break;
                    
                    case "download" :
                        $new_name = $this->getNewName();
                        $file_path = $this->getFileHttpPath();
                        $afile_ext = $this->getVal("afile_ext");
                        if($afile_ext=="pdf")
                        {
                            $fa_class = "file-pdf";
                            $div_dwld = "";
                        }
                        elseif(($afile_ext=="zip") or ($afile_ext=="rar"))
                        {
                            $fa_class = "folder";
                            $div_dwld = "";
                        }
                        else
                        {
                            $fa_class = "download";
                            $div_dwld = "<div class=\"${afile_ext}_download\">&nbsp;</div>";
                        }
                        
                        
                        $url = "<div>
                                     <a target='_download' style='' href='$file_path/$new_name' class='downloadbtn fright'>
                                        $div_dwld
                                        <div class=\"file_download\">
                                                <i class='fas fa-$fa_class'></i>
                                                <div>تحميل الملف</div>
                                        </div>      
                                     </a>
                                </div>";  // alt='انقر هنا لتحميل الملف'  // color: gray !important;
			return $url;
		    break;
                    
                    case "download_light" :
                        $new_name = $this->getNewName();
                        $file_path = $this->getFileHttpPath();
                        $afile_ext = $this->getVal("afile_ext");
                        
                        $url = AfwHtmlHelper::getLightDownloadUrl("$file_path/$new_name", $afile_ext);
			return $url;
		    break;
                    
                    
                    
                    case "small_picture" :
                        $new_name = $this->getNewName();
                        $id = $this->getId();
                        
                        global $small_picture_width, $small_picture_height;
                        if(!$small_picture_width) $small_picture_width = 128;
                        if(!$small_picture_height) $small_picture_height = 128;
                        
                        $pic_id = "zoom_${id}_$attribute";
                         
                        if($this->picture_style) $picture_style = "style='".$this->picture_style."'";
                        else $picture_style = "style='width: ${small_picture_width}px !important;   height: auto !important;'";
                        
//    zoomType: \"inner\",
                        
                        $img = "<img style='width: 400px !important;height: auto !important;' id='$pic_id' src='$upld_path/$new_name' $picture_style  data-zoom-image='$upld_path/$new_name'>";  // alt='انقر هنا لتحميل الملف'
                        $img .= "
<script>
    $('#$pic_id').elevateZoom({
cursor: \"crosshair\",
zoomWindowWidth:788,
zoomWindowHeight:960,
zoomWindowFadeIn: 500,
zoomWindowFadeOut: 1100,
zoomWindowOffety:-200

   });
   
</script>
                        ";  // alt='انقر هنا لتحميل الملف'*/
			return $img;
		    break;
                    
                    case "big_picture" :
                        $new_name = $this->getNewName();
                        $id = $this->getId();
                        
                        $pic_id = "zoom_${id}_$attribute";
                         
                        if($this->picture_style) $picture_style = "style='".$this->picture_style."'";
                        else $picture_style = "style='width: 598px !important;   height: auto !important;'";
                        
                        $img = "<img id='$pic_id' src='$upld_path/$new_name' $picture_style  data-zoom-image='$upld_path/$new_name'>";  // alt='انقر هنا لتحميل الملف'
                        
			return $img;
		    break;

                    case "embed" :
                        $new_name = $this->getNewName();
                        return "<embed src='$upld_path/$new_name' width='598px' height='598px' internalinstanceid='11' title=''>";;
		    break;

                     
               }
        }
        
        
        protected function hideDisactiveRowsFor($auser)
        {
              return true;  
        }
        
        public function isNotViewable()
        {
            if($this->estPicture()) return false;
            if($this->estVideo()) return false;
            return true;
        }
        
        public function showMySelf($style="")
        {
           global $lang;
               $my_id = $this->getId();
               $float_class = $this->float_class;
               $display = $this->getShortDisplay($lang);
               $f_type = $this->valType();
               if($this->estPicture())
               {
                    $this->picture_style = $style;
                    $small_picture = $this->getFormuleResult("small_picture");
               }
               else
                   $small_picture = "";
               
               
               $span_edit = "<span><a href='main.php?Main_Page=afw_mode_display.php&cl=Afile&currmod=ums&id=$my_id'>$display</a></span><br>";
               
               if($small_picture)
               {
                  $showMySelf = "<table style='width: 100%;'>
                            <tbody>
                                <tr>
                                   <td nowrap style='text-align: right !important;'>
                                       $span_edit
                                       $small_picture
                                   </td>
                                </tr>   
                           </tbody></table>";
               }
               elseif($this->estVideo())
               {
                      $file_path = $this->getVal("file_path");
                      $extension = strtolower($this->getVal("afile_ext"));
                      $showMySelf = "<div>
                                  <video
                                    id='my-video'
                                    class='video-js'
                                    controls
                                    preload='auto'
                                    width='640'
                                    height='264'
                                    poster='logo-video.png'
                                    data-setup='{}'
                                  >
                                    <source src='$file_path' type='video/$extension' />
                                    <p class='vjs-no-js'>
                                      To view this video please enable JavaScript, and consider upgrading to a
                                      web browser that
                                      <a href='https://videojs.com/html5-video-support/' target='_blank'
                                        >supports HTML5 video</a
                                      >
                                    </p>
                                  </video>
                                  <link href='../lib/videojs/video-js.css' rel='stylesheet' />
                                  <script src='../lib/videojs/video.js'></script>
                                </div>";
                }
                elseif($this->estMediaPlayer())
                {
                      $file_path = $this->getVal("file_path");
                      $extension = strtolower($this->getVal("afile_ext"));
                      $showMySelf = "<object id='mediaPlayer' width='320' height='285' 
      classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95' 
      codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701'
      standby='Loading Microsoft Windows Media Player components...' type='application/x-oleobject'>
      <param name='fileName' value='$file_path'>
      <param name='animationatStart' value='true'>
      <param name='transparentatStart' value='true'>
      <param name='autoStart' value='false'>
      <param name='showControls' value='true'>
      <param name='loop' value='true'>
      <embed type='application/x-mplayer2'
        pluginspage='http://microsoft.com/windows/mediaplayer/en/download/'
        id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1' 
        bgcolor='darkblue' showcontrols='true' showtracker='-1' 
        showdisplay='0' showstatusbar='-1' videoborder3d='-1' width='320' height='285'
        src='$file_path' autostart='true' designtimesp='5311' loop='true'>
      </embed>
</object>";
                }
                else
                {   
                        $download = $this->valDownload();
                        $showMySelf = "<table style='width: 100%;'>
                            <tbody>
                                <tr>
                                   <td nowrap style='text-align: right !important;'>
                                       $span_edit
                                       $download
                                   </td>
                                </tr>   
                           </tbody></table>"; 
                }   
                return "<div class='topactions $float_class'>$showMySelf</div>"; 
        
        }
        
        protected function getSpecificDataErrors($lang="ar",$show_val=true,$step="all",$erroned_attribute=null,$stop_on_first_error=false, $start_step=null, $end_step=null)
        {
              $objme = AfwSession::getUserConnected();
                
              $sp_errors = array();
              if(!$this->isActive()) $sp_errors["afile_name"] = "تم حذف أو تعطيل هذا الملف من  معرض المرفقات الخاصة بالموظف";
              $new_name = $this->getNewName();
              $file_path = $this->getFilePath().$new_name; 
              if(!file_exists($file_path))
              { 
                  if(($objme) and ($objme->isSuperAdmin()))
                     $file_full_path = $file_path;
                  else $file_full_path = "";   
                  $sp_errors["afile_name"] = "الملف غير موجود بالمعرض $file_full_path";  
              }
              $doc_type_id = $this->getVal("doc_type_id");
              if($doc_type_id==1)
              {
                  $sp_errors["doc_type_id"] = "لا بد من تحديد نوع الملف المرفق لتتمكن من استخدامه"; 
              }
              
              return $sp_errors;
        }
  
  
        public function getFilePath() 
        {            
            $uploads_root_path = AfwSession::config("uploads_root_path","");

            if($this->getVal("doc_type_id")==9)
                 return $uploads_root_path."imports/";
            else             
                 return $uploads_root_path;
	}
        
        public function getExcelData($row_num_start=-1, $row_num_end=-1, $caller="not-defined")
        {
             $file_dir_name = dirname(__FILE__); 

             $afile_ext = $this->getVal("afile_ext");
              
              $xls_ext_arr = ["xls","xlsx"];
              $doc_type_id = $this->getVal("doc_type_id");
              
              if(($doc_type_id==14) and (in_array($afile_ext,$xls_ext_arr)))
              {
                     require_once("$file_dir_name/../lib/hzm/excel/hzm_excel.php");
                     $new_name = $this->getNewName();
                     $file_path = $this->getFilePath().$new_name;
                     if(!file_exists($file_path))
                     {
                            throw new AfwRuntimeException("File not found : $file_path");
                     }
                     
                     $excel = new HzmExcel($file_path);
                     $my_data = $excel->getData($row_num_start, $row_num_end, $caller);
                     $my_head = $excel->getHeaderTrad();
                     
                     return [$excel, $my_head, $my_data];
              }
              else
              {
                     throw new AfwRuntimeException("getExcelData method can not work on non excel or non importable files, your file extension : $afile_ext, doc type = ".$this->het("doc_type_id"));
              }            
        }
  
        public function pictureView($style="width:100%;height:auto")
        {
                $upld_path = AfwSession::config("uploads_http_path","");

                
                
                $afile_ext = strtolower($this->getVal("afile_ext"));
                
                $xls_ext_arr = ["xls","xlsx"];
                $pdf_ext_arr = ["pdf"];
                $compressed_ext_arr = ["zip","rar"];
                
                $doc_type_id = $this->getVal("doc_type_id");
                
                if(in_array($afile_ext,$xls_ext_arr))
                { 
                        return $this->calc("download");
                }
                elseif(in_array($afile_ext,$pdf_ext_arr))
                {
                        return $this->calc("download");
                }
                elseif(in_array($afile_ext,$compressed_ext_arr))
                {
                        return $this->calc("download");
                }
                elseif($this->estPicture())
                {
                        $new_name = $this->getNewName();
                        $img = "<img class='rafik-img' style='$style' src='$upld_path/$new_name'>"; 
                        // die("after include_once of $file_dir_name/../external/config.php , upld_path = ".$upld_path." img = $img");
                        return $img;
                }
                else
                {
                        return "<img style='$style' src='lib/images/no-picture.png'>";                      
                }
              
        }
  
        public function previewMe($row_num_start=-1, $row_num_end=-1)
        {
              $afile_ext = $this->getVal("afile_ext");
              
              $xls_ext_arr = ["xls","xlsx"];
              $doc_type_id = $this->getVal("doc_type_id");
              
              if(($doc_type_id==14) and (in_array($afile_ext,$xls_ext_arr)))
              { 
                      require_once("afw_shower.php");
                      $new_name = $this->getNewName();
                      $file_path = $this->getFilePath().$new_name;
                      if(!file_exists($file_path))
                      {
                           return "File not found : $file_path";
                      }
                      else
                      {
                           list($excel, $my_head, $my_data) = $this->getExcelData($row_num_start, $row_num_end, "previewMe");
                           list($html, $ids) = AfwHtmlHelper::tableToHtml($my_data, $my_head, count($my_data)>20);
                           // $log = " my_data = ".var_export($my_data,true)." my_head = ".var_export($my_head,true);
                           return "<div id='previewMe'>".$html."</div>";
                           
                      }
              }
              elseif($this->estPicture())
              {
                     return $this->getFormuleResult("big_picture");
              }
              elseif($this->estVideo())
              {
                     return $this->showMe();
              }
              else
              {
                     return $this->getFormuleResult("embed");                      
              }
              
        }
        
        public function select_visibilite_horizontale($dropdown = false)
        {
                $me = AfwSession::getUserIdActing();        
                $this->where("me.avail='Y' or (me.avail ='W' and me.owner_id = '$me')");
        }
        
        
        public function beforeMAJ($id, $fields_updated) {
             return true;
        }
        
        public function getAvailableDocTypeId($doc_type_arr)
        {
              $file_dir_name = dirname(__FILE__); 
              
              $afile_ext = $this->getVal("afile_ext");
              //die("afile_ext=$afile_ext, doctype array : ".var_export($doc_type_arr,true));
              foreach($doc_type_arr as $doc_type_id)
              {
                    list($ext_arr, $ft_arr) = DocType::getExentionsAllowed($doc_type_id);
                    if(in_array(strtoupper($afile_ext),$ext_arr)) return $doc_type_id;
                    elseif($doc_type_id==7) die("for doctype $doc_type_id, $afile_ext not in allowed ext : ".var_export($ext_arr,true));
              }
              
              return 0;
        }
        
        public function userCanDeleteMeSpecial($auser)
        {
                if(!$auser) return false;
                if($auser->getId()==$this->getVal("owner_id")) return true;
                
                return false;
        }
        
        
        
        public function estMediaPlayer()
        {
            $extension = strtolower($this->getVal("afile_ext"));
            // one of wmv,avi,flv
            // if($extension=="wmv") return true;
            //if($extension=="flv") return true;
            //if($extension=="avi") return true;
            return false;
        }
        
        // ie supported by HTML5 Player
        public function estVideo()
        {
            $extension = strtolower($this->getVal("afile_ext"));
            // one of mp4,webm,ogg
            if($extension=="mp4") return true;
            if($extension=="webm") return true;
            if($extension=="ogg") return true;
            return false;
        }


        public function myShortNameToAttributeName($attribute){
                if($attribute=="original") return "original_name";
                if($attribute=="name") return "afile_name";
                if($attribute=="ext") return "afile_ext";
                if($attribute=="type") return "afile_type";
                if($attribute=="size") return "afile_size";
                return $attribute;
        }
        
        
}
?>