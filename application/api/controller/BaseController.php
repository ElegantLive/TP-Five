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

    /**
     * 重写thinkphp的前置操作
     * @param string $method
     * @param array $options
     */
    protected function beforeAction($method, $options = [])
    {
        if (isset($options['only'])) {
            if (is_string($options['only'])) {
                $options['only'] = explode(',', $options['only']);
            }

            $new_arr = [];

            foreach ($options['only'] as $action) {
                $new_arr[] = uncamelize($action, '');
            }

            $options['only'] = $new_arr;

            if (!in_array(strtolower($this->request->action()), $options['only'])) {
                return;
            }
        } elseif (isset($options['except'])) {
            if (is_string($options['except'])) {
                $options['except'] = explode(',', $options['except']);
            }

            $new_arr = [];

            foreach ($options['except'] as $action) {
                $new_arr[] = uncamelize($action, '');
            }

            $options['except'] = $new_arr;
            if (in_array(strtolower($this->request->action()), $options['except'])) {
                return;
            }
        }
        call_user_func([$this, $method]);
    }

}