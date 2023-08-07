<?php
namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username'  =>  'require|max:16',
        'password'  =>  'require|max:32',
        'captcha'   =>  'require|captcha'
    ];

    protected $message  =   [
        'username.require' => '用户名不能为空',
        'username.max'     => '用户名不能超过16个字符',
        'password.require'   => '密码不能为空',
        'password.max'  => '密码错误',
        'captcha.require'   => '图形验证码不能为空',
        'captcha.captcha'   => '图形验证码不正确'
    ];

    protected $scene = [
        'login'  =>  ['username','password'],
    ];

}