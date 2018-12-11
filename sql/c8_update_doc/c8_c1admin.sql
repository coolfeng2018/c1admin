/*创建表 data_fish_log*/
CREATE TABLE `data_fish_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL DEFAULT '0' COMMENT 'uid',
  `rate` varchar(11) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '概率',
  `op_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '操作用户名',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=749 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT COMMENT='产出与消耗数据表';

/*创建表 data_user_head*/
CREATE TABLE `data_user_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `head_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '头像地址',
  `o_desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '备注信息',
  `o_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0审核中 1已拒绝 2已通过',
  `op_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '操作人',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

/*创建表 data_table_fee*/
CREATE TABLE `data_table_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(20) NOT NULL DEFAULT '0' COMMENT '日期',
  `game_type` int(11) NOT NULL DEFAULT '0' COMMENT '游戏类型',
  `table_type` int(11) NOT NULL DEFAULT '0' COMMENT '场次类型',
  `table_fee` int(11) NOT NULL DEFAULT '0' COMMENT '台费值 分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=700 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;



/*创建表 data_table_oac*/
CREATE TABLE `data_table_oac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(20) NOT NULL DEFAULT '0' COMMENT '日期',
  `reason` int(11) NOT NULL DEFAULT '0' COMMENT '游戏类型',
  `table_money` int(11) NOT NULL DEFAULT '0' COMMENT '金币数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=709 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT COMMENT='产出与消耗数据表';


/*创建表 sys_activity_list*/
CREATE TABLE `sys_activity_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `act_name` varchar(50) NOT NULL DEFAULT '' COMMENT '活动名称',
  `act_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '活动类型',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '活动状态 0待上线 1生效中',
  `act_info` text NOT NULL COMMENT '活动配置',
  `start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `auth` varchar(50) NOT NULL DEFAULT '' COMMENT '操作者',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='充值活动配置表';