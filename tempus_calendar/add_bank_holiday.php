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
  
  
  if ($pdo !== 0) 
  {
    if (isset($_POST['submit'])) 
    {
      if( empty($_POST['title']) ||  empty($_POST['holiday']))
      {
        $errors .= "\n Please fill in these required fields.";
      }
      $title = trim($_POST['title']); /* a-z A-Z spaces */
      $title = preg_replace('/[^a-zA-Z \']+/', '', $title);
      $shops_open = trim($_POST['shops_open']); 
      $shops_open = preg_replace('/[^A-Za-z \.,-]+/', '', $shops_open);
      $holiday = trim($_POST['holiday']); 
      $holiday = preg_replace('/[^0-9]+/', '', $holiday);
      $insert = "INSERT INTO bank_holidays (title, shops_open, holiday) VALUES (:title, :shops_open, :holiday ) ";
      $statement = $pdo->prepare($insert);
      $statement->bindValue(":title", $title);
      $statement->bindValue(":shops_open", $shops_open);
      $statement->bindValue(":holiday", $holiday);
      if ($statement->execute()) 
      {
        $errors .= "\n Your event was successfully saved.";
      } 
      else 
      {
        $errors .= "\n Unable to insert record!";
      }
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
<?php include_once("links.php"); ?>
</head>
<body>

  <header><h1>Add Bank Holiday</h1></header>
  <nav class="nav top-nav">
    <ul class="nav-pills">
    <li><a href="special_event.php" id="special" title="Special event" class="glyphicon glyphicon-star-empty">Special event</a></li>
    <li><a href="add_work_hols.php" id="work_hols" class="glyphicon glyphicon-calendar">Days off</a></li>
    <li class="active disabled"><a href="add_bank_holiday.php" id="bank_holiday" title="Next month" class="glyphicon glyphicon-arrow-right">Add bank holiday</a></li>
    <li><strong><a href="new_recurring_event.php" id="recurring_event" title="Recurring event" class="disabled glyphicon glyphicon-refresh">Recurring Event</a></strong></li>
    </ul>
  </nav>
  
<div class="container">

  <section id="bank_holiday">
  <h2>Bank Holiday</h2>
  <form action="add_bank_holiday.php" method="post" class="form">
    <div class="form-group">
    <label for="title" class="sr-only">Holiday</label>
    <input class="form-control" type="text" id="title" name="title"  length="100" placeholder="Holiday title" />
    </div>
    <div class="form-group">
    <label for="shops_open">Shops Open</label>
    <input  class="form-control" type="text" id="shops_open" name="shops_open" length="200"  />
    </div>
    <div class="form-group">
      <label for="holiday">Date</label>
      <input type="date" id="holiday" name="holiday" class="form-control" placeholder="dd-mm-yyyy" />
    </div>

    <input type="submit" id="submit" name="submit" class="btn btn-primary btn-lg" value="Add" />
  </form>
  </section>
  
</div><!--container-->

<?php include_once("footer-nav.php"); ?>

</body>
</html>
