<?php
/**
 * Created by PhpStorm.
 * User: Anh
 * Date: 2018/06/03
 * Time: 10:00
 */

use PHPUnit\Framework\TestCase;

require '../../DTO/Items.php';

/**
 * Class ItemsTest
 * @property Items
 */
class ItemsTest extends TestCase
{

    private $expectedItem = array(
        'コーラ' => array(
            'name' => 'コーラ',
            'price' => 120,
            'stocks' => 5
        )
    );

    private $items;

    protected function setUp()
    {
        $this->items = new Items();
    }

    /**
     * @test
     */
    function デフォルトでコーラの商品情報を返す()
    {
        $this->assertEquals($this->expectedItem, $this->items->getItems());
    }

    /**
     * @test
     * @dataProvider 商品値段が取得できる用テストデータ
     * @param $name 商品名前
     * @param $expected 期待値
     */
    function 商品値段が取得できる($name, $expected)
    {
        $this->assertEquals($expected, $this->items->getItemsPrice($name));
    }

    function 商品値段が取得できる用テストデータ()
    {
        return array(
            '名前が正しい' => array('name' => 'コーラ', 'expected' => 120),
            '名前が違い' => array('name' => 'コーラテスト', 'expected' => null),
        );
    }


    /**
     * @test
     * @dataProvider 商品在庫が取得できる用テストデータ
     * @param $name 商品名前
     * @param $expected 期待値
     */
    function 商品在庫が取得できる($name, $expected)
    {
        $this->assertEquals($expected, $this->items->getItemsStocks($name));
    }

    function 商品在庫が取得できる用テストデータ()
    {
        return array(
            '名前が正しい' => array('name' => 'コーラ', 'expected' => 5),
            '名前が違い' => array('name' => 'コーラテスト', 'expected' => null),
        );
    }

    /**
     * @test
     * @dataProvider 商品在庫が更新する用テストデータ
     * @param $name 商品名前
     * @param $stocks 在庫
     * @param $expected 期待値
     */
    function 商品在庫が更新できる($name, $stocks, $expected)
    {
        $updatedItems = new Items();
        $updatedItems->setItemsStocks($name, $stocks);
        $this->assertEquals($expected, $updatedItems->getItemsStocks($name));
    }

    function 商品在庫が更新する用テストデータ()
    {
        return array(
            '名前が正しい' => array(
                'name' => 'コーラ',
                'stocks' => 10,
                'expected' => 10
            ),
            '名前が違い' => array(
                'name' => 'コーラテスト',
                'stocks' => 10,
                'expected' => 5
            ),
        );
    }
}
