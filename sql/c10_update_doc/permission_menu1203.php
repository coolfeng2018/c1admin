<?php
/**
 * +------------------------------
 * Created by PhpStorm.
 * +------------------------------
 * User: xxx
 * +------------------------------
 * DateTime: 2018/10/22 10:08
 * +------------------------------
 */

/**
 * eg: 运行此命令增加菜单 php artisan menu:make
 * [
 * 'name' => 'test.zxc',
 * 'display_name' => '测试1',
 * 'route' => 'admin.test',
 * 'parent_id' => 0,    //父级菜单 parent_id = 数字
 * 'is_child'  =>  0   //父级菜单 is_child = 0
 * ],
 *
 * [
 * 'name' => 'test.qwe',
 * 'display_name' => '测试1-1',
 * 'route' => 'admin.test',
 * 'parent_id' => 'test.zxc',  //子级菜单 parent_id =  父级菜单name
 * 'is_child'  =>  1     //子级菜单 is_child = 1
 * ],
 *
 * [
 * 'name' => 'test.asd',
 * 'display_name' => '测试2',
 * 'route' => 'admin.test',
 * 'parent_id' => 'parent_name',   //子级菜单 parent_id =  父级菜单name
 * 'is_child'  =>  1    //子级菜单 is_child = 1
 * ],
 *
 */

return [

    ['name' => 'config.icon', 'display_name' => '活动ICON排序配置', 'route' => 'admin.icon', 'parent_id' => 'config.manage', 'child' =>
        [
            ['name' => 'config.icon.create', 'display_name' => '添加', 'route' => 'admin.icon.create', 'parent_id' => 'config.icon'],
            ['name' => 'config.icon.edit', 'display_name' => '编辑', 'route' => 'admin.icon.edit', 'parent_id' => 'config.icon'],
            ['name' => 'config.icon.destroy', 'display_name' => '删除', 'route' => 'admin.icon.destroy', 'parent_id' => 'config.icon'],
        ]
    ],

    ['name' => 'operate.goldcoin', 'display_name' => '修改玩家金币', 'route' => 'admin.goldcoin', 'parent_id' => 'operate.manage', 'child' =>
        [
            ['name' => 'operate.goldcoin.create', 'display_name' => '添加', 'route' => 'admin.goldcoin.create', 'parent_id' => 'operate.goldcoin'],
        ]
    ],

    ['name' => 'operate.order.destroy', 'display_name' => '废弃', 'route' => 'admin.order.destroy', 'parent_id' => 'operate.order'],

    ['name' => 'system.opreatelog', 'display_name' => '系统操作日志', 'route' => 'admin.opreatelog', 'parent_id' => 'system.manage'],



    ['name' => 'store.manage', 'display_name' => '库存管理', 'route' => '', 'parent_id' => 0,'child'=>
        [
            //扑鱼
            ['name' => 'store.fishstore', 'display_name' => '捕鱼-库存控制', 'route' => 'admin.fishstore', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.fishstore.save', 'display_name' => '保存', 'route' => 'admin.fishstore.save', 'parent_id' => 'store.fishstore'],
                    ['name' => 'store.fishstore.send', 'display_name' => '发送', 'route' => 'admin.fishstore.send', 'parent_id' => 'store.fishstore'],
                ]
            ],
            ['name' => 'store.fishstorelist', 'display_name' => '捕鱼-抽水数据', 'route' => 'admin.fishstore.list', 'parent_id' => 'store.manage'],

            //牛牛
            ['name' => 'store.cattlestore', 'display_name' => '牛牛-抢庄控制', 'route' => 'admin.cattlestore', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.cattlestore.save', 'display_name' => '保存', 'route' => 'admin.cattlestore.save', 'parent_id' => 'store.cattlestore'],
                    ['name' => 'store.cattlestore.send', 'display_name' => '发送', 'route' => 'admin.cattlestore.send', 'parent_id' => 'store.cattlestore'],
                ]
            ],
            ['name' => 'store.cattlestorelist', 'display_name' => '牛牛-抽水数据', 'route' => 'admin.cattlestore.list', 'parent_id' => 'store.manage'],

            //扎金花
            ['name' => 'store.zjhstore', 'display_name' => '扎金花-库存控制', 'route' => 'admin.zjhstore', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.zjhstore.save', 'display_name' => '保存', 'route' => 'admin.zjhstore.save', 'parent_id' => 'store.zjhstore'],
                    ['name' => 'store.zjhstore.send', 'display_name' => '发送', 'route' => 'admin.zjhstore.send', 'parent_id' => 'store.zjhstore'],
                ]
            ],
            ['name' => 'store.zjhstorelist', 'display_name' => '扎金花-抽水数据', 'route' => 'admin.zjhstore.list', 'parent_id' => 'store.manage'],


            //百人牛牛
            ['name' => 'store.brnnstore', 'display_name' => '百人牛牛-库存控制', 'route' => 'admin.brnnstore', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.brnnstore.save', 'display_name' => '保存', 'route' => 'admin.brnnstore.save', 'parent_id' => 'store.brnnstore'],
                    ['name' => 'store.brnnstore.send', 'display_name' => '发送', 'route' => 'admin.brnnstore.send', 'parent_id' => 'store.brnnstore'],
                ]
            ],
            ['name' => 'store.brnnstorelist', 'display_name' => '百人牛牛-抽水数据', 'route' => 'admin.brnnstore.list', 'parent_id' => 'store.manage'],

            //红黑大战
            ['name' => 'store.hhdzstore', 'display_name' => '红黑- 库存控制', 'route' => 'admin.hhdzstore', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.hhdzstore.save', 'display_name' => '保存', 'route' => 'admin.hhdzstore.save', 'parent_id' => 'store.hhdzstore'],
                    ['name' => 'store.hhdzstore.send', 'display_name' => '发送', 'route' => 'admin.hhdzstore.send', 'parent_id' => 'store.hhdzstore'],
                ]
            ],
            ['name' => 'store.hhdzstorelist', 'display_name' => '红黑-抽水数据', 'route' => 'admin.hhdzstore.list', 'parent_id' => 'store.manage'],


            //财神驾到
            ['name' => 'store.mammonstore', 'display_name' => '财神驾到- 库存控制', 'route' => 'admin.mammonstore', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.mammonstore.save', 'display_name' => '保存', 'route' => 'admin.mammonstore.save', 'parent_id' => 'store.mammonstore'],
                    ['name' => 'store.mammonstore.send', 'display_name' => '发送', 'route' => 'admin.mammonstore.send', 'parent_id' => 'store.mammonstore'],
                ]
            ],
            ['name' => 'store.mammonstorelist', 'display_name' => '财神驾到-抽水数据', 'route' => 'admin.mammonstore.list', 'parent_id' => 'store.manage'],




            //欢乐足球
            ['name' => 'store.lfdjstore', 'display_name' => '欢乐足球- 库存控制', 'route' => 'admin.lfdjstore', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.lfdjstore.save', 'display_name' => '保存', 'route' => 'admin.lfdjstore.save', 'parent_id' => 'store.lfdjstore'],
                    ['name' => 'store.lfdjstore.send', 'display_name' => '发送', 'route' => 'admin.lfdjstore.send', 'parent_id' => 'store.lfdjstore'],
                ]
            ],
            ['name' => 'store.lfdjstorelist', 'display_name' => '欢乐足球-抽水数据', 'route' => 'admin.lfdjstore.list', 'parent_id' => 'store.manage'],


            //斗地主
            ['name' => 'store.ddzstorelist', 'display_name' => '斗地主-抽水数据', 'route' => 'admin.ddzstore.list', 'parent_id' => 'store.manage'],


            //水果机
            ['name' => 'store.fruitsstore', 'display_name' => '水果机- 库存控制', 'route' => 'admin.fruitsstore', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.fruitsstore.save', 'display_name' => '保存', 'route' => 'admin.fruitsstore.save', 'parent_id' => 'store.fruitsstore'],
                    ['name' => 'store.fruitsstore.send', 'display_name' => '发送', 'route' => 'admin.fruitsstore.send', 'parent_id' => 'store.fruitsstore'],
                ]
            ],
            ['name' => 'store.fruitsstorelist', 'display_name' => '水果机-抽水数据', 'route' => 'admin.fruitsstore.list', 'parent_id' => 'store.manage'],

            //大抽奖
            ['name' => 'store.granddraw', 'display_name' => '大抽奖- 库存控制', 'route' => 'admin.granddraw', 'parent_id' => 'store.manage','child'=>
                [
                    ['name' => 'store.granddraw.save', 'display_name' => '保存', 'route' => 'admin.granddraw.save', 'parent_id' => 'store.granddraw'],
                    ['name' => 'store.granddraw.send', 'display_name' => '发送', 'route' => 'admin.granddraw.send', 'parent_id' => 'store.granddraw'],
                ]
            ],
            ['name' => 'store.granddrawlist', 'display_name' => '大抽奖-抽水数据', 'route' => 'admin.granddraw.list', 'parent_id' => 'store.manage'],

        ]
    ],



    ['name' => 'config.fishcorrection', 'display_name' => '捕鱼修正配置', 'route' => 'admin.fishcorrection', 'parent_id' => 'config.manage', 'child' =>
        [
            ['name' => 'config.fishcorrection.save', 'display_name' => '保存', 'route' => 'admin.fishcorrection.save', 'parent_id' => 'config.fishcorrection'],
            ['name' => 'config.fishcorrection.send', 'display_name' => '编辑', 'route' => 'admin.fishcorrection.send', 'parent_id' => 'config.fishcorrection'],

        ]
    ],
    ['name' => 'config.fishpowerrate', 'display_name' => '捕鱼火力概率系数', 'route' => 'admin.fishpowerrate', 'parent_id' => 'config.manage', 'child' =>
        [
            ['name' => 'config.fishpowerrate.save', 'display_name' => '保存', 'route' => 'admin.fishpowerrate.save', 'parent_id' => 'config.fishpowerrate'],
            ['name' => 'config.fishpowerrate.send', 'display_name' => '发送', 'route' => 'admin.fishpowerrate.send', 'parent_id' => 'config.fishpowerrate'],
        ]
    ],

    ['name' => 'hall.manage', 'display_name' => '大厅配置', 'route' => '', 'parent_id' => 0,'child'=>
        [
            //vip充值
            ['name' => 'hall.recharge', 'display_name' => 'VIP充值配置', 'route' => 'admin.recharge', 'parent_id' => 'hall.manage','child'=>
                [
                    ['name' => 'hall.recharge.save', 'display_name' => '保存', 'route' => 'admin.recharge.save', 'parent_id' => 'hall.recharge'],
                ]
            ],

            //微信客服
            ['name' => 'hall.wechatservice', 'display_name' => '微信客服配置', 'route' => 'admin.wechatservice', 'parent_id' => 'hall.manage','child'=>
                [
                    ['name' => 'hall.wechatservice.save', 'display_name' => '保存', 'route' => 'admin.wechatservice.save', 'parent_id' => 'hall.wechatservice'],
                ]
            ],


            //大抽奖玩法配置
            ['name' => 'hall.granddraw', 'display_name' => '大抽奖玩法配置', 'route' => 'admin.granddraw.playlist', 'parent_id' => 'hall.manage','child'=>
                [
                    ['name' => 'hall.granddraw.playsave', 'display_name' => '保存', 'route' => 'admin.granddraw.playsave', 'parent_id' => 'hall.granddraw'],
                    ['name' => 'hall.granddraw.playsend', 'display_name' => '发送', 'route' => 'admin.granddraw.send', 'parent_id' => 'hall.granddraw'],
                ]
            ],

            //财神驾到玩法配置
            ['name' => 'hall.mammon', 'display_name' => '财神驾到玩法配置', 'route' => 'admin.mammon.playlist', 'parent_id' => 'hall.manage','child'=>
                [
                    ['name' => 'hall.mammon.playsave', 'display_name' => '保存', 'route' => 'admin.mammon.playsave', 'parent_id' => 'hall.mammon'],
                    ['name' => 'hall.mammon.playsend', 'display_name' => '发送', 'route' => 'admin.mammon.playend', 'parent_id' => 'hall.mammon'],
                    ['name' => 'hall.mammon.playlist', 'display_name' => '游戏配置', 'route' => 'admin.mammon.playlist', 'parent_id' => 'hall.mammon'],
                ]
            ],
        ]
    ],
    //大抽奖数据统计
    ['name' => 'operate.granddrawdata', 'display_name' => '大抽奖数据统计', 'route' => 'admin.granddraw.data_count', 'parent_id' => 'operate.manage', 'child' =>
        []
    ],
    //大抽奖中奖名单
    ['name' => 'operate.granddrawwin', 'display_name' => '大抽奖中奖名单', 'route' => 'admin.granddraw.winning', 'parent_id' => 'operate.manage', 'child' =>
        []
    ],

    //白名单-IP
    ['name' => 'operate.whitelist', 'display_name' => '白名单-IP', 'route' => 'admin.whitelist', 'parent_id' => 'operate.manage', 'child' =>
        [
            ['name' => 'operate.whitelist.create', 'display_name' => '添加', 'route' => 'admin.whitelist.create', 'parent_id' => 'operate.whitelist'],
            ['name' => 'operate.whitelist.edit', 'display_name' => '编辑', 'route' => 'admin.whitelist.edit', 'parent_id' => 'operate.whitelist'],
            ['name' => 'operate.whitelist.destroy', 'display_name' => '删除', 'route' => 'admin.whitelist.destroy', 'parent_id' => 'operate.whitelist'],
        ]
    ],

    //白名单-设备号
    ['name' => 'operate.whiteinstall', 'display_name' => '白名单-设备号', 'route' => 'admin.whiteinstall', 'parent_id' => 'operate.manage', 'child' =>
        [
            ['name' => 'operate.whiteinstall.create', 'display_name' => '添加', 'route' => 'admin.whiteinstall.create', 'parent_id' => 'operate.whiteinstall'],
            ['name' => 'operate.whiteinstall.edit', 'display_name' => '编辑', 'route' => 'admin.whiteinstall.edit', 'parent_id' => 'operate.whiteinstall'],
            ['name' => 'operate.whiteinstall.destroy', 'display_name' => '删除', 'route' => 'admin.whiteinstall.destroy', 'parent_id' => 'operate.whiteinstall'],
        ]
    ],

    //水果机配置
    ['name' => 'config.fruit', 'display_name' => '水果机配置', 'route' => 'admin.fruit', 'parent_id' => 'config.manage', 'child' =>
        [
            ['name' => 'config.fruit.save', 'display_name' => '保存', 'route' => 'admin.fruit.save', 'parent_id' => 'config.fruit'],
            ['name' => 'config.fruit.send', 'display_name' => '发送', 'route' => 'admin.fruit.send', 'parent_id' => 'config.fruit'],
        ]
    ],


    //百人牛牛-系统庄家配置
    ['name' => 'config.brnnbanker', 'display_name' => '百人牛牛系统庄家配置', 'route' => 'admin.brnnbanker', 'parent_id' => 'config.manage', 'child' =>
        [
            ['name' => 'config.brnnbanker.save', 'display_name' => '保存', 'route' => 'admin.brnnbanker.save', 'parent_id' => 'config.brnnbanker'],
            ['name' => 'config.brnnbanker.send', 'display_name' => '发送', 'route' => 'admin.brnnbanker.send', 'parent_id' => 'config.brnnbanker'],
        ]
    ],

    //百人牛牛-系统庄家配置
    ['name' => 'config.brnnten', 'display_name' => '百人牛牛十倍场机器人控制', 'route' => 'admin.brnnten', 'parent_id' => 'config.manage', 'child' =>
        [
            ['name' => 'config.brnnten.save', 'display_name' => '保存', 'route' => 'admin.brnnten.save', 'parent_id' => 'config.brnnten'],
            ['name' => 'config.brnnten.send', 'display_name' => '发送', 'route' => 'admin.brnnten.send', 'parent_id' => 'config.brnnten'],
        ]
    ],



    //邮件
    ['name' => 'hall.email', 'display_name' => '邮件', 'route' => 'admin.email', 'parent_id' => 'hall.manage','child'=>
        [
            ['name' => 'hall.email.create', 'display_name' => '添加', 'route' => 'admin.email.create', 'parent_id' => 'hall.email'],
            ['name' => 'hall.email.send', 'display_name' => '一键发送', 'route' => 'admin.email.send', 'parent_id' => 'hall.email'],
            ['name' => 'hall.email.edit', 'display_name' => '编辑', 'route' => 'admin.email.edit', 'parent_id' => 'hall.email'],

        ]
    ],

    ['name' => 'operate.mammon.stat', 'display_name' => '财神到数据流水', 'route' => 'admin.mammonstore.stat', 'parent_id' => 'operate.manage', 'child' =>
        []
    ],
];