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

  <header><h1>June 2015</h1></header>
  <nav class="nav nav-pills top-nav">
    <ul>
    <li><a href="#" id="prev_month" title="Previous month" class="glyphicon glyphicon-arrow-left"></a></li>
    <li><a href="#" id="this_month" >June</a></li>
    <li><a href="#" id="next_month" title="Next month" class="glyphicon glyphicon-arrow-right"></a></li>
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
  <tr>
    <td id="1"> </td>
    <td id="2"> </td>
    <td id="3"> </td>
    <td id="4"> </td>
    <td id="5"> </td>
    <td id="6"> </td>
    <td id="7"> </td>
  </tr><tr>
    <td id="8"> </td>
    <td id="9"> </td>
    <td id="10"> </td>
    <td id="11"> </td>
    <td id="12"> </td>
    <td id="13"> </td>
    <td id="14"> </td>
  </tr><tr>
    <td id="15"> </td>
    <td id="16"> </td>
    <td id="17"> </td>
    <td id="18"> </td>
    <td id="19"> </td>
    <td id="20"> </td>
    <td id="21"> </td>
  </tr><tr>
    <td id="22"> </td>
    <td id="23"> </td>
    <td id="24"> </td>
    <td id="25"> </td>
    <td id="26"> </td>
    <td id="27"> </td>
    <td id="28"> </td>
  </tr><tr>
    <td id="29"> </td>
    <td id="30"> </td>
    <td id="31"> </td>
    <td id="32"> </td>
    <td id="33"> </td>
    <td id="34"> </td>
    <td id="35"> </td>
  </tr>
  </tbody>
  </table>
<?php
  /* ("urgent", "high", "medium", "low"), priority */
  if ($pdo != NULL ) {
    $select = "SELECT task, s_day, details, priority FROM todo_item WHERE s_day = :today   LIMIT 1";
    $statement = $pdo->prepare($select);
    $statement->execute();
    if ($statement !== 0) 
    {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
          print("<option value='$row[\"cat_id\"]' style='background-color: $row[\"colour\"];'>$row[\"name\"]</option>\n");
        }
    }
    else 
    {
      print("<option value=\"0\">No categories</option>");
    } // mysqli num rows if
  } 
  else 
  {
    print("<p class=\"error\">Connection to the database has failed.</p>");
  }
?>  
  
</div>
<footer>
  <nav id="main-nav">
    <ul class="nav navbar-nav">
    <li><a href="new_event.php" >New Event</a></li>
    <li><a href="new_task.php" >New Task</a></li>
    <li><a href="daily.php">Daily</a></li>
    <li><a href="week.php" >Week</a></li>
    <li class="active disabled"><a href="month.php" >Month</a></li>
    <li><a href="year.php" >Year</a></li>
    </ul>
  </nav>
</footer>

</body>
</html>
