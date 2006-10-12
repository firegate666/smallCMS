ALTER TABLE `image` ADD `emoticon` TINYINT NOT NULL DEFAULT '0';
	
INSERT INTO dbversion(sql_id, sql_subid) VALUES (28, 0);