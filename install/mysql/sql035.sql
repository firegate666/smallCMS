ALTER TABLE `battle` ADD `score_t3` TINYINT NOT NULL DEFAULT '0',
ADD `score_1` INT NOT NULL DEFAULT '0',
ADD `score_2` INT NOT NULL DEFAULT '0';

ALTER TABLE `battle` ADD INDEX ( `score_t3` , `score_1` , `score_2` ) ;

INSERT INTO dbversion(sql_id, sql_subid) VALUES (35, 0);
