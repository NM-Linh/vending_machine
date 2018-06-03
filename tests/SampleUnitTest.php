<?php
/**
 * Created by PhpStorm.
 * User: Anh
 * Date: 2018/06/03
 * Time: 10:00
 */
use PHPUnit\Framework\TestCase;

class SampleUnitTest extends TestCase {

 function testCodeTrue()
  {
	$this->assertEquals(1, 1);
  }

 function testCodeFalse()
  {     
        $this->assertEquals(1, 0);
  }
}
