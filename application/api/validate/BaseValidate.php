<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/19
 * Time: 10:55
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $params = Request::instance()->param();

        if(!$this->check($params)){
            throw new ParameterException([
                'message' =>  $this->error
            ]);
        }
        return true;
    }

    protected function isMobile($mobile)
    {
        $reg = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $res = preg_grep($reg,$mobile);
        if($res){
            return true;
        }else{
            return false;
        }
    }
}