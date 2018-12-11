CREATE TABLE `dc_log_result.mammon_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `days` int(11) NOT NULL DEFAULT '0',
  `table_type` int(11) NOT NULL DEFAULT '0' COMMENT '房间类型',
  `trigger` int(11) NOT NULL DEFAULT '0' COMMENT '触发次数',
  `buy_num` int(11) NOT NULL DEFAULT '0' COMMENT '购买次数',
  `buy_usr` int(11) NOT NULL DEFAULT '0' COMMENT '购买人数',
  `award_num` int(11) NOT NULL DEFAULT '0' COMMENT '中奖次数',
  `award_usr` int(11) NOT NULL DEFAULT '0' COMMENT '中奖人数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


