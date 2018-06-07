<?php
/**
 * Created by PhpStorm.
 * User: j-heo
 * Date: 2018/06/07
 * Time: 18:11
 */

/**
 * Class Datas
 */
class Datas
{
    const RESULT_CODE_PURCHASE_SUCCESS = 1; //
    const RESULT_CODE_NOT_SUFFICIENT_MONEY = 2; //
    const RESULT_CODE_NOT_STOCKS = 3; //
    const RESULT_CODE_NOT_EXIST_ITEM = 4; //
    const RESULT_CODE_EXIT_PURCHASE_PROCESS = 5; //

    const MODE_CURRENT_AMOUNT_ZERO = 1; //
    const MODE_STOCKS_EXIST = 2; //
    const MODE_CURRENT_AMOUNT_NOT_ZERO_STOCKS_NOT_EXIST = 3; //

    const INPUT_MONEY = 1; //
    const PURCHASE_ITEMS = 2; //
    const PAY_BACK_MONEY = 3; //
    const CHECK_SALES = 4; //
    const QUIT_PROCESS = 5; //
}