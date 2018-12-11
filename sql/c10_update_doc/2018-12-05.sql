--注:已添加的错误码参数,可以直接从129上的表导入
CREATE TABLE `sys_error_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `error_code` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '错误码',
  `error_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '错误码释意',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统错误码配置';

