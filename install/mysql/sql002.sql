ALTER TABLE `ttcategory` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ttentry` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ttentrydependson` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ttentryrohstoff` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ttexplored` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tttype` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE `bauplan` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE `rohstoffshop` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;

INSERT INTO `dbversion` (`id`, `__createdon`, `__changedon`, `sql_id`, `sql_subid`) VALUES
(2, NULL, NULL, 2, 0);
