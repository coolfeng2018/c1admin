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

    //gm控制
    ['name' => 'hall.gmcontrol', 'display_name' => 'GM控制', 'route' => 'admin.gmcontrol', 'parent_id' => 'hall.manage','child'=>
        [
            ['name' => 'hall.gmcontrol.create', 'display_name' => '添加', 'route' => 'admin.gmcontrol.create', 'parent_id' => 'hall.gmcontrol'],
            ['name' => 'hall.gmcontrol.edit', 'display_name' => '编辑', 'route' => 'admin.gmcontrol.edit', 'parent_id' => 'hall.gmcontrol'],
        ]
    ],
    //错误码配置
    ['name' => 'config.errorcode', 'display_name' => '错误码配置', 'route' => 'admin.errorcode', 'parent_id' => 'config.manage','child'=>
        [
            ['name' => 'config.errorcode.create', 'display_name' => '添加', 'route' => 'admin.errorcode.create', 'parent_id' => 'config.errorcode'],
            ['name' => 'config.errorcode.edit', 'display_name' => '编辑', 'route' => 'admin.errorcode.store', 'parent_id' => 'config.errorcode'],
            ['name' => 'config.errorcode.destroy', 'display_name' => '删除', 'route' => 'admin.errorcode.destroy', 'parent_id' => 'config.errorcode'],
            ['name' => 'config.errorcode.send', 'display_name' => '发送', 'route' => 'admin.errorcode.send', 'parent_id' => 'config.errorcode'],
        ]
    ],
    //在线列表
    ['name' => 'operate.onlinelist', 'display_name' => '在线列表', 'route' => 'admin.onlinelist', 'parent_id' => 'operate.manage','child'=>
        [

        ]
    ],
    //用户列表
    ['name' => 'hall.userlist', 'display_name' => '用户列表', 'route' => 'admin.userlist', 'parent_id' => 'hall.manage','child'=>
        [
            ['name' => 'hall.userlist.create', 'display_name' => '解封号', 'route' => 'admin.userlist.create', 'parent_id' => 'hall.userlist'],
        ]
    ],

    //新人奖励
    ['name' => 'hall.newaward', 'display_name' => '新人奖励', 'route' => 'admin.newaward', 'parent_id' => 'hall.manage','child'=>
        [
            ['name' => 'hall.newaward.save', 'display_name' => '保存', 'route' => 'admin.newaward.save', 'parent_id' => 'hall.newaward'],
            ['name' => 'hall.newaward.send', 'display_name' => '发送', 'route' => 'admin.newaward.send', 'parent_id' => 'hall.newaward'],
        ]
    ],

    //渠道列表
    ['name' => 'operate.channellist', 'display_name' => '渠道列表', 'route' => 'admin.channellist', 'parent_id' => 'operate.manage','child'=>
        [
            ['name' => 'operate.channellist.create', 'display_name' => '添加', 'route' => 'admin.channellist.create', 'parent_id' => 'operate.channellist'],
            ['name' => 'operate.channellist.edit', 'display_name' => '编辑', 'route' => 'admin.channellist.store', 'parent_id' => 'operate.channellist'],
            ['name' => 'operate.channellist.destroy', 'display_name' => '删除', 'route' => 'admin.channellist.destroy', 'parent_id' => 'operate.channellist'],
        ]
    ],

    //版本管理
    ['name' => 'config.version', 'display_name' => '版本管理', 'route' => 'admin.version', 'parent_id' => 'config.manage','child'=>
        [
            ['name' => 'config.version.create', 'display_name' => '添加', 'route' => 'admin.version.create', 'parent_id' => 'config.version'],
            ['name' => 'config.version.edit', 'display_name' => '编辑', 'route' => 'admin.version.edit', 'parent_id' => 'config.version'],
            ['name' => 'config.version.destroy', 'display_name' => '删除', 'route' => 'admin.version.destroy', 'parent_id' => 'config.version'],
        ]
    ],

    //监控数据
    ['name' => 'operate.warning', 'display_name' => '监控数据', 'route' => 'admin.warning', 'parent_id' => 'operate.manage', 'child' =>
        []
    ],

    //ip黑名单
    ['name' => 'hall.iplock', 'display_name' => 'ip黑名单', 'route' => 'admin.iplock', 'parent_id' => 'hall.manage','child'=>
        [
            ['name' => 'hall.iplock.create', 'display_name' => '添加', 'route' => 'admin.iplock.create', 'parent_id' => 'hall.iplock'],
            ['name' => 'hall.iplock.edit', 'display_name' => '修改', 'route' => 'admin.iplock.edit', 'parent_id' => 'hall.iplock'],
        ]
    ],
];