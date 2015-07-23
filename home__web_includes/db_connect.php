<?php
  // define('HOST', 'localhost');
  // define('USER', 'coconut');
  // define('PASSWORD', '$^THFIkflwehr');
  // define('DATABASE', 'paradiseOffice'); 
  // the above don't work for some reason
  define('CAN_REGISTER', 'any');
  define('DEFAULT_ROLE', 'user');
  define('SECURE', 'FALSE'); // SSL - set to TRUE
  
  $mysqli = mysqli_connect('127.0.0.1', 'coconut', '$^THFIkflwehr', 'paradiseOffice');
  // check the bloody connection!
  if (mysqli_connect_errno()) {
    exit('Connect failed: '. mysqli_connect_error());
  }
  else
  {
    echo "Database has connected. ";
  }

?>
