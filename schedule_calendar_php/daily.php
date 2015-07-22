<?php
  
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
    <?php include_once("links.php"); ?>
</head>
<body>

  <header>
    <h1><?php $todayTitle = date("l dS F Y");
        echo $todayTitle;
        ?>
    </h1>
    
  </header>
  <nav class="nav nav-pills top-nav">
    <ul>
    <li><a href="#" id="yesterday" title="Yesterday" class="glyphicon glyphicon-arrow-left"></a></li>
    <li><a href="#" id="today" >Today</a></li>
    <li><a href="#" id="tomorrow" title="Tomorrow" class="glyphicon glyphicon-arrow-right"></a></li>
    </ul>
  </nav>
<div class="container-fluid" >
  <div class="col-sm-8 col-md-8" id="diarypage">  
    <div class="col-sm-1 col-md-1" id="timetracker">
    <ul>
    <span id="hidden-date"><?php 
      $now = date("Y-m-d");
    ?></span>
<?php
function drawData($today) {
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
  
  if ($pdo != NULL ) {
    //$today = date("Y-m-d");
    $select = "SELECT s_day, start_time, end_time, activity FROM time_usage WHERE s_day = :today ORDER BY start_time";
    $statement = $pdo->prepare($select);
    $statement->bindValue(":today", $today);
    $statement->execute();
    if ($statement !== 0) 
    {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
          print("<li id='" . $row["start_time"] . "' class='tt_activity'><p>" . $row["activity"] . "</p></li>");
        }
    }
    else 
    {
      print("<li> </li>");
    } 
  } 
  else 
  {
    print("<p class=\"error\">Connection to the database has failed.</p>");
  }
?>  
    </ul>
    </div>
    <div class="col-sm-2 col-md-2" id="times">
      <ul>
      <li class="0800">8:00 </li>
      <li class="0830">8:30 </li>
      <li class="0900">9:00 </li>
      <li class="0930">9:30 </li>
      <li class="1000">10:00</li>
      <li class="1030">10:30</li>
      <li class="1100">11:00</li>
      <li class="1130">11:30</li>
      <li class="1200">12:00</li>
      <li class="1230">12:30</li>
      <li class="1300">13:00</li>
      <li class="1330">13:30</li>
      <li class="1400">14:00</li>
      <li class="1430">14:30</li>
      <li class="1500">15:00</li>
      <li class="1530">15:30</li>
      <li class="1600">16:00</li>
      <li class="1630">16:30</li>
      <li class="1700">17:00</li>
      <li class="1730">17:30</li>
      <li class="1800">18:00</li>
      <li class="1830">18:30</li>
      <li class="1900">19:00</li>
      <li class="1930">19:30</li>
      <li class="2000">20:00</li>
      <li class="2030">20:30</li>
      <li class="2100">21:00</li>
      <li class="2130">21:30</li>
      <li class="2200">22:00</li>
      <li class="2230">22:30</li>
      <li class="2300">23:00</li>
      </ul>
    </div>
    <div class="col-sm-5 col-md-5" id="listings-todo">
<?php

  if ($pdo !== 0 ) {
    //$today = date("dmY");
    $recurSql = "SELECT * FROM routine_events LEFT JOIN categories ON routine_events.cat_id = categories.cat_id ORDER BY start_time";
    $statement = $pdo->prepare($recurSql);
    // This needs some JavaScript to take the start date and recurs
    // and create the recurring dates
    $statement->execute();
    if ($statement !== 0) 
    {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
          $html = "<div class='routine-event " . $row["start_time"] . "'>\n";
          $html .= "<h3 class='summary' style='background-color: " . $row["colour"] . ";'>" . $row["event"] . "</h3>\n";
          $html .= "<div class='event-details'>\n<span class='time'>Starts " . $row["start_time"] . "</span>";
          $html .= "<span class='time'> Ends " . $row["end_time"] . "</span> Recurring  " . $row["recurs"] . "<br />\n";
          $html .= "<h4 class='place'>" . $row["place"] . "</h4>\n";
          $html .= "<p>" . $row["details"] . "</p>\n<p class='attendees'>" .$row["attendees"] . "<br />\n<span class='category'>" . $row["name"] . "</span>";
          $html .= "<a href='" . $row["url"] . "' target='blank'>Web Link</a></p></div>";
          echo $html;

          }
        }
    }
     
    echo "</div>\n<div class='col-sm-4 col-md-4' id=\"listings-routine\">";

    $todoSql = "SELECT * FROM todo_item  LEFT JOIN categories ON todo_item.cat_id = categories.cat_id WHERE s_day = :today ORDER BY start_time";
    $statement = $pdo->prepare($todoSql);
    $statement->bindValue(":today", $today);
    $statement->execute();
    if ($statement !== 0) 
    {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
            print("<div class='todo " . $row["start_time"] . "'>\n<h3 class='summary' style='background-color: " . $row["colour"] . ";'>" . $row["task"] . "</h3>\n<div class='todo-details'>\n<p><span class='time'>Starts " . $row["start_time"] . "</span><span class='time'> Ends " . $row["end_time"] . "</span> <span class='category'> " . $row["name"] . "</span></p>\n<p>" . $row["details"] . "</p>\n<p class='priority'>" . $row["priority"] . "</p></div>");
        }
    }

  
  else 
  {
    print("<p class=\"error\">Connection to the database has failed.</p>");
  }
} // end of function

drawData($now);              
?> 
    </div>    
  </div></div>
  <div class="col-sm-4 col-md-4" id="notes">
    <h3>Notes</h3>
    <textarea class="form-control" id="todo-area" rows="8" placeholder="type here"></textarea>
    <button class="form-control" id="add-todo">Add Item</button>
    <ol class="todo-list"></ol>
  </div>
</div>



<footer>
  <nav id="main-nav">
    <ul class="nav navbar-nav">
    <li><a href="new_event.php" >New Event</a></li>
    <li class="active disabled"><a href="daily.php">Daily</a></li>
    <li><a href="month.php" >Month</a></li>
    <li><a href="year.php" >Year</a></li>
    </ul>
  </nav>
</footer>

</body>
</html>
