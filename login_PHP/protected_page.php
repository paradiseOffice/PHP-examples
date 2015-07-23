<?php
  include_once '/home/web_includes/db_connect.php';
  include_once ('/home/web_includes/functions.php');
  include_once ('/home/web_includes/login.php');
  
  sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <title>Dashboard - Paradise Office</title>
    <meta name="" content="" />
    <link rel="stylesheet" type="text/css" href="styles/forms.css" />
  <script type="text/JavaScript" src="scripts/login_js.js" >  </script>
</head>
<body>
<?php if (login_check($mysqli) == true) : ?>
  <a href="logout.php" title="Log out when finished using the programs">Log Out</a>
  <p>Welcome <?php echo htmlentities($_SESSION['username']); ?>. </p>

  
<?php else : ?>
<div class="errors_area">
<p class="error">You can't access this page! </p>  
</div>
<?php endif; ?>
</body>
</html>
