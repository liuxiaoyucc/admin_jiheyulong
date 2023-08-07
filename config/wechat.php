<?php
/**
 * 微信移动应用配置信息
 */
return [
    'auth' => [
        'appid' => '', //
        'appsecret'=> '',
        'auth_callback_url'=> '',
    ],
    'app_pay'=> [
        'appid' => '',
        'appsecret'=> '',
        'mch_id'=> '',
        'key'=> '', // iuv md5
        'notify_url'=> request()->domain() . '/api/v1/callback/wechat_pay',
    ]
];
