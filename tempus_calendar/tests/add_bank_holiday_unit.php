<?php

/**
 * @file tests/AddBankHolidayTest.php
 * Use java -jar selenium-server to run the selenium server before running.
 */
class AddBankHolidayTest extends PHPUnit_Extensions_Selenium2TestCase
{
  public function setUp()
  {
    
    // $this->setHost('localhost');
    // $this->setPort(4444);
    $this->setBrowserUrl('http://localhost/tempus/add_bank_holiday.php');
    $this->setBrowser('firefox');
    $this->prepareSession();
  }


  /**
  * Used to close the browser and exit the session if one is active.
  *
  */
  public function tearDown()
  {
    $this->stop();
  }

  /**
  * function to test: insert_bank_holiday. 
  * @return lastInsertId if true, false for failure.
  */
  public function validInputsProvider()
  {
    $inputs[] = [
      [
        'title'       => 'Christmas',
        'shops_open'  => 0,
        'hol_date'     => '20151225',
      ]
    ];

    return $inputs;
  }
  
  
  
  
  /**
    * passes an array of input into a form, and then submits the form
    *
    */
  public function fillFormAndSubmit(array $inputs)
  {
    // $this->waitForPageToLoad('30000');
    $form = $this->byId('add_bank_holiday');
    foreach ($inputs as $input => $value) {
      $form->byName($input)->value($value);
    }
    $form->submit();
    $idSpan = $this->byCssSelector('#sql-id');
    // set up the database
    require('../../settings.php');
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
    $sql = 'SELECT (title, shops_open, hol_date) FROM bank_holidays WHERE num = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $idSpan);
    $stmt->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $actualString = $row['title'] . ' ' . $row['shops_open'] . ' ' . $row['hol_date'];
    $testString = 'Christmas 0 20151225';
    $this->assertEquals($errorMessage, $actualString);
  }
  
}  // end of class

$test = new AddBankHolidayTest();
$test->setUp();
$test->fillFormAndSubmit($test->validInputsProvider());
$test->tearDown();
