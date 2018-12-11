###dc_log_result
ALTER TABLE `dc_log_result`.`exchange_result` ADD COLUMN `key` VARCHAR(32) DEFAULT '' NULL COMMENT '日志唯一key' AFTER `id`;

DROP TABLE IF EXISTS `dc_log_result`.`mammon_result`;
CREATE TABLE `dc_log_result`.`mammon_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL DEFAULT '0',
  `table_type` int(11) NOT NULL DEFAULT '0' COMMENT '房间类型',
  `trigger` int(11) NOT NULL DEFAULT '0' COMMENT '触发次数',
  `buy_num` int(11) NOT NULL DEFAULT '0' COMMENT '购买次数',
  `buy_usr` int(11) NOT NULL DEFAULT '0' COMMENT '购买人数',
  `award_num` int(11) NOT NULL DEFAULT '0' COMMENT '中奖次数',
  `award_usr` int(11) NOT NULL DEFAULT '0' COMMENT '中奖人数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

###dc_log_fish
ALTER TABLE `dc_log_fish`.`fish` ADD COLUMN `key` VARCHAR(32) DEFAULT '' NULL COMMENT '日志唯一key' AFTER `id`;

###dc_log_realtime
ALTER TABLE `dc_log_realtime`.`act_pullnew_bind` ADD COLUMN `key` VARCHAR(32) DEFAULT '' NULL COMMENT '日志唯一key' AFTER `id`;
ALTER TABLE `dc_log_realtime`.`act_pullnew_pump` ADD COLUMN `key` VARCHAR(32) DEFAULT '' NULL COMMENT '日志唯一key' AFTER `id`;
ALTER TABLE `dc_log_realtime`.`act_pullnew_reward` ADD COLUMN `key` VARCHAR(32) DEFAULT '' NULL COMMENT '日志唯一key' AFTER `id`;
ALTER TABLE `dc_log_realtime`.`online_onplay` ADD COLUMN `key` VARCHAR(32) DEFAULT '' NULL COMMENT '日志唯一key' FIRST;
ALTER TABLE `dc_log_realtime`.`online_onplay` DROP INDEX `op`, ADD INDEX `idx_key` (`key`);
ALTER TABLE `dc_log_realtime`.`online_onplay` ADD COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);

DROP TABLE IF EXISTS `dc_log_realtime`.`award_add_free_count`;
CREATE TABLE `dc_log_realtime`.`award_add_free_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT 'key',
  `add_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型 1推广免费次数 2vip登录免费次数 3绑定免费次数',
  `add_count` int(10) NOT NULL DEFAULT '0' COMMENT '次数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `op` int(11) NOT NULL DEFAULT '0' COMMENT 'op',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dc_log_realtime`.`award_bind_player`;
CREATE TABLE `dc_log_realtime`.`award_bind_player` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT 'key',
  `bind_uid` int(10) NOT NULL DEFAULT '0' COMMENT '被绑定的玩家 88888是官方 其他是玩家',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '主动绑定的玩家',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `op` int(11) NOT NULL DEFAULT '0' COMMENT 'op',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dc_log_realtime`.`award_data`;
CREATE TABLE `dc_log_realtime`.`award_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `add_count` int(10) NOT NULL DEFAULT '0' COMMENT '抽奖次数',
  `add_num` int(10) NOT NULL DEFAULT '0' COMMENT '抽奖人数',
  `pay_count` int(10) NOT NULL DEFAULT '0' COMMENT '付费次数',
  `count_bd` int(10) NOT NULL DEFAULT '0' COMMENT '绑定免费次数',
  `count_vip` int(10) NOT NULL DEFAULT '0' COMMENT 'VIP免费次数',
  `count_tg` int(10) NOT NULL DEFAULT '0' COMMENT '推广免费次数',
  `binding_count` int(10) NOT NULL DEFAULT '0' COMMENT '绑定人数（玩家）',
  `binding_count_gm` int(10) NOT NULL DEFAULT '0' COMMENT '绑定人数（官方）',
  `cp_count_true` int(10) NOT NULL DEFAULT '0' COMMENT '彩票张数（有效）',
  `cp_count_false` int(10) NOT NULL DEFAULT '0' COMMENT '彩票张数（无效）',
  `date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当日日期',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dc_log_realtime`.`award_lucky_draw`;
CREATE TABLE `dc_log_realtime`.`award_lucky_draw` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT 'key',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT 'uid',
  `pay_coins` int(10) NOT NULL DEFAULT '0' COMMENT '支付的钱 为0的时候是免费',
  `cpcode` varchar(100) NOT NULL DEFAULT '' COMMENT '彩票码 有这个字段的时候是总彩票了',
  `cp_valid` varchar(20) NOT NULL DEFAULT '' COMMENT '彩票是否是有效的 true or false',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `op` int(11) NOT NULL DEFAULT '0' COMMENT 'op',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dc_log_realtime`.`award_record`;
CREATE TABLE `dc_log_realtime`.`award_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT 'key',
  `cur_index` int(10) NOT NULL DEFAULT '0' COMMENT '期数',
  `player_award_list` text NOT NULL COMMENT 'uid,name,award_count:获奖注数,award_coins:获奖金额,is_robot:false',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '这期结束时间',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `op` int(11) NOT NULL DEFAULT '0' COMMENT 'op',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `dc_log_realtime`.`award_store_coins`;
CREATE TABLE `dc_log_realtime`.`award_store_coins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT 'key',
  `cur_index` int(10) NOT NULL DEFAULT '0' COMMENT '期数',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '这期结束时间',
  `fee_coins` int(11) NOT NULL DEFAULT '0' COMMENT '抽水值',
  `store_coins` int(11) NOT NULL DEFAULT '0' COMMENT '库存值',
  `store_system_add` int(11) NOT NULL DEFAULT '0' COMMENT '库存系统资助',
  `award_pool_coins` int(11) NOT NULL DEFAULT '0' COMMENT '奖金值',
  `award_pool_system_add` int(11) NOT NULL DEFAULT '0' COMMENT '系统资金资助',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `op` int(11) NOT NULL DEFAULT '0' COMMENT 'op',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;