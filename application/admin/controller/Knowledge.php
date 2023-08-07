<?php

namespace app\admin\controller;

use app\common\model\Knowledge as MKnowledge;
use app\common\model\KnowledgeCategory as MKnowledgeCategory;
use think\Request;
use think\facade\Session;

class Knowledge extends Basic
{

	public function index(Request $request, MKnowledge $m_knowledge)
	{
		try {
			$param = $request->post();
			$page = $param['page'];
			$limit = $param['limit'];

			$total = count($m_knowledge->field('1')->select());
			$data = $m_knowledge
				->order('id', 'desc')
				->page($page)
				->limit($limit)
				->select();

			return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
		}catch (\Exception $e) {
			return json(['code' => -100, 'message' => $e->getMessage()]);
		}
	}

	public function update(Request $request, MKnowledge $m_knowledge)
	{
		if ($request->isPost()) {
			try {
				$news_id = $request->post('knowledge_id');
				$param = $request->post('knowledge_info');

				$m_knowledge->allowField(true)->save($param, ['id' => $news_id]);

				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}
	public function create(Request $request, MKnowledge $m_knowledge)
	{
		if ($request->isPost()) {
			try {
				$param = $request->post();
				$m_knowledge->allowField(true)->save($param);
				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return json(['code' => -100, 'message' => $e->getMessage()]);
			}
		}
	}

	public function remove(Request $request, MKnowledge $m_knowledge)
	{
		if ($request->isPost()) {
			try {

				$ids = $request->post('ids');
				if (is_array($ids) && count($ids) > 0) {
					$m_knowledge->destroy($request->post('ids'));
					return ['code' => 0, 'message' => '操作成功'];
				}
				return ['code' => -1, 'message' => '参数错误'];
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

	public function info(Request $request, MKnowledge $m_knowledge)
	{
		try {
			$knowledge_id = $request->get('knowledge_id');
			$data = $m_knowledge
				->where(['id' => $knowledge_id])
				->find();

			return ['code' => 0, 'message' => 'ok', 'data' => $data];

		} catch (\Exception $e) {
			return ['code' => -100, 'message' => $e->getMessage()];
		}
	}

	public function cate_info(Request $request, MKnowledgeCategory $m_kc)
	{
		try {
			$cate_id = $request->get('cate_id');
			$data = $m_kc
				->where(['id' => $cate_id])
				->find();

			return ['code' => 0, 'message' => 'ok', 'data' => $data];

		} catch (\Exception $e) {
			return ['code' => -100, 'message' => $e->getMessage()];
		}
	}

	public function cate_create(Request $request, MKnowledgeCategory $m_kc)
	{
		if ($request->isPost()) {
			try {
				$param = $request->post();
				$m_kc->allowField(true)->save($param);
				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return json(['code' => -100, 'message' => $e->getMessage()]);
			}
		}
	}

	public function cates(Request $request, MKnowledgeCategory $m_kc)
	{
		$data = $m_kc->all();
		return json(['code'=> 0, 'data'=> $data, 'message'=> 'ok']);
	}

	public function cate_update(Request $request, MKnowledgeCategory $m_kc)
	{
		if ($request->isPost()) {
			try {
				$cate_id = $request->post('cate_id');
				$param = $request->post('cate_info');

				$m_kc->allowField(true)->save($param, ['id' => $cate_id]);

				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

	public function cate_list(Request $request, MKnowledgeCategory $m_kc)
	{
		try {
			$param = $request->post();
			$page = $param['page'];
			$limit = $param['limit'];



			$total = count($m_kc->field('1')->select());
			$data = $m_kc
				->order('id', 'desc')
				->page($page)
				->limit($limit)
				->select();

			return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
		}catch (\Exception $e) {
			return json(['code' => -100, 'message' => $e->getMessage()]);
		}
	}

	public function cate_remove(Request $request, MKnowledgeCategory $m_kc)
	{
		if ($request->isPost()) {
			try {

				$ids = $request->post('ids');
				if (is_array($ids) && count($ids) > 0) {
					$m_kc->destroy($request->post('ids'));
					return ['code' => 0, 'message' => '操作成功'];
				}
				return ['code' => -1, 'message' => '参数错误'];
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

}