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
  <nav class="nav top-nav">
    <ul class="nav-pills">
    <li><a href="special_event.php" id="special" title="Special event" class="glyphicon glyphicon-star-empty">Special event</a></li>
    <li><a href="add_work_hols.php" id="work_hols" class="glyphicon glyphicon-calendar">Days off</a></li>
    <li class="active disabled"><a href="add_bank_holiday.php" id="bank_holiday" title="Next month" class="glyphicon glyphicon-arrow-right">Add bank holiday</a></li>
    <li><strong><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="disabled glyphicon glyphicon-refresh">Recurring Event</a></strong></li>
    </ul>
  </nav>
  
<div class="container">

  <section id="bank_holiday">
  <h2>Bank Holiday</h2>
  <form action="add_bank_holiday.php" id="add_bank_holiday" method="post" class="form">
    <div class="form-group">
    <label for="title" class="sr-only">Holiday</label>
    <input class="form-control" type="text" id="title" name="title"  length="100" placeholder="Holiday title" />
    </div>
    <div class="form-group">
    <label for="shops_open">Shops Open</label>
    <input  class="form-control" type="checkbox" id="shops_open" name="shops_open" />
    </div>
    <div class="form-group">
      <label for="hol_date">Date</label>
      <input type="date" id="hol_date" name="hol_date" class="form-control" placeholder="dd-mm-yyyy" />
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
