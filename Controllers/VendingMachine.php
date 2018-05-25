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

/*
<?php
//商品情報
$Drink = array(
    'name' => 'cola',
    'price' => '150'
);

//文言の指定
$question = '購入したい商品を選んでください';

while (1) {

    echo $question . PHP_EOL;
    echo '商品リスト：', $Drink['name'] . PHP_EOL;

    // 標準入力から取得
    $line = trim(fgets(STDIN));	// 入力後エンターキーが押されるまで待ち状態

    // 一致したら終了
    if ($line === $Drink['name']) {
        echo "コーラを購入しました!";
        break;	// 無限ループを抜ける
    } else {
        echo "商品がありません。もう一度入力してください。" . PHP_EOL;
    }
}
?>

<?php
//商品情報
$Drink = array(
    'name' => 'cola',
    'price' => '150'
);

//文言の指定
$question = 'お金を入れてください';

//合計金額
$sum = 0;

//取り扱い通貨リスト
$money = ['10', '50', '100', '500', '1000'];


echo $question . PHP_EOL;

while (1) {
// 標準入力から取得
    $line = trim(fgets(STDIN));    // 入力後エンターキーが押されるまで待ち状態

    if (in_array($line, $money)) {
        $sum = $sum + $line;
        echo $line . "円投入されました。現在の合計は" . $sum . "です。" . PHP_EOL;
    } else if ($line == 'end'){
        break;
    } else {
        echo "投入された通貨はお取り扱いできません。現在の合計は" . $sum . "です。" . PHP_EOL;
    }
}

echo '最終金額は' . $sum . 'です！';

?>