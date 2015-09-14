<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
     <title>Today</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="" content="" />
    <?php require_once('links.php'); ?>
</head>
<body>

  <header>
    <h1>
    <?php 
    function fetch_data() {
      $dtz = new DateTimeZone('Europe/London');
      require_once 'common_libs.php';
      $pdo = db_connect();
      $errors = '';
      $todayTitle = new DateTime('now', $dtz);
      echo $todayTitle->format('l DS F Y');
      $today = $todayTitle->format('Ymd'); // for the SQL database
    ?>
    </h1>
    <h2>Today's Schedule</h2>
  </header>
  <nav class="top-nav">
    <ul class="nav-elements">
    <li><a href="#" id="yesterday" title="Yesterday" class="glyphicon glyphicon-arrow-left"></a></li>
    <li><a href="#" id="today" >Today</a></li>
    <li><a href="#" id="tomorrow" title="Tomorrow" class="glyphicon glyphicon-arrow-right"></a></li>
    </ul>
  </nav>
<div class="row" >
  <div class="small-8 medium-8 large-8 columns" id="diarypage">  
    <div class="row">
    <div class="small-2 medium-2 large-1 columns" id="times">
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
    <div class="small-3 medium-3 large-3 columns" id="listings-todo">
<?php

  if ($pdo !== 0 ):
    $recurSql = 'SELECT * FROM routine_events 
                 LEFT JOIN categories ON routine_events.cat_id = categories.cat_id 
                 LEFT JOIN recurrences ON routine_events.event_id = recurrences.rec_id
                 WHERE recurrences.s_day = :today1 AND routine_events.s_day = :today2
                 ORDER BY start_time';
    $statement = $pdo->prepare($recurSql);
    // This needs some JavaScript to take the start date and recurs
    // and create the recurring dates
    $statement->bindValue(':today1', $today);
    $statement->bindValue(':today2', $today);
    $statement->execute();
    if ($statement !== 0):
      while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false): ?>
        <div class="task-event <?php echo $row['start_time']; ?>">
        <h3 class="summary" style="background-color: <?php echo $row['colour'] ?>"><?php echo $row['event']; ?></h3>
        <div class="event-details">
          <span class="time">Starts <?php echo $row['start_time']; ?></span>
          <span class="time"> Ends <?php echo $row['end_time']; ?></span> Recurring <?php echo $row['recurs']; ?><br />
          <h4 class="place"><?php echo $row['place']; ?></h4>
            <p><?php echo $row['details']; ?></p>
            <p class="attendees"><?php echo $row['attendees']; ?><br />
            <span class="category"><?php echo $row['name']; ?></span>
            <a href="<?php echo $row['url']; ?>" target="blank">Web Link</a></p>
        </div></div>
    <?php endwhile;
        endif;
      endif;          
    ?>    
     
    </div>
    <div class="small-3 medium-3 large-2 columns" id="listings-routine">
    <?php
    
    $todoSql = 'SELECT * FROM task_item  LEFT JOIN categories ON task_item.cat_id = categories.cat_id 
                WHERE s_day = :today ORDER BY start_time';
    $statement = $pdo->prepare($todoSql);
    $statement->bindValue(':today', $today);
    $statement->execute();
    if ($statement !== 0) {
        while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false):
        ?>
        <div class="todo <?php echo $row['start_time']; ?>">
          <h3 class="summary" style="background-color: <?php echo $row['colour']; ?>">
          <?php echo $row['task']; ?></h3>
          <div class="todo-details">
            <p><span class="time">Starts <?php echo $row['start_time']; ?></span>
            <span class="time"> Ends <?php echo $row['end_time']; ?></span> 
            <span class="category"><?php echo $row['name']; ?></span></p>
            <p><?php echo $row['details']; ?></p>
            <p class="priority"><?php echo $row['priority']; ?></p>
          </div>
        </div>
        <?php endwhile;
    }  else  {
      echo '<p class="sql-error">Connection to the database has failed.</p>';
    }
 } // end function
   fetch_data();
   ?> 
    </div> </div>   
  </div></div>
  <div class="small-4 medium-4 large-4 columns" id="notes">
    <h3>Notes</h3>
    <textarea class="" id="todo-area" rows="8" placeholder="type here"></textarea>
    <button class="btn" id="add-todo">Add Item</button>
    <ol class="todo-list"></ol>
    <br />
    <img width="400" height="1000" src="images/big_ben.jpg" />
  </div>
</div>
<!-- Add a default colour list to the categories table, and have a hidden form field to update the day via Javascript, 
  for tomorrow and yesterday  -->

<?php require_once('footer-nav.php'); ?>

</body>
</html>
