<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:01
 */

/**
 * Class Items 自動販売機に登録されている商品情報保存、出し入れするクラス
 */
class Items
{
    /**
     * @var array $items 販売の商品が入ってる
     */
    private $items = array(
        'コーラ' => array(
            'name' => 'コーラ',
            'price' => 120,
            'stocks' => 5
        )
    );

    /**
     * @param $name 商品名
     * @return array 商品リスト
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $name 商品名
     * @return integer 商品値段
     */
    public function getItemsPrice($name)
    {
        return $this->items[$name]['price'];
    }

    /**
     * @param $name 商品名
     * @return integer 商品在庫
     */
    public function getItemsStocks($name)
    {
        return $this->items[$name]['stocks'];
    }

    /**
     * @param $name 商品名
     * @param $stocks 商品在庫
     */
    public function setItemsStocks($name, $stocks)
    {
        $this->items[$name]['stocks'] = $stocks;
    }
}