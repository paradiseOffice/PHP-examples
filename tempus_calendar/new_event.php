<?php
function new_event() {
  /**
   * @author 
   *   Hazel Windle
   * 
   * Places a new (non-recurring) event into the database.
   */
  require_once 'common_libs.php';
  $pdo = db_connect();
  $errors = '';
  $dtz = new DateTimeZone('Europe/London');

  if (isset($_POST['submit'])) {
    $task = trim($_POST['task']); /* a-z A-Z spaces */
    $task = preg_replace('/[^a-zA-Z ]+/', '', $task);
    $start_time = trim($_POST['start_time']); /* 00:00 */
    $start_time = preg_replace('/[a-zA-Z;@#~!\"\(\)\|?<>\^£$\*]+/', '', $start_time); 
    $end_time = trim($_POST['end_time']); 
    $end_time = preg_replace('/[a-zA-Z;@#~!\"\(\)\|?<>\^£$\*]+/', '', $end_time);
    $dirty_start_date = trim($_POST['s_day']);
    $dirty_start_date = preg_replace('/[^\d]*/', '', $dirty_start_date);
    $clean_start_date = substr($dirty_start_date, -4, 4) . 
      substr($dirty_start_date, -6, 2) . substr($dirty_start_date, 0, 2) . ' 12:00';
    $start_date = new DateTime($clean_start_date, $dtz);
    $s_day = $start_date->format('Ymd');
    $priority = $_POST['priority'];
    $details = trim($_POST['details']); /* A-z .,- */
    $details = preg_replace('/[^A-Za-z \.,-]+/', '', $details);
    $cat_id = $_POST['category']; 
    if (empty($_POST['task']) || empty($_POST['start_time']) ||
      empty($_POST['end_time']) || empty($_POST['s_day'])) {
      $errors .= '<p> Please fill in these required fields.</p>';
    }
    $insert = 'INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) 
             VALUES (:task, :s_day, :start_time, :end_time, :details, :priority, :category ) ';
    $statement = $pdo->prepare($insert);
    $statement->bindValue(':task', $task);
    $statement->bindValue(':start_time', $start_time);
    $statement->bindValue(':end_time', $end_time);
    $statement->bindValue(':s_day', $s_day);
    $statement->bindValue(':details', $details);
    $statement->bindValue(':priority', $priority);
    $statement->bindValue(':category', $cat_id);
    if ($statement->execute()) {
      $errors .= '<p class="success"> Your event was successfully saved.</p>';
    } else {
      $errors .= '<p class="sql-error"> Unable to insert record!</p>';
    }
  } // submit isset
} // end function
new_event();

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
    <?php require_once('links.php'); ?>
    
</head>
<body>

<header>
    <h1>Tempus</h1>
    <h2>New Event</h2>
  </header>
  <nav class="top-nav">
    <ul class="nav-elements">
    <li><a href="special_event.php" id="special" title="Special event" class="glyphicon glyphicon-star-empty">Special event</a></li>
    <li><a href="add_work_hols.php" id="work_hols" class="glyphicon glyphicon-calendar">Days off</a></li>
    <li><a href="add_bank_holiday.php" id="bank_holiday" title="Next month" class="glyphicon glyphicon-arrow-right">Add bank holiday</a></li>
    <li><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="glyphicon glyphicon-refresh">Recurring Event</a></li>
    </ul>
  </nav>
  
<div class="container">

  <section id="event_form">
  <h3>Enter Event</h3>
  <form action="new_event.php" method="post" class="form">
    <div class="row">
      <div class="small-12 medium-12 large=10 columns">
      <label for="task">Task
      <input class="" type="text" id="task" name="task"  length="100" placeholder="title" />
      </label></div>
    </div>
    <div class="row">
    <div class="small-4 medium-3 large-3 columns">
      <label for="s_day">Date 
      <input class="" type="date" id="s_day" name="s_day" placeholder="dd/mm/yyyy" 
      value="<?php $today = date('now'); echo $today; ?>" />
      </label>
    </div>
    <div class="small-4 medium-3 large-3 columns">
    <label for="start_time">Starts: </label>
    <input  class="" type="time" id="start_time" name="start_time" placeholder="00:00" />
    </div>
    <div class="small-4 medium-3 large-3 columns">
    <label for="end_time">Ends: </label>
    <input  class="" type="time" id="end_time" name="end_time" placeholder="00:00"  />
    </div>
    <div class="small-4 medium-3 large-3 columns">
    <label for="priority">Priority: </label>
    <select class=""  id="priority" name="priority">
      <option value="urgent">Urgent</option>
      <option value="high">high</option>
      <option value="medium">Medium</option>
      <option value="low">Low</option>
    </select>
    </div></div>
    <div class="row small-12 large-10 columns">
      <textarea id="details" name="details" placeholder="Details..." rows="4"></textarea>
    </div>
    <div class="row">
    <div class="small-7 medium-7 large-7 columns">
      <label for="category">Category</label>
    </div>
    <div class="small-5 medium-5 large-5 columns">
      <select id="category" name="category" class="">
      
<?php
function get_categories() {  
  require_once 'common_libs.php';
  $pdo = db_connect();
  $errors = '';
  
  if ($pdo !== NULL ) {
    $select = 'select * from categories ORDER BY cat_id';
    $statement = $pdo->prepare($select);
    $statement->execute();
    if ($statement !== 0) {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
          echo('<option value="' . $row['cat_id'] . '" style="background-color: ' . $row['colour'] . ';">' 
            . $row['name'] . '</option>' . "\n");
        }
    } else {
      $errors .= '<p class="sql-error">No categories found in table</p>';
    } 
  } else {
    $errors = '<p class="error">Connection to the database has failed.</p>';
  } // pdo true
} // end function
get_categories();
?>
        
      </select>
    </div></div>
    <input type="submit" id="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
  </form>
  <!--<p class="php-errors"><?php //echo $errors; ?></p>-->
  </section>
  
</div><!--container-->

<?php require_once('footer-nav.php'); ?>

</body>
</html>
