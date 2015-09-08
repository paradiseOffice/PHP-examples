<?php

/**
 * @file tests/add_bank_holiday_unit.php
 * Run all unit tests together using a shell script
 *
 */
class AddBankHolidayTest extends PHPUnit_Framework_TestCase
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
  *     'title'       => 'unicorn holiday',
  *     'shops_open'  => 0,
  *     'hol_date'     => '20151225',
  *   ]
  * ];
  */
  
  
  
  /**
    * passes an array of input into a form, and then submits the form
    *
    */
  public function fillFormAndSubmit() {
    // set up the database
    require_once '../common_libs.php';
    $pdo = db_connect();
    $sql = 'SELECT (num, title, shops_open, hol_date) FROM bank_holidays WHERE title = "unicorn holiday" AND shops_open = 0 AND hol_date = 20151225';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $actualString = $row['title'] . ' ' . $row['shops_open'] . ' ' . $row['hol_date'];
    $testString = 'unicorn holiday 0 2015-12-25';
    $this->assertEquals($testString, $actualString);
    $lastId = $row['num'];
    $tidy = 'DELETE FROM bank_holidays WHERE num = :id';
    $clearUp = $pdo->prepare($tidy);
    $clearUp->bindValue(':id', $lastId);
    if ($clearUp->execute()) {
      echo 'Test data removed from db';
    }
  }
  
}  // end of class

$test = new AddBankHolidayTest();
$test->fillFormAndSubmit();

