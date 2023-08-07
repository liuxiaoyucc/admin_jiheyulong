<?php

namespace app\admin\controller;

use app\common\model\Menu;
use think\facade\Request;
use think\facade\Session;

class Index extends Basic
{

    /**
     * 获取配置项
     * @return array
     */
    private function build_config()
    {
        $homeInfo = [
            'title' => '首页',
            'href' => 'page/manager/index.html',
        ];
        $logoInfo = [
            'title' => '大禹建设',
            'image' => 'images/logo.png',
            'href'  => '',
        ];

        $menuInfo = $this->build_menu();

        return [
            'homeInfo' => $homeInfo,
            'logoInfo' => $logoInfo,
            'menuInfo' => $menuInfo,
        ];
    }

    /**
     * 根据权限生成相应的菜单项
     * @return mixed
     */
    private function build_menu()
    {
        $m_menu = new Menu();


        $rules = $m_menu->where(['is_sidebar'=> 1])->all()->toArray();


        return listToTree($rules, 'id', 'parent_id', 'child', 0);

    }


    /**
     * 页面初始化
     * @param Request $request
     * @param Session $session
     * @return \think\response\Json
     */
    public function init(Request $request, Session $session)
    {

        if ($request::isPost()) {
            try {

                $manager = $session::get('manager');

                $config = $this->build_config();
                return json(['code'=> 0, 'message'=> 'ok', 'data'=> $config]);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }
        }
    }

    public function check_auth()
    {
        if (!session('manager')) {
            return json(['code'=> 401, 'message'=> '请先登录']);
        }
        return json(['code'=> 0]);
    }

    public function index()
    {
        return $this->fetch('../public/master/index.html');
    }

    public function test()
    {

    }


}