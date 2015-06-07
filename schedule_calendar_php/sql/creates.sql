CREATE TABLE time_usage {
  usage_id INTEGER NOT NULL PRIMARY_KEY AUTO_INCREMENT,
  start_time    TIMESTAMP NOT NULL,
  end_time      TIMESTAMP NOT NULL,
  activity      VARCHAR(100) DEFAULT "event shown"    
};

CREATE TABLE categories {
  cat_id INTEGER NOT NULL PRIMARY_KEY AUTO_INCREMENT,
  name   VARCHAR(100),
  colour VARCHAR(100) /* rgba(255,255,255,1.0) */
};

todo_item table

routine_events table

work_hol table # work /holiday date ranges

special_events table # birthdays etc. other day long events

bank_holidays table
