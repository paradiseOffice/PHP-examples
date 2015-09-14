<?php

function insert_bank_holiday() {
  require_once 'common_libs.php';
  $pdo = db_connect();
  $errors = '';
  $dtz = new DateTimeZone('Europe/London'); 
  
  
  if ($pdo !== 0) {
    if (isset($_POST['submit'])) {
      if( empty($_POST['title']) ||  empty($_POST['hol_date'])) {
        $errors .= '<p> Please fill in these required fields.</p>';
      }
      $title = trim($_POST['title']); /* a-z A-Z spaces */
      $title = preg_replace('/[^a-zA-Z \']+/', '', $title);
      (isset($_POST['shops_open'])) ? $shops_open = 1 : $shops_open = 0; 
      $dirty_date = trim($_POST['hol_date']);
      $dirty_date = preg_replace('/[^\d]*/', '', $dirty_date);
      $year = substr($dirty_date, -4, 4);
      $month = substr($dirty_date, -6, 2);
      $date = substr($dirty_date, 0, 2);
      $clean_date = $year . $month . $date . ' 12:00';
      $hol_date = new DateTime($clean_date, $dtz);
      $hol_date = $hol_date->format('Ymd');
      $insert = 'INSERT INTO bank_holidays (title, shops_open, hol_date) VALUES (:title, :shops_open, :hol_date ) ';
      $statement = $pdo->prepare($insert);
      $statement->bindValue(':title', $title);
      $statement->bindValue(':shops_open', $shops_open);
      $statement->bindValue(':hol_date', $hol_date);
      if ($statement->execute()) {
        $errors .= '<p class="success"> Your event was successfully saved.</p>';
        return $pdo->lastInsertId();
      } else {
        $errors .= '<p> Unable to insert record!</p>';
        return false;
      }
    } // submit isset
  } // pdo
  
} // function end 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
     <title>Tempus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="" content="" />
<?php require_once('links.php'); ?>
</head>
<body>

  <header>
    <h1>Tempus</h1>
    <h2>Add Bank Holiday</h2>
  </header>
  <nav class="top-nav">
    <ul class="nav-elements">
    <li><a href="special_event.php" id="special" title="Special event" class="glyphicon glyphicon-star-empty">Special event</a></li>
    <li><a href="add_work_hols.php" id="work_hols" class="glyphicon glyphicon-calendar">Days off</a></li>
    <li class="active disabled"><a href="add_bank_holiday.php" id="bank_holiday" title="Next month" class="disabled glyphicon glyphicon-arrow-right">Add bank holiday</a></li>
    <li><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="glyphicon glyphicon-refresh">Recurring Event</a></li>
    </ul>
  </nav>
  
<div class="container">

  <section id="bank_holiday">
  <h2>Bank Holiday</h2>
  <form action="add_bank_holiday.php" id="add_bank_holiday" method="post" class="form">
    <div class="row prefix-round">
    <label for="title" class="right inline">Holiday</label>
      <div class="small-3 large-2 columns">
        <span class="button prefix">Label </span>
      </div>
      <div class="small-6 large-8 columns">
        <input class="" type="text" id="title" name="title"  length="100" placeholder="title" />
        <!-- next to columns class, put error
        <small class="error">testing Invalid entry</small>
        -->
      </div>
    </div>
    <div class="row">
    <label for="shops_open" class="right inline">Shops Open
      <input  class="small-8 large-9 columns" type="checkbox" id="shops_open" name="shops_open" />
    </label>
    </div>
    <div class="row">
      <input type="date" id="hol_date" name="hol_date" class="small-5 large-8 columns" placeholder="dd-mm-yyyy" />
      <label for="hol_date" class="left inline">Date</label>
    </div>

    <input type="submit" id="submit" name="submit" class="btn btn-primary btn-lg" value="Add" />
  </form>
  </section>
  <?php 
    try {
      $id = insert_bank_holiday(); 
      echo '<span id="sql-id" name="sql-id" style=" position: relative; left: -5000px; ">' . $id . '</span>';
    } catch (PDOException $e) {
      $errors .= '<p class="sql-error">PDO Exception ' . $e . '</p>';
    }
  ?>
  
</div><!--container-->

<?php require_once('footer-nav.php'); ?>

</body>
</html>
