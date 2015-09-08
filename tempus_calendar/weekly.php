<?php
  require_once 'common_libs.php';
  $pdo = db_connect();
  $errors = '';
  
  $dtz = new DateTimeZone('Europe/London');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
     <title>Month - Year</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="" content="" />
    <?php require_once("links.php");  ?>
    
</head>
<body>

 

<?php require_once("footer-nav.php"); ?>

</body>
</html>
