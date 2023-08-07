<?php

namespace app\admin\controller;

use app\common\model\Navigation;
use app\common\model\OrderFlow as MOrderFlow;
use think\Request;

class OrderFlow extends Basic
{



    public function list(Request $request, MOrderFlow $m_order_flow)
    {
        $data = $m_order_flow->order('step', 'asc')->select();

        return json(['code'=> 0, 'data'=> $data, 'message'=> '查询成功']);
    }

    public function create(Request $request, MOrderFlow $m_order_flow)
    {
        if ($request->isPost()) {
            try {
                $code = 0;
                $message = '操作成功';

                $param = $request->post();
                $m_order_flow->allowField(true)->save($param);
                return json(['code' => $code, 'message'=> $message]);
            }catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request, MOrderFlow $m_order_flow)
    {
        if ($request->isPost()) {
            try {
                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_order_flow->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];

            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, MOrderFlow $m_order_flow)
    {
        try {
            $order_flow_id = $request->get('order_flow_id');
            $data = $m_order_flow
                ->where(['id' => $order_flow_id])
                ->find();
            return ['code' => 0, 'message' => 'ok', 'data'=> $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

    public function update(Request $request, MOrderFlow $m_banner)
    {
        if ($request->isPost()) {
            try {
                $code = 0;
                $message = '操作成功';
                $order_flow_id = $request->post('order_flow_id');
                $param = $request->post('order_flow_info');

                $m_banner->allowField(true)->save($param, ['id'=> $order_flow_id]);
                return json(['code' => $code, 'message'=> $message]);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }
}