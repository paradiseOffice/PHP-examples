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
        <option>None</option>
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
