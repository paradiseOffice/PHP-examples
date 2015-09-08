<?php

/**
 * @file tests/new_recurring_event_unit.php
 * Run all unit tests together using a shell script
 *
 */
class NewRecurringEventTest extends PHPUnit_Framework_TestCase
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
  *     'event'       => 'Going on a date',
  *     'recurs'      => 'fortnightly',
  *      's_day'      => 20150301,
  *      'start_time' => 1800,
  *      'end_time'   => 1900,
  *      'place'     =>  'California',
  *      'attendees' =>  'another person',
  *      'details' => 'go out with someone',
  *      'url'    => 'http://www.example.com',
  *     'cat_id'     => 10,
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
    $sql = 'SELECT (event_id, event, recurs, s_day, start_time, end_time, place, attendees, details, url, cat_id) FROM routine_events WHERE event = "Going on a date" AND s_day = 20150301';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $actualString = $row['event'] . ' ' . $row['recurs'] . ' ' . $row['s_day'] . ' ' . $row['start_time'];
    $actualString .= ' ' . $row['end_time'] . ' ' . $row['place'] . ' ' . $row['attendees'] . ' ' . $row['details'];
    $actualString .= ' ' . $row['url'] . ' ' . $row['cat_id'];
    $testString = 'Going on a date fortnightly 20150301 1800 1900 California another person go out with someone http://www.example.com 10';
    $this->assertEquals($testString, $actualString);
    $lastId = $row['event_id'];
    $tidy = 'DELETE FROM routine_events WHERE event_id = :id';
    $clearUp = $pdo->prepare($tidy);
    $clearUp->bindValue(':id', $lastId);
    if ($clearUp->execute()) {
      echo 'Test data removed from db';
    }
  }
  
}  // end of class

$test = new NewRecurringEventTest();
$test->fillFormAndSubmit();