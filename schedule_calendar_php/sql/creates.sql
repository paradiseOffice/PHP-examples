CREATE TABLE time_usage (
  usage_id      INT AUTO_INCREMENT PRIMARY KEY,
  s_day         DATE NOT NULL,
  start_time    TIME NOT NULL,
  end_time      TIME NOT NULL,
  activity      VARCHAR(100) DEFAULT "--&lt;"
);

CREATE TABLE categories (
  cat_id        INTEGER PRIMARY KEY AUTO_INCREMENT,
  name          VARCHAR(100) NOT NULL,
  colour        VARCHAR(100) NOT NULL 
  /* rgba(255,255,255,1.0) */
);

CREATE TABLE todo_item (
  task_id       INTEGER PRIMARY KEY AUTO_INCREMENT,
  task          VARCHAR(100) NOT NULL,
  s_day         DATE,
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
  s_day         DATE,
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

CREATE TABLE work_hol (
  num           INT AUTO_INCREMENT,
  start_date    DATE,
  end_date      DATE,
  work_days     BOOLEAN,
  hol_days      BOOLEAN,
  PRIMARY KEY (num)
);

CREATE TABLE special_events (
  num           INT AUTO_INCREMENT,
  event         VARCHAR(100) NOT NULL,
  s_day         DATE,
  yearly        BOOLEAN,
  attendees     VARCHAR(300),
  details       VARCHAR(1000),
  PRIMARY KEY (num)
);

CREATE TABLE bank_holidays (
  num           INT AUTO_INCREMENT,
  title         VARCHAR(100) NOT NULL,
  shops_open    VARCHAR(200) NOT NULL,
  holiday       DATE,
  PRIMARY KEY (num)
);
