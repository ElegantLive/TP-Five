<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/19
 * Time: 16:06
 */

namespace app\lib\exception;

use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    private $request_url;
    public function render(Exception $e)
    {
        if($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            if(config('app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = '未知错误';
                $this->errorCode = '999';
                // 记录日志
                self::recordLog($e);
            }
        }

        $this->request_url = Request::instance()->url();

        $res = [
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_url' => $this->request_url
        ];

        return json($res,$this->code);
    }

    private function recordLog($e)
    {
        Log::record($e->getMessage(),'error');
    }
}