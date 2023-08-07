<?php

namespace app\admin\controller;

use app\common\model\Lawyer as MLawyer;
use app\common\model\LawyerCategory as MLawyerCategory;
use think\Request;
use think\facade\Session;

class Lawyer extends Basic
{

	public function index(Request $request, MLawyer $m_lawyer)
	{
		try {
			$param = $request->post();
			$page = $param['page'];
			$limit = $param['limit'];

			$total = count($m_lawyer->field('1')->select());
			$data = $m_lawyer
				->order('id', 'desc')
				->page($page)
				->limit($limit)
				->select();

			return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
		}catch (\Exception $e) {
			return json(['code' => -100, 'message' => $e->getMessage()]);
		}
	}

	public function update(Request $request, MLawyer $m_lawyer)
	{
		if ($request->isPost()) {
			try {
				$lawyer_id = $request->post('lawyer_id');
				$param = $request->post('lawyer_info');

				$m_lawyer->allowField(true)->save($param, ['id' => $lawyer_id]);

				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}
	public function create(Request $request, MLawyer $m_lawyer)
	{
		if ($request->isPost()) {
			try {
				$param = $request->post();
				$m_lawyer->allowField(true)->save($param);
				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return json(['code' => -100, 'message' => $e->getMessage()]);
			}
		}
	}

	public function remove(Request $request, MLawyer $m_lawyer)
	{
		if ($request->isPost()) {
			try {

				$ids = $request->post('ids');
				if (is_array($ids) && count($ids) > 0) {
					$m_lawyer->destroy($request->post('ids'));
					return ['code' => 0, 'message' => '操作成功'];
				}
				return ['code' => -1, 'message' => '参数错误'];
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

	public function info(Request $request, MLawyer $m_lawyer)
	{
		try {
			$lawyer_id = $request->get('lawyer_id');
			$data = $m_lawyer
				->where(['id' => $lawyer_id])
				->find();

			return ['code' => 0, 'message' => 'ok', 'data' => $data];

		} catch (\Exception $e) {
			return ['code' => -100, 'message' => $e->getMessage()];
		}
	}

	public function cate_info(Request $request, MLawyerCategory $m_lc)
	{
		try {
			$cate_id = $request->get('cate_id');
			$data = $m_lc
				->where(['id' => $cate_id])
				->find();

			return ['code' => 0, 'message' => 'ok', 'data' => $data];

		} catch (\Exception $e) {
			return ['code' => -100, 'message' => $e->getMessage()];
		}
	}

	public function cate_create(Request $request, MLawyerCategory $m_lc)
	{
		if ($request->isPost()) {
			try {
				$param = $request->post();
				$m_lc->allowField(true)->save($param);
				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return json(['code' => -100, 'message' => $e->getMessage()]);
			}
		}
	}

	public function cates(Request $request, MLawyerCategory $m_lc)
	{
		$data = $m_lc->all();
		return json(['code'=> 0, 'data'=> $data, 'message'=> 'ok']);
	}

	public function cate_update(Request $request, MLawyerCategory $m_lc)
	{
		if ($request->isPost()) {
			try {
				$cate_id = $request->post('cate_id');
				$param = $request->post('cate_info');

				$m_lc->allowField(true)->save($param, ['id' => $cate_id]);

				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

	public function cate_list(Request $request, MLawyerCategory $m_lc)
	{
		try {
			$param = $request->post();
			$page = $param['page'];
			$limit = $param['limit'];



			$total = count($m_lc->field('1')->select());
			$data = $m_lc
				->order('id', 'desc')
				->page($page)
				->limit($limit)
				->select();

			return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
		}catch (\Exception $e) {
			return json(['code' => -100, 'message' => $e->getMessage()]);
		}
	}

	public function cate_remove(Request $request, MLawyerCategory $m_lc)
	{
		if ($request->isPost()) {
			try {

				$ids = $request->post('ids');
				if (is_array($ids) && count($ids) > 0) {
					$m_lc->destroy($request->post('ids'));
					return ['code' => 0, 'message' => '操作成功'];
				}
				return ['code' => -1, 'message' => '参数错误'];
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

}