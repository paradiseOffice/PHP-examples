<?php

function add_routine_event() {
  require_once 'common_libs.php';
  $pdo = db_connect();
  $errors = '';
  $dtz = new DateTimeZone('Europe/London');

  if (isset($_POST['submit'])) {
    $event_name = trim($_POST['event_name']); /* a-z A-Z spaces */
    $event_name = preg_replace('/[^a-zA-Z ]+/', '', $event_name);
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

    if (empty($_POST['event_name']) || empty($_POST['start_time']) ||
      empty($_POST['end_time']) || empty($_POST['recurs'])) {
      $errors .= '<p> Please fill in these required fields.</p>';
    }
    $insert = 'INSERT INTO routine_events 
     (event, recurs, s_day, start_time, end_time, place, attendees, details, url, cat_id) VALUES 
     (:event_name, :recurs, :s_day, :start_time, :end_time,  :place, :attendees, :details, :url, :category)';
    $statement = $pdo->prepare($insert);
    $statement->bindValue(':event_name', $event_name);
    $statement->bindValue(':recurs', $recurs);
    $statement->bindValue(':s_day', $s_day);
    $statement->bindValue(':start_time', $start_time);
    $statement->bindValue(':end_time', $end_time);
    $statement->bindValue(':place', $place);
    $statement->bindValue(':attendees', $attendees);
    $statement->bindValue(':details', $details);
    $statement->bindValue(':url', $url);
    $statement->bindValue(':category', $cat_id, PDO::PARAM_INT);
    if ($statement->execute()) {
      $errors .= '<p class="success"> Your event was successfully saved.</p>';
    } else {
      $errors .= '<p class="sql-error"> Unable to insert record!</p>';
    }
  } // submit isset
 // Work out recurrences (next_date event_id REFERENCES tempus.routine_events (event_id). Next 10 events by default.
    
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
    <h2>Add Recurring Event</h2>
  </header>
  <nav class="top-nav">
    <ul class="nav-elements">
    <li><a href="special_event.php" id="special" title="Special event" class="glyphicon glyphicon-star-empty">Special event</a></li>
    <li><a href="add_work_hols.php" id="work_hols" class="glyphicon glyphicon-calendar">Days off</a></li>
    <li><a href="add_bank_holiday.php" id="bank_holiday" title="Next month" class="glyphicon glyphicon-arrow-right">Add bank holiday</a></li>
    <li><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="disabled glyphicon glyphicon-refresh">Recurring Event</a></li>
    </ul>
  </nav>
  
<div class="">

  <section id="recurring_event_form">
  <h2>Recurring Event</h2>
  <form action="new_recurring_event.php" method="post" class="form">
    <div class="row small-12 medium-10 large-10 columns">
      <label for="event_name">Event
      <input class="" type="text" id="event_name" name="event_name"  length="100" placeholder="name" />
      </label>
    </div>
    <div class="row">
    <div class="small-4 medium-3 large-3 columns">
      <label for="start_time">Starts 
      <input  class="" type="time" id="start_time" name="start_time" placeholder="00:00" />
      </label>
    </div>
    <div class="small-4 medium-3 large-3 columns">
      <label for="end_time">Ends 
      <input  class="" type="time" id="end_time" name="end_time" placeholder="00:00"  />
      </label>
    </div>
    <div class="small-4 medium-3 large-3 columns">
      <label for="s_day">Date 
      <input type="date" id="s_day" name="s_day" class="" />
      </label>
    </div>
    <div class="small-4 medium-3 large-3 columns">
      <label for="recurs">Recurs </label>
      <select class=""  id="recurs" name="recurs">
        <option>daily</option>
        <option>weekly</option>
        <option>fortnightly</option>
        <option>lunar</option>
        <option>monthly</option>
        <option>yearly</option>
        <option>quarterly</option>
      </select>
    <!-- put in a No of times recurs field, with a checkbox for forever. 
       Add a table in SQL with re_id, event_id, date. Compute all the dates where the event recurs in a PHP array.
       Insert each recurrence in this table. the index.php/daily page will need to search by date in that table and
       do a join on event_id, gathering the routine_event details. Hide most of the details with Javascript.
    
    -->
    </div>
    </div>
    <div class="row">
    <div class="small-10 medium-10 large-10 columns">
      <label for="place" class="">Place
      <input type="text" id="place" name="place" class="" length="100" placeholder="Place" />
      </label>
    </div><div class="small-2 medium-2 large-2 columns">
      <a href="http://www.bing.com/maps/" target="blank" title="Map with GPS" class="glyphicon glyphicon-map-marker"> Find</a>
    </div></div>
    <div class="row">
      <label for="attendees" class="small-2 large-2 columns">Attendees 
      <input id="attendees" name="attendees" type="text" class="small-10 large-10 columns" placeholder="attendees" />
      </label>
    </div>
    <div class="row">
      <textarea id="details" name="details" class="small-12 large-12 columns" placeholder="Details..." rows="4"></textarea>
    </div>
    <div class="row">
    <div class="small-8 medium-8 large-8 columns">
      <label for="url" class="small-2 medium-2 large-2 columns">Web page</label>
      <input type="url" class="small-10 medium-10 large-10 columns" id="url" name="url" placeholder="web page" />
    </div>
    <div class="small-4 medium-4 large-4 columns">
      <select id="category" name="category" class="">
      
<?php
  
  if ($pdo !== NULL ) {
    $select = 'SELECT * FROM categories ORDER BY cat_id';
    $statement = $pdo->prepare($select);
    $statement->execute();
    if ($statement !== 0) {
      while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false):
      ?>  

      <option value="<?php echo $row['cat_id']; ?>" style="background-color: <?php echo $row['colour']; ?>;">
      <?php echo $row['name']; ?></option>

      <?php
      endwhile;  
    } else {
      echo('<option value="0">No categories</option>');
    } 
  } else {
    echo('<p class="sql-error">Connection to the database has failed.</p>');
  }
} // end function 
add_routine_event();

?>
        
      </select>
    </div></div>
    <input type="submit" id="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
  </form>
  </section>
  
</div><!--container-->

<?php require_once('footer-nav.php'); ?>

</body>
</html>
