StayCMS is content management system framework, written in PHP, designed to be simple to configure, apply, and extend.

Project Homepage
   http://katmore.com/sft/staycms
   
Social:
   staycms@katmore.com http://twitter.com/katmoresoft
   
Quickstart / Configuration:
   http://katmore.com/sft/staycms/docs/txt/quickstart
      1) expand package (staycms-latest.zip)
      2) edit sf-config.php appropriately, it is well commented
      3) edit/add to content as appropriate
      4) edit theme as seen fit

Themes, and Content:
   The default package is intended to make 'theme' based webpage content available
   for display to an end user. Page display is determined by REQUEST URI. For
   example, the following URI:
      http://example.com/sf.php?p=contact-us
         will cause StayCMS to use the 'theme' file
      sf-theme/{my_theme}/page.inc.php
         the 'theme' file will include the 'content'
      sf-content/{my_content}/contact-us.inc.php
   But if the default theme in 'sf-config.php' file is changed, the same
   'content' will display but with the different theme.

Repository and source
   https://github.com/katmore/staycms
   
License
   http://mirrors.katmore.com/staycms/LICENSE.txt
   
Download
   http://mirrors.katmore.com/staycms
   
Latest release
   http://mirrors.katmore.com/staycms/staycms-latest.zip

Documentation: 
   http://katmore.com/sft/staycms/docs
   
Road Map / Feature Wish List:
   http://katmore.com/sft/staycms/docs/txt/todo
   
StayCMS Framework Specification:
   Purpose:
      The purpose of the StayCMS Framework is to provide a means to conviently
      create and manage resources available to an end-user.
   
   Prime Directives:
      The StayCMS Framework and all valid componants must:
          1) never require database connectivity for its stated purpose
          2) be constrained by RESTful practices

   Architecture:
      StayCMS architecture implements features by the use of the following
      componants 'core', 'extention', 'module', and 'widget'.

   Instance:
      A StayCMS instance is one particular execution of a StayCMS
      implementation.
   
   Implementation:
   A StayCMS implementation is a set of resources available in a given setting.
   A valid StayCMS implementation loads only one primary extention per 
   instance, and makes the core available to all StayCMS architecture
   componants.
   
   Extention:
      Extentions affect what resources are available to an end user. There are
      'primary' extentions and 'addon' extentions.

      Primary Extention:
      Only one primary extention can be applied per StayCMS Instance, though
      multiple primary extentions may still be available to a particular end
      user depending on the implementation.

      Addon Extention:
      An addon extention can be dependant on a particular primary extention
      though it does not have to be. Addon extentions are designed primarily to
      affect the processing of a resource into display.

   Package:
      A distribution of a StayCMS Framework implementation with a limited
      scope. For example; the intended scope of the default 'staycms' package
      (distributed at mirrors.katmore.com/staycms) is creating a traditional
      website.      

Release History: (see CHANGELOG for details)
   2012-05-06: staycms-0.6 release
   
   2011-03-21: staycms-0.5 release
   
   2011-03-16: staycms-0.4 release
   
   2011-03-04: staycms-0.3 release
   
   2011-02-23: staycms-0.2 release
   
   2011-02-22: staycms-0.1 release