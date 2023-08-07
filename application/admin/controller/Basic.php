<?php
namespace app\admin\controller;


use think\Controller;
use think\facade\Log;
use think\facade\Request;

class Basic extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $manager = session('manager');
        if (!$manager) { // 登录检测
            return json(['code'=> 401, 'message'=> '请先登录'])->header('Content-type', 'application/json');
        }

    }

}