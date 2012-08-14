<?php
class usphonefilter extends sfvarfilter {
   public function __construct() {
      
   }
   public function apply($f_str) {
      $this->str = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", '\1-\2-\3', $str);
   } 
}

class numfilter extends sfvarfilter {
   public function __construct() {
      
   }
   public function apply($f_str) {
      $this->str = preg_replace('/[^0-9.]/',"",$f_str);
   }
}

class alphafilter extends sfvarfilter {
   public function __construct() {
      
   }
   public function apply($f_str) {
      $this->str = preg_replace('/[^A-Za-z]/',"",$f_str);
   }
}

class mysqlfilter extends sfvarfilter {
   private $myresource;
   public function __construct($myresource=NULL) {
      $this->myresource = $myresource;
   }
   public function apply($f_str) {
      if ($this->myresource != NULL) {
         $my = $this->myresource;
      }
      $this->str = mysql_real_escape_string($f_str,$my);
   }
}

class htmlfilter extends sfvarfilter {
   public function __construct() {
      
   }
   public function apply($f_str) {
      $this->str = htmlentities($f_str);
   }
}

class alphanumfilter extends sfvarfilter {
   private $extraregx;
   public function __construct($f_extraregx="_ -.") {
      $this->extraregx = $f_extraregx;
   }
   public function apply($f_str) {
      $this->str = preg_replace('/[^A-Za-z0-9' . $this->extraregx . ']/',"",$f_str);
   }
}

class regxfilter extends sfvarfilter {
   private $regx;
   public function __construct($regx) {
      $this->regx = $regx;
   }
   public function apply($f_str) {
      $this->str = preg_replace('/[^' . $this->regx . ']/',"",$f_str);
   }
}
   

class sfvarfilter {
   protected $str;
   public function value() {
      return $this->str;
   }
}