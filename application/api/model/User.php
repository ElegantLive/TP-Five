<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/28
 * Time: 16:59
 */

namespace app\api\model;


class User extends BaseModel
{
    public static function check(int $mobile,string $password)
    {
        $where['mobile'] = $mobile;
        $where['password'] = $password;

        $result = self::get($where);

        if($result) return $result;

        return false;
    }
}