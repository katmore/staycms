<?php
/**
 *
 * sfcms.inc.php of stayfront
 *
 */
define("staycms_core_version","0.6");
class sfcms {

   private $errmsg;
   private $errctx;
   
   public function fail($errctx="",$errmsg="") {
      /*
       *to do: have it look to theme for 500 error 
       */
      $this->set_err($errctx,$errmsg);
      if (is_readable(__DIR__ . "/template.fail.inc.php")) {
         require("template.fail.inc.php");
      } else {
         echo "fail";
         $this->showErrorText();
      }
      die();
   }

   public function showErrorText() {
      if ($this->errctx != "") echo "" . $this->errctx;
      if ($this->errmsg != "") echo ": " . $this->errmsg;
   }

   protected function set_err($ctx,$msg) {
      $this->errmsg = $msg;
      $this->errctx = $ctx;
   }

   function __construct() {

   }
} /*-sfcms class-*/

class sfmodule {
   private $status;
   protected function setModuleStatusGood() {
      $this->status = true;
   }
   protected function statusGood() {
      return $this->status;
   }
   public function initModule() {
      $this->status = false;
   }
   public function moduleStatus() {
      return $this->status(); 
   }
}

class sfaddon {
   
}

class sfwidget {
   /*--
    * I plan for widgets to be really cool because
    * they will be able to be just an iframe
    * or as a componant in the html
    --*/ 
   private $status;
   protected function setWidgetStatusGood() {
      $this->status = true;
   }
   protected function statusGood() {
      return $this->status;
   }
   public function initModule() {
      $this->status = false;
   }
   public function moduleStatus() {
      return $this->status(); 
   }
}

class sfmodule_bad extends sfmodule {
   public function __construct() {
      $this->initModule();
   }
}




















