ALTER TABLE `imagecategory` ADD `parent` BIGINT NOT NULL AFTER `name` ;
ALTER TABLE imagecategory ADD FOREIGN KEY (parent) REFERENCES imagecategory(id) ON DELETE RESTRICT;
RENAME TABLE `imagecategory` TO `filecategory` ;
ALTER TABLE `filecategory` CHANGE `parent` `parent` BIGINT( 20 ) NULL ;

INSERT INTO dbversion(sql_id, sql_subid) VALUES (32, 0);