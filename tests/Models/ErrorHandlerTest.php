<?php
require_once '../../Models/ErrorHandler.php';

use \PHPUnit\Framework\TestCase;

class ErrorHandlerTest extends TestCase
{
    /** @var ErrorHandler  */
    private $errorHandler;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->errorHandler = new ErrorHandler();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @test
     * @dataProvider ユーザーが入力したデータが正しいかテスト用テスト
     *
     */
    public function ユーザーが入力したデータが正しいかテスト($inputValue, $expected)
    {
        $result = $this->errorHandler->inputMenuError($inputValue);
        $this->assertEquals($expected, $result);
    }

    public function ユーザーが入力したデータが正しいかテスト用テスト()
    {
        return array(
            '数値「半角」「0-9」' => array(
                'inputValue' => 1,
                'expected' => true,
            ),
            '数値「全角」「0-9」' => array(
                'inputValue' => １,
                'expected' => true,
            ),
            '文字「漢字」' => array(
                'inputValue' => '購入',
                'expected' => '購入',
            ),
            '数値「半角」「0↓」' => array(
                'inputValue' => -1,
                'expected' => false,
            ),
        );
    }
}