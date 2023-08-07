<?php

namespace app\admin\controller;

use app\common\model\Filiale as MFiliale;
use think\Request;
use think\facade\Session;

class Filiale extends Basic
{

    public function index(Request $request, MFiliale $m_filiale)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];



            $total = count($m_filiale->field('1')->select());
            $data = $m_filiale
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }


    public function update(Request $request, MFiliale $m_filiale)
    {
        if ($request->isPost()) {
            try {
                $filiale_id = $request->post('filiale_id');
                $param = $request->post('filiale_info');

                $m_filiale->allowField(true)->save($param, ['id' => $filiale_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }


    public function create(Request $request, MFiliale $m_filiale)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_filiale->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request,  MFiliale $m_filiale)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_filiale->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, MFiliale $m_filiale)
    {
        try {
            $filiale_id = $request->get('filiale_id');
            $data = $m_filiale
                ->where(['id' => $filiale_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

}