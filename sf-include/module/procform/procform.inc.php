<?php
/**
 * sfprocform.inc.php
 * 
 * Purpose:
 *    creates the ProcForm sf-Module which facilitates processing of HTML forms by extending the sf-Form Module
 * 
 * Features:
 *    Processes POST or GET key-value pairs.
 *    Has public methods that are handy for processing forms freestyle in php script
 *       (especially in the 'content' portions).
 * 
 * Note:
 *    Using sf-ProcForm is a 'quick-and-dirty' way to process a form.
 *    It is most suitable for 'one-time' forms,
 *       ones that are trivial or that you probably wont edit or reuse much in the future.
 *    If creating a substatial set of forms, or form(s) that might be ported, routinely updated,
 *       etc, it is best to create a custom extention of the sf-Form Module.
 *    I like to implement arbitrary filter for single input boxes (showNameValueAttrs).
 *    I have chosen not to allow arbitrary filters in most 'showValueIf...' (esp. group ones)
 *       family of methods because these are typically used for 'names' or a value 
 *       that is containe within a string literal for comparison, and it seems problematic. 
 *       For the vast majority of even pretty complex forms the methods provided should suffice.
 *       And besides, if strange specific behavior is desired, just extend the customize 
 *       an sf-Form class extention.     
 * 
 * To-Do:
 *    Allow arbitrary filter for single input boxes (showNameValueAttrs).
 *    
 * 
 * 
 */

/*
 * depends on the 'form' sf-Module
 */
require_once(__DIR__ . "/../form/form.inc.php");
require_once(__DIR__ . "/../form/valrules.inc.php");
define("staycms_module_procform_version","0.1");
define("staycms_module_procform_errflag","705200"); //modules are flag 700000, sfform and deriv are +5000, mailproc is +100

class sfprocformvalrule {
   private $name;
   private $valrule = NULL;
   public function getValrule() {
      return $this->valrule;
      if (is_a($this->valrule,"sfvalrule")) {
         return $this->valrule;
      } else {
         throw new Exception("no valid valrule set");
      }
   }
   public function name() {
      return $this->name;
   }
   public function __construct($what,$valrule) {
      //check that it's a valid rule
      if (is_a("sfvalrule_".$valrule,"sfvalrule")) {
         $newrule = "sfvalrule_".$valrule;
         $this->valrule = new $newrule;
         $this->name = $what;
      } else {
         throw new Exception("'$valrule' is not a valid form val rule.");
      }
   }
}
   
class sfprocform extends sfform {
   
   private $var;
   private $vartype;
   private $varidx;
   
   private $valrule; //array of sfprocformvalrule
   
   private $submitprocess;
   
   public function __construct() {
      $this->initForm();
   }
   
   public function countValruleBroken() {
      $i = 0;
      foreach ($this->valrule as $mbr) {
         $mbr->getValrule()->test($this->getFormvar($mbr->name())->value());
         if (false===$mbr->getValrule()->compliant()) {
            $i++;
         }
      }
      return $i;
   }
   
   public function showCountIfAnyValruleBroken($format_plural="%count% rules broken",$format_single="1 rule broken") {
      if ($this->isAnyValruleBroken()) {
         if ($this->countValruleBroken() == 1) {
            $format = $format_single;
         } else {
            $format = $format_plural;
         }
         $format = str_replace("%count%",$this->countValruleBroken(),$format);
         echo $format;
      }
   }
   
   public function showStrIfAnyValruleBroken($str_format="at least one rule broken") {
      if ($this->isAnyValruleBroken()) { 
         $str = $str_format;
         echo $str;
      }
   }
   
   public function isAnyValruleBroken() {
      foreach ($this->valrule as $mbr) {
         
            $mbr->getValrule()->test($this->getFormvar($mbr->name())->value());
            if (false===$mbr->getValrule()->compliant()) {
               return true;
            }
         
      }
   }
   
   public function isValruleBroken($name) {
      foreach ($this->valrule as $mbr) {
         if ($mbr->name() == $name) {
            $mbr->getValrule()->test($this->getFormvar($name)->value());
            if (false===$mbr->getValrule()->compliant()) {
               return true;
            }
         }
      }
   }
   
   public function showMsgForEachValruleBroken($name,$msg_format="%name% %msg% (%pneumonic%)") {
      foreach ($this->valrule as $mbr) {
         if ($mbr->name() == $name) {
            $mbr->getValrule()->test($this->getFormvar($name)->value());
            if (false===$mbr->getValrule()->compliant()) {
               $format = $msg_format;
               $format = str_replace("%msg%",$mbr->getValrule()->getMsg("%s"),$format);
               $format = str_replace("%name%",$name,$format);
               $format = str_replace("%pneumonic%",$mbr->getValrule()->pneumonic(),$format);
               echo $format;
            }
         }
      }
   }
   
   public function showStrForEachValruleExistent($name,$str_format="* (%pneumonic%)") {
      foreach ($this->valrule as $mbr) {
         if ($mbr->name() == $name) {
            $str = $str_format;
            $str = str_replace("%pneumonic%",$mbr->getValrule()->pneumonic(),$str);
            echo $str;
         }
      }
   }
   
   
   public function showStrIfValruleExistent($name,$valrule,$str_format="* (%pneumonic%)") {
      foreach ($this->valrule as $mbr) {
         if ($mbr->name() == $name) {
            if (is_a($mbr->getValrule(),"sfvalrule_".$valrule)) {
               $str = $str_format;
               $str = str_replace("%pneumonic%",$mbr->getValrule()->pneumonic(),$str);
               echo $str;
               return;
            }
         }
      }
   }
   
   public function isValruleExistent($what) {
      //echo "there are " . count($this->valrule) . " valrules";
      foreach ($this->valrule as $mbr) {
         //echo "checking if valrule exists for '$what'" ;
         if ($mbr->name() == $what) {
            return true;
         }
      }
   }
   
   public function addValruleToFormvar($what,$rule) {
      
      $this->valrule[] = new sfprocformvalrule($what,$rule);
      
   }
   
   public function showValueSelectedAttrsForGroup($what,$value,$selIfNotProcessed=false,$value_format="value=\"%value%\"",$sel_format="selected",$deliniator=" ") {
      $buff = "";
      
      $value_attr = $value_format;
      $value_attr = str_replace("%value%",$value,$value_attr);
      $buff .= $value_attr;
      
      echo $buff;
      
      $this->showSelectedIfValueInGroup($what,$value,$selIfNotProcessed,$sel_format,$deliniator . "%s");
   }
   
   public function showSelectedIfValueInGroup($what,$value,$selIfNotProcessed=false,$sel_format="selected",$format=" %s ") {
      if (!$this->submitprocess) {
         if ($selIfNotProcessed) printf($format,$sel_format);
         return;
      }
      $this->showStrIfValueFoundInGroup($what,$value,$sel_format,$format);
   }
   
   public function showStrIfValueFoundInGroup($what,$value,$str,$format=" %s ") {
      if (is_a($this->getFormvar($what),"sfformvargrp")) {
         for($i=0;$i < $this->getFormvar($what)->getCount();$i++ ) {
            if ($this->getFormvar($what)->value($i) == $value) {
               printf($format,$str);
            } 
         }
      }
   }
   
   public function showNameCheckedIdAttrs($what,$key,$chkIfNotProcessed=false,$name_format="name=\"%name%\"",$check_format="checked",$chkval_cmp="on",$id_format="id=\"%id%\"",$deliniator=" ") {
      $buff = "";
      
      $id_attr = $id_format;
      $id_attr = str_replace("%id%",$key,$id_attr);
      $buff .= $id_attr;
      $buff .= $deliniator;
      
      echo $buff;
      
      $this->showNameCheckedAttrs($what,$key,$chkIfNotProcessed,$name_format,$check_format,$chkval_cmp,$deliniator);
      
   }
   
   public function showNameCheckedAttrs($what,$key,$chkIfNotProcessed=false,$name_format="name=\"%name%\"",$check_format="checked",$chkval_cmp="on",$deliniator=" ") {
      
      $buff = "";
      
      $name_attr = $name_format;
      $name_attr = str_replace("%name%",$what . "['" . $key . "']",$name_attr);
      $buff .= $name_attr;
      
      echo $buff;
      
      $this->showCheckedAttrIfOn($what,$key,$chkIfNotProcessed,$check_format,$chkval_cmp,$deliniator .  "%s");
      
   }
   
   public function showCheckedAttrIfOn($what,$key,$chkIfNotProcessed=false,$check_format="checked",$chkval_cmp="on",$format=" %s ") {
      if (!$this->isProcessed()) {
         if ($chkIfNotProcessed) {
            printf($format, $check_format );
         }
      }
      if ($this->getFormvar($what)->value($key) == $chkval_cmp) {
         
         printf($format, $check_format );
      }
   }
   
   public function showNameValueCheckedIdAttrs($what,$value,$chkIfNotProcessed=false,$name_format="name=\"%name%\"",$valattr_format="value=\"%value%\"",$chkformat="checked",$id_format="id=\"%id%\"",$deliniator=" ") {
      $buff = "";
      
      $name_attr = $name_format;
      $name_attr = str_replace("%name%",$what,$name_attr);
      $buff .= $name_attr;
      $buff .= $deliniator;
      
      echo $buff;
      
      $this->showValueCheckedIdAttrs($what,$value,$chkIfNotProcessed,$valattr_format,$chkformat,$id_format,$deliniator);
      
   }

   public function showValueCheckedIdAttrs($what,$value,$chkIfNotProcessed=false,$valattr_format="value=\"%value%\"",$chkformat="checked",$id_format="id=\"%id%\"",$deliniator=" ") {
      $buff = "";
      
      $id_attr = $id_format;
      $id_attr = str_replace("%id%",$value,$id_attr);
      $buff .= $id_attr;
      $buff .= $deliniator;
      
      echo $buff;
      
      $this->showValueCheckedAttrs($what,$value,$chkIfNotProcessed,$valattr_format,$chkformat,$deliniator);
   }

   public function showValueCheckedAttrs($what,$value,$chkIfNotProcessed=false,$valattr_format="value=\"%value%\"",$chkformat="checked",$deliniator=" ") {
      $this->showValueSelectedAttrs($what,$value,$chkIfNotProcessed,$valattr_format,$chkformat,$deliniator);
   }
   

   public function showValueSelectedAttrs($what,$value,$selIfNotProcessed=false,$valattr_format="value=\"%value%\"",$selformat="selected",$deliniator=" ") {
      $buff = "";
      
      $value_attr = $valattr_format;
      //$value_attr = str_replace("%attr%","value",$value_attr);
      $value_attr = str_replace("%value%",$value,$value_attr);
      $buff .= $value_attr;
      
      echo $buff  ;
      
      if (!$this->isProcessed()) {
         if ($selIfNotProcessed===true) {
            printf("%s",$deliniator . $selformat);
         }
      } else {
         $this->showStrIfValueMatch($what,$value,$deliniator . $selformat,"%s");
      }
      
   }
   
   

   
   public function showStrIfValueMatch($what,$value,$str,$format=" %s ") {
      //$this->getFormvar($what)->value()
     // echo "value:" . $this->getFormvar($what)->value();
      if ($value == $this->getFormvar($what)->value()) {
         printf($format,$str);
      }
   }
   
   public function getFormvarCount() {
      if (!is_array($this->var)) return 0;
      return count($this->var);
   }
   
   public function showFormvarCount() {
      echo $this->getFormvarCount();
   }
   
   public function getFormvarByIdx($idx) {
      if (!is_integer($idx)) return false;
      /*-make sure the var exists-*/
      if (!isset($this->var[$idx])) return false;
      /*-check that it's appropriate type?-*/
      //havent done this yet
      
      /*-return the formvar, confident that it exists-*/
      return $this->var[$idx];
   }
   
   public function getFormvarByName($name) {
      
      /*-get the index if it exists-*/
      if (!isset($this->varidx[$name])) return false;
      $idx = $this->varidx[$name];
      
      /*-return the val of ForvarIdx-*/
      return $this->getFormvarByIdx($idx);
      
   }
   
   public function showNameValueAttrs($what,$valueIfNotProcessed="",$format=" %s ",$attr_format="%attr%=\"%value%\"",$attr_delinitator=" ") {
      $buff = "";
      
      $name_attr = $attr_format;
      $name_attr = str_replace("%attr%","name",$name_attr);
      $name_attr = str_replace("%value%",$what,$name_attr);
      $buff .= $name_attr;

      $buff .= $attr_delinitator;

      $value_attr = $attr_format;
      $value_attr = str_replace("%attr%","value",$value_attr);
      
      $val = $this->getFormvar($what)->value();
      
      if (!$this->isProcessed()) {
         $val = $valueIfNotProcessed;
      }
      
      $value_attr = str_replace("%value%",$val,$value_attr);
      $buff .= $value_attr;
      
      printf($format,$buff);
      
   }
   
   public function getFormvar($what=0) {
      
      /*-is the what an index or name-*/
      if ( is_int($what) ) {
         //echo (int) $what . " is an integer<br>";
         /*-since it's an integer, try to find it by index-*/
         if (false !== ($formvar = $this->getFormvarByIdx($what))) return $formvar;
         //$formvar = $this->getFormvarByIdx($what);
         //if ($formvar === false) echo "it was poop<br>";
         
      }
      
      /*-try to find it by name-*/
      if (false !== ($formvar = $this->getFormvarByName($what))) return $formvar;
      
      /*-just to be nice, return a group full of empty values with the right name-*/
      $blank = new sfformvargrp_blank($what);
      
      return $blank;
      
   }
   
   public function isProcessed() {
      if ($this->submitprocess === true) return true;
      return false;
   }
   
   public function processForm($submitname="sfform_submit",$f_method="POST") {
      $source = NULL;
      $method = "POST";
      if ($f_method == "GET") $method="GET";
      if ($method=="POST") {
         $source = $_POST;
      } else
      if ($method=="GET") {
         $source = $_GET;
      }
      
      if (isset($source[$submitname])) {
         
         $this->var = array();
         $this->vartype = array();
         $this->varidx = array();
         $i = 0;
         foreach ($source as $key => $value) {
            
            if (is_array($value) ) {
               //create a vargroup
               //($f_name,$f_first_filter=NULL,$f_method="POST")
               $this->var[$i] = new sfformvargrp($key,new alphanumfilter(),$method);
               $this->vartype[$i] = "sfformvargrp";
               $this->varidx[$key] = $i;
            } else {
               //echo "on $i and it's $key<br>";
               $this->var[$i] = new sfformvar($key,new alphanumfilter(),$method);
               $this->vartype[$i] = "sfformvar";
               $this->varidx[$key] = $i;
            }
            //echo "<br>";
            $i++;
         }
         $this->submitprocess = true;
      }
      //see what was in the form
      //add a var based on type of form input used
      //if not known don't add it
      
   }
}
   