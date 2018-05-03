<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/29
 * Time: 15:53
 */

namespace app\api\controller;


use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{
    /**
     * 验证专有权限
     * @param $Identity
     * @throws \app\lib\exception\ForbiddenException
     * @throws \app\lib\exception\TokenException
     */
    public function checkIdentity($Identity)
    {
        Token::authentication($Identity);
    }
}