--remove the rest of seawars

CREATE TABLE `allianz` (
  `id` bigint(20) NOT NULL auto_increment,
  `tag` varchar(10) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `kurzbeschreibung` text NOT NULL,
  `beschreibung` longtext NOT NULL,
  `nimmtauf` tinyint(4) NOT NULL default '1',
  `bildurl` varchar(200) default NULL,
  `leader_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tag` (`tag`,`name`)
) TYPE=MyISAM;
ALTER TABLE `allianz` ADD `__createdon` DATETIME;
ALTER TABLE `allianz` ADD `__changedon` DATETIME;

CREATE TABLE `archipel` (
  `id` bigint(20) NOT NULL default '0',
  `x_pos` bigint(20) NOT NULL default '0',
  `y_pos` bigint(20) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  `kartenabschnitt_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `x_pos` (`x_pos`,`y_pos`,`kartenabschnitt_id`)
) TYPE=MyISAM;
ALTER TABLE `archipel` ADD `groessenklasse` TINYINT DEFAULT '1' NOT NULL ;
ALTER TABLE `archipel` CHANGE `id` `id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE archipel ADD `__createdon` DATETIME;
ALTER TABLE archipel ADD `__changedon` DATETIME;

CREATE TABLE `bauplan` (
  `id` bigint(20) NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
ALTER TABLE bauplan ADD `__createdon` DATETIME;
ALTER TABLE bauplan ADD `__changedon` DATETIME;

CREATE TABLE `bauplan_enthaelt` (
  `bauplan_id` bigint(20) NOT NULL default '0',
  `tech_id` bigint(20) NOT NULL default '0',
  `anzahl` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`bauplan_id`,`tech_id`)
) TYPE=MyISAM;
ALTER TABLE bauplan_enthaelt ADD `__createdon` DATETIME;
ALTER TABLE bauplan_enthaelt ADD `__changedon` DATETIME;

CREATE TABLE `flotte` (
  `id` bigint(20) NOT NULL auto_increment,
  `auftrag` bigint(20) NOT NULL default '0',
  `x_pos` bigint(20) NOT NULL default '0',
  `y_pos` bigint(20) NOT NULL default '0',
  `ankunft` timestamp NOT NULL,
  `timestamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
ALTER TABLE flotte ADD `__createdon` DATETIME;
ALTER TABLE flotte ADD `__changedon` DATETIME;
UPDATE flotte SET __createdon=timestamp, __changedon=timestamp;
ALTER TABLE flotte DROP COLUMN timestamp;

CREATE TABLE `hatbuendnissmit` (
  `antragsteller_id` bigint(20) NOT NULL default '0',
  `antragempfaenger_id` bigint(20) NOT NULL default '0',
  `typ` tinyint(4) NOT NULL default '0',
  `commit` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`antragsteller_id`,`antragempfaenger_id`)
) TYPE=MyISAM;
ALTER TABLE hatbuendnissmit ADD `__createdon` DATETIME;
ALTER TABLE hatbuendnissmit ADD `__changedon` DATETIME;

CREATE TABLE `hatquest` (
  `quest_id` bigint(20) NOT NULL default '0',
  `spieler_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`quest_id`,`spieler_id`)
) TYPE=MyISAM;
ALTER TABLE hatquest ADD `__createdon` DATETIME;
ALTER TABLE hatquest ADD `__changedon` DATETIME;

CREATE TABLE `insel` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `groesse` int(11) NOT NULL default '0',
  `x_pos` bigint(20) NOT NULL default '0',
  `y_pos` bigint(20) NOT NULL default '0',
  `spieler_id` bigint(20) NOT NULL default '0',
  `archipel_id` bigint(20) NOT NULL default '0',
  `timestamp` timestamp NOT NULL,
  `lager_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `lager_id` (`lager_id`)
) TYPE=MyISAM;
ALTER TABLE insel ADD `__createdon` DATETIME;
ALTER TABLE insel ADD `__changedon` DATETIME;
UPDATE insel SET __createdon=timestamp, __changedon=timestamp;
ALTER TABLE insel DROP COLUMN timestamp;

CREATE TABLE `istinallianz` (
  `allianz_id` bigint(20) NOT NULL default '0',
  `spieler_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`allianz_id`,`spieler_id`)
) TYPE=MyISAM;
ALTER TABLE istinallianz ADD `__createdon` DATETIME;
ALTER TABLE istinallianz ADD `__changedon` DATETIME;

CREATE TABLE `kartenabschnitt` (
  `id` bigint(20) NOT NULL default '0',
  `links_id` bigint(20) NOT NULL default '0',
  `rechts_id` bigint(20) NOT NULL default '0',
  `welt_id` bigint(20) NOT NULL default '0',
  `kartennummer` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `links_id` (`links_id`,`rechts_id`,`welt_id`,`kartennummer`)
) TYPE=MyISAM;
ALTER TABLE kartenabschnitt ADD `__createdon` DATETIME;
ALTER TABLE kartenabschnitt ADD `__changedon` DATETIME;

CREATE TABLE `lager` (
  `id` bigint(20) NOT NULL auto_increment,
  `kapazitaet` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
ALTER TABLE lager ADD `__createdon` DATETIME;
ALTER TABLE lager ADD `__changedon` DATETIME;

CREATE TABLE `lagerenthaelt` (
  `lager_id` bigint(20) NOT NULL default '0',
  `rohstoff_id` bigint(20) NOT NULL default '0',
  `anzahl` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`lager_id`,`rohstoff_id`)
) TYPE=MyISAM;
ALTER TABLE lagerenthaelt ADD `__createdon` DATETIME;
ALTER TABLE lagerenthaelt ADD `__changedon` DATETIME;

CREATE TABLE `mitteilung` (
  `id` bigint(20) NOT NULL auto_increment,
  `sender` bigint(20) NOT NULL default '0',
  `empfaenger` bigint(20) NOT NULL default '0',
  `datum` date NOT NULL default '0000-00-00',
  `uhrzeit` time NOT NULL default '00:00:00',
  `betreff` varchar(100) default 'kein Betreff',
  `inhalt` longtext,
  `gelesen` tinyint(4) NOT NULL default '0',
  `geloescht_sender` tinyint(4) NOT NULL default '0',
  `geloescht_empfaenger` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
ALTER TABLE `mitteilung` DROP `uhrzeit` ;
ALTER TABLE `mitteilung` CHANGE `datum` `datum` TIMESTAMP NOT NULL ;
ALTER TABLE `mitteilung` ADD `art` TINYINT( 4 ) NOT NULL AFTER `inhalt` ;
ALTER TABLE mitteilung ADD `__createdon` DATETIME;
ALTER TABLE mitteilung ADD `__changedon` DATETIME;
UPDATE mitteilung SET __createdon=datum, __changedon=datum;
ALTER TABLE mitteilung DROP COLUMN datum;

CREATE TABLE `quest` (
  `id` bigint(20) NOT NULL auto_increment,
  `kurzbeschreibung` text NOT NULL,
  `beschreibung` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
ALTER TABLE quest ADD `__createdon` DATETIME;
ALTER TABLE quest ADD `__changedon` DATETIME;

CREATE TABLE `rohstoff` (
  `id` bigint(20) NOT NULL auto_increment,
  `sem_id` varchar(10) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `beschreibung` text,
  `grafik_url` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sem_id` (`sem_id`),
  UNIQUE KEY `sem_id_2` (`sem_id`)
) TYPE=MyISAM;
ALTER TABLE `rohstoff` ADD `min_archipel_groessenklasse` TINYINT DEFAULT '1' NOT NULL ,
	ADD `max_archipel_groessenklasse` TINYINT DEFAULT '1' NOT NULL ;
ALTER TABLE rohstoff ADD `__createdon` DATETIME;
ALTER TABLE rohstoff ADD `__changedon` DATETIME;

CREATE TABLE `rohstoffproduktion` (
  `insel_id` bigint(20) NOT NULL default '0',
  `rohstoff_id` bigint(20) NOT NULL default '0',
  `wachstum_prozent` int(11) NOT NULL default '0',
  `produktion_stunde` int(11) NOT NULL default '0',
  PRIMARY KEY  (`insel_id`,`rohstoff_id`)
) TYPE=MyISAM;
ALTER TABLE rohstoffproduktion ADD `__createdon` DATETIME;
ALTER TABLE rohstoffproduktion ADD `__changedon` DATETIME;

CREATE TABLE `rohstoffshop` (
  `id` bigint(20) NOT NULL default '0',
  `insel_id` bigint(20) NOT NULL default '0',
  `lager_id` bigint(20) NOT NULL default '0',
  `umsatz` double NOT NULL default '0',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `insel_id` (`insel_id`,`lager_id`)
) TYPE=MyISAM;
ALTER TABLE rohstoffshop ADD `__createdon` DATETIME;
ALTER TABLE rohstoffshop ADD `__changedon` DATETIME;

CREATE TABLE `rohstoffverkauf` (
  `rohstoffshop_id` bigint(20) NOT NULL default '0',
  `rohstoff_id` bigint(20) NOT NULL default '0',
  `minBestand` bigint(20) NOT NULL default '0',
  `preis` double NOT NULL default '0',
  PRIMARY KEY  (`rohstoffshop_id`,`rohstoff_id`)
) TYPE=MyISAM;
ALTER TABLE rohstoffverkauf ADD `__createdon` DATETIME;
ALTER TABLE rohstoffverkauf ADD `__changedon` DATETIME;

CREATE TABLE `schiff` (
  `id` bigint(20) NOT NULL auto_increment,
  `flotten_id` bigint(20) NOT NULL default '0',
  `wendigkeit` double NOT NULL default '0',
  `geschwindigkeit` double NOT NULL default '0',
  `gefechtsgeschwindigkeit` double NOT NULL default '0',
  `enterkampfwert` double NOT NULL default '0',
  `lager_id` bigint(20) NOT NULL default '0',
  `erfahrungsstufe` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `flotten_id` (`flotten_id`)
) TYPE=MyISAM;
ALTER TABLE schiff ADD `__createdon` DATETIME;
ALTER TABLE schiff ADD `__changedon` DATETIME;

CREATE TABLE `seawars` (
  `id` bigint(20) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
ALTER TABLE seawars ADD `__createdon` DATETIME;
ALTER TABLE seawars ADD `__changedon` DATETIME;

CREATE TABLE `spieler` (
  `id` bigint(20) NOT NULL auto_increment,
  `email` varchar(200) NOT NULL default '',
  `username` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `name` varchar(200) NOT NULL default '',
  `vorname` varchar(200) NOT NULL default '',
  `telefonnummer` varchar(50) NOT NULL default '',
  `bezahlt_bis` date NOT NULL default '0000-00-00',
  `welt_id` bigint(20) NOT NULL default '1',
  `avatar` varchar(200) default NULL,
  `signatur` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`,`welt_id`)
) TYPE=MyISAM;
ALTER TABLE `spieler` DROP `bezahlt_bis`;
ALTER TABLE `spieler` ADD `hash` VARCHAR( 100 ) NOT NULL ,
	ADD `confirmed` TINYINT DEFAULT '0' NOT NULL ;
ALTER TABLE spieler ADD `__createdon` DATETIME;
ALTER TABLE spieler ADD `__changedon` DATETIME;

CREATE TABLE `ttcategory` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
);
ALTER TABLE ttcategory ADD `__createdon` DATETIME;
ALTER TABLE ttcategory ADD `__changedon` DATETIME;

CREATE TABLE `ttentry` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `tttypeid` bigint(20) NOT NULL default '0',
  `imageid` bigint(20) NOT NULL default '0',
  `ttcategoryid` bigint(20) NOT NULL default '0',
  `aufwand` bigint(20) NOT NULL default '100',
  `res1_abs` tinyint(4) NOT NULL default '0',
  `res2_abs` tinyint(4) NOT NULL default '0',
  `res3_abs` tinyint(4) NOT NULL default '0',
  `res4_abs` tinyint(4) NOT NULL default '0',
  `res5_abs` tinyint(4) NOT NULL default '0',
  `res6_abs` tinyint(4) NOT NULL default '0',
  `res7_abs` tinyint(4) NOT NULL default '0',
  `res8_abs` tinyint(4) NOT NULL default '0',
  `res9_abs` tinyint(4) NOT NULL default '0',
  `res10_abs` tinyint(4) NOT NULL default '0',
  `morale_pc` tinyint(4) NOT NULL default '0',
  `money_abs` tinyint(4) NOT NULL default '0',
  `maxpopulation_pc` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
);
ALTER TABLE `ttentry`
  DROP `res1_abs`,
  DROP `res2_abs`,
  DROP `res3_abs`,
  DROP `res4_abs`,
  DROP `res5_abs`,
  DROP `res6_abs`,
  DROP `res7_abs`,
  DROP `res8_abs`,
  DROP `res9_abs`,
  DROP `res10_abs`;
ALTER TABLE `ttentry`
	CHANGE `morale_pc` `morale_pc` TINYINT( 4 ) DEFAULT '0' NOT NULL ,
	CHANGE `money_abs` `money_build` TINYINT( 4 ) DEFAULT '0' NOT NULL ,
	CHANGE `maxpopulation_pc` `maxpopulation_pc` TINYINT( 4 ) DEFAULT '0' NOT NULL
ALTER TABLE `ttentry`
	ADD `money_cost` BIGINT NOT NULL AFTER `money_build` ;
ALTER TABLE `ttentry`
	ADD `max_per_island` INT DEFAULT '0' NOT NULL ,
	ADD `max_per_player` INT DEFAULT '0' NOT NULL ,
	ADD `max_per_archipel` INT DEFAULT '0' NOT NULL ,
	ADD `max_per_ship` INT DEFAULT '0' NOT NULL ;
INSERT INTO `ttentry`
	( `id` ,`name` , `description` , `tttypeid` , `imageid` , `ttcategoryid` , `aufwand` , `morale_pc` , `money_build` , `money_cost` , `maxpopulation_pc` , `max_per_island` , `max_per_player` , `max_per_archipel` , `max_per_ship` )
VALUES
	('0', 'RootTech', 'The Source of all', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
ALTER TABLE ttentry ADD `__createdon` DATETIME;
ALTER TABLE ttentry ADD `__changedon` DATETIME;

CREATE TABLE `ttentrydependson` (
  `id` bigint(20) NOT NULL,
  `entry_id` bigint(20) NOT NULL default '0',
  `dependson_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `entry_id` (`entry_id`,`dependson_id`)
);
ALTER TABLE ttentrydependson ADD `__createdon` DATETIME;
ALTER TABLE ttentrydependson ADD `__changedon` DATETIME;

CREATE TABLE `ttentryrohstoff` (
  `rohstoffid` bigint(20) NOT NULL default '0',
  `ttentry_resid` tinyint(3) NOT NULL default '0',
  `id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `rohstoffid` (`rohstoffid`)
);
ALTER TABLE `ttentryrohstoff`
	CHANGE `ttentry_resid` `ttentry_id` BIGINT DEFAULT '0' NOT NULL;
ALTER TABLE `ttentryrohstoff`
	ADD	`res_cost` BIGINT DEFAULT '0' NOT NULL ,
	ADD `res_build` BIGINT DEFAULT '0' NOT NULL ;
ALTER TABLE ttentryrohstoff ADD `__createdon` DATETIME;
ALTER TABLE ttentryrohstoff ADD `__changedon` DATETIME;

CREATE TABLE `ttexplored` (
  `id` bigint(20) NOT NULL,
  `spieler_id` bigint(20) NOT NULL default '0',
  `techtree_entry_id` bigint(20) NOT NULL default '0',
  `start` timestamp NOT NULL default '0000-00-00 00:00:00',
  `end` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `spieler_id` (`spieler_id`,`techtree_entry_id`)
);
ALTER TABLE `ttexplored`
	ADD `finished` TINYINT DEFAULT '0' NOT NULL ;
ALTER TABLE `ttexplored` ADD INDEX ( `finished` ) ;
ALTER TABLE ttexplored ADD `__createdon` DATETIME;
ALTER TABLE ttexplored ADD `__changedon` DATETIME;

CREATE TABLE `tttype` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL default '',
  `beschreibung` text NOT NULL,
  PRIMARY KEY  (`id`)
);
ALTER TABLE tttype ADD `__createdon` DATETIME;
ALTER TABLE tttype ADD `__changedon` DATETIME;

CREATE TABLE `welt` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
ALTER TABLE welt ADD `__createdon` DATETIME;
ALTER TABLE welt ADD `__changedon` DATETIME;
	
INSERT INTO dbversion(sql_id, sql_subid) VALUES (36, 0);
