<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/19
 * Time: 10:53
 */

namespace app\api\controller\v1;


use app\api\validate\TestValidate;
use think\Controller;

class First extends Controller
{
    public function info($id,$name)
    {
        (new TestValidate())->goCheck();
        return $id.$name;
    }
}