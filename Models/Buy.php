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
     * Buy constructor.
     * @param $items object from controller
     * @param $sales object from controller
     * @param $bankbook object from controller
     * Controllerから作ってもらったobjectを参照する
     */
    public function __construct($items, $sales, $bankbook)
    {
        $this->items = $items;
        $this->sales = $sales;
        $this->bankbook = $bankbook;
    }

    /**
     * @param string $name 商品の名前
     * 購入を行うとき、商品を情報を入れてもらって処理を行う
     */
    public function buyItems($name){
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
    public function calculateSales($price){
        $beforeSales = $this->sales->getCurrentSales();
        $currentSales = $beforeSales + $price;
        $this->sales->setCurrentSales($currentSales);
    }

    /**
     * @param $name 商品の名前
     * @param $stocks 商品の在庫
     * 在庫の計算
     */
    public function calculateStocks($name, $stocks){
        $this->items->setItemsStocks($name, --$stocks);
    }

    /**
     * @param $price
     * 現在金額の計算
     */
    public function calculateAmount($price){
        $getAmount = $this->bankbook->getCurrentAmount();
        $currentAmount = $getAmount - $price;
        $this->bankbook->setCurrentAmount($currentAmount);
    }
}