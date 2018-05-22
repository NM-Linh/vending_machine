<?php

/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:31
 */
class VendingMachine
{
    public function display()
    {
        //商品情報を取得
        //現在の投入金額を取得
        //取得した商品情報と投入金額を表示
    }

    public function getAmountAndItems()
    {
        //在庫チェック
        //在庫が0なら売り切れを表示する

    }

    public function chooseAction()
    {
        //入力された値によって各機能を呼び出す
        //入出金
        //商品を購入する

    }

    public function powerOn()
    {
        //入力情報を取得する
        //display()を呼び出す
        //getAmountAndItems()を呼び出す
        //chooseAction()を呼び出す
    }

    public function powerOff()
    {
        //処理を終える
    }

}