<?php

/**
 * @file tests/add_work_hols_unit.php
 * Run all unit tests together using a shell script
 *
 */
class AddWorkHolidayTest extends PHPUnit_Framework_TestCase
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
  *     'start_date'       => '20140503',
  *     'end_date'  => 20160101,
  *     'work'     => '0',
  *     'holiday'  => '1',
  *   ]
  * ];
  */
  
  public function testDBOutput() {
    require_once '../common_libs.php';
    $pdo = db_connect();
    $sql = 'SELECT (num, start_date, end_date, work, holiday) FROM work_hol WHERE start_date = 20140503 AND end_date = 20160101 AND work = 0 AND holiday = 1 LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $actualString = $row['start_date'] . ' ' . $row['end_date'] . ' ' . $row['work'] . ' ' . $row['holiday'];
    $correctString = '20140503 20160101 0 1';
    $this->assertEquals($correctString, $actualString);
    $lastId = $row['num'];
    $tidy = 'DELETE FROM work_hol WHERE num = :id';
    $clearUp = $pdo->prepare($tidy);
    $clearUp->bindValue(':id', $lastId);
    if ($clearUp->execute()) {
      echo 'Test db data removed';
    }
  }  
  
  
}

$test = new AddWorkHolidayTest();
$test->testDBOutput();