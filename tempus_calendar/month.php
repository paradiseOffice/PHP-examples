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
     <title>Month - Year</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="" content="" />
    <?php include_once("links.php");
    date_default_timezone_set("Europe/London");
   ?>
    
</head>
<body>

  <header><h1><?php echo date("M Y"); ?></h1></header>
  <nav class="nav nav-pills top-nav">
    <ul>
    <li><a href="<?php $today = date("Ymd").strftime("last month"); ?>" id="prev_month" title="Previous month" class="glyphicon glyphicon-arrow-left"></a></li>
    <li><a href="#" id="this_month" ><?php echo date("M"); ?></a></li>
    <li><a href="<?php $today = date("Ymd").strftime("next month"); ?>" id="next_month" title="Next month" class="glyphicon glyphicon-arrow-right"></a></li>
    </ul>
  </nav>
<div class="container-fluid">

  <table class="table-striped table-bordered table-hover" id="month">
    <thead>
    <th> Monday</th>
    <th> Tuesday</th>
    <th>Wednesday</th>
    <th>Thursday</th>
    <th>Friday</th>
    <th>Saturday</th>
    <th>Sunday </th>
  </thead>
  <tbody>

<?php
  /* ("urgent", "high", "medium", "low"), priority */
  if ($pdo !== NULL ) {
    $today = date("Ymd");
    $endMonth = date("Ymd").strtotime("first day of next month");
    // $dayno = strtotime($endMonth, strtotime($today));
    $select = "SELECT * FROM todo_item  LEFT JOIN categories ON todo_item.cat_id = categories.cat_id WHERE priority = :priority AND s_day >= :today AND s_day < 20150701 ORDER BY s_day LIMIT 15";
    $statement = $pdo->prepare($select);
    $statement->bindValue(":priority", "high");
    $statement->bindValue(":today", $today);
    // $statement->bindValue(":endMonth", $endMonth);
    // $statement->bindValue(":dayno", $dayno, PDO::PARAM_INT);
    $statement->execute();
    if ($statement !== 0) 
    {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
          print("<tr>");
          for ($i = 1; $i <= 7; $i++)
          {
            print("<td>\n");
            print("<div class='todo " . $row["start_time"] . "'>\n<h3 class='summary' style='background-color: " . $row["colour"] . ";'>" . $row["task"] . "</h3>\n<div class='todo-details'>\n<p><span class='time'>Starts " . $row["start_time"] . "</span><span class='time'> Ends " . $row["end_time"] . "</span> <span class='category'> " . $row["name"] . "</span></p>\n<p>" . $row["details"] . "</p>\n<p class='priority'>" . $row["priority"] . "</p></div></td>");
          }
          print("</tr>\n");
        }
    }
    else 
    {
      print(" ?");
    } // mysqli num rows if
  } 
  else 
  {
    print("<p class=\"error\">Connection to the database has failed.</p>");
  }
?>    

  </tbody>
  </table>
 
  
</div>
<footer>
  <nav id="main-nav">
    <ul class="nav navbar-nav">
    <li><a href="new_event.php" >New Event</a></li>
    <li><a href="daily.php">Daily</a></li>
    <li class="active disabled"><a href="month.php" >Month</a></li>
    <li><a href="year.php" >Year</a></li>
    </ul>
  </nav>
</footer>

</body>
</html>
