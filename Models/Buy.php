<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:33
 */



/**
 * Class Buy
 *
 */
class Buy
{
    /**
     * @var object $items ControllerからもらったItemsクラスのobjectの情報が入っている変数
     */
    private $items;

    /**
     * @var object $sales ControllerからもらったSalesクラスのobjectの情報が入っている変数
     */
    private $sales;

    /**
     * @var object $bankbook ControllerからもらったBankbookクラスのobjectの情報が入っている変数
     */
    private $bankbook;

    /**
     * @var object $errorHandler
     */
    private $errorHandler;

    /**
     * Buy constructor.
     * @param $items object from controller which is Class Items
     * @param $sales object from controller which is Class Sales
     * @param $bankbook object from controller which is Class Bankbook
     * @param $errorHandler object from controller which is Class ErrorHandler
     * Controllerから作ってもらったobjectを参照する
     */
    public function __construct($items, $sales, $bankbook, $errorHandler)
    {
        $this->items = $items;
        $this->sales = $sales;
        $this->bankbook = $bankbook;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param string $name 商品の名前
     * 購入を行うとき、商品を情報を入れてもらって処理を行う
     */
    public function buyItems($name)
    {
        $itemName = $this->errorHandler->inputItemNameError($this->items, $name);

        if ($itemName === '0') {
            return Datas::RESULT_CODE_PURCHASE_SUCCESS;
        }

        if ($itemName === false) {
            return Datas::RESULT_CODE_NOT_EXIST_ITEM;
        }

        if ($this->items->getItemsStocks($itemName) <= 0) {
            return Datas::RESULT_CODE_NOT_STOCKS;
        }

        if (($this->bankbook->getCurrentAmount()) - ($this->items->getItemsPrice($itemName)) < 0) {
            return Datas::RESULT_CODE_NOT_SUFFICIENT_MONEY;
        }

        $this->purchaseProcess($itemName);
        return Datas::RESULT_CODE_PURCHASE_SUCCESS;
    }

    /**
     * @param $name
     */
    public function purchaseProcess($name)
    {
        $getItemsPrice = $this->items->getItemsPrice($name);
        $getBeforeStocks = $this->items->getItemsStocks($name);
        $this->calculateSales($getItemsPrice);
        $this->calculateStocks($name, $getBeforeStocks);
        $this->calculateAmount($getItemsPrice);
    }

    /**
     * @param $price 商品の値段
     * 売り上げの計算
     */
    public function calculateSales($price)
    {
        $beforeSales = $this->sales->getCurrentSales();
        $currentSales = $beforeSales + $price;
        $this->sales->setCurrentSales($currentSales);
    }

    /**
     * @param $name 商品の名前
     * @param $stocks 商品の在庫
     * 在庫の計算
     */
    public function calculateStocks($name, $stocks)
    {
        $this->items->setItemsStocks($name, --$stocks);
    }

    /**
     * @param $price
     * 現在金額の計算
     */
    public function calculateAmount($price)
    {
        $beforeAmount = $this->bankbook->getCurrentAmount();
        $currentAmount = $beforeAmount - $price;
        $this->bankbook->setCurrentAmount($currentAmount);
    }
}