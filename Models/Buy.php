<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:33
 */

/**
 * Class Buy
 * 名前：空白、名前がないとき
 * 入れるお金：文字、空白、
 */
class Buy
{
    const RESULT_CODE_PURCHASE_SUCCESS = 1;
    const RESULT_CODE_NOT_SUFFICIENT_MONEY = 2;
    const RESULT_CODE_NOT_STOCKS = 3;
    const RESULT_CODE_NOT_EXIST_ITEM = 4;
    const RESULT_CODE_EXIT_PURCHASE_PROCESS = 5;
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
    private $errorHandler;

    /**
     * Buy constructor.
     * @param $items object from controller
     * @param $sales object from controller
     * @param $bankbook object from controller
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
            return self::RESULT_CODE_EXIT_PURCHASE_PROCESS;
        }

        if ($itemName === false) {
            return self::RESULT_CODE_NOT_EXIST_ITEM;
        }

        if ($this->items->getItemsStocks($itemName) <= 0) {
            return self::RESULT_CODE_NOT_STOCKS;
        }

        if (($this->bankbook->getCurrentAmount()) - ($this->items->getItemsPrice($itemName)) < 0) {
            return self::RESULT_CODE_NOT_SUFFICIENT_MONEY;
        }

        $this->purchaseProcess($itemName);
        return self::RESULT_CODE_PURCHASE_SUCCESS;
    }

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