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
  $event_name = trim($_POST['event_name']); /* a-z A-Z spaces */
  $event_name = preg_replace('/[^a-zA-Z ]+/', '', $event_name);
  $start_time = trim($_POST['start_time']); /* 00:00 */
  $start_time = preg_replace('/[a-zA-Z;@#~!\"\(\)\|?<>\^£$\*+/', '', $start_time); 
  $end_time = trim($_POST['end_time']); 
  $end_time = preg_replace('/[a-zA-Z;@#~!\"\(\)\|?<>\^£$\*]+/', '', $end_time);
  $recurs = $_POST['recurs']; 
  $place = trim($_POST['place']); /* a-z -+ 0-9 spaces () */
  $place = preg_replace('/[^a-zA-Z \(\)-_]+/', '', $place);
  $attendees = trim($_POST['attendees']); /* A-z - spaces */
  $attendees = preg_replace('/[^a-zA-Z ]+/', '', $attendees);
  $details = trim($_POST['details']); /* A-z .,- */
  $details = preg_replace('/[^A-Za-z \.,-]+/', '', $details);
  $url = trim($_POST['url']); /* url regex */
  $url = preg_replace('/[^A-Za-z\/:\.]+/', '', $url);
  $cat_id = $_POST['category']; 

  if(
    empty($_POST['event_name']) ||
    empty($_POST['start_time']) ||
    empty($_POST['end_time']) ||
     empty($_POST['recurs']))
{
    $errors .= "\n Please fill in these required fields.";
}

 if ($_POST['submit']) {
    $insert = "INSERT INTO routine_events (event, recurs, start_time, end_time, place, attendees, details, url, cat_id) VALUES (:event_name, :start_time, :end_time, :recurs, :place, :attendees, :details, :url, :category ) ";
    $statement = $pdo->prepare($insert);
    $statement->bindValue(":event_name", $event_name);
    $statement->bindValue(":start_time", $start_time);
    $statement->bindValue(":end_time", $end_time);
    $statement->bindValue(":place", $place);
    $statement->bindValue(":attendees", $attendees);
    $statement->bindValue(":details", $details);
    $statement->bindValue(":url", $url);
    $statement->bindValue(":category", $cat_id, PDO::PARAM_INT);
    if ($statement->execute()) 
    {
    $errors .= "\n Your event was successfully saved.";
    } 
    else 
    {
    $errors .= "\n Unable to insert record!" . mysqli_error_list($db);
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
    <li><a href="add_bank_holiday.php" id="bank_holiday" title="Next month" class="glyphicon glyphicon-arrow-right">Add bank holiday</a></li>
    <li><strong><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="disabled glyphicon glyphicon-refresh">Recurring Event</a></strong></li>
    </ul>
  </nav>
  
<div class="container">
<!--

CREATE TABLE categories (
  cat_id        INTEGER PRIMARY KEY AUTO_INCREMENT,
  name          VARCHAR(100) NOT NULL,
  colour        VARCHAR(100) NOT NULL 
  /* rgba(255,255,255,1.0) */
);

CREATE TABLE routine_events (
  event_id      INTEGER AUTO_INCREMENT,
  event         VARCHAR(100) NOT NULL,
  recurs        ENUM("daily", "weekly", "fortnightly", "monthly", "quarterly", "biannual", "yearly") NOT NULL,
  start_time    TIME NOT NULL,
  end_time      TIME NOT NULL,
  place         VARCHAR(100),
  attendees     VARCHAR(300),
  details       VARCHAR(1000),
  url           VARCHAR(200),
  cat_id        INTEGER NOT NULL, 
  PRIMARY KEY (event_id),
  CONSTRAINT FOREIGN KEY (cat_id) REFERENCES categories(cat_id)
);
-->

  <section id="recurring_event_form">
  <h2>Recurring Event</h2>
  <form>
    <div class="form-group">
    <input class="form-control" type="text" id="event_name" name="event_name"  length="100" placeholder="event name" />
    </div>
    <div class="form-group">
    <div class="col-sm-4">
    <label for="start_time">Starts: </label>
    <input  class="form-control" type="time" id="start_time" name="start_time" placeholder="00:00" />
    </div>
    <div class="col-sm-4">
    <label for="end_time">Ends: </label>
    <input  class="form-control" type="time" id="end_time" name="end_time" placeholder="00:00"  />
    </div>
    <div class="col-sm-4">
    <label for="recurs">Recurs: </label>
    <select class="form-control col-sm-3"  id="recurs" name="recurs">
      <option>daily</option>
      <option>weekly</option>
      <option>fortnightly</option>
      <option>monthly</option>
      <option>yearly</option>
      <option>quarterly</option>
      <option>biannual</option>
    </select>
    </div></div>
    <div class="form-group">
    <div class="col-sm-10">
      <label for="place" class="sr-only">Place:</label>
      <input type="text" id="place" name="place" class="form-control" length="100" placeholder="Place" />
    </div><div class="col-sm-2">
      <a href="http://www.bing.com/maps/" target="blank" title="Map with GPS" class="glyphicon glyphicon-map-marker"> Find</a>
    </div></div>
      <label for="attendees" class="sr-only">Attendees: </label>
      <input id="attendees" name="attendees" type="text" class="form-control" placeholder="attendees" />
    <textarea id="details" name="details" class="form-group col-sm-12" placeholder="Details..." rows="4"></textarea>
    <div class="col-sm-8">
      <label for="url" class="sr-only">Web page</label>
      <input type="url" class="form-control" id="url" name="url" placeholder="web page" />
    </div>
    <div class="col-sm-4">
      <select id="category" name="category" class="form-control">
      
<?php
  
  if ($db != NULL ) {
    $select = "select * from categories ORDER BY cat_id";
    $allrows = $pdo->prepare($select);
    $statement->execute();
    if (mysqli_num_rows($allrows) > 0) 
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
        
      </select>
    </div>
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
