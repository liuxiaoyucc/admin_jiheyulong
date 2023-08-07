<?php

namespace app\admin\controller;

use app\common\model\Banner as MBanner;
use app\common\model\Navigation;
use think\Request;

class Banner extends Basic
{

    public function get_positions(Request $request, Navigation $m_navigation)
    {
        $data = $m_navigation->all();
        return json(['code'=> 0, 'data'=> $data, 'message'=> 'ok']);
    }

    public function banners(Request $request, MBanner $m_banner)
    {
        $d_banners = $m_banner->with(['position'])->select();

        return json(['code'=> 0, 'data'=> $d_banners, 'message'=> '查询成功']);
    }

    public function create(Request $request, MBanner $m_banner)
    {
        if ($request->isPost()) {
            try {
                $code = 0;
                $message = '操作成功';

                $param = $request->post();
                $m_banner->allowField(true)->save($param);
                return json(['code' => $code, 'message'=> $message]);
            }catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function remove(Request $request, MBanner $m_banner)
    {
        if ($request->isPost()) {
            try {
                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_banner->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];

            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }


    public function info(Request $request, MBanner $m_banner)
    {
        try {
            $banner_id = $request->get('banner_id');
            $data = $m_banner
                ->where(['id' => $banner_id])
                ->find();
            return ['code' => 0, 'message' => 'ok', 'data'=> $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

    public function update(Request $request, MBanner $m_banner)
    {
        if ($request->isPost()) {
            try {
                $code = 0;
                $message = '操作成功';
                $banner_id = $request->post('banner_id');
                $param = $request->post('banner_info');

                $m_banner->allowField(true)->save($param, ['id'=> $banner_id]);
                return json(['code' => $code, 'message'=> $message                                                                                                       ]);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }
}