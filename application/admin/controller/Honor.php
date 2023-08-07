<?php

namespace app\admin\controller;

use app\common\model\Honor as MHonor;
use app\common\model\CooperationCaseCategory;
use think\Request;
use think\facade\Session;

class Honor extends Basic
{

    public function index(Request $request, MHonor $m_honor)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];



            $total = count($m_honor->field('1')->select());
            $data = $m_honor
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }


    public function update(Request $request, MHonor $m_honor)
    {
        if ($request->isPost()) {
            try {
                $honor_id = $request->post('honor_id');
                $param = $request->post('honor_info');

                $m_honor->allowField(true)->save($param, ['id' => $honor_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }


    public function create(Request $request, MHonor $m_honor)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_honor->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request,  MHonor $m_honor)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_honor->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, MHonor $m_honor)
    {
        try {
            $honor_id = $request->get('honor_id');
            $data = $m_honor
                ->where(['id' => $honor_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

}