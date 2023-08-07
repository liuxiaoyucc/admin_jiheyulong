<?php


namespace app\admin\controller;


use think\Controller;
use think\facade\Cookie;
use think\facade\Request;
use app\admin\model\Manager;
use think\facade\Session;
use think\captcha\Captcha;

class Login extends Controller
{
    /**
     * 登录页加载和登录处理
     * @param Request $request
     * @param Manager $manager
     * @param Session $session
     * @return array|mixed|\think\response\Json
     */
    public function index(Request $request, Manager $manager, Session $session)
    {
        if ($request::isPost()) {
            try {
                $param = $request::post();
                $res = $this->validate($param, 'app\admin\validate\Login.login');
                if ($res === true ) { // 验证成功, 核查用户名密码
                    $data = $manager
                        ->where(['username'=> $param['username'], 'password'=> md5($param['password'])])
                        ->field('id, username')
                        ->find();
                    if ($data) {
                         // 保存登录态
                        $session::set('manager', $data);
                        return ['code' => 0, 'message'=> '登录成功', 'data'=> $data];
                    }
                    return ['code' => -1, 'message'=> '用户名或密码不正确'];
                }
                return json(['code' => -1, 'message'=> $res]);
            } catch (\Exception $e) {
                return json(['code' => -100, 'message' => $e->getMessage()]);
            }

        }
        $session::delete('manager');
        return $this->fetch('../public/master/page/login.html');
    }

    public function out(Session $session)
    {
        $session::delete('manager');
//        $this->success('操作成功', 'admin/login/index');
        return $this->fetch('../public/master/page/login.html');
    }

    /**
     * 加载图形验证码
     * @return \think\Response
     */
    public function verify()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }

    public function test()
    {
        return 1;
    }
}