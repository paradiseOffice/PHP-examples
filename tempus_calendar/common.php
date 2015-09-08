<?php

require('/var/www/html/settings.php');
$pdo = new PDO(
  sprintf('mysql:host=%s;dbname=%s;port=%s;charset=%s',
    $settings['host'],
    $settings['dbname'],
    $settings['port'],
    $settings['charset']
    ),
    $settings['username'],
    $settings['password']
    );
    
  $errors = '';
  $dtz = new DateTimeZone('Europe/London'); 