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
    <link rel="stylesheet" type="text/css" href="scripts/lib/bootstrap-3.1.1-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <!--
    <link rel="stylesheet" type="text/css" href="css/black_and_white.css" />-->
<script type="text/JavaScript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
</script>
<script type="text/JavaScript" src="scripts/lib/jquery-1.11.2-min.js"></script>
<script type="text/JavaScript" src="scripts/lib/jquery-ui.min.js"></script>
<script type="text/JavaScript" src="scripts/lib/bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
<script type="text/JavaScript" src="scripts/application.js"></script>
<?php
<script type="text/JavaScript">
  echo "$(document).ready(function() {\n";
  if ($pdo != NULL ) {
    $today = date("d m Y");
    $recurSql = "SELECT * FROM routine_events WHERE s_day = :today ORDER BY start_time";
    $statement = $pdo->prepare($recurSql);
    $statement->bindValue(":today", $today);
    $statement->execute();
    if ($statement !== 0) 
    {
        print("var routineArray = [];\n");
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
          for ($i = 0; $i < count($row); $i++) 
          {
            print("var routineArray[$i] = \"<div class='routine-event $row[\"start_time\"]'>\n<h3 class='summary'>$row[\"event\"]</h3>\n<div class='event-details'><span class='time'>Starts $row[\"start_time\"]</span><span class='time'> Ends $row[\"end_time\"]</span>\" Recurring $row[\"recurs\"]<br />\n<h4 class='place'>$row[\"place\"]</h4>\n<p>$row[\"details\"]</p>\n<p class='attendees'>$row['attendees'] <br />\n<a href='$row[\"url\"]' target='blank'>$row[\"url\"]</a></p>\n</div>\n");
            if ($row['start_time'] >= "8:00:00" || $row['start_time'] <= "8:30:00") {
              print("$('#listings.0800').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "8:30:00" || $row['start_time'] <= "9:00:00") {
              print("$('#listings.0830').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "9:00:00" || $row['start_time'] <= "9:30:00") {
              print("$('#listings.0900').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "9:30:00" || $row['start_time'] <= "10:00:00") {
              print("$('#listings.0930').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "10:00:00" || $row['start_time'] <= "10:30:00") {
              print("$('#listings.1000').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "10:30:00" || $row['start_time'] <= "11:00:00") {
              print("$('#listings.1030').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "11:00:00" || $row['start_time'] <= "11:30:00") {
              print("$('#listings.1100').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "11:30:00" || $row['start_time'] <= "12:00:00") {
              print("$('#listings.1130').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "12:00:00" || $row['start_time'] <= "12:30:00") {
              print("$('#listings.1200').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "12:30:00" || $row['start_time'] <= "13:00:00") {
              print("$('#listings.1230').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "13:00:00" || $row['start_time'] <= "13:30:00") {
              print("$('#listings.1300').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "13:30:00" || $row['start_time'] <= "14:00:00") {
              print("$('#listings.1330').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "14:00:00" || $row['start_time'] <= "14:30:00") {
              print("$('#listings.1400').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "14:30:00" || $row['start_time'] <= "15:00:00") {
              print("$('#listings.1430').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "15:00:00" || $row['start_time'] <= "15:30:00") {
              print("$('#listings.1500').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "15:30:00" || $row['start_time'] <= "16:00:00") {
              print("$('#listings.1530').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "16:00:00" || $row['start_time'] <= "16:30:00") {
              print("$('#listings.1600').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "16:30:00" || $row['start_time'] <= "17:00:00") {
              print("$('#listings.1630').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "17:00:00" || $row['start_time'] <= "17:30:00") {
              print("$('#listings.1700').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "17:30:00" || $row['start_time'] <= "18:00:00") {
              print("$('#listings.1730').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "18:00:00" || $row['start_time'] <= "18:30:00") {
              print("$('#listings.1800').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "18:30:00" || $row['start_time'] <= "19:00:00") {
              print("$('#listings.1830').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "19:00:00" || $row['start_time'] <= "19:30:00") {
              print("$('#listings.1900').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "19:30:00" || $row['start_time'] <= "20:00:00") {
              print("$('#listings.1930').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "20:00:00" || $row['start_time'] <= "20:30:00") {
              print("$('#listings.2000').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "20:30:00" || $row['start_time'] <= "21:00:00") {
              print("$('#listings.2030').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "21:00:00" || $row['start_time'] <= "21:30:00") {
              print("$('#listings.2100').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "21:30:00" || $row['start_time'] <= "22:00:00") {
              print("$('#listings.2130').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "22:00:00" || $row['start_time'] <= "22:30:00") {
              print("$('#listings.2200').append(routineArray[$i]);\n");
            } else if ($row['start_time'] >= "22:30:00" || $row['start_time'] <= "23:00:00") {
              print("$('#listings.2230').append(routineArray[$i]);\n");
            } 
          }
        }
    }
    $todoSql = "SELECT * FROM todo_item, categories WHERE s_day = :today ORDER BY start_time";
    $statement = $pdo->prepare($todoSql);
    $statement->bindValue(":today", $today);
    $statement->execute();
    if ($statement !== 0) 
    {
        print("var todoArray = [];\n");
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
          for ($i = 0; $i < count($row); $i++) 
          {
            print("var todoArray[$i] = \"<div class='todo $row[\"start_time\"]'>\n<h3 class='summary' style='background-color: $row[\"colour\"];'>$row[\"task\"]</h3>\n<div class='todo-details'><p><span class='time'>Starts $row[\"start_time\"]</span><span class='time'> Ends $row[\"end_time\"]</span>\" <span class='category'> $row[\"name\"]</span>\n</p><p>$row[\"details\"]</p>\n<p class='priority'>$row['priority'] </p>\n</div>\n");
            if ($row['start_time'] >= "8:00:00" || $row['start_time'] <= "8:30:00") {
              print("$('#listings.0800').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "8:30:00" || $row['start_time'] <= "9:00:00") {
              print("$('#listings.0830').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "9:00:00" || $row['start_time'] <= "9:30:00") {
              print("$('#listings.0900').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "9:30:00" || $row['start_time'] <= "10:00:00") {
              print("$('#listings.0930').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "10:00:00" || $row['start_time'] <= "10:30:00") {
              print("$('#listings.1000').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "10:30:00" || $row['start_time'] <= "11:00:00") {
              print("$('#listings.1030').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "11:00:00" || $row['start_time'] <= "11:30:00") {
              print("$('#listings.1100').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "11:30:00" || $row['start_time'] <= "12:00:00") {
              print("$('#listings.1130').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "12:00:00" || $row['start_time'] <= "12:30:00") {
              print("$('#listings.1200').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "12:30:00" || $row['start_time'] <= "13:00:00") {
              print("$('#listings.1230').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "13:00:00" || $row['start_time'] <= "13:30:00") {
              print("$('#listings.1300').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "13:30:00" || $row['start_time'] <= "14:00:00") {
              print("$('#listings.1330').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "14:00:00" || $row['start_time'] <= "14:30:00") {
              print("$('#listings.1400').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "14:30:00" || $row['start_time'] <= "15:00:00") {
              print("$('#listings.1430').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "15:00:00" || $row['start_time'] <= "15:30:00") {
              print("$('#listings.1500').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "15:30:00" || $row['start_time'] <= "16:00:00") {
              print("$('#listings.1530').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "16:00:00" || $row['start_time'] <= "16:30:00") {
              print("$('#listings.1600').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "16:30:00" || $row['start_time'] <= "17:00:00") {
              print("$('#listings.1630').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "17:00:00" || $row['start_time'] <= "17:30:00") {
              print("$('#listings.1700').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "17:30:00" || $row['start_time'] <= "18:00:00") {
              print("$('#listings.1730').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "18:00:00" || $row['start_time'] <= "18:30:00") {
              print("$('#listings.1800').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "18:30:00" || $row['start_time'] <= "19:00:00") {
              print("$('#listings.1830').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "19:00:00" || $row['start_time'] <= "19:30:00") {
              print("$('#listings.1900').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "19:30:00" || $row['start_time'] <= "20:00:00") {
              print("$('#listings.1930').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "20:00:00" || $row['start_time'] <= "20:30:00") {
              print("$('#listings.2000').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "20:30:00" || $row['start_time'] <= "21:00:00") {
              print("$('#listings.2030').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "21:00:00" || $row['start_time'] <= "21:30:00") {
              print("$('#listings.2100').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "21:30:00" || $row['start_time'] <= "22:00:00") {
              print("$('#listings.2130').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "22:00:00" || $row['start_time'] <= "22:30:00") {
              print("$('#listings.2200').append(todoArray[$i]);\n");
            } else if ($row['start_time'] >= "22:30:00" || $row['start_time'] <= "23:00:00") {
              print("$('#listings.2230').append(todoArray[$i]);\n");
            } 
          }
        }
    }

  } 
  else 
  {
    print("<p class=\"error\">Connection to the database has failed.</p>");
  }


   
 echo "});\n</script>\n";
?>

</head>
<body>

  <header>
    <h1><?php $todayTitle = date("dd [,.stndrh\t ]+ m ([ .\t-])* y");
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
  <div class="col-sm-8" id="diarypage">  
    <div class="col-sm-3" id="timetracker">
    <ul>
<?php
  
  if ($pdo != NULL ) {
    $today = date("d m Y");
    $select = "SELECT s_day, start_time, end_time, activity FROM time_usage WHERE s_day = :today ORDER BY start_time";
    $statement = $pdo->prepare($select);
    $statement->bindValue(":today", $today);
    $statement->execute();
    if ($statement !== 0) 
    {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
          print("<li id='$row[\"start_time\"]' class='tt_activity'><p>$row[\"activity\"]</p></li>\n");
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
    <div class="col-sm-2" id="times">
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
    <div class="col-sm-7" id="listings">
      <ul>
      <li class="0800"> </li>
      <li class="0830"> </li>
      <li class="0900"> </li>
      <li class="0930"> </li>
      <li class="1000"> </li>
      <li class="1030"> </li>
      <li class="1100"> </li>
      <li class="1130"> </li>
      <li class="1200"> </li>
      <li class="1230"> </li>
      <li class="1300"> </li>
      <li class="1330"> </li>
      <li class="1400"> </li>
      <li class="1430"> </li>
      <li class="1500"> </li>
      <li class="1530"> </li>
      <li class="1600"> </li>
      <li class="1630"> </li>
      <li class="1700"> </li>
      <li class="1730"> </li>
      <li class="1800"> </li>
      <li class="1830"> </li>
      <li class="1900"> </li>
      <li class="1930"> </li>
      <li class="2000"> </li>
      <li class="2030"> </li>
      <li class="2100"> </li>
      <li class="2130"> </li>
      <li class="2200"> </li>
      <li class="2230"> </li>
      <li class="2300"> </li>
      </ul>
    </div>
  </div>
  <div class="col-sm-4" id="notes">
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
    <li><a href="new_task.php" >New Task</a></li>
    <li class="active disabled"><a href="daily.php">Daily</a></li>
    <li><a href="week.php" >Week</a></li>
    <li><a href="month.php" >Month</a></li>
    <li><a href="year.php" >Year</a></li>
    </ul>
  </nav>
</footer>

</body>
</html>
