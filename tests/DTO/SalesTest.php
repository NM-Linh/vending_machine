<?php
/**
 * Created by PhpStorm.
 * User: Anh
 * Date: 2018/06/03
 * Time: 10:00
 */

use PHPUnit\Framework\TestCase;

require '../../DTO/Sales.php';

/**
 * Class SalesTest
 * @property Sales
 */
class SalesTest extends TestCase
{
    /**
     * @test
     */
    function 最初に現在の売上が０を返す()
    {
        $sale = new Sales();
        $this->assertEquals(0, $sale->getCurrentSales());
    }

    /**
     * @test
     */
    function 現在の売上をセットして取得できるテスト()
    {
        $sale = new Sales();
        $sale->setCurrentSales(1);
        $this->assertEquals(1, $sale->getCurrentSales());
    }

    /**
     * @test
     */
    function DTOの属性をチェックする()
    {
        $sale = new Sales();
        $saleAttributes = $sale->getAllAttributes();
        $this->assertEquals(1, $this->count($saleAttributes));
        $this->assertArrayHasKey('currentSales', $saleAttributes);
    }
}
