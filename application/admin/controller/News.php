<?php

namespace app\admin\controller;

use app\common\model\News as MNews;
use app\common\model\NewsCategory as MNewsCategory;
use think\Request;
use think\facade\Session;

class News extends Basic
{

	public function index(Request $request, MNews $m_news)
	{
		try {
			$param = $request->post();
			$page = $param['page'];
			$limit = $param['limit'];

			$total = count($m_news->field('1')->select());
			$data = $m_news
				->order('id', 'desc')
				->page($page)
				->limit($limit)
				->select();

			return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
		}catch (\Exception $e) {
			return json(['code' => -100, 'message' => $e->getMessage()]);
		}
	}

	public function update(Request $request, MNews $m_news)
	{
		if ($request->isPost()) {
			try {
				$news_id = $request->post('news_id');
				$param = $request->post('news_info');

				$m_news->allowField(true)->save($param, ['id' => $news_id]);

				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}
	public function create(Request $request, MNews $m_news)
	{
		if ($request->isPost()) {
			try {
				$param = $request->post();
				$m_news->allowField(true)->save($param);
				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return json(['code' => -100, 'message' => $e->getMessage()]);
			}
		}
	}

	public function remove(Request $request, MNews $m_news)
	{
		if ($request->isPost()) {
			try {

				$ids = $request->post('ids');
				if (is_array($ids) && count($ids) > 0) {
					$m_news->destroy($request->post('ids'));
					return ['code' => 0, 'message' => '操作成功'];
				}
				return ['code' => -1, 'message' => '参数错误'];
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

	public function info(Request $request, MNews $m_news)
	{
		try {
			$news_id = $request->get('news_id');
			$data = $m_news
				->where(['id' => $news_id])
				->find();

			return ['code' => 0, 'message' => 'ok', 'data' => $data];

		} catch (\Exception $e) {
			return ['code' => -100, 'message' => $e->getMessage()];
		}
	}

	public function cate_info(Request $request, MNewsCategory $m_nc)
	{
		try {
			$cate_id = $request->get('cate_id');
			$data = $m_nc
				->where(['id' => $cate_id])
				->find();

			return ['code' => 0, 'message' => 'ok', 'data' => $data];

		} catch (\Exception $e) {
			return ['code' => -100, 'message' => $e->getMessage()];
		}
	}

	public function cate_create(Request $request, MNewsCategory $m_nc)
	{
		if ($request->isPost()) {
			try {
				$param = $request->post();
				$m_nc->allowField(true)->save($param);
				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return json(['code' => -100, 'message' => $e->getMessage()]);
			}
		}
	}

	public function cates(Request $request, MNewsCategory $m_nc)
	{
		$data = $m_nc->all();
		return json(['code'=> 0, 'data'=> $data, 'message'=> 'ok']);
	}

	public function cate_update(Request $request, MNewsCategory $m_nc)
	{
		if ($request->isPost()) {
			try {
				$cate_id = $request->post('cate_id');
				$param = $request->post('cate_info');

				$m_nc->allowField(true)->save($param, ['id' => $cate_id]);

				return json(['code' => 0, 'message' => '操作成功']);
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

	public function cate_list(Request $request, MNewsCategory $m_nc)
	{
		try {
			$param = $request->post();
			$page = $param['page'];
			$limit = $param['limit'];



			$total = count($m_nc->field('1')->select());
			$data = $m_nc
				->order('id', 'desc')
				->page($page)
				->limit($limit)
				->select();

			return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
		}catch (\Exception $e) {
			return json(['code' => -100, 'message' => $e->getMessage()]);
		}
	}

	public function cate_remove(Request $request, MNewsCategory $m_nc)
	{
		if ($request->isPost()) {
			try {

				$ids = $request->post('ids');
				if (is_array($ids) && count($ids) > 0) {
					$m_nc->destroy($request->post('ids'));
					return ['code' => 0, 'message' => '操作成功'];
				}
				return ['code' => -1, 'message' => '参数错误'];
			} catch (\Exception $e) {
				return ['code' => -100, 'message' => $e->getMessage()];
			}
		}
	}

}