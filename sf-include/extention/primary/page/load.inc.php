<?php

   if (isset($_GET["p"])) {
      $page = $cms->getPage($content_path,$_GET["p"]);
   } else {
      $page = $cms->getPage($content_path,"home");
   }
   
   /*
    * show errors if relevant
    */
   if ( (!$page)) {
      $msg = "not created";
      if ($show_sferrors)
      if (isset($_GET["p"])) { 
         $msg .= ": p='" . htmlentities($_GET["p"])."'";
      }
      if ($show_sferrors) $cms->fail("page",$msg);
      $cms->fail("to see details here set show_sferrors = true in sf-config.php");
   }
   
   /*
    * finish it
    */
   if (isset($time_start)) {
      $page->setTimestart($time_start);
   } else {
      $page->setTimestart();
   }
   $page->setTheme($theme_path,$theme_baseurl);
   $page->setLinkformat($content_linkformat);
   $page->setSitename($site_name);
   $page->setSitecopyright($site_copyright);
   $page->setHomebaseurl($home_baseurl);
   
   $page->show();
   
