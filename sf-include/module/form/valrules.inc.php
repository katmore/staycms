<?php
class sfvalrule {
   protected $message;
   protected $compliant = false;
   protected $pneumonic;
   public function getMsg($format="value %s") {
      if ($this->message == "") return "";
      return sprintf($format,$this->message);
   }
   public function compliant() {
      return $this->compliant;
   }
   public function pneumonic() {
      return $this->pneumonic;
   }
}
class sfvalrule_preg extends sfvalrule {
   //implement a preg expression to check for copmliances
   //preg_match ( string $pattern , string $subject);
   private $preg;
   private $failmsg;
   public function test($f_val) {
      $this->message = "";
      if (false !== ($matches = preg_match ( $this->preg, $f_val ) ) ) {
         if ($matches > 0) {
            return true;
         } else {
            $this->message = $this->failmsg;
            return false;
         }
      } else {
         $this->message = "regx err:" . $this->preg;
         return false;
      }
   }
   public function initValrule_preg($f_preg,$f_failmsg="no match for regx") {
      $this->preg = $f_preg;
      $this->failmsg = $f_failmsg;
   }
   public function __construct($f_preg,$f_custmsg="no match for regx") {
      $this->initValrule_preg($f_preg,$f_custmsg);
   }
}
class sfvalrule_integer extends sfvalrule {
   public function test($f_val) {
      $this->compliant = false;
      $this->message = "";
      if ( !preg_match( '/^\d*$/'  , $f_val) == 1 ) {
         $this->message = "'$f_val' is not integer";
         $this->compliant = false;
      } else
      $this->compliant = true;
   }
   public function __construct() {
      $this->pneumonic = "integer";
   }
}
class sfvalrule_noblank extends sfvalrule {
   public function test($f_val) {
      $this->compliant = false;
      $this->message = "";
      if ($f_val == "") {
         $this->message = "cannot be blank";
      } else
      $this->compliant = true;
   }
   public function __construct() {
      $this->pneumonic = "noblank";
   }
}