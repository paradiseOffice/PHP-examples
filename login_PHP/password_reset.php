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

  require_once('/home/web_includes/db_connect.php');
  require_once('/home/web_includes/functions.php');
  require_once('/home/web_includes/login.php');
  require_once ('/home/web_includes/encrypt_string.php');
  require_once ('/home/web_includes/recaptchalib.php');
  
if (isset($_POST['send']))
{
  // fetch their entered email... clean up
  $email = trim(strtolower($_POST['email']));
  $query = "SELECT custID, email FROM users WHERE email = :email LIMIT 1";
  $resultEmail = $pdo->prepare($query);
  // see if email is in users table and get user_id.
  $resultEmail->bindValue(':email', $email);
  if ( $resultEmail->execute() ) {
    $row = $resultEmail->fetch(PDO::FETCH_ASSOC);
  }
  $user_id = $row['custID'];
  // echo $user_id; // DEBUG
  global $user_id;
  if ( $row )
  {
    // create random pin, expiration (now time)
    $pin = hash('whirlpool', rand(20,34503));
    // echo "Pin: $pin\n"; // DEBUG
    $now = time();
    // echo "Now: $now\n"; // DEBUG
    // put both variables and user_id in reset table
    $query = "INSERT INTO reset (user_id,pin,now) VALUES (:user_id, :pin, :now)";
    $resultInsert = $pdo->prepare($query);
    $resultInsert->bindValue(':user_id', $user_id);
    $resultInsert->bindValue(':pin', $pin);
    $resultInsert->bindValue(':now', $now);
    if ( !$resultInsert->execute() ) {
      echo "<p>Error in inserting the password reset record</p>";
    }
    // send random pin to registered email
    $subject = "Paradise Office - Forgotten Password Reset";
    $message = "Please use the password reset form to update your password.\r\n "
    $message .= "You will need the following pin. \r\nPlease copy the whole pin by selecting the text, and pressing Ctrl + C, then paste this into the form. \r\n\r\n";
    $message .= $pin;
    $headers = "From: lead-dev@linux-paradise.co.uk" . "\r\n" .
    "Reply-To: lead-dev@linux-paradise.co.uk" . "\r\n"; // change to support email
    // install ssmtp for simple emailing 
    if (mail($email, $subject, $message, $headers))
    {
      $errors .= "<p>Please check your inbox... </p>";
      echo "in Sent if";
    }
    else
    {
      $errors .= "<p>The email didn't get sent.</p>";
    }
  }
  else
  {
    $errors .= "<p>Are you sure you typed in the correct email address that you used to sign up for Paradise Office? </p>";
  }
}  // end if for send click

if (isset($_POST['change']))
{
  // see if the user submits the form too late (after 24 hours from email being sent)
  $changeTime = time();
  $query = "SELECT user_id, pin, now FROM reset WHERE user_id = :user_id LIMIT 1";
  // get user_id.
  $resultReset = $pdo->prepare($query);
  $resultReset->bindValue(':user_id', $user_id);
  $row = $resultReset->FETCH(PDO::FETCH_ASSOC);
  $user_id = $row['user_id'];
  $db_pin = $row['pin'];
  $firstTime = $row['now'];
  $diffTime = $changeTime - $firstTime;
  // echo "difftime:  $diffTime"; // DEBUG
  // check pin in reset table
  $userPin = trim($_POST['pin']);
  // Do more data sweeping on the above
  if ( ($db_pin == $userPin) && ( $diffTime < (24*60*60)) )
  {
    // get new passwords, check they match
    if (trim($_POST['password1']) == trim($_POST['password2']))
    {
      if (preg_match('/[a-zA-Z0-9\-_*^!$]......+/', trim($_POST['password1'])))
      {
        // $rand = new password_hash, password_verify methods 5.5 onwards.
        $password = trim($_POST['passCipher']);
        // encrypt new password
        $cipher_pass = encrypt_string($password);
        
        // captcha stuff ... from Google?!
        $privatekey = "6LfUYu8SAAAAAEvTHX82XEqTB-6cPwTMWN9f5a78";
        $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
        if (!$resp->is_valid) 
        {
          // What happens when the CAPTCHA was entered incorrectly
          die ("Please don't take this the wrong way, but are you a 'spam bot'? <br />Please try signing up again." .      "(reCAPTCHA said: " . $resp->error . ")");
        } 
        else 
        {
          // update db users by user_id, changing password
          $update = "UPDATE users SET password = :cipher_pass' WHERE id = :user_id' LIMIT 1";
          $updResult = $pdo->prepare($update);
          $updResult->bindValue(':cipher_pass', $cipher_pass);
          $updResult->bindValue(':user_id', $user_id);
          $updResult->execute();
          $row = $updResult->FETCH(PDO::FETCH_ASSOC);
          if ( $row )
          {
            $errors .= "<p class='success'>The password has now been updated. Please feel free to <a href='login.php' id='login'>Login</a></p>";
          }
          else
          {
            $errors .= "<p>The password didn't get updated for some reason. </p>";
          }
        }
        // End of captcha - update tables bit.
      }
      else
      {
        $errors .= "<p>Password is under 7 characters or has a weird punctuation character in it or a space. A-Z, numbers, '- _ * ^ ! $' are allowed. </p>";
        $password = "";
      }
    } 
  }  
}  // end if for change click

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <title>Password Reset - Paradise Office</title>
    <meta name="" content="" />
    <link rel="stylesheet" type="text/css" href="styles/forms.css" />
  <script type="text/JavaScript" src="scripts/sha512.js" ></script>  
  <script type="text/JavaScript" src="scripts/login_js.js" > </script>
</head>
<body>

<form method="POST" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
  <fieldset>
  <input type="email" name="email" id="email" placeholder="name@webaddress.com" />
  <input type="submit" id="send" name="send" value="Send" />
  </fieldset>
</form>
<form method="POST" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
  <fieldset>
  <label for="pin">Pin from the email just sent:</label>
  <input type="text" name="pin" id="pin" placeholder="Paste here" /><br />
  <label for="password1">New Password</label>
  <input type="password" name="password1" id="password1" /><br />
  <!-- this gets encrypted in Javascript, sha512 before getting sent to the server's PHP file -->
  <label for="password2">Confirm New Password</label>
  <input type="password" name="password2" id="password2" /><br />
  <input type="hidden" name="passCipher" id="passCipher" value="" />
  </fieldset>
  <fieldset class="captcha">
  <!-- Captcha -->
  <?php
    $publickey = "6LfUYu8SAAAAABixp_frVxvlzKXmaMLWWAVgTRX3"; 
    echo recaptcha_get_html($publickey);
  ?>
  <!-- end of Captcha -->
  </fieldset>
  <fieldset>
  <input type="submit" value="Change" id="change" name="change" onclick="return reset_pass_form(this.form, this.form.pin, this.form.password1, this.form.password2);" />
  </fieldset>
</form>
<div class="errors_area">
  <?php echo $errors; ?>
</div>

</body>
</html>
