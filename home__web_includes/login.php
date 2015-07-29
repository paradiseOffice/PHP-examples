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

require_once '/home/web_includes/db_connect.php';
require_once '/home/web_includes/encrypt_string.php';
  
function sec_session_start() 
{
  $session_name = 'sec_session_id';
  $secure = SECURE; // only if using SSL
  // This stops Javascript being able to access the session ID
  $httponly = true;
  // Forces sessions to use only cookies.
  /*
  if (ini_set('session_use_only_cookies', 1) === FALSE)
  {
    header("Location: ../error.php"); // Remember to create an error page.
    exit();
  }  */ // BUG?
  // Gets current cookie settings. Mmm... cookies.
  $cookieParams = session_get_cookie_params();
  session_set_cookie_params( // chocolate chip...
    $cookieParams["lifetime"],
    $cookieParams["path"],
    $cookieParams["domain"],
    $secure,
    $httponly);
  // Sets the session name to the one set above.
  session_name($session_name);
  session_start(); // start the PHP session
  session_regenerate_id(); // Deletes old ID and creates new shiny one.
}

function login($uName, $password, $mysqli)
{

  // Using prepared statements like below stops MySQL injection attacks.
  if ($stmt = mysqli_query($mysqli, "SELECT custID, uName, email, password FROM users WHERE email = '$uName' OR uName = '$uName' LIMIT 1"))
  {
    $row = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
    $user_id = $row["custID"];
    $uName = $row["uName"];
    $email = $row["email"];
    $db_pass = $row["password"];
    // $salt = $row['salt'];
    // the entered password from the user - sha512 hashed
    $cipher_pass = encrypt_string($password);
    // $cipher_pass = $salt . $cipher_pass;
    
    // $db_pass = $salt . $db_pass;
    
    if (mysqli_num_rows($stmt) == 1)
    {
      // checking whether the user exists
      // Have they tried to login too many times?
      if (checkbrute($user_id, $mysqli) == true)
      {
        // account is locked out
        $to = $email;
        $subject = "Too many failed login attempts";
        $message = "Your account has been locked due to more than 5 failed attempts at logging in.";
        $headers = "From: lead-dev@linux-paradise.co.uk\r\n"; // change to support email
        $send = mail($to, $subject, $message, $headers);
        // Put reset link in message, for the forgotten password page.
        return false;
      }
      else
      {
        // check the passwords match
        if (password_verify($cipher_pass, $db_pass))
        {
          // Get the user agent string
          $user_browser = $_SERVER['HTTP_USER_AGENT'];
          // Protecting against bad guys using XSS attacks
          // echo $user_browser; // DEBUG
          $_SESSION['user_id'] = $user_id;
          $user_id = preg_replace("/[^0-9]+/", "", $user_id);
          $_SESSION['username'] = $uName; 
          $uName = preg_replace("/[^a-zA-Z0-9\-_]+/", "", $uName);
          $_SESSION['login_string'] = hash('whirlpool', $cipher_pass . $user_browser);
          return true;
        }
        else
        {
          // Password is wrong! Record attempt.
          $now = time();
          mysqli_query($mysqli, "INSERT INTO login_attempts(userid, time) VALUES ('$user_id', '$now')");
          return false;
        }
      } // if - check brute force
    }
    else
    {
      // No user exists!
      return false;
    }
  }
}

function checkbrute($user_id, $mysqli)
{

  // Get timestamp of current time
  $now = time();
  // Count all login attempts from past two hours.
  $valid_attempts = $now - (2 * 60 * 60);
  if ($stmt = mysqli_prepare($mysqli, "SELECT time FROM login_attempts WHERE userid = ? AND time > '$valid_attempts'"))
  {
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    // Execute prepared query
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id);
    mysqli_stmt_fetch($stmt);
    
    // There's been more than 5 failed login attempts!
    if (mysqli_stmt_num_rows($stmt) > 5)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}

function login_check($mysqli)
{
  if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string']))
  {
    $user_id = $_SESSION['user_id'];
    $login_string = $_SESSION['login_string'];
    $uName = $_SESSION['username'];
    // Get the user agent of the user.
    $user_browser = $_SERVER['HTTP_USER_AGENT'];
    if ($stmt = mysqli_prepare($mysqli, "SELECT password FROM users WHERE id = ? LIMIT 1"))
    {
      // bind 'user_id'
      mysqli_stmt_bind_param($stmt, 'i', $user_id);
      // Execute prepared query
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $user_id);
      mysqli_stmt_fetch($stmt);
     
      if (mysqli_num_rows($stmt) == 1)
      {
        // if the user exists get password variable
        mysqli_stmt_bind_result($stmt, $password);
        // mysqli_stmt_bind_result($stmt, $salt);
        mysqli_stmt_fetch($stmt);
        
        $login_check = $password . $user_browser;
        $login_check = hash('whirlpool', $login_check);
        
        if ($login_check == $login_string)
        {
          return true;
        }
        else
        {
          echo "\nLogin strings don't match, check salts and things.";
          return false;
        }
      }
      else
      {
        echo "\nNo user found by that name\n";
        return false;
      }
    }
    else
    {
      echo "\nCouldn't get the password and salt from users, problem with select query. \n";
      return false;
    }
  }
  echo "User id: " . $_SESSION['user_id'] . "\nusername: " . $_SESSION['username'] . "\n Login string: \n" .  $_SESSION['login_string'];
} // end of function login_check


  
