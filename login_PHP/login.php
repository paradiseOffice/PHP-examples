<?php

  /*******************************************************************
 * 
 * Paradise Office 
 * Copyright (c) 2013 Hazel Windle
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 *  Email me at: lead-dev@linux-paradise.co.uk if you have any problems or questions.
 *
************************************************************************/

  include_once '/home/web_includes/db_connect.php';
  include_once '/home/web_includes/functions.php';
  include_once '/home/web_includes/login.php';
  
  header('X-Frame-Options: deny');
  session_start(); // starting secure session.
  
  if (isset($_POST['login']))
  {
    $enteredUser = trim($_POST['user']);
    $enteredPass = $_POST['passCipher']; // altered via js
    if (login($enteredUser, $enteredPass, $pdo) == true)
    {
      // Login success
      header('Location: dashboard.php');
    }
    else
    {
      // Login failed
      //header('Location: error.php');
      echo "Login failed\n";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <title>Login</title>
    <meta name="" content="" />
    <link rel="stylesheet" type="text/css" href="styles/forms.css" />
  <!-- This isn't for production use as I can't find the below files anywhere -->
  <script type="text/JavaScript" src="scripts/sha512.js" ></script>
  <script type="text/JavaScript" src="scripts/login_js.js" ></script>
</head>
<body>
  
<div id="login_container">
  <form id="login" method="POST" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
    <fieldset>
    <input type="text" name="user" id="user" placeholder="User Name" />
    <input type="password" name="password" id="password" placeholder="Password" />
    <input type="hidden" name="passCipher" id="passCipher" value="" />
    <input type="submit" value="Log In" id="login" name="login" onclick="return hash_password_client(this.form, this.form.password);" />
    </fieldset>
  </form>
  <a href="register.php" title="Create an account by signing up">Register</a>
<div class="errors_area">
  <?php echo $errors; ?>
</div>


</div>

</body>
</html>
