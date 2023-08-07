<?php

namespace app\admin\validate;

use think\Validate;

class Permission extends Validate
{
    protected $rule = [
        'name'             =>  'require',
        'manager_id'        =>  'require',
        'username'          =>  'require|max:16',
        'password'          =>  'require|max:32',
    ];

    protected $message  =   [
        'name.require'         =>  '权限组标题不能为空',
        'manager_id.require'    =>  'manager_id不能为空',
        'username.require'      =>  '用户名不能为空',
        'username.max'          =>  '用户名不能超过16个字符',
        'password.require'      =>  '密码不能为空',
        'password.max'          =>  '密码错误',
    ];

    protected $scene = [
        'add'             =>  ['name'],
        'edit'            =>  ['name'],
        'manager_create'  =>  ['username', 'password'],
        'manager_update'  =>  ['username']
    ];
}