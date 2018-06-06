<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:01
 */


/**
 * Class Bankbook 現在入っている金額を出し入れするクラス
 */
class Bankbook
{
    /**
     * @var integer $currentAmount 入っている金額
     */
    private $currentAmount = 0;

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

    /**
     * テストために追加
     * @return array
     */
    public function getAllAttributes()
    {
        return get_object_vars($this);
    }
}