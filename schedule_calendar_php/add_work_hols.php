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
  $start_date = trim($_POST['start_date']);
  $end_date = trim($_POST['end_date']); 
  $work_days = $_POST['work_days']; 
  if ($work_days == False) {
    $work_days = 0;
  }
  $hol_days = trim($_POST['hol_days']); 
  if ($hol_days == False) {
    $hol_days = 0;
  }  
  if( empty($_POST['start_date']) ||  empty($_POST['end_date']) )
  {
    $errors .= "\n Please fill in these required fields.";
  }

  if ($_POST['submit']) {
    $insert = "INSERT INTO work_hol (num, start_date, end_date, work_days, hol_days) VALUES (:start_date, :end_date, :work_days, :hol_days ) ";
    $statement = $pdo->prepare($insert);
    $statement->bindValue(":start_date", $start_date);
    $statement->bindValue(":end_date", $end_date);
    $statement->bindValue(":work_days", $work_days);
    $statement->bindValue(":hol_days", $hol_days);
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
    <link rel="stylesheet" type="text/css" href="scripts/lib/bootstrap-3.1.1-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
<script type="text/JavaScript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
</script>
<script type="text/JavaScript" src="scripts/lib/jquery-1.11.2-min.js"></script>
<script type="text/JavaScript" src="scripts/lib/jquery-ui.min.js"></script>
<script type="text/JavaScript" src="scripts/lib/bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
<script type="text/JavaScript" src="scripts/application.js"></script>
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
    <input class="form-control" type="radio" id="work_days" name="work_days" value="1"/>Work <br />
    <input class="form-control" type="radio" id="hol_days" name="hol_days" value="1" />Holiday <br />
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
<footer>
  <nav id="main-nav">
    <ul class="nav navbar-nav">
    <li><a href="new_event.php" >New Event</a></li>
    <li><a href="new_task.php" >New Task</a></li>
    <li><a href="daily.php">Daily</a></li>
    <li><a href="week.php" >Week</a></li>
    <li><a href="month.php" >Month</a></li>
    <li><a href="year.php" >Year</a></li>
    </ul>
  </nav>
</footer>

</body>
</html>
