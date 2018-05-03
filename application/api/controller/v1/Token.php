<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/29
 * Time: 15:53
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\UserToken;
use app\api\validate\LoginValidate;
use app\lib\exception\SuccessMessage;

class Token extends BaseController
{

    /**
     * 用户登陆
     * @param $mobile
     * @param $password
     * @throws SuccessMessage
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenException
     */
    public function getUserToken($mobile, $password)
    {
        (new LoginValidate())->goCheck();

        $token = UserToken::get($mobile, $password);

        throw new SuccessMessage([
            'data' => ['token' => $token]
        ]);
    }

}