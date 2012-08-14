<?php
   //see what host
   $addon->initMultisite($content_dir,$themes_dir);
   
   $queryval = array();
   
   //do it like this by default
   //$multisite_contentns
   if (is_array($multisite_contentns)) {
      foreach($multisite_contentns as $mbr) {
         $derive = "Contentns" . $mbr;
         $addon->$derive();
      }
   } else {
      if (isset($multisite_contentns)) {
         if ($multisite_contentns != "") {    
            $derive = "Contentns" . $multisite_contentns;
            $addon->$derive();
         }
      } else { /*-if no setting, our default-*/
         $addon->ContentnsByHostname();
      }
   }
   //see if folder folder exists
   //if (file_exists("$content_dir/" . $_SERVER['SERVER_NAME'])) {
   //   $addon->changeContentnsIfHostname($_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']);
   //}
   
   
   //see if there's a hash table of hosts/content id's
      //add them to hash in class
   //get the namespace to use
   
   //add to urladd
   if ($addon->getContentns() != $content_name) {
      $queryval["ns"] = $addon->getContentns();
   }

   //change the $content_path to 
   $content_path = "$content_dir/" . $addon->getContentns();

   //see if there are settings
   if (is_readable("$content_path/" . "reserved-settings.inc.php")) {
      //require the settings
      require("$content_path/" . "reserved-settings.inc.php");
      
      //serialize a setting name
      $overridethemevar = $addon->getContentns() . "_theme";
      //echo "overridethemevar:$overridethemevar<br>";
      
      //see if setting exists
      if (isset($$overridethemevar)) {
         //echo "it exists as serialized:value is:" . $$overridethemevar . "<br>";
         //see if theme exists in folder
            //do that later
         $theme_name = $$overridethemevar;
         $theme_path = "$themes_dir/$theme_name";
         $theme_baseurl = $home_baseurl . "$theme_folder/$theme_name";
      }
      
   }

   if (is_array($multisite_contentns)) {
      foreach($multisite_theme as $mbr) {
         $derive = "Theme" . $mbr;
         $addon->$derive();
      }
   }
   
   if ($addon->getTheme() !== false) {
      $theme_name = $addon->getTheme();
      $theme_path = "$themes_dir/$theme_name";
      $theme_baseurl = $home_baseurl . "$theme_folder/$theme_name";
      $queryval["t"] = $theme_name;
   }
   
   
   
   
   
   
   
   
   
   
   
   
   