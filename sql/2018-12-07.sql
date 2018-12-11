CREATE TABLE dc_log_result.pack_count_warning (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间戳',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `average_count` int(11) NOT NULL DEFAULT '0' COMMENT '每秒发包总数',
  `pack_count` int(11) NOT NULL DEFAULT '0' COMMENT '五分钟发包总数',
  `ip` varchar(16) NOT NULL DEFAULT '' COMMENT 'ip',
  `period_traffic_KB` int(11) NOT NULL DEFAULT '0' COMMENT '五分钟发包总量',
  `key` varchar(64) NOT NULL DEFAULT '',
  `op` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

