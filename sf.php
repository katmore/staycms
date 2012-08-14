<?php
/**
 *
 * sfcms.php of stayfront (sfcms)
 *
 * stayfront cms is a fast, optimized but versitile CMS
 *
 */
$time_start = microtime(true);
require("sf-config.php");

/*
 *
 * Include the file(s) needed to provide the basis for the staycms framework
 * 
 *
 */
require("$include_path/core/cms.inc.php");

//include file containing primary cms extention class
require($include_path . "/extention/primary/$primary_extention/" . $primary_extention . ".inc.php");

//serialize name of primary extention class
$ext = "sfcms_" . $primary_extention;

//load primary extention class
$cms = new $ext();

//load any/all addons
if(isset($addon_toload)) if(is_array($addon_toload))
foreach($addon_toload as $addon_name) {
   //see if file exists
   if (is_readable($include_path . "/extention/addon/$addon_name/" . $addon_name . ".inc.php")) {
      //include file with expected to have addon class definition
      require($include_path . "/extention/addon/$addon_name/" . $addon_name . ".inc.php");
      //serialize name of addon extention class
      $clsname = "sfaddon_$addon_name";
      $addon = new $clsname();
      //see if class is extention of sfaddon
      
      if (is_a($addon,"sfaddon")) {
         //load the module
         if (is_readable($include_path . "/extention/addon/$addon_name/load.inc.php")) {
            require($include_path . "/extention/addon/$addon_name/load.inc.php");
         } else {
            if ($show_sferrors) $cms->fail("addon","could not load '$addon_name'");
            $cms->fail("to see details here set show_sferrors = true in sf-config.php");
         }
      } else {
         //throw a "fail"
         if ($show_sferrors) $cms->fail("addon","'$clsname' not class sfaddon in '$addon_name'");
         $cms->fail("to see details here set show_sferrors = true in sf-config.php");
      }
   } else/*-end addon exists-*/{
      if ($show_sferrors) $cms->fail("addon","'$addon_name' does not exist and/or cannot be read");
      $cms->fail("to see details here set show_sferrors = true in sf-config.php");
   }
} /*-end addon loop-*/

//apply the primary extention style, if relevant style is defined/exists
if (is_readable($include_path . "/extention/primary/$primary_extention/load.inc.php"))
   require($include_path . "/extention/primary/$primary_extention/load.inc.php");













