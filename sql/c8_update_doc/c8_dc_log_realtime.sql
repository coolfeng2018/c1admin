
/* 活动绑定表 */
CREATE TABLE `act_pullnew_bind` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `bind_uid` int(11) NOT NULL DEFAULT '0' COMMENT '绑定uid',
  `op` int(11) NOT NULL DEFAULT '0' COMMENT 'op',
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/* 活动绑定表 */
CREATE TABLE `act_pullnew_pump` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `pay_coin` int(11) NOT NULL DEFAULT '0' COMMENT '支付金币',
  `award_coin` int(11) NOT NULL DEFAULT '0' COMMENT '奖励金币',
  `op` int(11) NOT NULL DEFAULT '0' COMMENT 'op',
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


/* 活动奖励 */
CREATE TABLE `act_pullnew_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `award_list` text NOT NULL COMMENT '奖励信息',
  `op` int(11) NOT NULL DEFAULT '0' COMMENT 'op',
  PRIMARY KEY (`id`),
  KEY `time` (`time`),
  KEY `op` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;