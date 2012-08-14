<?php

require_once("formvar.inc.php");

class sfform extends sfmodule {
   protected $action;
   protected $themepath;

   public function showFormAttrs($format=" %s ",$attr_format="%attr%=\"%value%\"",$attr_delinitator=" ") {
      $buff = "";

      $method_attr = $attr_format;
      $method_attr = str_replace("%attr%","method",$method_attr);
      $method_attr = str_replace("%value%","POST",$method_attr);
      $buff .= $method_attr;

      $buff .= $attr_delinitator;
      
      $action_attr = $attr_format;
      $action_attr = str_replace("%attr%","action",$action_attr);
      $action_attr = str_replace("%value%",$this->action,$action_attr);
      $buff .= $action_attr;
      
      printf($format,$buff);
   }
   protected function action() {
      return $this->action;
   }
   public function showAction() {
      echo $this->action;
   }
   private function addGetToAction($f_key,$f_val) {
      /*--proper filtering for query string (i think)--*/
      $key = preg_replace('/[^A-Za-z0-9_]/',"",$f_key);
      $val = htmlentities(urlencode($f_val));
      
      /*--if action is already query string, simply append key/val pair--*/
      if (false !== strstr($this->action,"?")) {
         $this->action .= "&amp;$key=$val";
      } else { /*--if it's not a query string yet, make it one--*/
         $this->action .= "?$key=$val";
      }
      
   }
   public function overrideAction($f_new_action) {
      /*--sometime needs to allow for formatting--*/
      $this->action = $f_new_action;
   }
   public function versionForm() {
      $version = "0.2";
      return $version;
   }
   public function setContentid($f_contentid) {
      $this->addGetToAction("p",$f_contentid);
   }
   protected function initForm() {
      $this->action = "./";
      $this->setModuleStatusGood();
   }
   public function __construct() {
      $this->initForm();
   }
   
} /*-sfform class-*/

























