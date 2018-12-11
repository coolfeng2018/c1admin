/* 扑鱼日记数据 */
CREATE TABLE `dc_log_fish`.`fish` (
   `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
   `op` varchar(100) NOT NULL,
   `gid` varchar(100) NOT NULL COMMENT '场景编号',
   `uid` int(11) NOT NULL COMMENT '用户ID',
   `bullet_count` int(11) DEFAULT NULL COMMENT '子弹数量',
   `bullet_coins` int(11) DEFAULT NULL COMMENT '消耗子弹金币',
   `fish_count` int(11) DEFAULT NULL COMMENT '获得鱼的数量',
   `fish_coins` int(11) DEFAULT NULL COMMENT '获得鱼金币',
   `create_time` int(11) DEFAULT NULL,
   `create_date` varchar(20) DEFAULT NULL COMMENT '日期',
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* 创建本月的表 */
CREATE TABLE IF NOT EXISTS `dc_log_fish`.`fish201810` LIKE `dc_log_fish`.`fish`;
/* 创建下个的表 */
CREATE TABLE IF NOT EXISTS `dc_log_fish`.`fish201811` LIKE `dc_log_fish`.`fish`;