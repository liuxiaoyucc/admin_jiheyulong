<?php

namespace app\admin\controller;

use app\common\model\Message as MMessage;
use think\Request;

class Message extends Basic
{


	public function index(Request $request, MMessage $m_message)
	{
		try {
			$param = $request->post();
			$page = $param['page'];
			$limit = $param['limit'];

			$total = count($m_message->field('1')->select());
			$data = $m_message
				->order('id', 'desc')
				->page($page)
				->limit($limit)
				->select();

			return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
		}catch (\Exception $e) {
			return json(['code' => -100, 'message' => $e->getMessage()]);
		}
	}

}