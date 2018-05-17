<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:01
 */

class Bankbook
{
    /**
     * @var integer $currentAmount 入っている金額
     */
    private $currentAmount = null;

    /**
     * @return integer
     */
    public function getCurrentAmount()
    {
        return $this->currentAmount;
    }

    /**
     * @param $currentAmount 変動があった自動販売機に入ってる金額
     */
    public function setCurrentAmount($currentAmount)
    {
        $this->currentAmount = $currentAmount;
    }
}