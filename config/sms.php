<?php
/**
 * Created by PhpStorm.
 * User: Kassy
 * Date: 2020-08-14
 * Time: 9:19
 * Description: 短信配置
 */

return [
    'sms_conf'     => [
        'appId'  => '', // accessKeyId
        'appKey' => '', // accessSecret
        'sign'   => '' // signName
    ],
    'sms_template' => [
        [
            'title'   => '场景缺省',
            'temp_id' => '',
            'content' => '',
        ],
        [
            'title'   => '注册',
            'temp_id' => 'SMS_214635222',
            'content' => '验证码${code}，您正在注册成为新用户，感谢您的支持！',
        ],
        [
            'title'   => '忘记密码',
            'temp_id' => 'SMS_214635221',
            'content' => '验证码${code}，您正在尝试修改登录密码，请妥善保管账户信息。',
        ],
        [
            'title'   => '找回密码',
            'temp_id' => 'SMS_214635221',
            'content' => '验证码${code}，您正在尝试修改登录密码，请妥善保管账户信息。',
        ],
        [
            'title'   => '修改密码',
            'temp_id' => 'SMS_214635221',
            'content' => '验证码${code}，您正在尝试修改密码，请妥善保管账户信息。',
        ],
        [
            'title'   => '短信登录',
            'temp_id' => 'SMS_214635224',
            'content' => '验证码${code}，您正在登录，若非本人操作，请勿泄露。',
        ],
        [
            'title'   => '绑定手机号',
            'temp_id' => 'SMS_214635225',
            'content' => '验证码${code}，您正在进行身份验证，打死不要告诉别人哦！',
        ]
    ]
];