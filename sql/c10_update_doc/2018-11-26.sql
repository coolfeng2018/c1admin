ALTER TABLE `sys_broadcast`
ADD COLUMN `interval`  mediumint(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '时间间隔' AFTER `target_coins`,
ADD COLUMN `is_need_fake`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否需要生成假数据 0否 1是' AFTER `interval`;

