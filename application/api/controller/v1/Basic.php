<?php
namespace app\api\controller\v1;


use think\Controller;
use think\facade\Log;
use think\Request;

class Basic extends Controller
{
    protected $middleware = ['Check'];
    public function __construct(Request $request)
    {
        parent::__construct();
    }


}