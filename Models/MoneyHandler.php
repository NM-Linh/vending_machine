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
    private $authorizedMoney = array('10', '50', '100', '500', '1000');


    public function validateMoney($checkMoney)
    {

        if (in_array($checkMoney, $this->authorizedMoney)) {
            return true;
        }
        return false;
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