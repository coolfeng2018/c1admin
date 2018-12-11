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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='停服公告表';


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





