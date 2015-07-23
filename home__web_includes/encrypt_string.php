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
  /* encrypt_string.php 
  * : contains the functions encrypt_string($string).
  * 
  */

function encrypt_string($string)
{
   /* Salting method (OpenSSL, bcrypt).
        Encodes the given data with base64.
    * This encoding is designed to make binary data survive transport * through transport layers that are not 8-bit clean, such as mail * bodies.
    * Base64-encoded data takes about 33% more space than the  original data. 
   *To generate the salt, first generate enough random bytes. Because
   * base64 returns one character for each 6 bits, the we should generate
   * at least 22*6/8=16.5 bytes, so we generate 17. Then we get the first
   * 22 base64 characters
   */
  // password already hashed in js .
  $ciphertext = hash('whirlpool', $string);  
  // debug
  $length = strlen($ciphertext);
  echo "Cipher length: $length\n";
  // debug
  return $ciphertext;
} // end of function encrypt_string($string)
       
function get_rand_string($length)
{
      $string = substr(base64_encode(openssl_random_pseudo_bytes(17)),0,$length);
      return $string;
}