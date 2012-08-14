<?php
class sfdoc {
   private $timestart;
   private $themedir;
   private $themeurl;
   private $sitename;
   private $sitecopyright;
   private $homebaseurl;
   
   public function setTimestart($microtimestamp=NULL) {
      if ($microtimestamp == NULL ) {
         $this->timestart = microtime(true);
      } else {
         $this->timestart = $microtimestamp;
      }
   }
   
   protected function showExectime($format="%s seconds",$rnd_prec=4) {
      $prec = 3;
      if (is_numeric($rnd_prec)) if ( ($rnd_prec >=0) && ($rnd_prec < 10)) $prec = $rnd_prec;
      printf($format, round($this->exectime(),$prec));
   }
   
   protected function exectime() {
      $time = -1;
      if (is_numeric($this->timestart)) if ($this->timestart > 0) {
         $time_end = microtime(true);
         $time = $time_end - $this->timestart;
      }
      return $time;
   }
   protected function getModule($f_name) {
      $classname = "sf" . $f_name;
      //include the widget
      require(__DIR__ . "./../module/" . $f_name . "/" . $f_name . ".inc.php");
      
      //load the widget
      $module = new $classname();
      
      //do some stupid test on it
      if (!is_a($module,"sfmodule")) return new sfmodule_bad();
      
      
      //return it
      return $module;
      
   }
   protected function getWidget($f_name) {
      //include the widget
      require("widget/" . $f_name . "/" . $f_name . ".inc.php");
      //load the widget
      $widget = new $f_name();
      //return it
      return $widget;
      
   }
   protected function sitecopyright() {
      return $this->sitecopyright;
   }
   
   protected function homebaseurl() {
      return $this->homebaseurl;
   }
   
   public function setHomebaseurl($f_homebaseurl) {
      $this->homebaseurl = $f_homebaseurl;
   }

   public function setSitecopyright($f_copyright) {
      $this->sitecopyright = $f_copyright;
   }

   protected function showSitename($f_format="%s",$keep_tags=false) {
      $buff = $this->sitename;
      if (!$keep_tags) {
         $buff = strip_tags($buff);
      }
      printf($f_format,$buff);
   }

   public function setSitename($f_sitename) {
      $this->sitename = $f_sitename;
   }

   public function showThemeurl() {
      echo $this->themeurl;
   }

   protected function themeurl() {
      return $this->themeurl;
   }
   protected function themedir() {
      return $this->themedir;
   }
   public function setTheme($f_themedir,$f_themeurl) {
      $this->themedir=$f_themedir;
      $this->themeurl = $f_themeurl;

   }
   public function initSfdoc() {
      $this->themedir="theme/sfd";
      $this->themeurl="theme/sfd";
   }

   public function __construct() {
      return initSfdoc();
   }
} /*-sfdoc class-*/