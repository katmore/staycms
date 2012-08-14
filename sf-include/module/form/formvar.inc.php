<?php

require_once("varfilters.inc.php");

class sfformvargrp_blank extends sfformvargrp {
   public function __construct($f_name) {
      $this->name = $f_name;
      $this->rawvalue[0] = "";
      $this->mbrval[0] = "";
      $this->mbrkey[0] = "";
   }
}

class sfformvargrp {
   protected $name;
   private $method;
   protected $rawvalue;
   
   protected $mbrval; //value of member's
   protected $mbrkey; //key of member's (can by alphanum or num)
   
   protected $mbridx; //index by key
   
   public function name() {
      return $this->name;
   }
   
   public function showName() {
      echo $this->name();
   }
   
   public function getCount() {
      if (is_array($this->rawvalue)) {
         return count($this->rawvalue);
      }
      return 0;
   }
   
   public function showCount() {
      echo $this->getCount();
   }
   
   public function value($what=0) {
      
      if (is_int($what)) {
         if (!($what > (count($this->mbrval) - 1 ) )) {
            return $this->mbrval[$what];
         }
      }
      
      /*-do this just to be nice-*/
      return $this->getValueByKey($what);
   }
   
   public function showValue($what=0) {
      echo $this->value($what);
   }
   
   public function getValueByKey($key) {
      
      if (!isset($this->mbridx[$key])) return "";
      
      $idx = $this->mbridx[$key];
      
      return $this->mbrval[$idx];
      
   }
   
   public function getKey($idx=0) {
      if ($idx > (count($this->mbrval) - 1) ) return false; 
      return $this->mbrkey[$idx];
   }
   
   public function showKey($idx=0) {
      echo $this->getKey($idx);
   }
   
   private function get_each_value_and_filter($filter) {
      $this->value = array();
      if ($this->method == "POST") {
         if (isset($_POST[$this->name])) {
            $this->rawvalue = $_POST[$this->name];
         }
      } else
      if ($this->method == "GET") {
         if (isset($_GET[$this->name])) {
            $this->rawvalue = $_GET[$this->name];
         }
      }
      
      if (!is_array($this->rawvalue)) return false;
      
      $namefltr = new alphanumfilter("_");
      $this->mbrval = array();
      $this->mbrkey = array();
      
      $i=0;
      foreach($this->rawvalue as $key => $val) {
         /*--if magic quotes is running, fix it--*/
         if (get_magic_quotes_gpc()) {
            $val = stripslashes($val);
         }
         
         $filter->apply($val);
         $namefltr->apply($key);
         $this->mbrval[$i] = $filter->value();
         $this->mbrkey[$i] = $namefltr->value();
         $this->mbridx[$namefltr->value()] = $i;
         $i++;
      }
   }
   
   public function initVargrp($f_name,$f_filter=NULL,$f_method="POST") {
      $this->name = $f_name;
      //check if first_filter is sfvarfilter type (class)
      if (is_subclass_of ( $f_filter , "sfvarfilter" ) ) {
         $filter = $f_filter;
      } else {
         $filter = new alphanumfilter();
      }
      if ($f_method == "GET") {
         $this->method = "GET";
      } else {
         $this->method = "POST";
      }
      $this->get_each_value_and_filter($filter);
   }
   public function __construct($f_name,$f_filter=NULL,$f_method="POST") {
      $this->initVargrp($f_name,$f_filter,$f_method);
   }
}

class sfformvar {
   private $name;
   private $value;
   private $orgval;
   
   public function name() {
      return $this->name;
   }
   
   public function showName() {
      echo $this->name();
   }
   
   public function showValue($diff_filter=NULL) {
      echo $this->value($diff_filter);
   }
   public function value($diff_filter=NULL) {
      if (is_subclass_of ( $diff_filter , "sfvarfilter" ) ) {
         $diff_filter->apply($this->orgval);
         return $diff_filter->value();
      }
      return $this->value;
   }
   public function initFormvar($f_name,$f_filter=NULL,$f_method="POST") {
      /*--names can only be alphanum and undrscore--*/
      //$this->name = preg_replace('/[^A-Za-z0-9_]/',"",$f_name);
      $this->name = $f_name;
      if (is_subclass_of ( $f_filter , "sfvarfilter" ) ) {
         $filter = $f_filter;
      } else {
         $filter = new alphanumfilter();
      }
      $this->method = $f_method;
      $this->get_value_and_filter($filter);
   }
   public function __construct($f_name,$f_filter=NULL,$f_method="POST") {
      $this->initFormvar($f_name,$f_filter,$f_method);
   }
   private function get_value_and_filter($filter) {
      
      if ($this->method == "POST") {
         if (isset($_POST[$this->name])) {
            $val = $_POST[$this->name];
            
            /*--if magic quotes is running, fix it--*/
            if (get_magic_quotes_gpc()) {
               $val = stripslashes($_POST[$this->name]);
            }
         }
      } else
      if ($this->method == "GET") {
         if (isset($_GET[$this->name])) {
            $val = $_GET[$this->name];
            /*--if magic quotes is running, fix it--*/
            if (get_magic_quotes_gpc()) {
               $val = stripslashes($_GET[$this->name]);
            }
         }
      }
      //echo (get_class($filter)) . " is the filter<br>";
      $filter->apply($val);
      
      $this->value = $filter->value();
      
      $this->orgval = $val;
   } /*--get_value_and_filter()--*/
}/*-class sfformval-*/
























