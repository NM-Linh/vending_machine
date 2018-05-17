<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:33
 */

class Buy
{
    public function buyItems($name){
        $items = new Items();
        $getItemsPrice = $items->getItemsPrice($name);
        $getBeforeStocks = $items->getItemsStocks($name);
        $this->calculateSales($getItemsPrice);
        $this->calculateStocks($name, $getBeforeStocks);
        $this->calculateAmount($getItemsPrice);
    }

    public function calculateSales($price){
        $sales = new Sales();
        $beforeSales = $sales->getCurrentSales();
        $currentSales = $beforeSales + $price;
        $sales->setCurrentSales($currentSales);
    }

    public function calculateStocks($name, $stocks){
        $items = new Items();
        $items->setItemsStocks($name, --$stocks);
    }

    public function calculateAmount($price){
        $bankbook = new Bankbook();
        $getAmount = $bankbook->getCurrentAmount();
        $currentAmount = $getAmount - $price;
        $bankbook->setCurrentAmount($currentAmount);
    }
}