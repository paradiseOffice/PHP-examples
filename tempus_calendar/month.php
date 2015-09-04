<?php
  require_once('../settings.php');
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
  
  $dtz = new DateTimeZone('Europe/London');
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
    <?php require_once('links.php');
    
   ?>
    
</head>
<body>

  <header><h1><?php $today = new DateTime('now', $dtz); echo $today->format('M Y'); ?></h1></header>
  <nav class="nav nav-pills top-nav">
    <ul>
    <li><a href="<?php $prevMonth = new DateTime('today -1 month', $dtz); echo $prevMonth->format('M'); ?>" id="prev_month" title="Previous month" class="glyphicon glyphicon-arrow-left"></a></li>
    <li><a href="#" id="this_month" ><?php echo $today->format('M'); ?></a></li>
    <li><a href="<?php $nextMonth = new DateTime('today +1 month', $dtz); echo $nextMonth->format('M'); ?>" id="next_month" title="Next month" class="glyphicon glyphicon-arrow-right"></a></li>
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
  // use Javascript on this part to populate each day with events.
  if ($pdo !== NULL ):
    $endMonth = date('Ymd').strtotime('first day of next month');
    // $dayno = strtotime($endMonth, strtotime($today));
    $select = 'SELECT * FROM task_item  LEFT JOIN categories ON task_item.cat_id = categories.cat_id 
             WHERE priority = :priority AND s_day >= :today AND s_day < :endMonth 
             ORDER BY s_day LIMIT 15';
    $statement = $pdo->prepare($select);
    $statement->bindValue(':priority', 'high');
    $statement->bindValue(':today', $today->format('Ymd'));
    $statement->bindValue(':endMonth', $endMonth);
    // $statement->bindValue(":dayno", $dayno, PDO::PARAM_INT);
    $statement->execute();
    if ($statement !== 0):
    
      while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false):
      ?>
        <tr>
    <?php 
      for ($i = 1; $i <= 7; $i++):
        echo("<td>\n"); ?>

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
        </td>
    <?php
        endfor; // end of for
          echo("</tr>\n");
      endwhile;
    endif;    // end of if $statement...
endif; 
?>    

  </tbody>
  </table>
 
  
</div>

<?php require_once('footer-nav.php'); ?>

</body>
</html>