<?php header('HTTP/1.1 500 Internal Server Error'); ?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
   <head>
      <title>Internal Server Error</title>
   </head>
   <body>
      <h1>StayCMS : Internal Server Error</h1>
      <h2><?php $this->showErrorText(); ?></h2>
      <h3>see the StayCMS documentation for more info</h3>
      <h4><a href="http://katmore.com/sft/staycms/docs/">katmore.com/sft/staycms/docs</a></h4>
      generated <?php echo date ("c"); ?>
   </body>
</html>