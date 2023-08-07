<?php


namespace app\admin\model;



use think\facade\Log;
use think\Model;
use think\model\concern\SoftDelete;


class Manager extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $pk = 'id';
    protected $autoWriteTimestamp = true; // 自动写入create_time和update_time

    // 模型初始化
    protected static function init()
    {
        self::event('before_insert', function ($data) {
            $data->create_time = time();
        });
    }
}