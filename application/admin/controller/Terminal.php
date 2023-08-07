<?php

namespace app\admin\controller;

use app\common\model\Terminal as MTerminal;
use think\Request;
use think\facade\Session;

class Terminal extends Basic
{

    public function index(Request $request, MTerminal $m_terminal)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];

            $condition = [];
            if (!empty($param['title'])) $condition[] = ['title', 'like', '%' . $param['title'] . '%'];

            $total = count($m_terminal->where($condition)->field('1')->select());
            $data = $m_terminal
                ->where($condition)
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }


    public function update(Request $request, MTerminal $m_terminal)
    {
        if ($request->isPost()) {
            try {
                $terminal_id = $request->post('terminal_id');
                $param = $request->post('terminal_info');

                $m_terminal->allowField(true)->save($param, ['id' => $terminal_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }
    public function create(Request $request, MTerminal $m_terminal)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_terminal->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request, MTerminal $m_terminal)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_terminal->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, MTerminal $m_terminal)
    {
        try {
            $terminal_id = $request->get('terminal_id');
            $data = $m_terminal
                ->where(['id' => $terminal_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

}