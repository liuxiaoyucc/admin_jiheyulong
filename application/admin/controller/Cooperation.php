<?php

namespace app\admin\controller;

use app\common\model\CooperationCase;
use app\common\model\CooperationCaseCategory;
use think\Request;
use think\facade\Session;

class Cooperation extends Basic
{

    public function index(Request $request, CooperationCase $m_cc)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];



            $total = count($m_cc->field('1')->select());
            $data = $m_cc
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }

    public function cate_remove(Request $request, CooperationCaseCategory $m_ccc)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_ccc->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function cate_list(Request $request, CooperationCaseCategory $m_ccc)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];



            $total = count($m_ccc->field('1')->select());
            $data = $m_ccc
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }

    public function cates(Request $request, CooperationCaseCategory $m_ccc)
    {
        $data = $m_ccc->all();
        return json(['code'=> 0, 'data'=> $data, 'message'=> 'ok']);
    }

    public function cate_update(Request $request, CooperationCaseCategory $m_ccc)
    {
        if ($request->isPost()) {
            try {
                $cate_id = $request->post('cate_id');
                $param = $request->post('cate_info');

                $m_ccc->allowField(true)->save($param, ['id' => $cate_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function update(Request $request, CooperationCase $m_cc)
    {
        if ($request->isPost()) {
            try {
                $cooperation_id = $request->post('cooperation_id');
                $param = $request->post('cooperation_info');

                $m_cc->allowField(true)->save($param, ['id' => $cooperation_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

	public function cate_info(Request $request, CooperationCaseCategory $m_ccc)
	{
		try {
			$cate_id = $request->get('cate_id');
			$data = $m_ccc
				->where(['id' => $cate_id])
				->find();

			return ['code' => 0, 'message' => 'ok', 'data' => $data];

		} catch (\Exception $e) {
			return ['code' => -100, 'message' => $e->getMessage()];
		}
	}


	public function cate_create(Request $request, CooperationCaseCategory $m_ccc)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_ccc->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function create(Request $request, CooperationCase $m_cc)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_cc->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request, CooperationCase $m_cc)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_cc->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, CooperationCase $m_cc)
    {
        try {
            $cooperation_id = $request->get('cooperation_id');
            $data = $m_cc
                ->where(['id' => $cooperation_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

}