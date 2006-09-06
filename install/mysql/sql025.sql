ALTER TABLE `user` ADD `lastlogin` DATETIME NULL ,
ADD `errorlogins` BIGINT NOT NULL DEFAULT '0',
ADD `hash` VARCHAR( 100 ) NOT NULL DEFAULT '';

INSERT INTO dbversion(sql_id, sql_subid) VALUES (25, 0);