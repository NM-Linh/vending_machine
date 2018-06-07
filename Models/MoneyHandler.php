<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:33
 */

/**
 * Class MoneyHandler
 * @property Bankbook
 */
class MoneyHandler
{
    /**
     * @var object $bankbook ControllerからもらったBankbookクラスのobjectの情報が入っている変数
     */
    private $bankbook;

    /**
     * @var object $errorHandler ControllerからもらったErrorHandlerクラスのobjectの情報が入っている変数
     */
    private $errorHandler;

    /**
     * MoneyHandler constructor.
     * @param $bankbook
     * @param $errorHandler
     */
    public function __construct($bankbook, $errorHandler)
    {
        $this->bankbook = $bankbook;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param $money
     * @return mixed
     */
    public function inputMoney($money)
    {
        $money = $this->errorHandler->inputMoneyError($money);
        if ($money) {
            $getAmount = $this->bankbook->getCurrentAmount();
            $currentMoney = $this->calculation($money, $getAmount);
            $this->bankbook->setCurrentAmount($currentMoney);
        }
        return $money;
    }

    /**
     * @param Integer $insertMoney
     * @param Bankbook $bankbook
     *
     * @return Integer
     */
    public function calculation($insertMoney, $getAmount)
    {
        return $getAmount + $insertMoney;
    }

}