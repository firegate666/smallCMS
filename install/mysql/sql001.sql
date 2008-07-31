CREATE TABLE `army` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  `userid` bigint(20) NOT NULL default '0',
  `commander` varchar(100) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `codex` bigint(20) NOT NULL default '0',
  `comment` text NOT NULL,
  `points` int(11) default NULL,
  `gamesystem` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `codex` (`codex`),
  KEY `userid` (`userid`),
  KEY `gamesystem` (`gamesystem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=298 ;

CREATE TABLE `battle` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL default '',
  `comment` text NOT NULL,
  `points` int(11) default NULL,
  `player1` bigint(20) NOT NULL default '0',
  `player2` bigint(20) NOT NULL default '0',
  `winner` tinyint(4) NOT NULL default '0',
  `mission` bigint(20) NOT NULL default '0',
  `day` int(11) NOT NULL default '0',
  `month` int(11) NOT NULL default '0',
  `year` int(11) NOT NULL default '0',
  `vp1` int(11) NOT NULL default '0',
  `vp2` int(11) NOT NULL default '0',
  `userid` bigint(20) NOT NULL default '0',
  `battletypeid` bigint(20) NOT NULL default '0',
  `impdate` varchar(20) NOT NULL default '',
  `realdate` date NOT NULL default '0000-00-00',
  `multibattle` bigint(20) default '0',
  `gamesystem` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `multibattle` (`multibattle`),
  KEY `player1` (`player1`),
  KEY `player2` (`player2`),
  KEY `mission` (`mission`),
  KEY `userid` (`userid`),
  KEY `battletypeid` (`battletypeid`),
  KEY `gamesystem` (`gamesystem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8145 ;

CREATE TABLE `battletype` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL default '',
  `comment` text NOT NULL,
  `parent` bigint(20) default '0',
  `sortfirst` varchar(10) NOT NULL default '',
  `sortsecond` varchar(10) NOT NULL default '',
  `sortthird` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

CREATE TABLE `codex` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL default '',
  `comment` text NOT NULL,
  `commander` varchar(100) NOT NULL default '',
  `founding` varchar(100) NOT NULL default '',
  `homeplanet` varchar(100) NOT NULL default '',
  `followers` text NOT NULL,
  `colors` text NOT NULL,
  `specialized` text NOT NULL,
  `favunit` varchar(100) NOT NULL default '',
  `favweapon` varchar(100) NOT NULL default '',
  `reputation` text NOT NULL,
  `actstrength` text NOT NULL,
  `archenemy` varchar(100) NOT NULL default '',
  `groupname` varchar(10) default NULL,
  `gamesystem` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `gamesystem` (`gamesystem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

CREATE TABLE `dbversion` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `sql_id` bigint(20) NOT NULL default '0',
  `sql_subid` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sql_id` (`sql_id`,`sql_subid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `extendible`
-- 

CREATE TABLE `extendible` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  `parent` varchar(100) NOT NULL default '',
  `parentid` bigint(20) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`parent`,`parentid`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `filecategory`
-- 

CREATE TABLE `filecategory` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `parent` bigint(20) NOT NULL,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `gamesystem`
-- 

CREATE TABLE `gamesystem` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL default '',
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `guestbook`
-- 

CREATE TABLE `guestbook` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `email` varchar(200) default NULL,
  `subject` varchar(200) NOT NULL default '',
  `content` text NOT NULL,
  `deleted` tinyint(4) NOT NULL default '0',
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `ip` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `image`
-- 

CREATE TABLE `image` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) collate latin1_general_ci NOT NULL default '',
  `url` varchar(100) collate latin1_general_ci NOT NULL default '',
  `imagecategoryid` bigint(20) default NULL,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `parent` varchar(100) collate latin1_general_ci NOT NULL default '',
  `parentid` bigint(20) NOT NULL default '0',
  `size` bigint(20) NOT NULL default '0',
  `type` varchar(100) collate latin1_general_ci NOT NULL default '',
  `prio` bigint(20) NOT NULL default '0',
  `emoticon` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`,`parent`,`parentid`),
  KEY `imagecategoryid` (`imagecategoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=274 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mailer`
-- 

CREATE TABLE `mailer` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `mto` text NOT NULL,
  `msubject` text NOT NULL,
  `mbody` text NOT NULL,
  `mheader` text NOT NULL,
  `mstate` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `message`
-- 

CREATE TABLE `message` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `sender` bigint(20) NOT NULL default '0',
  `receiver` bigint(20) NOT NULL default '0',
  `subject` varchar(250) NOT NULL default '0',
  `body` text NOT NULL,
  `unread` tinyint(4) NOT NULL default '1',
  `sender_deleted` tinyint(4) NOT NULL default '0',
  `receiver_deleted` tinyint(4) NOT NULL default '0',
  `read_on` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `sender` (`sender`,`receiver`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mission`
-- 

CREATE TABLE `mission` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL default '',
  `comment` text NOT NULL,
  `category` text NOT NULL,
  `ruleset` text NOT NULL,
  `rounds` varchar(100) NOT NULL default '0',
  `source` text NOT NULL,
  `gamesystem` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `gamesystem` (`gamesystem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `multibattle`
-- 

CREATE TABLE `multibattle` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `multibattlearmy`
-- 

CREATE TABLE `multibattlearmy` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime NOT NULL default '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL default '0000-00-00 00:00:00',
  `multibattle` bigint(20) NOT NULL default '0',
  `army_id` bigint(20) NOT NULL default '0',
  `player` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `multibattle` (`multibattle`),
  KEY `army_id` (`army_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `newsletter`
-- 

CREATE TABLE `newsletter` (
  `id` bigint(20) NOT NULL auto_increment,
  `email` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `page`
-- 

CREATE TABLE `page` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `pagestatistic`
-- 

CREATE TABLE `pagestatistic` (
  `id` bigint(20) NOT NULL auto_increment,
  `template` varchar(200) NOT NULL default '',
  `user` bigint(20) default NULL,
  `ip` varchar(15) NOT NULL default '',
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=63027 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `question`
-- 

CREATE TABLE `question` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `name` text NOT NULL,
  `sem_id` varchar(100) NOT NULL default '',
  `blockname` varchar(100) NOT NULL default '',
  `groupname` varchar(100) NOT NULL default '',
  `questionaireid` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UNIQUE_SEM_QID` (`sem_id`,`questionaireid`),
  KEY `questionaireid` (`questionaireid`),
  KEY `groupname` (`groupname`),
  KEY `blockname` (`blockname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `questionaire`
-- 

CREATE TABLE `questionaire` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `name` varchar(100) NOT NULL default '',
  `author` varchar(100) NOT NULL default '',
  `email` varchar(200) NOT NULL default '',
  `shortdesc` varchar(200) NOT NULL default '',
  `longdesc` text NOT NULL,
  `published` tinyint(4) NOT NULL default '0',
  `closed` tinyint(4) NOT NULL default '0',
  `layout_main` bigint(20) NOT NULL default '0',
  `layout_end` bigint(20) NOT NULL default '0',
  `layout_question` bigint(20) NOT NULL default '0',
  `layout_question_alt` bigint(20) default NULL,
  `userid` bigint(20) NOT NULL default '0',
  `randompages` tinyint(4) NOT NULL default '0',
  `deleted` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `questionaireanswers`
-- 

CREATE TABLE `questionaireanswers` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `questionanswerid` bigint(20) NOT NULL default '0',
  `questionanswervalue` text NOT NULL,
  `quserid` bigint(20) NOT NULL default '0',
  `confirmed` tinyint(4) NOT NULL default '0',
  `verified` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `questionanswerid` (`questionanswerid`),
  KEY `quserid` (`quserid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `questionaireuser`
-- 

CREATE TABLE `questionaireuser` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `lastquestionaire` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email_2` (`email`),
  KEY `email` (`email`),
  KEY `password` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `questionanswer`
-- 

CREATE TABLE `questionanswer` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `questionid` bigint(20) NOT NULL default '0',
  `answertype` bigint(20) NOT NULL default '0',
  `sortid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `questionid` (`questionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `questionanswertype`
-- 

CREATE TABLE `questionanswertype` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `name` varchar(100) default NULL,
  `layout` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `session`
-- 

CREATE TABLE `session` (
  `sid` bigint(20) NOT NULL auto_increment,
  `uid` bigint(20) NOT NULL default '0',
  `client_ip` varchar(15) collate latin1_general_ci NOT NULL default '',
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  PRIMARY KEY  (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=157806 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `setting`
-- 

CREATE TABLE `setting` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `value` varchar(100) NOT NULL default '',
  `description` varchar(200) NOT NULL default '',
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `template`
-- 

CREATE TABLE `template` (
  `id` bigint(20) NOT NULL auto_increment,
  `class` varchar(25) collate latin1_general_ci NOT NULL default '',
  `layout` varchar(25) collate latin1_general_ci NOT NULL default '',
  `content` longtext collate latin1_general_ci NOT NULL,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `backup` text collate latin1_general_ci NOT NULL,
  `contenttype` varchar(100) collate latin1_general_ci NOT NULL default 'text/html',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `class` (`class`,`layout`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=157 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `login` varchar(100) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `groupid` bigint(20) NOT NULL default '0',
  `signature` varchar(100) NOT NULL default '',
  `show_email` tinyint(1) NOT NULL default '0',
  `lastlogin` datetime default NULL,
  `errorlogins` bigint(20) NOT NULL default '0',
  `hash` varchar(100) NOT NULL default '',
  `newgroup` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `groupid` (`groupid`),
  KEY `newgroup` (`newgroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `usergroup`
-- 

CREATE TABLE `usergroup` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `userrights`
-- 

CREATE TABLE `userrights` (
  `id` bigint(20) NOT NULL auto_increment,
  `__createdon` datetime default NULL,
  `__changedon` datetime default NULL,
  `userright` varchar(100) NOT NULL default '',
  `usergroupid` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `usergroupid` (`usergroupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=160 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `army_view`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`w40k`@`localhost` SQL SECURITY DEFINER VIEW `w40k`.`army_view` AS select `a`.`id` AS `id`,`a`.`__createdon` AS `__createdon`,`a`.`__changedon` AS `__changedon`,`a`.`userid` AS `userid`,`a`.`commander` AS `commander`,`a`.`name` AS `name`,`a`.`codex` AS `codex`,`a`.`comment` AS `comment`,`a`.`points` AS `points`,`a`.`gamesystem` AS `gamesystem`,`c`.`name` AS `codexname`,`u`.`login` AS `username`,`g`.`name` AS `gamesystemname`,(select count(0) AS `count(*)` from `w40k`.`image` where ((`w40k`.`image`.`parent` = _latin1'army') and (`w40k`.`image`.`parentid` = `a`.`id`))) AS `icount` from (((`w40k`.`army` `a` join `w40k`.`codex` `c`) join `w40k`.`user` `u`) join `w40k`.`gamesystem` `g`) where ((`a`.`userid` = `u`.`id`) and (`a`.`codex` = `c`.`id`) and (`a`.`gamesystem` = `g`.`id`)) order by `a`.`id`;

-- --------------------------------------------------------

-- 
-- Table structure for table `battle_view`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`w40k`@`localhost` SQL SECURITY DEFINER VIEW `w40k`.`battle_view` AS select `b`.`id` AS `id`,`b`.`__createdon` AS `__createdon`,`b`.`__changedon` AS `__changedon`,`b`.`name` AS `name`,`b`.`comment` AS `comment`,`b`.`points` AS `points`,`b`.`player1` AS `player1`,`b`.`player2` AS `player2`,`b`.`winner` AS `winner`,`b`.`mission` AS `mission`,`b`.`day` AS `day`,`b`.`month` AS `month`,`b`.`year` AS `year`,`b`.`vp1` AS `vp1`,`b`.`vp2` AS `vp2`,`b`.`userid` AS `userid`,`b`.`battletypeid` AS `battletypeid`,`b`.`impdate` AS `impdate`,`b`.`realdate` AS `realdate`,`b`.`multibattle` AS `multibattle`,`b`.`gamesystem` AS `gamesystem`,`m`.`name` AS `missionname`,`bt`.`name` AS `battletypename`,(select count(0) AS `count(*)` from `w40k`.`image` where ((`w40k`.`image`.`parent` = _latin1'battle') and (`w40k`.`image`.`parentid` = `b`.`id`))) AS `icount` from ((`w40k`.`battle` `b` join `w40k`.`mission` `m`) join `w40k`.`battletype` `bt`) where ((`b`.`mission` = `m`.`id`) and (`b`.`battletypeid` = `bt`.`id`)) order by `b`.`id`;

-- --------------------------------------------------------

-- 
-- Table structure for table `questionaire_answercount_view`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`w40k`@`localhost` SQL SECURITY DEFINER VIEW `w40k`.`questionaire_answercount_view` AS select `q`.`questionaireid` AS `questionaireid`,count(distinct `qas`.`quserid`) AS `anzahl` from ((`w40k`.`question` `q` join `w40k`.`questionaireanswers` `qas`) join `w40k`.`questionanswer` `qa`) where ((`qas`.`questionanswerid` = `qa`.`id`) and (`qa`.`questionid` = `q`.`id`)) group by `q`.`questionaireid` order by `qas`.`quserid`,`q`.`id`;

-- --------------------------------------------------------

-- 
-- Table structure for table `questionaire_answertable_view`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`w40k`@`localhost` SQL SECURITY DEFINER VIEW `w40k`.`questionaire_answertable_view` AS select `q`.`sem_id` AS `sem_id`,`qas`.`questionanswervalue` AS `questionanswervalue`,`qas`.`quserid` AS `quserid`,`qas`.`__createdon` AS `__createdon`,`q`.`questionaireid` AS `questionaireid` from ((`w40k`.`question` `q` join `w40k`.`questionaireanswers` `qas`) join `w40k`.`questionanswer` `qa`) where ((`qas`.`questionanswerid` = `qa`.`id`) and (`qa`.`questionid` = `q`.`id`)) order by `q`.`id`,`qas`.`quserid`,`qas`.`__createdon`;

-- --------------------------------------------------------

-- 
-- Table structure for table `questionaire_users_view`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`w40k`@`localhost` SQL SECURITY DEFINER VIEW `w40k`.`questionaire_users_view` AS select distinct `qu`.`email` AS `email`,`q`.`questionaireid` AS `questionaireid` from (((`w40k`.`question` `q` join `w40k`.`questionaireanswers` `qas`) join `w40k`.`questionanswer` `qa`) join `w40k`.`questionaireuser` `qu`) where ((`qas`.`quserid` = `qu`.`id`) and (`qas`.`questionanswerid` = `qa`.`id`) and (`qa`.`questionid` = `q`.`id`)) order by `qas`.`quserid`,`q`.`id`;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_view`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`w40k`@`localhost` SQL SECURITY DEFINER VIEW `w40k`.`user_view` AS select `u`.`id` AS `id`,`u`.`__createdon` AS `__createdon`,`u`.`__changedon` AS `__changedon`,`u`.`login` AS `login`,`u`.`email` AS `email`,`u`.`password` AS `password`,`u`.`groupid` AS `groupid`,`u`.`signature` AS `signature`,`u`.`show_email` AS `show_email`,`u`.`lastlogin` AS `lastlogin`,`u`.`errorlogins` AS `errorlogins`,`u`.`hash` AS `hash`,`u`.`newgroup` AS `newgroup`,`ug1`.`name` AS `groupname`,`ug2`.`name` AS `newgroupname`,(select count(0) AS `count(*)` from `w40k`.`army` where (`w40k`.`army`.`userid` = `u`.`id`)) AS `armycount`,(select count(0) AS `count(*)` from `w40k`.`battle` where (`w40k`.`battle`.`userid` = `u`.`id`)) AS `battlecount` from ((`w40k`.`user` `u` left join `w40k`.`usergroup` `ug1` on((`u`.`groupid` = `ug1`.`id`))) left join `w40k`.`usergroup` `ug2` on((`u`.`newgroup` = `ug2`.`id`))) order by `u`.`id`;

-- --------------------------------------------------------

-- 
-- Table structure for table `userrights_view`
-- 

CREATE ALGORITHM=UNDEFINED DEFINER=`w40k`@`localhost` SQL SECURITY DEFINER VIEW `w40k`.`userrights_view` AS select `ur`.`id` AS `id`,`ur`.`__createdon` AS `__createdon`,`ur`.`__changedon` AS `__changedon`,`ur`.`userright` AS `userright`,`ur`.`usergroupid` AS `usergroupid`,`ug`.`name` AS `usergroupname` from (`w40k`.`userrights` `ur` join `w40k`.`usergroup` `ug`) where (`ur`.`usergroupid` = `ug`.`id`) order by `ur`.`id`;

-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `army`
-- 
ALTER TABLE `army`
  ADD CONSTRAINT `army_ibfk_1` FOREIGN KEY (`codex`) REFERENCES `codex` (`id`),
  ADD CONSTRAINT `army_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `army_ibfk_3` FOREIGN KEY (`gamesystem`) REFERENCES `gamesystem` (`id`);

-- 
-- Constraints for table `battle`
-- 
ALTER TABLE `battle`
  ADD CONSTRAINT `battle_ibfk_1` FOREIGN KEY (`player1`) REFERENCES `army` (`id`),
  ADD CONSTRAINT `battle_ibfk_2` FOREIGN KEY (`player2`) REFERENCES `army` (`id`),
  ADD CONSTRAINT `battle_ibfk_3` FOREIGN KEY (`mission`) REFERENCES `mission` (`id`),
  ADD CONSTRAINT `battle_ibfk_4` FOREIGN KEY (`userid`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `battle_ibfk_5` FOREIGN KEY (`battletypeid`) REFERENCES `battletype` (`id`),
  ADD CONSTRAINT `battle_ibfk_6` FOREIGN KEY (`multibattle`) REFERENCES `multibattle` (`id`),
  ADD CONSTRAINT `battle_ibfk_7` FOREIGN KEY (`gamesystem`) REFERENCES `gamesystem` (`id`);

-- 
-- Constraints for table `battletype`
-- 
ALTER TABLE `battletype`
  ADD CONSTRAINT `battletype_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `battletype` (`id`);

-- 
-- Constraints for table `codex`
-- 
ALTER TABLE `codex`
  ADD CONSTRAINT `codex_ibfk_1` FOREIGN KEY (`gamesystem`) REFERENCES `gamesystem` (`id`);

-- 
-- Constraints for table `filecategory`
-- 
ALTER TABLE `filecategory`
  ADD CONSTRAINT `filecategory_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `filecategory` (`id`);

-- 
-- Constraints for table `image`
-- 
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`imagecategoryid`) REFERENCES `filecategory` (`id`);

-- 
-- Constraints for table `mission`
-- 
ALTER TABLE `mission`
  ADD CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`gamesystem`) REFERENCES `gamesystem` (`id`);

-- 
-- Constraints for table `multibattlearmy`
-- 
ALTER TABLE `multibattlearmy`
  ADD CONSTRAINT `multibattlearmy_ibfk_1` FOREIGN KEY (`army_id`) REFERENCES `army` (`id`),
  ADD CONSTRAINT `multibattlearmy_ibfk_2` FOREIGN KEY (`multibattle`) REFERENCES `multibattle` (`id`);

-- 
-- Constraints for table `user`
-- 
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`groupid`) REFERENCES `usergroup` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`newgroup`) REFERENCES `usergroup` (`id`) ON DELETE SET NULL;

-- 
-- Constraints for table `userrights`
-- 
ALTER TABLE `userrights`
  ADD CONSTRAINT `userrights_ibfk_1` FOREIGN KEY (`usergroupid`) REFERENCES `usergroup` (`id`) ON DELETE CASCADE;
