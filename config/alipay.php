<?php
/**
 * 支付宝支付配置信息
 */

// 应用公钥
// MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAriVbBCUC5TOYlIK+VEe1NnYFz8gZqQhSziMU8S/owS5Yk8PujDK4/Tl5yEwSddS9UFWjhIxW6KRr9Ui97LBhTRcU42kiFB3GQ1xoHWblA0XfFqCQZPXBkOOdIDzkQBuGsdbHiZ8n8Vnw4xas0FI9yBChuxsqIjIWlWIwevy8ELL2cfaU6gCwz38B45IP7VsotYDr2tH0tJ/jKGPHnykV8MTA+frgjTmtqlZAwVHlwaZ1B0370G3X3RqDnBoUiAvwMTEnxOlLxIj4h3fLcCZqlaugzVqTRzh961h0YdLgywRBHnc2CfFc6FKRKEnN+NDGCjSR87Em978Nb1AG4+npIwIDAQAB

return [
    'config'=> [
        //应用ID,您的APPID。
        'app_id' => "", //正式对公

        //商户私钥
        'merchant_private_key' => "",
        //异步通知地址
        'notify_url' => "",

        //同步跳转
        'return_url' => "",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA2",

        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        //
        'alipay_public_key' => ""
    ]
];
