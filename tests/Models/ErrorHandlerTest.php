<?php
require_once '../../Models/ErrorHandler.php';

use \PHPUnit\Framework\TestCase;

class ErrorHandlerTest extends TestCase
{
    /** @var ErrorHandler */
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
            '数値「環境依存」' => array(
                'inputValue' => '①',
                'expected' => false,
            ),
            '数値「半角」「0以下」' => array(
                'inputValue' => -1,
                'expected' => false,
            ),
            '数値「半角」「9以上」' => array(
                'inputValue' => 10,
                'expected' => false,
            ),
            '文字「想定外」' => array(
                'inputValue' => '購入1',
                'expected' => false,
            ),
        );
    }

    /**
     * @test
     * @dataProvider ユーザーが数値を入力したデータが正しいかテスト用テスト
     *
     */
    public function ユーザーが数値を入力したデータが正しいかテスト($inputValue, $expected)
    {
        $result = $this->errorHandler->inputNumberError($inputValue);
        $this->assertEquals($expected, $result);
    }

    public function ユーザーが数値を入力したデータが正しいかテスト用テスト()
    {
        return array(
            '数値「半角」「0-9」' => array(
                'inputValue' => 12,
                'expected' => true,
            ),
        );
    }
}