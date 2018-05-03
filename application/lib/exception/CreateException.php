<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/5/3
 * Time: 21:42
 */

namespace app\lib\exception;


class CreateException extends BaseException
{
    public $code = 400;
    public $message = '写入数据失败';
    public $errorCode = 100001;
}