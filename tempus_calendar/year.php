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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
     <title>Year</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="" content="" />
    <?php include_once("links.php");
    date_default_timezone_set("Europe/London");
    ?>
    
</head>
<body class="year-page">

  <header>
    <h1><?php echo date("Y"); ?></h1>
  </header>
    <nav class="nav top-nav">
    <ul class="nav-pills">
    <li><a href="special_event.php" id="special" title="Special event" class="glyphicon glyphicon-star-empty">Special event</a></li>
    <li><a href="add_work_hols.php" id="work_hols" class="glyphicon glyphicon-calendar">Days off</a></li>
    <li class="active disabled"><a href="add_bank_holiday.php" id="bank_holiday" title="Next month" class="glyphicon glyphicon-arrow-right">Add bank holiday</a></li>
    <li><strong><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="disabled glyphicon glyphicon-refresh">Recurring Event</a></strong></li>
    </ul>
  </nav>
  
<div class="container-fluid">
  <div class="month col-sm-1" id="jan">
    <h2>January</h2>
  </div>
  <div class="month col-sm-1" id="feb">
    <h2>February</h2>
    <div class="special-event">Sister's Birthday</div>
  </div>
  <div class="month col-sm-1" id="mar">
    <h2>March</h2>
  </div>
  <div class="month col-sm-1" id="apr">
    <h2>April</h2>
  </div>
  <div class="month col-sm-1" id="may">
    <h2>May</h2>
  </div>
  <div class="month col-sm-1" id="jun">
    <h2>June</h2>
    <div class="special-event">Swing Jazz Concert 11:30pm-12:30pm</div>
  </div>
  <div class="month col-sm-1" id="jul">
    <h2>July</h2>
  </div>
  <div class="month col-sm-1" id="aug">
    <h2>August</h2>
  </div>
  <div class="month col-sm-1" id="sep">
    <h2>September</h2>
  </div>
  <div class="month col-sm-1" id="oct">
    <h2>October</h2>
    <div class="hols">2nd-23rd long break</div>
  </div>
  <div class="month col-sm-1" id="nov">
    <h2>November</h2>
  </div>
  <div class="month col-sm-1" id="dec">
    <h2>December</h2>
    <div class="hols">25th December: Christmas</div>    

  </div>

<!-- container div --></div>

<?php require_once("footer-nav.php"); ?>

</body>
</html>
