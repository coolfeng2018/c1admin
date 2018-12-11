ALTER TABLE `data_rank_board`
MODIFY COLUMN `rank_level`  int(10) NOT NULL DEFAULT 0 COMMENT '排名' AFTER `today_income`;

