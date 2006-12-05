CREATE TABLE `mailer` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `mto` text NOT NULL,
  `msubject` text NOT NULL,
  `mbody` text NOT NULL,
  `mheader` text NOT NULL,
  `mstate` tinyint NOT NULL default 0,
 PRIMARY KEY  (`id`)
);
INSERT INTO dbversion(sql_id, sql_subid) VALUES (29, 0);