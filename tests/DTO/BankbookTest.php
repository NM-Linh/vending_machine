<?php
/**
 * Created by PhpStorm.
 * User: Anh
 * Date: 2018/06/03
 * Time: 10:00
 */

use PHPUnit\Framework\TestCase;

require '../../DTO/Bankbook.php';

class BankbookTest extends TestCase
{
    /**
     * @test
     */
    function デフォルトで現在金額が０を返す()
    {
        $bankbook = new Bankbook();
        $this->assertEquals(0, $bankbook->getCurrentAmount());
    }

    /**
     * @test
     */
    function 現在の金額をセットできて取得できるテスト()
    {
        $bankbook = new Bankbook();
        $bankbook->setCurrentAmount(1);
        $this->assertEquals(1, $bankbook->getCurrentAmount());
    }

    /**
     * @test
     */
    function DTOの属性をチェックする()
    {
        $bankbook = new Bankbook();
        $bankbookAttributes = $bankbook->getAllAttributes();
        $this->assertEquals(1, $this->count($bankbookAttributes));
        $this->assertArrayHasKey('currentAmount', $bankbookAttributes);
    }
}
