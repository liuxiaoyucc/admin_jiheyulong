<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;


class Message extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $pk = 'id';
    protected $autoWriteTimestamp = true; // 自动写入create_time和update_time

    // 模型初始化
    protected static function init()
    {


    }

}