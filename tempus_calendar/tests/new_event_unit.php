<?php

/**
 * @file tests/new_event_unit.php
 * Run all unit tests together using a shell script
 *
 */
class NewEventTest extends PHPUnit_Framework_TestCase
{
  /**
  * function to test: insert_bank_holiday. 
  * @return lastInsertId if true, false for failure.
  * Type these in as Selenium isn't quite working:
  *
  * public function validInputsProvider()
  * {
  *  $inputs[] = [
  *    [
  *     'task'       => 'Bring washing in',
  *      's_day'      => 20150301,
  *      'start_time' => 1400,
  *      'end_time'   => 1500,
  *      'details'    => 'checked dryness',
  *      'priority'   => 'medium',
  *     'cat_id'     => 7,
  *   ]
  * ];
  */
  
  
  
  /**
  * Tests for the inserted data.
  *
  */
  public function fillFormAndSubmit() {
    // set up the database
    require_once '../common_libs.php';
    $pdo = db_connect();
    $sql = 'SELECT (task_id, task, s_day, start_time, end_time, details, priority, cat_id) FROM task_item WHERE task = "Bring washing in" AND s_day = 20150301';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $actualString = $row['task'] . ' ' . $row['s_day'] . ' ' . $row['start_time'];
    $actualString .= ' ' . $row['end_time'] . ' ' . $row['details'] . ' ' . $row['priority'] . ' ' . $row['cat_id'];
    $testString = 'Bring washing in 20150301 1400 1500 checked dryness medium 7';
    $this->assertEquals($testString, $actualString);
    $lastId = $row['task_id'];
    $tidy = 'DELETE FROM task_item WHERE task_id = :id';
    $clearUp = $pdo->prepare($tidy);
    $clearUp->bindValue(':id', $lastId);
    if ($clearUp->execute()) {
      echo 'Test data removed from db';
    }
  }
  
}  // end of class

$test = new NewEventTest();
$test->fillFormAndSubmit();