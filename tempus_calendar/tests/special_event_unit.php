<?php

/**
 * @file tests/special_event_unit.php
 * Run all unit tests together using a shell script
 *
 */
class SpecialEventTest extends PHPUnit_Framework_TestCase
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
  *     'event'       => 'Sue',
  *      's_day'      => 20150711,
  *      'birthday'  => 1,
  *      'place'     =>  'Leeds',
  *      'details' => 'I think it was then',
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
    $sql = 'SELECT (num, event, s_day, birthday, place, details) FROM anniversary WHERE event = "Sue" AND place = "Leeds"';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $actualString = $row['event'] . ' ' . $row['s_day'] . ' ' . $row['birthday'];
    $actualString .= ' ' . $row['place'] . ' ' . $row['details'];
    $testString = 'Sue 20150711 1 Leeds I think it was then';
    $this->assertEquals($testString, $actualString);
    $lastId = $row['num'];
    $tidy = 'DELETE FROM anniversary WHERE num = :id';
    $clearUp = $pdo->prepare($tidy);
    $clearUp->bindValue(':id', $lastId);
    if ($clearUp->execute()) {
      echo 'Test data removed from db';
    }
  }
  
}  // end of class

$test = new NewRecurringEventTest();
$test->fillFormAndSubmit();