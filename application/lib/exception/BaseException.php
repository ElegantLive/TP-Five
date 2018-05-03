<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/19
 * Time: 16:30
 */

namespace app\lib\exception;

use Exception;

/**
 * 自定义全局异常基类
 * Class BaseException
 * @package app\lib\exception
 */
class BaseException extends Exception
{
    public $code = 400;
    public $message = '参数错误';
    public $errorCode = 10000;
    public $data = null;

    public function __construct(array $param = [])
    {
        if (!is_array($param)) {
            return;
        }
        if (array_key_exists('code', $param)) {
            $this->code = $param['code'];
        }
        if (array_key_exists('message', $param)) {
            $this->message = $param['message'];
        }
        if (array_key_exists('errorCode', $param)) {
            $this->errorCode = $param['errorCode'];
        }
        if (array_key_exists('data', $param)) {
            $this->data = $param['data'];
        }
    }
}