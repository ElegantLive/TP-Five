<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/19
 * Time: 16:30
 */

namespace app\lib\exception;

use Exception;
use Throwable;

class BaseException extends Exception
{
    // http 状态码
    public $code = 400;
    // 错误提示信息
    public $msg = '参数错误';
    // 错误码
    public $errorCode = 10000;

    public function __construct($param)
    {
        if(!is_array($param)){
            return ;
        }
        if(array_key_exists('code',$param)){
            $this->code = $param['code'];
        }
        if(array_key_exists('msg',$param)){
            $this->msg = $param['msg'];
        }
        if(array_key_exists('errorCode',$param)){
            $this->errorCode = $param['errorCode'];
        }
    }
}