<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/23
 * Time: 18:14
 */

/**
 * Class Error ユーザーが入力の間に起こる可能性があるエラーの処理を行う
 */
class ErrorHandler
{
    private $number = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    private $menu = array('入金', '購入', '払い戻し', '払戻し', '払戻', '売り上げ確認', '売上げ確認', '売上確認', '終了');


    public function inputMenuError($inputValue)
    {
        $inputValue = mb_convert_kana($inputValue, 'rnas', 'UTF-8');
        if (strlen($inputValue) > 1) {
            foreach ($this->menu as $value) {
                if ($inputValue === $value) {
                    return $inputValue;
                }
            }
        } else {
            if ($this->inputNumberError((int)$inputValue) && (int)$inputValue !== 0) {
                return $inputValue;
            }
        }
        return false;
    }

    public function inputNumberError($inputValue)
    {
        $boolean = false;
        for ($i = 0; $i < strlen($inputValue); $i++) {
            for ($j = 0; $j < count($this->number); $j++) {
                if ($this->number[$j] !== substr($inputValue, $i, 1)) {
                    $boolean = true;
                }
            }
        }
        return $boolean;
    }

    /**
     * @param $items 商品が入っている配列
     * @param $name ユーザーから入力してもらった商品の名前
     * @return bool
     * 入力してもらった商品の名前が正しいか正しくないかを判別
     */
    public function inputNameError($items, $name)
    {
        $name = mb_convert_kana($name, 'rnas', 'UTF-8');
        if(strlen($name)>1) {
            foreach ($items->getItems() as $value) {
                if ($name === $value['name']) {
                    return $name;
                }
            }
        }else{
            if ($this->inputNumberError((int)$name)) {
                return $name;
            }
        }
        return false;
    }
}