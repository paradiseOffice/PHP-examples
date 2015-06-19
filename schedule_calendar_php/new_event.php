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

 if (isset($_POST['submit'])) 
 {
  $task = trim($_POST['task']); /* a-z A-Z spaces */
  $task = preg_replace('/[^a-zA-Z ]+/', '', $task);
  $start_time = trim($_POST['start_time']); /* 00:00 */
  $start_time = preg_replace('/[a-zA-Z;@#~!\"\(\)\|?<>\^£$\*]+/', '', $start_time); 
  $end_time = trim($_POST['end_time']); 
  $end_time = preg_replace('/[a-zA-Z;@#~!\"\(\)\|?<>\^£$\*]+/', '', $end_time);
  $s_day = $_POST['s_day']; 
  $priority = $_POST['priority'];
  $details = trim($_POST['details']); /* A-z .,- */
  $details = preg_replace('/[^A-Za-z \.,-]+/', '', $details);
  $cat_id = $_POST['category']; 

  if(
    empty($_POST['task']) ||
    empty($_POST['start_time']) ||
    empty($_POST['end_time']) ||
     empty($_POST['s_day']))
  {
    $errors .= "\n Please fill in these required fields.";
  }
    $insert = "INSERT INTO todo_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES (:task, :s_day, :start_time, :end_time, :details, :priority, :category ) ";
    $statement = $pdo->prepare($insert);
    $statement->bindValue(":task", $task);
    $statement->bindValue(":start_time", $start_time);
    $statement->bindValue(":end_time", $end_time);
    $statement->bindValue(":s_day", $s_day);
    $statement->bindValue(":details", $details);
    $statement->bindValue(":priority", $priority);
    $statement->bindValue(":category", $cat_id);
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

CREATE TABLE todo_item (
  task_id       INTEGER PRIMARY KEY AUTO_INCREMENT,
  task          VARCHAR(100) NOT NULL,
  s_day         DATE NOT NULL,
  start_time    TIME,
  end_time      TIME,
  details       VARCHAR(1000),
  priority      ENUM("urgent", "high", "medium", "low"),
  cat_id        INTEGER, 
  CONSTRAINT FOREIGN KEY (cat_id) REFERENCES categories(cat_id)
);

-->

  <section id="event_form">
  <h2>New Todo</h2>
  <form action="new_event.php" method="post" class="form">
    <div class="form-group">
    <input class="form-control" type="text" id="task" name="task"  length="100" placeholder="Task name" />
    </div>
    <div class="form-group">
    <div class="col-sm-3">
    <label for="s_day">Date: </label>
    <input class="form-control" type="date" id="s_day" name="s_day" placeholder="dd/mm/yyyy" />
    </div>
    <div class="col-sm-3">
    <label for="start_time">Starts: </label>
    <input  class="form-control" type="time" id="start_time" name="start_time" placeholder="00:00" />
    </div>
    <div class="col-sm-3">
    <label for="end_time">Ends: </label>
    <input  class="form-control" type="time" id="end_time" name="end_time" placeholder="00:00"  />
    </div>
    <div class="col-sm-3">
    <label for="priority">Priority: </label>
    <select class="form-control col-sm-3"  id="priority" name="priority">
      <option value="urgent">Urgent</option>
      <option value="high">high</option>
      <option value="medium">Medium</option>
      <option value="low">Low</option>
    </select>
    </div></div>
    <textarea id="details" name="details" class="form-group col-sm-12" placeholder="Details..." rows="4"></textarea>
    <div class="col-sm-7">
      <p>Category:</p>
    </div>
    <div class="col-sm-5">
      <select id="category" name="category" class="form-control">
      
<?php
  
  if ($pdo !== NULL ) {
    $select = "select * from categories ORDER BY cat_id";
    $statement = $pdo->prepare($select);
    $statement->execute();
    if ($statement !== 0) 
    {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) 
        {
          print("<option value='" . $row["cat_id"] . "' style='background-color: " . $row["colour"] . ";'>" . $row["name"] . "</option>\n");
        }
    }
    else 
    {
      print("?");
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
  <p class="php-errors"><?php echo $errors; ?></p>
  </section>
  
</div><!--container-->
<footer>
  <nav id="main-nav">
    <ul class="nav navbar-nav">
    <li class="disabled active"><a href="new_event.php" >New Event</a></li>
    <li><a href="daily.php">Daily</a></li>
    <li><a href="month.php" >Month</a></li>
    <li><a href="year.php" >Year</a></li>
    </ul>
  </nav>
</footer>

</body>
</html>
