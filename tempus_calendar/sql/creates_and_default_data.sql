
-- MySQL Script generated by MySQL Workbench
-- Tue 25 Aug 2015 14:23:21 BST
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema tempus
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema tempus
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tempus` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `tempus` ;

-- -----------------------------------------------------
-- Table `tempus`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`categories` (
  `cat_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `colour` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`cat_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`task_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`task_item` (
  `task_id` INT NOT NULL AUTO_INCREMENT,
  `task` VARCHAR(100) NOT NULL,
  `s_day` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `details` VARCHAR(1000) NULL,
  `priority` ENUM('urgent', 'high', 'medium', 'low') NULL DEFAULT 'medium',
  `cat_id` INT NOT NULL,
  PRIMARY KEY (`task_id`),
  INDEX `cat_id_idx` (`cat_id` ASC),
  CONSTRAINT `cat_id_1`
    FOREIGN KEY (`cat_id`)
    REFERENCES `tempus`.`categories` (`cat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`routine_events`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`routine_events` (
  `event_id` INT NOT NULL AUTO_INCREMENT,
  `event` VARCHAR(100) NOT NULL,
  `recurs` ENUM('daily', 'weekly', 'fortnightly', 'lunar', 'monthly', 'bimonthly', 'quarterly', 'yearly') NOT NULL DEFAULT 'daily',
  `s_day` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `place` VARCHAR(100) NULL,
  `attendees` VARCHAR(100) NULL,
  `details` VARCHAR(1000) NULL,
  `url` VARCHAR(300) NULL,
  `cat_id` INT NOT NULL,
  PRIMARY KEY (`event_id`),
  INDEX `cat_id_idx2` (`cat_id` ASC),
  CONSTRAINT `cat_id_2`
    FOREIGN KEY (`cat_id`)
    REFERENCES `tempus`.`categories` (`cat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`recurrences`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `tempus`.`recurrences` (
  `rec_id` INT NOT NULL AUTO_INCREMENT,
  `next_date` DATE NOT NULL,
  `event_id` INT NOT NULL,
  PRIMARY KEY (`rec_id`),
  INDEX `event_id` (`event_id` ASC),
  CONSTRAINT `event_id`
    FOREIGN KEY (`event_id`)
    REFERENCES `tempus`.`routine_events` (`event_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`work_hol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`work_hol` (
  `num` INT NOT NULL AUTO_INCREMENT,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `work` TINYINT(1) NULL DEFAULT 0,
  `holiday` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`num`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`anniversary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`anniversary` (
  `num` INT NOT NULL AUTO_INCREMENT,
  `event` VARCHAR(100) NOT NULL,
  `s_day` DATE NOT NULL,
  `birthday` TINYINT(1) NULL DEFAULT 0,
  `place` VARCHAR(100) NULL,
  `details` VARCHAR(1000) NULL,
  PRIMARY KEY (`num`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`bank_holidays`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`bank_holidays` (
  `num` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `shops_open` TINYINT(1) NOT NULL DEFAULT 1,
  `hol_date` DATE NOT NULL,
  PRIMARY KEY (`num`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tempus`.`notes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tempus`.`notes` (
  `note_id` INT NOT NULL AUTO_INCREMENT,
  `s_day` DATE NOT NULL,
  `content` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`note_id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -------------------------------------------------------
-- Insert some nice default category colours
-- -------------------------------------------------------
INSERT INTO categories (name, colour) VALUES ('cleaning', 'rgba(234, 232, 197, 1.0)');
INSERT INTO categories (name, colour) VALUES ('shopping', 'rgba(238, 29, 242, 0.8)');
INSERT INTO categories (name, colour) VALUES ('life admin', 'rgba(100, 100, 100, 1.0)');
INSERT INTO categories (name, colour) VALUES ('holiday', 'rgba(248, 192, 249, 1.0)');
INSERT INTO categories (name, colour) VALUES ('leisure', 'rgba(249, 225, 192, 1.0)');
INSERT INTO categories (name, colour) VALUES ('work', 'rgba(166, 238, 244, 1.0)');
INSERT INTO categories (name, colour) VALUES ('IT learning', 'rgba(230, 230, 230, 1.0)');
INSERT INTO categories (name, colour) VALUES ('IT', 'rgba(169, 219, 98, 1.0)');
INSERT INTO categories (name, colour) VALUES ('website', 'rgba(210, 196, 242, 1.0)');
INSERT INTO categories (name, colour) VALUES ('social', 'rgba(186, 163, 83, 1.0)');
INSERT INTO categories (name, colour) VALUES ('languages', 'rgba(249, 107, 118, 1.0)');
INSERT INTO categories (name, colour) VALUES ('needlecraft', 'rgba(178, 146, 41, 1.0)');
INSERT INTO categories (name, colour) VALUES ('debugging', 'rgba(237, 242, 145, 1.0)');
INSERT INTO categories (name, colour) VALUES ('reading', 'rgba(255, 255, 255, 1.0)');
INSERT INTO categories (name, colour) VALUES ('testing', 'rgba(124, 131, 255, 1.0)');

-- -------------------------------------------------------
-- Insert bank holidays for 3 years
-- -------------------------------------------------------
--- INSERT INTO bank_holidays (title, shops_open, hol_date) VALUES (' ', 1, 00000000);


-- -------------------------------------------------------
-- Insert some tasks for a week
-- -------------------------------------------------------
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Design personal blog', 20150827, 1400, 1500, 'Design personal portfolio site, read book on Wordpress to help.', 'urgent', 9);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Design lakeside website', 20150828, 1700, 1900, 'Website for Kirk Hallam lake, lots of CSS and JavaScript', 'high', 9);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('programming PHP book', 20150828, 1500, 1900, 'From page 100', 'medium', 7);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Tempus - create tests', 20150829, 1000, 1100, 'Find help in the Jenkins cookbook', 'urgent', 15);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Tempus unit tests', 20150829, 1200, 1300, ' ', 'high', 15);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Bugfix Tempus', 20150829, 1300, 1600, 'Make some unit tests pass - PC', 'urgent', 13);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('programming PHP book', 20150829, 2000, 2230, 'From page 500', 'medium', 7);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Fix SQL', 20150829, 1030, 1100, 'Fix indexing error 1005', 'high', 13);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Create all unit tests for Tempus', 20150829, 1230, 1600, 'Read Jenkins PHP book for inspiration', 'urgent', 15);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Drupal book', 20150829, 1700, 1900, 'Drupal modules book', 'high', 7);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Design lakeside website', 20150829, 1900, 2000, 'Look at pictures for inspiration', 'medium', 9);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Check hotmails', 20150829, 2000, 2000, ' ', 'low', 3);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('programming PHP', 20150829, 2000, 2230, 'On Pi', 'high', 7);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Read SSH book', 20150830, 0700, 1000, 'Set up two VMs one nginx server, one plain SSH server (minimal centos). Book is in networking', 'high', 7);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Go to Aldi', 20150830, 1000, 1200, ' ', 'high', 3);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Fix Tempus bug(s)', 20150830, 1300, 1600, 'Pick a failing unit test ', 'urgent', 13);

INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Fix Tempus bugs', 20150830, 1700, 1900, 'Do proper git stuff ', 'medium', 13);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Read deploying OpenStack', 20150831, 0800, 1730, 'Put openstack on VM ', 'high', 7);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('JS', 20150830, 1900, 2000, 'Put that you have read a book and recorded some company details for spec letters', 'high', 3);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Edit duck pics', 20150830, 2000, 2230, 'and video ', 'medium', 5);

INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Clean floors', 20150831, 1800, 1900, 'mop, empty vac ', 'high', 1);
INSERT INTO task_item (task, s_day, start_time, end_time, details, priority, cat_id) VALUES ('Dust cobwebs', 20150831, 1900, 2000, 'get no spiders on self', 'urgent', 1);

