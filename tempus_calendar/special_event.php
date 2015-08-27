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
   $birthday = $_POST['birthday'];
   $place = trim($_POST['place']); /* A-z - spaces */
   $place = preg_replace('/[^a-zA-Z ]+/', '', $place);
   $details = trim($_POST['details']); /* A-z .,- */
   $details = preg_replace('/[^A-Za-z \.,-]+/', '', $details);

  if(empty($_POST['event']) || empty($_POST['s_day']) )
  {
    $errors .= "\n Please fill in these required fields.";
  }
 
  $insert = "INSERT INTO anniversary (event, s_day, birthday, place, details) VALUES (:event, :s_day, :birthday, :place, :details ) ";
    $statement = $pdo->prepare($insert);
    $statement->bindValue(":event", $event);
    $statement->bindValue(":s_day", $s_day);
    $statement->bindValue(":birthday", $birthday);
    $statement->bindValue(":place", $place);
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
    <input  class="form-control" type="radio" id="yes" name="birthday" value="1">Yes</input>
    <input class="form-control" type="radio" id="no" name="birthday" value="0">No</input>
    </div>
    </div>
      <label for="place" class="sr-only">Attendees: </label>
      <input id="place" name="place" type="text" class="form-control" placeholder="place" />
    <textarea id="details" name="details" class="form-group col-sm-12" placeholder="Details..." rows="4"></textarea>
    <button type="submit" id="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
  </form>
  </section>
  
</div><!--container-->

<?php require_once("footer-nav.php"); ?>

</body>
</html>
