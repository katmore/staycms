<?php

class sfcms_page extends sfcms {
   public function getPage($f_content_path,$f_content_id) {
      $cid = preg_replace('/[^A-Za-z0-9_-]/',"",$f_content_id);
      /*
       * check page to see if exists
       */
      if (!file_exists($f_content_path . "/" . $cid . ".inc.php" )) {
         //echo "fail: on content exist<br>";
         //see if content folder exists, if not throw a 500 error (or whatever error will be used as one)
         //if content folder exists, but content id does not, it's just a 404 error (or equiv)
         return false;
      }
      //echo $this->theme_path. "/$cid";die();
      /*
       * make the new document
       */
      $page = new sfpagedoc($f_content_path,$cid);
      return $page;
   } 
} /*--page()--*/

/**
 *
 * Class sfpage
 *
 * Constructor Method:
 * sfpage($themedir,$contentdir,$contentid)
 * Constructor Definition
 * sfpage( [$themedir="include/theme/sfd", [$contentdir="include/content", [$contentid="home"] ] ] )
 *
 * External Methods:
 * sfpage::show()
 *
 * Methods for use in Themes
 * sfpage::showContent()
 *
 *
 *
 */
class sfpagedoc extends sfdoc {
   private $contentid;
   private $contentdir;
   private $linkformat;
   
   
   private function showHeadextra() {
      if (file_exists ($this->contentdir . "/headextra-" . $this->contentid .".inc.php")) {
         include($this->contentdir . "/headextra-" . $this->contentid .".inc.php");
      }
   }

   private function showCopyright($f_format="%s") {
      if (file_exists ($this->contentdir . "/copyright-" . $this->contentid .".inc.php")) {
         include($this->contentdir . "/copyright-" . $this->contentid .".inc.php");
      } else {
         printf($f_format,$this->sitecopyright());
      }
   }

   public function setLinkformat($f_format) {
      $this->linkformat = $f_format;
   }
   
   private function showContentLink($f_contentid) {
      if (file_exists ($this->contentdir . "/" . $f_contentid .".inc.php")) {
         if ($f_contentid != "home") {
            $ret = $this->linkformat;
            $ret = str_replace("%contentid%",$f_contentid,$ret);
            echo $ret;
            return;
         } else { /*--if it's 'home' treat it special--*/
            echo $this->homebaseurl();
            return;
         }   
      }
   }

   private function showTitletext($f_format="%s - ") {
      if (file_exists ($this->contentdir . "/titletext-" . $this->contentid .".inc.php")) {
         include($this->contentdir . "/titletext-" . $this->contentid .".inc.php");
      } else {
         $title = str_replace("-"," ",$this->contentid);
         $title = ucwords($title);
         $title = strip_tags($title);
         printf($f_format,$title);
      }
   }

   private function showHeadingtext($f_format="%s - ") {
      if (file_exists ($this->contentdir . "/headingtext-" . $this->contentid .".inc.php")) {
         include($this->contentdir . "/headingtext-" . $this->contentid .".inc.php");
      } else {
         $heading = str_replace("-"," ",$this->contentid);
         $heading = ucwords($heading);
         printf($f_format,$heading);
      }
   }

   private function showContentid() {
      echo $this->contentid;
   }

   private function showContent() {
      require($this->contentdir . "/" . $this->contentid .".inc.php");
   }

   public function show() {
      require($this->themedir() . "/page.inc.php" );
   }

   public function __construct($f_contentdir="include/content",$f_contentid="home",$f_linkformat="/?p=%contentid%") {
      $this->contentdir =$f_contentdir;
      $this->contentid = preg_replace('/[^A-Za-z0-9_-]/',"",$f_contentid);
      $this->linkformat=$f_linkformat;
   }

   protected function getNewsitems($f_limit=5) {
      //$items 
   }
}