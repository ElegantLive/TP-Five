<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/19
 * Time: 10:16
 */

namespace app\api\controller;


class Test
{
    public function test($params)
    {
        return 'test'.$params;
    }
}