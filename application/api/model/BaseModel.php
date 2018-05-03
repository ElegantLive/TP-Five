<?php
/**
 * Created by PhpStorm.
 * User: 二狗蛋
 * Date: 2018/4/28
 * Time: 17:00
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    protected $auto = ['password','status','sex'];
    protected $hidden = ['delete_time', 'password'];
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
     * 状态获取器
     * @param $value
     * @return mixed
     */
    protected function getStatusAttr($value)
    {
        $status = [
            'NORMAL' => '正常',
            'SUCCESS' => '成功',
            'PROCESS' => '处理中',
            'CANCEL' => '取消',
            'WAIT_VERIFY' => '待审核'
        ];

        return $status[$value];
    }

    /**
     * 状态自动完成
     * @param $value
     * @return mixed
     */
    protected function setStatusAttr($value)
    {
        $status = [
            '正常' => 'NORMAL',
            '成功' => 'SUCCESS',
            '处理中' => 'PROCESS',
            '取消' => 'CANCEL',
            '待审核' => 'WAIT_VERIFY'
        ];

        return $status[$value];
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

    /**
     * 查询列表分页核心代码(不包含模型关联)
     * @param array $map
     * @param string $field
     * @param string $order
     * @param int $page
     * @param int $limit
     * @param bool $simple
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function getList(array $map, string $field = '*', string $order = 'create_time desc', int $page = 1, int $limit = 10, bool $simple = false)
    {
        return self::where($map)->field($field)->order($order)->paginate($limit, $simple, ['page' => $page]);
    }

}