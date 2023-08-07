<?php

namespace app\admin\controller;

use think\Request;
use app\common\model\DemoVideo as MVideo;

class DemoVideo extends Basic
{

    public function save(Request $request, MVideo $m_video)
    {
        try {
            $param = $request->post();
            $title = $param['title'];
            $video = $param['video'] ?? '';
            if (!$title || !$video) {
                return json(['code' => -1, 'message' => '标题或视频不能为空']);
            }

            $m_video->allowField(true)->save($param);

            return json(['code' => 0, 'message' => '保存成功']);
        } catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }

    public function info(Request $request, MVideo $m_video)
    {
        try {
            $video_id = $request->get('video_id');
            $data = $m_video
                ->where(['id' => $video_id])
                ->find();

            return ['code' => 0, 'message' => 'ok', 'data' => $data];

        } catch (\Exception $e) {
            return ['code' => -100, 'message' => $e->getMessage()];
        }
    }

    public function update(Request $request, MVideo $m_video)
    {
        if ($request->isPost()) {
            try {
                $video_id = $request->post('video_id');
                $param = $request->post('video_info');

                $m_video->allowField(true)->save($param, ['id' => $video_id]);

                return json(['code' => 0, 'message' => '操作成功']);
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }

    public function videos(Request $request, MVideo $m_video)
    {
        try {
            $videos = $m_video->all();

            return json(['code' => 0, 'message' => 'ok', 'data'=> $videos]);
        } catch (\Exception $e) {
            return json(['code' => -100, 'message' => $e->getMessage()]);
        }
    }

    public function remove(Request $request, MVideo $m_video)
    {
        if ($request->isPost()) {
            try {

                $ids = $request->post('ids');
                if (is_array($ids) && count($ids) > 0) {
                    $m_video->destroy($request->post('ids'));
                    return ['code' => 0, 'message' => '操作成功'];
                }
                return ['code' => -1, 'message' => '参数错误'];
            } catch (\Exception $e) {
                return ['code' => -100, 'message' => $e->getMessage()];
            }
        }
    }



}