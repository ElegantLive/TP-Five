<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/19
 * Time: 11:25
 */

namespace app\api\validate;


class TestValidate extends BaseValidate
{
    protected $rule = [
        ['id','require','id不能为空'],
        ['name','require|email','name不能为空name不能为空'],
        ['mobile','require|isMobile','手机号码格式不正确']
    ];

}