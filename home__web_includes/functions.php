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
  // insertUser function for registering a user.
function insertUser($fName, $lName, $email, $company, $uName, $password, $salt, $mysqli)
{
  $query = "INSERT INTO users (fName, lName, company, email, uName, password, salt) VALUES ('$fName', '$lName', '$company', '$email', '$uName', '$password', '$salt')" ;
  $result = mysqli_query($mysqli, $query);
  $resultNum = mysqli_num_rows($result);
  if ( $resultNum > 0 )
  {
    header("Location: login.php");
    exit;
  }
  else
  {
    $errors .= "<p>Registration failed! </p>";
  }
}  // end of insertUser function.

function esc_url($url)
{
  if ("" == $url)
  {
    return $url;
  }
  $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|', "", $url);
  $strip = array('%0d', '%0a', '%0D', '%0A');
  $url = (string) $url;
  $count = 1;
  while ($count)
  {
    $url = str_replace($strip, "", $url, $count);
  }
  $url = str_replace(';//', '://', $url);
  $url = str_replace("'", "&#039;", $url);
  
  if ($url[0] !== '/')
  {
    // We're only interested in relative links from $_SERVER['PHP_SELF'];
    return "";
  }
  else
  {
    return $url;
  }
}
?>
