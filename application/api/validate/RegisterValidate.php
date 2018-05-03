<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/30
 * Time: 16:04
 */

namespace app\api\validate;


class RegisterValidate extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'password' => 'require|checkPwd',
        'confirmPwd' => 'require|confirm:password',
        'code' => 'require|checkSMSCode'
    ];

    protected $message = [
        'name' => '用户名格式不正确',
        'mobile' => '手机号码格式不正确',
        'password' => '密码为6~16位数的数字或者字母',
        'confirmPwd' => '两次输入密码不一样',
        'code' => '验证码格式不正确'
    ];
}