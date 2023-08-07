<?php

namespace app\admin\controller;

use app\common\model\Major;
use app\common\model\Specialist as MSpecialist;
use think\Request;

class Specialist extends Basic
{


    public function index(Request $request, MSpecialist $m_spec)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];

            $total = count($m_spec->field('1')->select());
            $data = $m_spec
                ->where([])
                ->append(['majors'])
                ->page($page)
                ->limit($limit)
                ->order('id', 'desc')
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, MSpecialist $m_spec)
    {
        if ($request->isPost()) {
            try {
                $specialist_id = $request->post('specialist_id');
                $param = $request->post('specialist_info');

                $m_spec->allowField(true)->save($param, ['id' => $specialist_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }
    public function create(Request $request, MSpecialist $m_spec)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_spec->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request, MSpecialist $m_spec)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_spec->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function info(Request $request, MSpecialist $m_spec)
    {
        try {
            $specialist_id = $request->get('specialist_id');
            $data = $m_spec
                ->where(['id' => $specialist_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

    public function major_info(Request $request, Major $m_major)
    {
        try {
            $major_id = $request->get('major_id');
            $data = $m_major
                ->where(['id' => $major_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

    public function major_create(Request $request, Major $m_major)
    {
        if ($request->isPost()) {
            try {
                $param = $request->post();
                $m_major->allowField(true)->save($param);
                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function majors(Request $request, Major $m_major)
    {
        $data = $m_major->all();
        return json(['code'=> 0, 'data'=> $data, 'message'=> 'ok']);
    }

    public function major_update(Request $request, Major $m_major)
    {
        if ($request->isPost()) {
            try {
                $major_id = $request->post('major_id');
                $param = $request->post('major_info');

                $m_major->allowField(true)->save($param, ['id' => $major_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function major_list(Request $request, Major $m_major)
    {
        try {
            $param = $request->post();
            $page = $param['page'];
            $limit = $param['limit'];



            $total = count($m_major->field('1')->select());
            $data = $m_major
                ->order('id', 'desc')
                ->page($page)
                ->limit($limit)
                ->select();

            return json(['code'=> 0, 'count'=> $total, 'data'=> $data, 'message'=> 'ok']);
        }catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }

    public function major_remove(Request $request, Major $m_major)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_major->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }
}