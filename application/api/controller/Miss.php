<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/29
 * Time: 14:58
 */

namespace app\api\controller;


use app\lib\exception\MissException;

/**
 * 网页丢失类
 * Class Miss
 * @package app\api\controller
 */
class Miss
{
    public function miss()
    {
        throw new MissException();
    }
}