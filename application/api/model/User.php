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
    protected $readonly = ['name'];

    /**
     * 密码自动完成
     * @param $value
     * @return string
     */
    protected function setPasswordAttr($value)
    {
        return md5($value);
    }

    /**
     * 性别获取器
     * @param $value
     * @return mixed
     */
    protected function getSexAttr($value)
    {
        $sex = [
            'MAN' => '男',
            'WOMAN' => '女'
        ];

        return $sex[$value];
    }

    /**
     * 性别自动完成
     * @param $value
     * @return mixed
     */
    protected function setSexAttr($value)
    {
        $sex = [
            '男' => 'MAN',
            '女' => 'WOMAN'
        ];

        return $sex[$value];
    }

    public static function register()
    {
        Db::startTrans();

        try {
            $name = self::checkExist(['name' => input('post.name')]);

            if ($name) {
                throw new Exception('用户名已存在！换一个吧');
            }

            $mobile = self::checkExist(['mobile' => input('post.mobile')]);

            if ($mobile) {
                throw new Exception('该手机号码已被绑定！换一个吧');
            }

            $user = self::create(input('post.'), true);

            if (!$user) {
                throw new Exception('用户注册失败！');
            } else {
                Db::commit();
                return $user->data['name'];
            }

        } catch (Exception $e) {
            Db::rollback();

            throw new CreateException([
                'message' => $e->getMessage()
            ]);
        }
    }


    public static function checkExist($map)
    {
        $res = self::get($map);

        if (!$res) return false;

        return $res;
    }
}