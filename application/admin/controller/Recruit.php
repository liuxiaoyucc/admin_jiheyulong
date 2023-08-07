<?php

namespace app\admin\controller;

use app\common\model\Recruit as MRecruit;
use think\Request;
use think\facade\Session;

class Recruit extends Basic
{

    public function index(Request $request, MRecruit $m_recruit)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];



            $total = count($m_recruit->field('1')->select());
            $data = $m_recruit
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }


    public function update(Request $request, MRecruit $m_recruit)
    {
        if ($request->isPost()) {
            try {
                $recruit_id = $request->post('recruit_id');
                $param = $request->post('recruit_info');

                $m_recruit->allowField(true)->save($param, ['id' => $recruit_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }
    public function create(Request $request, MRecruit $m_recruit)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_recruit->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request, MRecruit $m_recruit)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_recruit->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, MRecruit $m_recruit)
    {
        try {
            $recruit_id = $request->get('recruit_id');
            $data = $m_recruit
                ->where(['id' => $recruit_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

}