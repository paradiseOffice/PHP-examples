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


 if (isset($_POST['submit'])) {
   $event = trim($_POST['event']); /* a-z A-Z spaces */
   $event = preg_replace('/[^a-zA-Z ]+/', '', $event);
   $s_day = $_POST['s_day']; 
   $yearly = $_POST['yearly'];
   $attendees = trim($_POST['attendees']); /* A-z - spaces */
   $attendees = preg_replace('/[^a-zA-Z ]+/', '', $attendees);
   $details = trim($_POST['details']); /* A-z .,- */
   $details = preg_replace('/[^A-Za-z \.,-]+/', '', $details);

  if(empty($_POST['event']) || empty($_POST['s_day']) )
  {
    $errors .= "\n Please fill in these required fields.";
  }
 
  $insert = "INSERT INTO special_events (event, s_day, yearly, attendees, details) VALUES (:event, :s_day, :yearly, :attendees, :details ) ";
    $statement = $pdo->prepare($insert);
    $statement->bindValue(":event", $event);
    $statement->bindValue(":s_day", $s_day);
    $statement->bindValue(":yearly", $yearly);
    $statement->bindValue(":attendees", $attendees);
    $statement->bindValue(":details", $details);
    if ($statement->execute()) 
    {
    $errors .= "\n Your event was successfully saved.";
    } 
    else 
    {
    $errors .= "\n Unable to insert record!";
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
    <li><a href="add_bank_holiday.php" id="bank_holiday" class="">Add bank holiday</a></li>
    <li><strong><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="disabled glyphicon glyphicon-refresh">Recurring Event</a></strong></li>
    </ul>
  </nav>
  
<div class="container">

  <section id="special_event_form">
  <h2>Special Event</h2>
  <form action="special_event.php" method="post" class="form">
    <div class="form-group">
    <input class="form-control" type="text" id="event" name="event"  length="100" placeholder="event name" />
    </div>
    <div class="form-group">
    <div class="col-sm-5">
    <label for="s_day">Date: </label>
    <input  class="form-control" type="date" id="s_day" name="s_day" placeholder="dd/mm/yyyy" />
    </div>
    <div class="col-sm-7">
    <label for="end_time">Yearly: </label>
    <input  class="form-control" type="radio" id="yes" name="yearly" value="1">Yes</input>
    <input class="form-control" type="radio" id="no" name="yearly" value="0">No</input>
    </div>
    </div>
      <label for="attendees" class="sr-only">Attendees: </label>
      <input id="attendees" name="attendees" type="text" class="form-control" placeholder="attendees" />
    <textarea id="details" name="details" class="form-group col-sm-12" placeholder="Details..." rows="4"></textarea>
    <button type="submit" id="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
  </form>
  </section>
  
</div><!--container-->
<footer>
  <nav id="main-nav">
    <ul class="nav navbar-nav">
    <li><a href="new_event.php" >New Event</a></li>
    <li><a href="daily.php">Daily</a></li>
    <li><a href="month.php" >Month</a></li>
    <li><a href="year.php" >Year</a></li>
    </ul>
  </nav>
</footer>

</body>
</html>
