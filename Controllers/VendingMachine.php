<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/05/16
 * Time: 19:31
 */

require_once 'DTO/Bankbook.php';
require_once 'DTO/Items.php';
require_once 'DTO/Sales.php';
require_once 'Models/Buy.php';
require_once 'Models/ErrorHandler.php';
require_once 'Models/MoneyHandler.php';

class VendingMachine
{
    const MODE_CURRENT_AMOUNT_ZERO = 1;
    const MODE_STOCKS_EXIST = 2;
    const MODE_CURRENT_AMOUNT_NOT_ZERO_STOCKS_NOT_EXIST = 3;

    const INPUT_MONEY = 1;
    const PURCHASE_ITEMS = 2;
    const PAY_BACK_MONEY = 3;
    const CHECK_SALES = 4;
    const QUIT_PROCESS = 5;

    const RESULT_CODE_PURCHASE_SUCCESS = 1;
    const RESULT_CODE_NOT_SUFFICIENT_MONEY = 2;
    const RESULT_CODE_NOT_STOCKS = 3;
    const RESULT_CODE_NOT_EXIST_ITEM = 4;
    const RESULT_CODE_EXIT_PURCHASE_PROCESS = 5;

    private $items;
    private $sales;
    private $bankbook;
    private $buy;
    private $errorHandler;
    private $moneyHandler;

    public function __construct()
    {
        $this->items = new Items();
        $this->sales = new Sales();
        $this->bankbook = new Bankbook();
        $this->errorHandler = new ErrorHandler();
        $this->moneyHandler = new MoneyHandler();
        $this->buy = new Buy($this->items, $this->sales, $this->bankbook, $this->errorHandler);
        $this->powerOn();
    }

    public function powerOn()
    {
        $this->listUpMenu();
        $this->selectMenu();
    }

    public function listUpMenu()
    {
        $itemNumber = 0;
        foreach ($this->items->getItems() as $value) {
            if ($value['stocks'] !== 0) {
                $this->view("\n" . ++$itemNumber . '  ' . $value['name'] . $value['price'] . "円");
            } else {
                $this->view("\n" . ++$itemNumber . '  ' . $value['name'] . $value['price'] . "円【売切れ】");
            }
        }
        $this->view("\n現在残高：" . $this->bankbook->getCurrentAmount() . "円\n");
    }

    public function view($value)
    {
        printf($value . "\n");
    }

    public function selectMenu()
    {
        $this->view("どんなメニューになさいますか？");
        if ($this->bankbook->getCurrentAmount() === 0) {
            $menu = readline("① 入金, ④ 売り上げ確認, ⑤ 終了\n");
            $mode = self::MODE_CURRENT_AMOUNT_ZERO;
        } elseif ($this->stocksValidation()) {
            $menu = readline("① 入金, ② 購入, ③ 払い戻し, ④ 売り上げ確認, ⑤ 終了\n");
            $mode = self::MODE_STOCKS_EXIST;
        } else {
            $menu = readline("① 入金, ③ 払い戻し, ④ 売り上げ確認, ⑤ 終了\n");
            $mode = self::MODE_CURRENT_AMOUNT_NOT_ZERO_STOCKS_NOT_EXIST;
        }
        $this->validateInput($mode, $menu);
    }

    public function stocksValidation()
    {
        $boolean = false;
        foreach ($this->items->getItems() as $value) {
            if ($value['stocks'] !== 0) {
                $boolean = true;
            }
        }
        return $boolean;
    }

    public function validateInput($mode, $menu)
    {
        $menu = $this->errorHandler->inputMenuError($menu);
        if ($menu) {
            $this->controlMenu($mode, $menu);
        } else {
            $this->getBackToSelectMenu();
        }
    }

    public function controlMenu($mode, $menu)
    {
        switch ($menu) {
            case '入金':
            case self::INPUT_MONEY:
                if (!$this->insertMoney()) {
                    $this->view("\n正しいお金を入れてください!\n");
                }
                $this->selectMenu();
                break;

            case '購入':
            case self::PURCHASE_ITEMS:
                switch ($mode) {
                    case self::MODE_STOCKS_EXIST:
                        $this->purchaseItem();
                        $this->selectMenu();
                        break;

                    case self::MODE_CURRENT_AMOUNT_ZERO:
                    case self::MODE_CURRENT_AMOUNT_NOT_ZERO_STOCKS_NOT_EXIST:
                        $this->getBackToSelectMenu();
                        break;
                }
                break;

            case '払い戻し':
            case '払戻し':
            case '払戻':
            case self::PAY_BACK_MONEY:
                switch ($mode) {
                    case self::MODE_STOCKS_EXIST:
                    case self::MODE_CURRENT_AMOUNT_NOT_ZERO_STOCKS_NOT_EXIST:
                        $this->payBack();
                        $this->resetBankbook();
                        $this->selectMenu();
                        break;

                    default:
                        $this->getBackToSelectMenu();
                        break;
                }
                break;

            case '売り上げ確認':
            case '売上げ確認':
            case '売上確認':
            case self::CHECK_SALES:
                $this->checkSales();
                $this->selectMenu();
                break;

            case '終了':
            case self::QUIT_PROCESS:
                $this->powerOff();
                break;

            default:
                $this->getBackToSelectMenu();
                break;
        }
    }

    public function insertMoney()
    {
        $insertMoney = readline("お金を入れてください（'10', '50', '100', '500', '1000'のみ使えます）\n");
        $getAmount = $this->bankbook->getCurrentAmount();
        if ($this->moneyHandler->validateMoney($insertMoney)) {
            $currentMoney = $this->moneyHandler->calculation($insertMoney, $getAmount);
            $this->bankbook->setCurrentAmount($currentMoney);
            $this->view("\n ". $insertMoney. "円を投入した!\n");
            return true;
        }
        return false;
    }

    public function purchaseItem()
    {
        do {
            $this->listUpMenu();
            $itemName = readline("どんな商品を買いますか？(戻りたければ'0'を入力してください)\n");
            switch ($this->buy->buyItems($itemName)){
                case self::RESULT_CODE_PURCHASE_SUCCESS:
                    $this->view('商品を買いました！');
                    break;

                case self::RESULT_CODE_NOT_SUFFICIENT_MONEY:
                    $this->view("\n残高が足りないです！\n");
                    break;

                case self::RESULT_CODE_NOT_STOCKS:
                    $this->view("\nその商品は売切れです！\n");
                    break;

                case self::RESULT_CODE_NOT_EXIST_ITEM:
                    $this->view("\n商品名を正しく入力してください！\n");
                    break;

                case self::RESULT_CODE_EXIT_PURCHASE_PROCESS:
                    $itemName = 0;
                    break;
            }
        } while ($itemName !== 0);
    }

    public function getBackToSelectMenu()
    {
        $this->view("\nメニューにあることを入力してください！\n");
        $this->selectMenu();
    }

    public function payBack()
    {
        $this->view("\nおつりは".$this->bankbook->getCurrentAmount()."です\n");
        return $this->bankbook->getCurrentAmount();
    }

    public function resetBankbook()
    {
        $this->bankbook->setCurrentAmount(0);
    }

    public function checkSales()
    {
        $this->view("\n現在売り上げは" . $this->sales->getCurrentSales() . "円です。\n");
    }

    public function powerOff()
    {
        $this->view("\nご利用いただき誠にありがとうございました。");
    }
}

new VendingMachine();