<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>
        <meta charset="UTF-8" />
         <title><?php $this->showTitletext("%s"); ?><?php $this->showSitename(" - %s"); ?></title>
         <LINK href="<?php $this->showThemeurl(); ?>/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
   <div id="container">
      <div id="top">
   <h1><a href="./"><?php $this->showSitename("%s",true); ?></a></h1> : <h2><?php $this->showHeadingText("%s"); ?></h2>
      </div><!--top-->
      <div id="middle">
   