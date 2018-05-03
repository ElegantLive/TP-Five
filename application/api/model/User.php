<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/28
 * Time: 16:59
 */

namespace app\api\model;


use app\lib\exception\CreateException;
use think\Db;
use think\Exception;

class User extends BaseModel
{
    public static function register()
    {
        Db::startTrans();

        $input = input('post.');
        try{
            $name = self::checkExist(['name' => input('post.name')]);

            if($name){
                throw new Exception('用户名已存在！换一个吧');
            }

            $mobile = self::checkExist(['name' => input('post.mobile')]);

            if($mobile){
                throw new Exception('该手机号码已被绑定！换一个吧');
            }

            $user = self::create($input);

            if(!$user){
                throw new Exception('用户注册失败！');
            }else{
                Db::commit();
                return $user->name;
            }

        }catch (Exception $e){
            Db::rollback();

            throw new CreateException([
                'message' => $e->getMessage()
            ]);
        }
    }


    public static function checkExist($map)
    {
        $res = self::get($map);

        if(!$res) return false;

        return $res;
    }
}