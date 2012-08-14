<?php
class sfaddon_multisite extends sfaddon {
   private $contentns;
   private $getkey;
   private $schema;
   private $themeschema;
   private $theme;
   private $themekey;
   public function initMultisite($f_content_schema,$f_theme_schema,$f_default_contentns="multisite_default",$f_default_content_getkey="ns",$f_default_theme=false,$f_default_theme_getkey="t") {
      $this->contentns = $f_default_contentns;
      $this->getkey = $f_default_content_getkey;
      $this->schema = $f_content_schema;
      $this->themeschema = $f_theme_schema;
      $this->theme = $f_default_theme;
      $this->themekey = $f_default_theme_getkey;
   }
   public function getTheme() {
      return $this->theme;
   }
   public function ThemeByGet() {
      if (isset($_GET[$this->themekey])) {
         
         $themename  = preg_replace('/[^A-Za-z0-9_-]/',"",$_GET[$this->themekey]);
         if (file_exists($this->themeschema . "/" . $themename)) {
            
            $this->theme = $themename;
         }
      }
   }
   public function ContentnsByGet() {
      if (isset($_GET[$this->getkey])) {
         $ns = preg_replace('/[^A-Za-z0-9_-]/',"",$_GET[$this->getkey]);
         if (file_exists($this->schema . "/" . $ns))
            $this->contentns = $ns;
         return true;
      }
      return false;
   }
   public function ContentnsByHostname() {
      //see what the host is
      if (isset($_SERVER['SERVER_NAME'])) if ("" != ($_SERVER['SERVER_NAME'])) {
         //if there's a namespace, change it only if it exists in scheme
         if (file_exists($this->schema . "/" . $_SERVER['SERVER_NAME']))
            $this->contentns = $_SERVER['SERVER_NAME'];
         return true;
      }
      return false;
   }
   public function getContentns() {
      //see if 'namespace' exists in 'schema'
      return $this->contentns;
   }
}
   