<?php


namespace app\common\model;


use think\Model;
use think\model\concern\SoftDelete;


class Specialist extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $pk = 'id';
    protected $autoWriteTimestamp = true; // 自动写入create_time和update_time

    // 模型初始化
    protected static function init()
    {
    	
    }



	public function getMajorsAttr($v, $data)
	{
		$m_major = new Major();

		$major_ids = $data['major_ids'];
		if ($major_ids) {
			$major_ids_arr = explode(',', $major_ids);

			$major_name = [];
			foreach ($major_ids_arr as $index => $item) {
				$d_major = $m_major->where([
					'id'=> $item
				])->find();

				$major_name[] = $d_major['name'];
			}

			return implode('/', $major_name);
		}

		return [];
    }


}