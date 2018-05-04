<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/23
 * Time: 13:02
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Request;

class Token
{

    /**
     * 获取校验身份
     * @param $key
     * @return mixed
     * @throws TokenException
     */
    protected static function getIdentityKey(string $key)
    {
        $Identity_arr = [
            'user' => ScopeEnum::User,
            'other' => ScopeEnum::Other,
            'admin' => ScopeEnum::Admin
        ];
        if (array_key_exists($key, $Identity_arr)) return $Identity_arr[$key];

        throw new TokenException([
            'message' => '校验的身份不存在',
            'errorCode' => 10002
        ]);
    }

    /**
     * 生成token身份令牌
     * @return string
     */
    protected static function createRandKey()
    {
        $randChar = getRandChar(32);
        $timestamp = time();

        return md5($randChar . $timestamp);
    }

    /**
     * 服务器cache缓存token
     * @param $value
     * @return string
     * @throws TokenException
     */
    protected static function saveCache(array $value)
    {
        $key = self::createRandKey();
        $expire_in = config('setting.token_expire_in');
        $res = Cache::store('redis')->set($key, $value, $expire_in);
        if (!$res) {
            throw new TokenException([
                'message' => '服务器缓存异常',
                'errorCode' => '10003'
            ]);
        }

        return $key;
    }

    /**
     * 获取token身份信息
     * @param $key
     * @return mixed
     * @throws TokenException
     */
    public static function getCurrentTokenVar(string $key)
    {
        $token = Request::instance()->header('token');

        $info = Cache::store('redis')->get($token);

        if (!$info || !is_array($info) || !array_key_exists($key, $info)) {
            throw new TokenException([
                'message' => 'Token无效或已过期'
            ]);
        }

        return $info[$key];
    }

    /**
     * 验证专有权限
     * @param $auth
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function authentication(string $auth)
    {
        $Identity = self::getIdentityKey($auth);

        $scope = self::getCurrentTokenVar('scope');

        if (!$scope) {
            throw new TokenException([
                'message' => '身份认证失败，请登陆'
            ]);
        }

        if ($scope != $Identity) {
            throw new ForbiddenException([
                'message' => '你无权访问'
            ]);
        }
    }

    /**
     * 获取校验身份列表
     * @param array $list
     * @return array
     * @throws TokenException
     */
    protected static function getIdentityList(array $list)
    {
        if (is_array($list)) {
            throw new TokenException([
                'message' => '身份令牌验证信息缺失'
            ]);
        }

        $Identity_arr = [
            'user' => ScopeEnum::User,
            'other' => ScopeEnum::Other,
            'admin' => ScopeEnum::Admin
        ];

        foreach ($list as $value) {
            if (!array_key_exists($value, $Identity_arr)) unset($Identity_arr[$value]);
        }

        if (empty($Identity_arr)) {
            throw new TokenException([
                'message' => '校验身份不存在'
            ]);
        }

        return $Identity_arr;
    }

    /**
     * 验证共有的允许(禁止)权限
     * @param array $auth
     * @param bool $allow
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function authenticationAllow(array $auth, bool $allow = true)
    {
        $Identity = self::getIdentityList($auth);

        $scope = self::getCurrentTokenVar('scope');

        if (!$scope) {
            throw new TokenException([
                'message' => '身份认证失败，请登陆'
            ]);
        }

        if ($allow) {
            if (!in_array($scope, $Identity)) {
                throw new ForbiddenException([
                    'message' => '你无权访问'
                ]);
            }
        } else {
            if (in_array($scope, $Identity)) {
                throw new ForbiddenException([
                    'message' => '你无权访问'
                ]);
            }
        }
    }

}