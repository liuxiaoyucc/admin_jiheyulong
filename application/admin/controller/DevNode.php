<?php

namespace app\admin\controller;

use app\common\model\DevNode as MDevNode;
use think\Request;
use think\facade\Session;

class DevNode extends Basic
{

    public function index(Request $request, MDevNode $m_node)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];



            $total = count($m_node->field('1')->select());
            $data = $m_node
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }


    public function update(Request $request, MDevNode $m_node)
    {
        if ($request->isPost()) {
            try {
                $dev_node_id = $request->post('dev_node_id');
                $param = $request->post('dev_node_info');

				$m_node->allowField(true)->save($param, ['id' => $dev_node_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }


    public function create(Request $request, MDevNode $m_node)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
				$m_node->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request,  MDevNode $m_node)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
					$m_node->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, MDevNode $m_node)
    {
        try {
            $dev_node_id = $request->get('dev_node_id');
            $data = $m_node
                ->where(['id' => $dev_node_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

}