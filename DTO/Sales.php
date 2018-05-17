<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:00
 */

class Sales
{
    /**
     * @var integer $currentSales 売り上げ金額
     */
    private $currentSales = null;

    /**
     * @return integer
     */
    public function getCurrentSales()
    {
        return $this->currentSales;
    }

    /**
     * @param $currentSales 変動があった売り上げ金額
     */
    public function setCurrentSales($currentSales)
    {
        $this->currentSales = $currentSales;
    }
}