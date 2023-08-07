<?php


namespace app\admin\controller;


use app\common\model\Config;
use think\Request;

class Setting extends Basic
{

    public function cheat()
    {
        $m_config = new Config();
		$is_cheat = $m_config->where([
            'key' => 'is_cheat'
        ])->find();

        return json(['code'=> 0, 'data'=> $is_cheat['value'], 'message'=> '查询成功']);
    }

    public function update_cheat(Request $request, Config $m_config)
    {
        $data = $request->post();

		$is_cheat = $data['is_cheat'];

        $m_config->where([
            'key'=> 'is_cheat'
        ])->update([
            'value'=> $is_cheat
        ]);
        return json(['code'=> 0, 'message'=> '更新成功']);
    }


}