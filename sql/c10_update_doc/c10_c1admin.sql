
###c1Admin
ALTER TABLE `c1Admin`.`sys_game_list` ADD COLUMN `guide_status` TINYINT(4) DEFAULT 2 NOT NULL COMMENT '是否强引导 1:需要2:不需要' AFTER `status`;
ALTER TABLE `c1Admin`.`sys_vip` ADD COLUMN `enter_word`  varchar(255) NOT NULL DEFAULT '' COMMENT 'VIP进场提示语' AFTER `online`;
ALTER TABLE `c1Admin`.`sys_vip` ADD COLUMN `free_num` INT(10) DEFAULT 0 NOT NULL COMMENT '大抽奖免费次数' AFTER `enter_word`;
ALTER TABLE `c1Admin`.`sys_vip` ADD COLUMN `caishen_base_rate` tinyint(3) DEFAULT 0 NOT NULL COMMENT '财神到触发加成' AFTER `free_num`;

ALTER TABLE `c1Admin`.`sys_broadcast`
ADD COLUMN `interval`  mediumint(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '时间间隔' AFTER `target_coins`,
ADD COLUMN `is_need_fake`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否需要生成假数据 0否 1是' AFTER `interval`;

ALTER TABLE `c1Admin`.`sys_broadcast` ADD COLUMN `mid`  int UNSIGNED NOT NULL DEFAULT 0 COMMENT '广播ID' AFTER `id`;

DROP TABLE IF EXISTS `c1Admin`.`sys_act_icon`;
CREATE TABLE `c1Admin`.`sys_act_icon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `sort_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `key_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'key值=>活动ID',
  `name_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '入口名称ID',
  `auth` varchar(50) NOT NULL DEFAULT '' COMMENT '操作者',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动ICON排序表';

DROP TABLE IF EXISTS `c1Admin`.`user_money_update`;
CREATE TABLE `c1Admin`.`user_money_update` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '玩家ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '修改类型1加金币，2减金币',
  `value` int(10) NOT NULL DEFAULT '0' COMMENT '数量',
  `remarks` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `auth` varchar(50) NOT NULL DEFAULT '' COMMENT '操作者',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='修改玩家金币表';

DROP TABLE IF EXISTS `c1Admin`.`log_operate`;
CREATE TABLE `c1Admin`.`log_operate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `method` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '请求方法',
  `path` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '请求路径',
  `params` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '请求参数',
  `ip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'ip',
  `created_at` int(11) DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `c1Admin`.`user_white_list`;
CREATE TABLE `c1Admin`.`user_white_list` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '修改类型1 IP白名单，2设备号白名单',
  `address` VARCHAR(100) NOT NULL DEFAULT '' COMMENT 'ip地址或者设备号',
  `remarks` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '备注',
  `auth` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '操作者',
  `created_at` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COMMENT='白名单';


















