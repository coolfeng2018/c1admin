ALTER TABLE `sys_vip`
CHANGE COLUMN `mammon` `caishen_base_rate`  tinyint(3) NOT NULL DEFAULT 0 COMMENT '财神到触发加成' AFTER `free_num`;










INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-机器人类型', '200004>robot_type', 'brnn_ten_normal', '', '2', 'zita', '2018-05-13 10:41:10');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-是否开放机器人', '200004>open_robot', 'true', '', '2', 'zita', '2018-05-13 10:41:10');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-标识图片名', '200004>img_icon', 'gold_3.png', '', '2', 'zita', '2018-05-13 10:41:10');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-底图名', '200004>img_bg', 'cc_cj.png', '', '2', 'zita', '2018-05-13 10:41:10');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-底注', '200004>dizhu', '0', '', '2', 'zita', '2018-05-13 10:41:10');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-台费', '200004>cost', '5', '', '2', '42;suli', '2018-07-26 15:47:54');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-进场最大限制', '200004>max', '0', '', '2', 'zita', '2018-05-13 10:41:10');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-进场最小限制', '200004>min', '0', '', '2', '24;hyh', '2018-05-22 11:13:01');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('8', '房间配置-200004-场次名称', '200004>name', '百人牛牛十倍场', '', '2', 'zita', '2018-05-13 10:41:10');




INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>count', '100', '人数', '2', '14;lyf', '2018-05-19 12:06:41');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>min_coin', '50000', '最小', '2', '60;hm1111', '2018-06-27 16:13:32');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>max_coin', '300000', '最大', '2', '60;hm1111', '2018-06-27 16:52:44');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>total_coin', '5000000', '机器人累计携带金币总额', '2', '60;hm1111', '2018-06-27 16:50:38');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>probability_config>1', '{-1000000000000000000, 9999999, 65}', '机器人配置', '2', '42;sl', '2018-06-07 15:18:20');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>probability_config>2', '{10000000, 14999999, 50}', '机器人配置', '2', '42;sl', '2018-06-06 17:26:31');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>probability_config>3', '{15000000, 25000000, 20}', '机器人配置', '2', '42;sl', '2018-06-06 17:26:40');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>probability_config>4', '{25000001, 29999999, 0}', '机器人配置', '2', '42;sl', '2018-06-06 17:26:47');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场', 'brnn_ten_normal>probability_config>5', '{30000000, 1000000000000000000, 0}', '机器人配置', '2', '42;sl', '2018-06-06 17:26:55');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场-下注概率', 'brnn_ten_normal>probability_cnf>1', '{10,10,10,10}', '', '2', '14;lyf', '2018-05-22 11:35:50');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场-下注概率', 'brnn_ten_normal>probability_cnf>2', '{10, 2, 2,10}', '', '2', '14;lyf', '2018-05-22 11:35:38');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场-下注概率', 'brnn_ten_normal>probability_cnf>3', '{10, 2,10,2}', '', '2', '14;lyf', '2018-05-22 11:35:30');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场-下注概率', 'brnn_ten_normal>probability_cnf>4', '{2,10, 3,10}', '', '2', '14;lyf', '2018-05-22 11:35:19');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场-机器人上线-时间', 'brnn_ten_normal>cnf>1>1', '12:00:00-23:59:59', '', '2', '16;hxf', '2018-05-23 12:19:03');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场-机器人上线-数量', 'brnn_ten_normal>cnf>1>2', '30-40', '', '2', '14;lyf', '2018-05-19 12:18:37');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场-机器人上线-时间', 'brnn_ten_normal>cnf>2>1', '00:00:00-12:00:00', '', '2', '14;lyf', '2018-05-19 10:49:25');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛十倍场-机器人上线-数量', 'brnn_ten_normal>cnf>2>2', '30-40', '', '2', '60;hm1111', '2018-06-27 16:16:20');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛-十倍场闲家下注限制值[2]浮动数值', 'brnn_ten_normal>cnf>1>3', '80000-50', '', '2', '42;sl', '2018-06-28 18:26:30');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('4', '百人牛牛-十倍场闲家下注限制值[2]浮动数值', 'brnn_ten_normal>cnf>2>3', '100000-50', '', '2', '42;sl', '2018-06-28 18:26:41');




INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-机器人类型-([上庄机器人]={人数范围,金币范围})', 'brnn_ten_normal>robot_type_list>6', '{\"6-10\",\"5000000-50000000\"}', '', '2', '26;lyf', '2018-10-20 17:58:54');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-Vip座位上座率', 'brnn_ten_normal>vip_seat_rate', '{0,0,10,40,30,20,0}', '', '2', '28;php', '2018-07-27 15:57:12');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-后30%时间下注量', 'brnn_ten_normal>bet_acount3', '50', '', '2', '', '2018-05-25 16:51:40');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-中50%时间下注量', 'brnn_ten_normal>bet_acoun2', '20', '', '2', '', '2018-05-25 16:51:40');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-前20%时间下注量', 'brnn_ten_normal>bet_acount1', '30', '', '2', '', '2018-05-25 16:51:40');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-区域下注浮动值', 'brnn_ten_normal>bet_area_float', '80-120', '', '2', '', '2018-05-25 16:51:40');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-玩家坐庄各下注区域比例', 'brnn_ten_normal>player_bet_area', '{25,25,25,25}', '', '2', '15;myt', '2018-07-26 16:48:07');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-玩家坐庄上局下注选用比例', 'brnn_ten_normal>player_last_bet_rate', '20', '', '2', '', '2018-05-25 16:51:40');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-玩家坐庄机器人下注下限', 'brnn_ten_normal>player_bet_min', '6000000', '', '2', '26;lyf', '2018-10-20 17:33:42');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-系统坐庄各下注区域比例', 'brnn_ten_normal>system_bet_area', '{25,25,25,25}', '', '2', '15;myt', '2018-07-26 16:47:47');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-系统坐庄上局下注选用比例', 'brnn_ten_normal>system_last_bet_rate', '50', '', '2', '', '2018-05-25 16:51:40');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-系统坐庄机器人下注下限', 'brnn_ten_normal>system_bet_min', '2000000', '', '2', '42;suli', '2018-09-25 17:38:11');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-机器人离桌率', 'brnn_ten_normal>leave_rate', '2', '', '2', '42;suli', '2018-07-27 16:29:25');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-机器人类型-([非R型]={人数范围,金币范围})', 'brnn_ten_normal>robot_type_list>5', '{\"2-5\",\"10000-50000\"}', '', '2', '42;suli', '2018-09-25 18:02:31');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-机器人类型-([小R型]={人数范围,金币范围})', 'brnn_ten_normal>robot_type_list>4', '{\"6-15\",\"50000-200000\"}', '', '2', '42;suli', '2018-09-25 18:02:21');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-机器人类型-([中R型]={人数范围,金币范围})', 'brnn_ten_normal>robot_type_list>3', '{\"6-15\",\"200000-500000\"}', '', '2', '42;suli', '2018-09-25 18:02:12');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-机器人类型-([大R型]={人数范围,金币范围})', 'brnn_ten_normal>robot_type_list>2', '{\"3-10\",\"500000-1000000\"}', '', '2', '42;suli', '2018-09-25 18:02:04');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-机器人类型-([土豪型]={人数范围,金币范围})', 'brnn_ten_normal>robot_type_list>1', '{\"1-5\",\"1000000-5000000\"}', '', '2', '26;lyf', '2018-10-20 17:58:37');
INSERT INTO `one_by_one`.`gamecfg` (`typeid`, `desc`, `key_col`, `val_col`, `memo`, `o_status`, `op_name`, `op_time`) VALUES ('14', '机器人控制-百人牛牛十倍场-牌型大小界定值', 'brnn_ten_normal>card_compare_value', '5', '', '2', '', '2018-05-25 16:51:40');
