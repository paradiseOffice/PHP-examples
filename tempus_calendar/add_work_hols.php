<?php
  include('../settings.php');
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
  
   
  
  if ($pdo !== 0) {
    if (isset($_POST['submit'])) {
      if( empty($_POST['start_date']) ||  empty($_POST['end_date']) )
      {
        $errors .= "\n Please fill in these required fields.";
      }
      $start_date = trim($_POST['start_date']);
      $end_date = trim($_POST['end_date']); 
      $work = $_POST['work']; 
      $holiday = trim($_POST['holiday']); 
      $start_date = preg_replace('/[^0-9]+/', '', $start_date);
      $end_date = preg_replace('/[^0-9]+/', '', $end_date);
      if ($holiday == False) {
        $holiday = 0;
      } 
      if ($work == False) {
        $work = 0;
      }
      $insert = "INSERT INTO work_hol (start_date, end_date, work, holiday) VALUES (:start_date, :end_date, :work, :holiday ) ";
      $statement = $pdo->prepare($insert);
      $statement->bindValue(":start_date", $start_date);
      $statement->bindValue(":end_date", $end_date);
      $statement->bindValue(":work", $work);
      $statement->bindValue(":holiday", $holiday);
      if ($statement->execute()) 
      {
        $errors .= "\n Your event was successfully saved.";
      } 
      else 
      {
        $errors .= "\n Unable to insert record!";
      }
    }
  }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
     <title>Tempus - New Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="" content="" />
    <?php include_once("links.php"); ?>
   
</head>
<body>

  <header><h1>New Event</h1></header>
    <nav class="nav top-nav">
    <ul class="nav-pills">
    <li><a href="special_event.php" id="special" title="Special event" class="glyphicon glyphicon-star-empty">Special event</a></li>
    <li><a href="add_work_hols.php" id="work_hols" class="glyphicon glyphicon-calendar">Days off</a></li>
    <li class="active disabled"><a href="add_bank_holiday.php" id="bank_holiday" title="Next month" class="glyphicon glyphicon-arrow-right">Add bank holiday</a></li>
    <li><strong><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="disabled glyphicon glyphicon-refresh">Recurring Event</a></strong></li>
    </ul>
  </nav>
  
<div class="container">

  <section id="work_hols">
  <h2>Add Holiday Days</h2>
  <form action="add_work_hols.php" method="post" class="form">
    <div class="form-group">
    <input class="form-control" type="radio" id="work" name="work" value="1"/>Work <br />
    <input class="form-control" type="radio" id="holiday" name="holiday" value="1" />Holiday <br />
    </div>
    <div class="form-group">
    <div class="col-sm-6">
    <label for="start_date">Start Date</label>
    <input  class="form-control" type="date" id="start_date" name="start_date" placeholder="dd-mm-yyyy" />
    </div>
    <div class="col-sm-6">
    <label for="end_date">End Date </label>
    <input  class="form-control" type="date" id="end_date" name="end_date" placeholder="dd-mm-yyyy"  />
    </div></div>
    <button type="submit" id="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
  </form>
  </section>
  
</div><!--container-->

<?php require_once("footer-nav.php"); ?>

</body>
</html>
