<?php

namespace app\admin\controller;

use app\common\model\Service as MService;
use think\Request;
use think\facade\Session;

class Service extends Basic
{

    public function index(Request $request, MService $m_service)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];



            $total = count($m_service->field('1')->select());
            $data = $m_service
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }


    public function update(Request $request, MService $m_service)
    {
        if ($request->isPost()) {
            try {
                $service_id = $request->post('service_id');
                $param = $request->post('service_info');

                $m_service->allowField(true)->save($param, ['id' => $service_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }


    public function create(Request $request, MService $m_service)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_service->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request,  MService $m_service)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_service->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, MService $m_service)
    {
        try {
            $service_id = $request->get('service_id');
            $data = $m_service
                ->where(['id' => $service_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

}