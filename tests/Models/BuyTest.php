<?php
require_once '../../Models/Buy.php';
require_once '../../DTO/Items.php';
require_once '../../DTO/Sales.php';
require_once '../../DTO/Bankbook.php';

use \PHPUnit\Framework\TestCase;

class BuyTest extends TestCase
{
    /** @var Buy */
    private $buy;

    /** @var  Items */
    private $items;

    /** @var  Sales */
    private $sales;

    /** @var  Bankbook */
    private $bankbook;

    private $amountDefault = 500;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->items = new Items();
        $this->sales = new Sales();
        $this->bankbook = new Bankbook();
        $this->bankbook->setCurrentAmount($this->amountDefault);
        $this->buy = new Buy($this->items, $this->sales, $this->bankbook);
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @test
     */
    function 購入を行うとき売り上げと在庫と現在金額の計算が正しいかとテスト()
    {
        $itemName = 'コーラ';
        $this->buy->buyItems($itemName);
        $this->buy->buyItems($itemName);

        /** 売り上げの計算をチャックする */
        $this->assertEquals($this->sales->getCurrentSales(), $this->items->getItemsPrice($itemName) * 2);

        /** 在庫の計算をチェックする */
        $this->assertEquals($this->items->getItemsStocks($itemName), Items::limit - 2);

        /** 現在金額の計算をチェックする */
        $this->assertEquals($this->bankbook->getCurrentAmount(),
            $this->amountDefault - ($this->items->getItemsPrice($itemName) * 2));
    }
}