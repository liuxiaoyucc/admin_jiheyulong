<?php
// 前端导航配置

return [
    'menu'=>[
        [
            'level'     =>  '',
            'id'        =>  '1',
            'title'     =>  '常规',
            'icon'      =>  'fa fa-address-book',
            'href'      =>  '',
            'target'    =>  '_self',
            'child'     =>  [
                [
                    'level'     =>  '1-1',
                    'id'        =>  '1',
                    'title'     =>  '设置',
                    'icon'      =>  'fa fa-home',
                    'href'      =>  '',
                    'target'    =>  '_self',
                    'child'     =>  [
                        [
                            'level'     =>  '1-1-1',
                            'id'        =>  '2',
                            'title'     =>  '权限',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  '',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],
                        [
                            'level'     =>  '1-1-2',
                            'id'        =>  '3',
                            'title'     =>  '系统设置',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/setting/index.html',
                            'target'    =>  '_self',
                            'child'     =>  [],
                        ],
                    ],
                ],
                [
                    'level'     =>  '1-2',
                    'id'        =>  '4',
                    'title'     =>  '广告管理',
                    'icon'      =>  'fa fa-lock',
                    'href'      =>  '',
                    'target'    =>  '_self',
                    'child'     =>  [
                        [
                            'level'     =>  '1-2-1',
                            'id'        =>  '5',
                            'title'     =>  '轮播图片管理',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/advert/banner.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ]
                    ],
                ],
                [
                    'level'     =>  '1-3',
                    'id'        =>  '6',
                    'title'     =>  '用户管理',
                    'icon'      =>  'fa fa-lock',
                    'href'      =>  '',
                    'target'    =>  '_self',
                    'child'     =>  [
                        [
                            'level'     =>  '1-3-1',
                            'id'        =>  '7',
                            'title'     =>  '用户列表',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/user/index.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],
                    ],
                ],
                [
                    'level'     =>  '1-4',
                    'id'        =>  '9',
                    'title'     =>  '门票管理',
                    'icon'      =>  'fa fa-lock',
                    'href'      =>  '',
                    'target'    =>  '_self',
                    'child'     =>  [
                        [
                            'level'     =>  '1-4-1',
                            'id'        =>  '10',
                            'title'     =>  '门票列表',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/ticket/index.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],
                        [
                            'level'     =>  '1-4-2',
                            'id'        =>  '11',
                            'title'     =>  '门票购买记录',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/ticket/buy_record.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],
                        [
                            'level'     =>  '1-4-3',
                            'id'        =>  '12',
                            'title'     =>  '退票管理',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/ticket/refund.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ]
                    ],


                ],
                [
                    'level'     =>  '1-5',

                    'id'        =>  '15',
                    'title'     =>  '充值管理',
                    'icon'      =>  'fa fa-lock',
                    'href'      =>  '',
                    'target'    =>  '_self',
                    'child'     =>  [
                        [
                            'level'     =>  '1-5-1',

                            'id'        =>  '16',
                            'title'     =>  '充值设置',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/recharge/index.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],
                        [
                            'level'     =>  '1-5-2',

                            'id'        =>  '17',
                            'title'     =>  '充值记录',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/recharge/record.html',
                            'target'    =>  '_self',
                            'child'     =>  [],
                        ]
                    ]
                ],
                [
                    'level'     =>  '1-7',

                    'id'        =>  '22',
                    'title'     =>  '赛事管理',
                    'icon'      =>  'fa fa-lock',
                    'href'      =>  '',
                    'target'    =>  '_self',
                    'child'     =>  [
                        [
                            'level'     =>  '1-7-6',

                            'id'        =>  '23',
                            'title'     =>  '分类管理',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/compete/classify.html',
                            'target'    =>  '_self',
                            'child'     =>  [],
                        ],
                        [
                            'level'     =>  '1-7-2',
                            'id'        =>  '25',
                            'title'     =>  '赛事列表',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/compete/index.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],
                        [
                            'level'     =>  '1-7-3',
                            'id'        =>  '26',
                            'title'     =>  '比赛规则管理',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/compete/rule.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],
                    ]
                ],


                [
                    'level'     =>  '1-8',

                    'id'        =>  '29',
                    'title'     =>  '单页管理',
                    'icon'      =>  'fa fa-lock',
                    'href'      =>  '',
                    'target'    =>  '_self',
                    'child'     =>  [
                        [
                            'level'     =>  '1-8-1',

                            'id'        =>  '30',
                            'title'     =>  '协议管理',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  '',
                            'target'    =>  '_self',
                            'child'     =>  [
                                [
                                    'level'     =>  '1-8-1-1',

                                    'id'        =>  '31',
                                    'title'     =>  '用户协议',
                                    'icon'      =>  'fa fa-user',
                                    'href'      =>  'page/single_page/user_agreement.html',
                                    'target'    =>  '_self',
                                    'child'     =>  [],
                                ],
                                [
                                    'level'     =>  '1-8-1-2',

                                    'id'        =>  '32',
                                    'title'     =>  '隐私协议',
                                    'icon'      =>  'fa fa-user',
                                    'href'      =>  'page/single_page/privacy_agreement.html',
                                    'target'    =>  '_self',
                                    'child'     =>  [],
                                ],
                                [
                                    'level'     =>  '1-8-1-3',

                                    'id'        =>  '33',
                                    'title'     =>  '会员服务协议',
                                    'icon'      =>  'fa fa-user',
                                    'href'      =>  'page/single_page/vip_agreement.html',
                                    'target'    =>  '_self',
                                    'child'     =>  [],
                                ],
                            ],

                        ],
                        [
                            'level'     =>  '1-8-2',

                            'id'        =>  '34',
                            'title'     =>  '系统设置',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/single_page/setting.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],
                        [
                            'level'     =>  '1-8-3',

                            'id'        =>  '34',
                            'title'     =>  '赛事列表玩法讲解',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/single_page/compete_explain.html',
                            'target'    =>  '_self',
                            'child'     =>  [],

                        ],

                    ]
                ],



                [
                    'level'     =>  '1-9',

                    'id'        =>  '34',
                    'title'     =>  '文章管理',
                    'icon'      =>  'fa fa-lock',
                    'href'      =>  '',
                    'target'    =>  '_self',
                    'child'     =>  [
                        [
                            'level'     =>  '1-9-1',

                            'id'        =>  '35',
                            'title'     =>  '问题列表',
                            'icon'      =>  'fa fa-user',
                            'href'      =>  'page/faq/index.html',
                            'target'    =>  '_self',
                            'child'     =>  [],
                        ],
                    ]
                ],


            ]
        ],
//        [
//            'id'        =>  '-1',
//            'level'     =>  '2',
//            'title'     =>  '其他',
//            'icon'      =>  'fa fa-gears',
//            'href'      =>  '',
//            'target'    =>  '_self',
//            'child'     =>  [
//                [
//                    'level'     =>  '2-1',
//                    'id'        =>  '-1',
//                    'title'     =>  '设置',
//                    'icon'      =>  'fa fa-gears',
//                    'href'      =>  '',
//                    'target'    =>  '_self',
//                    'child'     =>  [],
//
//                ]
//            ]
//        ],
    ]
    
];
