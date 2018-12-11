CREATE TABLE `sys_stop_notice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(35) NOT NULL DEFAULT '' COMMENT '公告标题',
  `info` varchar(500) NOT NULL DEFAULT '' COMMENT '公告内容',
  `inscribe` varchar(50) NOT NULL DEFAULT '' COMMENT '公告落款',
  `notice_time` varchar(100) NOT NULL DEFAULT '' COMMENT '通知时间',
  `start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `redactor` varchar(50) NOT NULL DEFAULT '' COMMENT '编辑者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='停服公告表';


--大厅列表
CREATE TABLE `sys_game_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_type` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '游戏类型',
  `position` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '大厅位置排序',
  `shown_type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '类型 1普通金币房 2私人房 3快速进入房',
  `notice_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '角标--0无 1推荐 2热门',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '--状态[0:正常][1:期待]',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='大厅列表';


CREATE TABLE `sys_vip_robot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `min_coins` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '携带金币 小',
  `max_coins` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '携带金币 大',
  `vip_rate` varchar(500) NOT NULL DEFAULT '' COMMENT 'vip 权重',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='VIP机器人配置表';


CREATE TABLE `sys_vip_avatar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `avator_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '头像框id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '头像框名称',
  `time_type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '头像框期限类型 1永久 2实时',
  `use_time` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '使用小时',
  `condition` varchar(500) NOT NULL DEFAULT '' COMMENT '解锁条件',
  `icon_border_url` varchar(255) NOT NULL DEFAULT '' COMMENT '头像框url',
  `sort` mediumint(8) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '置顶 0否 1是',
  `online` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 上下线 0下线 1上线',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='VIP头像框配置表';



CREATE TABLE `sys_vip` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'VIP等级',
  `week_award_max` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '周福利上限(单位是分)',
  `icon_border_url` varchar(255) NOT NULL DEFAULT '' COMMENT '头像框url',
  `battery_url` varchar(255) NOT NULL DEFAULT '' COMMENT '专属炮台图片url',
  `charge_coins` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '充值金额(单位是分)',
  `privilege` varchar(1000) NOT NULL DEFAULT '' COMMENT '特权',
  `online` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0下线 1上线',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='VIP配置表';

