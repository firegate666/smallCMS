--
-- Tabellenstruktur für Tabelle `allianz`
--

CREATE TABLE IF NOT EXISTS `allianz` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `kurzbeschreibung` text NOT NULL,
  `beschreibung` longtext NOT NULL,
  `nimmtauf` tinyint(4) NOT NULL DEFAULT '1',
  `bildurl` varchar(200) DEFAULT NULL,
  `leader_id` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`,`name`),
  KEY `leader_id` (`leader_id`),
  KEY `name` (`name`),
  KEY `tag_2` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `archipel`
--

CREATE TABLE IF NOT EXISTS `archipel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `x_pos` bigint(20) NOT NULL DEFAULT '0',
  `y_pos` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `kartenabschnitt_id` bigint(20) NOT NULL DEFAULT '0',
  `groessenklasse` tinyint(4) NOT NULL DEFAULT '1',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `x_pos` (`x_pos`,`y_pos`,`kartenabschnitt_id`),
  KEY `kartenabschnitt_id` (`kartenabschnitt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `army`
--

CREATE TABLE IF NOT EXISTS `army` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `userid` bigint(20) NOT NULL DEFAULT '0',
  `commander` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `codex` bigint(20) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `points` int(11) DEFAULT NULL,
  `gamesystem` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `codex` (`codex`),
  KEY `userid` (`userid`),
  KEY `gamesystem` (`gamesystem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `battle`
--

CREATE TABLE IF NOT EXISTS `battle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `points` int(11) DEFAULT NULL,
  `player1` bigint(20) NOT NULL DEFAULT '0',
  `player2` bigint(20) NOT NULL DEFAULT '0',
  `winner` tinyint(4) NOT NULL DEFAULT '0',
  `mission` bigint(20) NOT NULL DEFAULT '0',
  `day` int(11) NOT NULL DEFAULT '0',
  `month` int(11) NOT NULL DEFAULT '0',
  `year` int(11) NOT NULL DEFAULT '0',
  `vp1` int(11) NOT NULL DEFAULT '0',
  `vp2` int(11) NOT NULL DEFAULT '0',
  `userid` bigint(20) NOT NULL DEFAULT '0',
  `battletypeid` bigint(20) NOT NULL DEFAULT '0',
  `impdate` varchar(20) NOT NULL DEFAULT '',
  `realdate` date NOT NULL DEFAULT '0000-00-00',
  `multibattle` bigint(20) DEFAULT '0',
  `gamesystem` bigint(20) NOT NULL DEFAULT '0',
  `score_t3` tinyint(4) NOT NULL DEFAULT '0',
  `score_1` int(11) NOT NULL DEFAULT '0',
  `score_2` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `multibattle` (`multibattle`),
  KEY `player1` (`player1`),
  KEY `player2` (`player2`),
  KEY `mission` (`mission`),
  KEY `userid` (`userid`),
  KEY `battletypeid` (`battletypeid`),
  KEY `gamesystem` (`gamesystem`),
  KEY `score_t3` (`score_t3`,`score_1`,`score_2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `battletype`
--

CREATE TABLE IF NOT EXISTS `battletype` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `parent` bigint(20) DEFAULT '0',
  `sortfirst` varchar(10) NOT NULL DEFAULT '',
  `sortsecond` varchar(10) NOT NULL DEFAULT '',
  `sortthird` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bauplan`
--

CREATE TABLE IF NOT EXISTS `bauplan` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bauplan_enthaelt`
--

CREATE TABLE IF NOT EXISTS `bauplan_enthaelt` (
  `bauplan_id` bigint(20) NOT NULL DEFAULT '0',
  `tech_id` bigint(20) NOT NULL DEFAULT '0',
  `anzahl` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`bauplan_id`,`tech_id`),
  KEY `bauplan_id` (`bauplan_id`),
  KEY `tech_id` (`tech_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `codex`
--

CREATE TABLE IF NOT EXISTS `codex` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `commander` varchar(100) NOT NULL DEFAULT '',
  `founding` varchar(100) NOT NULL DEFAULT '',
  `homeplanet` varchar(100) NOT NULL DEFAULT '',
  `followers` text NOT NULL,
  `colors` text NOT NULL,
  `specialized` text NOT NULL,
  `favunit` varchar(100) NOT NULL DEFAULT '',
  `favweapon` varchar(100) NOT NULL DEFAULT '',
  `reputation` text NOT NULL,
  `actstrength` text NOT NULL,
  `archenemy` varchar(100) NOT NULL DEFAULT '',
  `groupname` varchar(10) DEFAULT NULL,
  `gamesystem` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gamesystem` (`gamesystem`),
  KEY `gamesystem_2` (`gamesystem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dbversion`
--

CREATE TABLE IF NOT EXISTS `dbversion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `sql_id` bigint(20) NOT NULL DEFAULT '0',
  `sql_subid` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sql_id` (`sql_id`,`sql_subid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `dbversion`
--

INSERT INTO `dbversion` (`id`, `__createdon`, `__changedon`, `sql_id`, `sql_subid`) VALUES
(1, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `extendible`
--

CREATE TABLE IF NOT EXISTS `extendible` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `parent` varchar(100) NOT NULL DEFAULT '',
  `parentid` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`parent`,`parentid`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `filecategory`
--

CREATE TABLE IF NOT EXISTS `filecategory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `parent` bigint(20) DEFAULT NULL,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `flotte`
--

CREATE TABLE IF NOT EXISTS `flotte` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `auftrag` bigint(20) NOT NULL DEFAULT '0',
  `x_pos` bigint(20) NOT NULL DEFAULT '0',
  `y_pos` bigint(20) NOT NULL DEFAULT '0',
  `ankunft` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(100) NOT NULL DEFAULT '',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auftrag` (`auftrag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gamesystem`
--

CREATE TABLE IF NOT EXISTS `gamesystem` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `guestbook`
--

CREATE TABLE IF NOT EXISTS `guestbook` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `email` varchar(200) DEFAULT NULL,
  `subject` varchar(200) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hatbuendnissmit`
--

CREATE TABLE IF NOT EXISTS `hatbuendnissmit` (
  `antragsteller_id` bigint(20) NOT NULL DEFAULT '0',
  `antragempfaenger_id` bigint(20) NOT NULL DEFAULT '0',
  `typ` tinyint(4) NOT NULL DEFAULT '0',
  `commit` tinyint(4) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`antragsteller_id`,`antragempfaenger_id`),
  KEY `antragsteller_id` (`antragsteller_id`),
  KEY `antragempfaenger_id` (`antragempfaenger_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hatquest`
--

CREATE TABLE IF NOT EXISTS `hatquest` (
  `quest_id` bigint(20) NOT NULL DEFAULT '0',
  `spieler_id` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`quest_id`,`spieler_id`),
  KEY `quest_id` (`quest_id`),
  KEY `spieler_id` (`spieler_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `imagecategoryid` bigint(20) DEFAULT NULL,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `parent` varchar(100) NOT NULL DEFAULT '',
  `parentid` bigint(20) NOT NULL DEFAULT '0',
  `size` bigint(20) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '',
  `prio` bigint(20) NOT NULL DEFAULT '0',
  `emoticon` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`parent`,`parentid`),
  KEY `imagecategoryid` (`imagecategoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `insel`
--

CREATE TABLE IF NOT EXISTS `insel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `groesse` int(11) NOT NULL DEFAULT '0',
  `x_pos` bigint(20) NOT NULL DEFAULT '0',
  `y_pos` bigint(20) NOT NULL DEFAULT '0',
  `spieler_id` bigint(20) DEFAULT '0',
  `archipel_id` bigint(20) NOT NULL DEFAULT '0',
  `lager_id` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lager_id` (`lager_id`),
  KEY `spieler_id` (`spieler_id`),
  KEY `archipel_id` (`archipel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `istinallianz`
--

CREATE TABLE IF NOT EXISTS `istinallianz` (
  `allianz_id` bigint(20) NOT NULL DEFAULT '0',
  `spieler_id` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`allianz_id`,`spieler_id`),
  KEY `allianz_id` (`allianz_id`),
  KEY `spieler_id` (`spieler_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kartenabschnitt`
--

CREATE TABLE IF NOT EXISTS `kartenabschnitt` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `links_id` bigint(20) NOT NULL DEFAULT '0',
  `rechts_id` bigint(20) NOT NULL DEFAULT '0',
  `welt_id` bigint(20) NOT NULL DEFAULT '0',
  `kartennummer` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kartennummer` (`kartennummer`),
  KEY `rechts_id` (`rechts_id`),
  KEY `links_id` (`links_id`),
  KEY `welt_id` (`welt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lager`
--

CREATE TABLE IF NOT EXISTS `lager` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kapazitaet` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lagerenthaelt`
--

CREATE TABLE IF NOT EXISTS `lagerenthaelt` (
  `lager_id` bigint(20) NOT NULL DEFAULT '0',
  `rohstoff_id` bigint(20) NOT NULL DEFAULT '0',
  `anzahl` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`lager_id`,`rohstoff_id`),
  KEY `lager_id` (`lager_id`),
  KEY `rohstoff_id` (`rohstoff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mailer`
--

CREATE TABLE IF NOT EXISTS `mailer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `mto` text NOT NULL,
  `msubject` text NOT NULL,
  `mbody` text NOT NULL,
  `mheader` text NOT NULL,
  `mstate` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `sender` bigint(20) NOT NULL DEFAULT '0',
  `receiver` bigint(20) NOT NULL DEFAULT '0',
  `subject` varchar(250) NOT NULL DEFAULT '0',
  `body` text NOT NULL,
  `unread` tinyint(4) NOT NULL DEFAULT '1',
  `sender_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `receiver_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `read_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `receiver` (`receiver`),
  KEY `sender_deleted` (`sender_deleted`),
  KEY `receiver_deleted` (`receiver_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mission`
--

CREATE TABLE IF NOT EXISTS `mission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` varchar(100) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `category` text NOT NULL,
  `ruleset` text NOT NULL,
  `rounds` varchar(100) NOT NULL DEFAULT '0',
  `source` text NOT NULL,
  `gamesystem` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gamesystem` (`gamesystem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitteilung`
--

CREATE TABLE IF NOT EXISTS `mitteilung` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender` bigint(20) NOT NULL DEFAULT '0',
  `empfaenger` bigint(20) NOT NULL DEFAULT '0',
  `betreff` varchar(100) DEFAULT 'kein Betreff',
  `inhalt` longtext,
  `art` tinyint(4) NOT NULL,
  `gelesen` tinyint(4) NOT NULL DEFAULT '0',
  `geloescht_sender` tinyint(4) NOT NULL DEFAULT '0',
  `geloescht_empfaenger` tinyint(4) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `empfaenger` (`empfaenger`),
  KEY `gelesen` (`gelesen`),
  KEY `geloescht_sender` (`geloescht_sender`),
  KEY `geloescht_empfaenger` (`geloescht_empfaenger`),
  KEY `art` (`art`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `multibattle`
--

CREATE TABLE IF NOT EXISTS `multibattle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `multibattlearmy`
--

CREATE TABLE IF NOT EXISTS `multibattlearmy` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `__changedon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `multibattle` bigint(20) NOT NULL DEFAULT '0',
  `army_id` bigint(20) NOT NULL DEFAULT '0',
  `player` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `multibattle` (`multibattle`),
  KEY `army_id` (`army_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pagestatistic`
--

CREATE TABLE IF NOT EXISTS `pagestatistic` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `template` varchar(200) NOT NULL DEFAULT '',
  `user` bigint(20) DEFAULT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `pagestatistic`
--

INSERT INTO `pagestatistic` (`id`, `template`, `user`, `ip`, `__createdon`, `__changedon`) VALUES
(1, 'login', NULL, '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'css', NULL, '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'css', 1, '127.0.0.1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `quest`
--

CREATE TABLE IF NOT EXISTS `quest` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kurzbeschreibung` text NOT NULL,
  `beschreibung` longtext NOT NULL,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `name` text NOT NULL,
  `sem_id` varchar(100) NOT NULL DEFAULT '',
  `blockname` varchar(100) NOT NULL DEFAULT '',
  `groupname` varchar(100) NOT NULL DEFAULT '',
  `questionaireid` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_SEM_QID` (`sem_id`,`questionaireid`),
  KEY `questionaireid` (`questionaireid`),
  KEY `groupname` (`groupname`),
  KEY `blockname` (`blockname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `questionaire`
--

CREATE TABLE IF NOT EXISTS `questionaire` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `author` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(200) NOT NULL DEFAULT '',
  `shortdesc` varchar(200) NOT NULL DEFAULT '',
  `longdesc` text NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT '0',
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  `layout_main` bigint(20) NOT NULL DEFAULT '0',
  `layout_end` bigint(20) NOT NULL DEFAULT '0',
  `layout_question` bigint(20) NOT NULL DEFAULT '0',
  `layout_question_alt` bigint(20) DEFAULT NULL,
  `userid` bigint(20) NOT NULL DEFAULT '0',
  `randompages` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `questionaireanswers`
--

CREATE TABLE IF NOT EXISTS `questionaireanswers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `questionanswerid` bigint(20) NOT NULL DEFAULT '0',
  `questionanswervalue` text NOT NULL,
  `quserid` bigint(20) NOT NULL DEFAULT '0',
  `confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `verified` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `questionanswerid` (`questionanswerid`),
  KEY `quserid` (`quserid`),
  KEY `confirmed` (`confirmed`),
  KEY `verified` (`verified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `questionaireuser`
--

CREATE TABLE IF NOT EXISTS `questionaireuser` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `lastquestionaire` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `password` (`password`),
  KEY `lastquestionaire` (`lastquestionaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `questionanswer`
--

CREATE TABLE IF NOT EXISTS `questionanswer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `questionid` bigint(20) NOT NULL DEFAULT '0',
  `answertype` bigint(20) NOT NULL DEFAULT '0',
  `sortid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `questionid` (`questionid`),
  KEY `answertype` (`answertype`),
  KEY `sortid` (`sortid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `questionanswertype`
--

CREATE TABLE IF NOT EXISTS `questionanswertype` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `layout` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rohstoff`
--

CREATE TABLE IF NOT EXISTS `rohstoff` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sem_id` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `beschreibung` text,
  `grafik_url` varchar(200) NOT NULL DEFAULT '',
  `min_archipel_groessenklasse` tinyint(4) NOT NULL DEFAULT '1',
  `max_archipel_groessenklasse` tinyint(4) NOT NULL DEFAULT '1',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sem_id` (`sem_id`),
  UNIQUE KEY `sem_id_2` (`sem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rohstoffproduktion`
--

CREATE TABLE IF NOT EXISTS `rohstoffproduktion` (
  `insel_id` bigint(20) NOT NULL DEFAULT '0',
  `rohstoff_id` bigint(20) NOT NULL DEFAULT '0',
  `wachstum_prozent` int(11) NOT NULL DEFAULT '0',
  `produktion_stunde` int(11) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`insel_id`,`rohstoff_id`),
  KEY `insel_id` (`insel_id`),
  KEY `rohstoff_id` (`rohstoff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rohstoffshop`
--

CREATE TABLE IF NOT EXISTS `rohstoffshop` (
  `id` bigint(20) NOT NULL DEFAULT '0',
  `insel_id` bigint(20) NOT NULL DEFAULT '0',
  `lager_id` bigint(20) NOT NULL DEFAULT '0',
  `umsatz` double NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `insel_id` (`insel_id`,`lager_id`),
  KEY `insel_id_2` (`insel_id`),
  KEY `lager_id` (`lager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rohstoffverkauf`
--

CREATE TABLE IF NOT EXISTS `rohstoffverkauf` (
  `rohstoffshop_id` bigint(20) NOT NULL DEFAULT '0',
  `rohstoff_id` bigint(20) NOT NULL DEFAULT '0',
  `minBestand` bigint(20) NOT NULL DEFAULT '0',
  `preis` double NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`rohstoffshop_id`,`rohstoff_id`),
  KEY `rohstoff_id` (`rohstoff_id`),
  KEY `rohstoffshop_id` (`rohstoffshop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schiff`
--

CREATE TABLE IF NOT EXISTS `schiff` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `flotten_id` bigint(20) DEFAULT '0',
  `wendigkeit` double NOT NULL DEFAULT '0',
  `geschwindigkeit` double NOT NULL DEFAULT '0',
  `gefechtsgeschwindigkeit` double NOT NULL DEFAULT '0',
  `enterkampfwert` double NOT NULL DEFAULT '0',
  `lager_id` bigint(20) NOT NULL DEFAULT '0',
  `erfahrungsstufe` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flotten_id` (`flotten_id`),
  KEY `flotten_id_2` (`flotten_id`),
  KEY `lager_id` (`lager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `seawars`
--

CREATE TABLE IF NOT EXISTS `seawars` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `sid` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT '0',
  `client_ip` varchar(15) NOT NULL DEFAULT '',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `value` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Daten für Tabelle `setting`
--

INSERT INTO `setting` (`id`, `name`, `value`, `description`, `__createdon`, `__changedon`) VALUES
(12, 'timestampformat', '%Y-%m-%d %H:%M:%S', 'Timestamp Format', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'message_defaultpagelimit', '', 'Message Default Pagelimit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'defaultgroup', '', 'Default Usergroup', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'moderated_guestbook', '1', 'Moderated Guestbook? (1=true, 2=false)', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'email_guestbookadmin', 'false', 'Email Guestbookadmin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'pwdstyle', '(\\\\w|\\\\d){5,}', 'Password complexity (regex)', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'systememail', 'noreply@sea-wars.de', 'System Email Address', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'gamespeed', '1', 'Game Speed Faktor', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'baseurl', 'http://www.sea-wars.de/game2/index.php', 'System Base Url', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'ttpointsfaktor', '0.1', 'Faktor mit denen erforschte Techs in die Punktzahl eingehen', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'charset', 'ISO-8859-1', 'Charset', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spieler`
--

CREATE TABLE IF NOT EXISTS `spieler` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(200) NOT NULL DEFAULT '',
  `vorname` varchar(200) NOT NULL DEFAULT '',
  `telefonnummer` varchar(50) NOT NULL DEFAULT '',
  `welt_id` bigint(20) NOT NULL DEFAULT '1',
  `avatar` varchar(200) DEFAULT NULL,
  `signatur` text,
  `hash` varchar(100) NOT NULL,
  `confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`welt_id`),
  KEY `welt_id` (`welt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `class` varchar(25) NOT NULL DEFAULT '',
  `layout` varchar(25) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `backup` text NOT NULL,
  `contenttype` varchar(100) NOT NULL DEFAULT 'text/html',
  PRIMARY KEY (`id`),
  UNIQUE KEY `class` (`class`,`layout`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `template`
--

INSERT INTO `template` (`id`, `class`, `layout`, `content`, `__createdon`, `__changedon`, `backup`, `contenttype`) VALUES
(1, 'admin', 'css', 'body {\r\n  font-family:sans-serif;\r\n  font-size:small;\r\n}\r\n\r\nimg {\r\n  border: none;\r\n}\r\n\r\n.small{\r\n  font-family:sans-serif;\r\n  font-size:small;\r\n}\r\n\r\n.error{\r\n  font-family:sans-serif;\r\n  color: #FF0000;\r\n}\r\n\r\n.adminrow{\r\n  background-color: #FFFFFF;\r\n}\r\n\r\n.adminrowalt{\r\n  background-color: #D0EAF7;\r\n}\r\n\r\na:link {\r\n	color: #000000;\r\n	text-decoration: none;\r\n}\r\na:visited {\r\n	color: #1596D8;\r\n	text-decoration: none;\r\n}\r\na:hover {\r\n	color: #1596D8;\r\n	text-decoration: underline;\r\n}\r\na:active {\r\n	color: #1596D8;\r\n	text-decoration: underline;\r\n}\r\n\r\ninput {\r\ncolor: #000000;\r\nbackground-color: #D0EAF7;\r\n}\r\n\r\nselect {\r\ncolor: #000000;\r\nbackground-color: #D0EAF7;\r\n}\r\n\r\ntextarea {\r\ncolor: #000000;\r\nbackground-color: #D0EAF7;\r\n}\r\n\r\ntd{\r\n  font-family:sans-serif;\r\n  font-size:12;\r\n}\r\n\r\nth{\r\n  font-family:sans-serif;\r\n  font-size:12;\r\n}\r\n\r\n.adminlist th {\r\n  background-color: #1596D8;\r\n  color: #FFFFFF;\r\n}\r\n\r\n.adminlist td {\r\n  background-color: #D0EAF7;\r\n}\r\n\r\n.adminedit td {\r\n  background-color: #D0EAF7;\r\n}\r\n\r\n.adminedit th {\r\n  background-color: #1596D8;\r\n  color: #FFFFFF;\r\n}\r\n\r\n.adminlist h3{\r\n  display: inline;\r\n}\r\n\r\n.adminedit h3{\r\n  display: inline;\r\n}\r\n\r\n\r\n#topframe {\r\n  text-alig: left;\r\n  vertical-align: top;\r\n  height: 25px;\r\n}\r\n\r\n#navframe {\r\n  text-align: left;\r\n  vertical-align: top;\r\n  width: 100px;\r\n}\r\n\r\n#mainframe {\r\n  text-align: left;\r\n  vertical-align: top;\r\n}\r\n\r\n.lightborder {\r\n  border-style: dotted;\r\n  border-size: 1px;\r\n  border-color: #f00;\r\n}', NULL, NULL, '', 'text/css'),
(2, 'admin', 'customnavi', '&lt;br/&gt;&lt;br/&gt;\r\n&lt;hr/&gt;\r\n&lt;br/&gt;&lt;a href=&quot;index.php&quot;&gt;Indexseite&lt;/a&gt;\r\n&lt;br/&gt;&lt;a href=&quot;index.php?admin=&amp;template=&amp;tpl_class=page&amp;admin=&amp;tpl_layout=css_w40k&quot; &gt;Edit CSS&lt;/a&gt;', NULL, NULL, '', 'text/html'),
(3, 'admin', 'head', '&lt;?xml version=&quot;1.0&quot; ?&gt;\r\n&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot;\r\n    &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n&lt;html xmlns=&quot;http://www.w3.org/1999/xhtml&quot;&gt;\r\n  &lt;head&gt;\r\n    &lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html;charset=utf-8&quot; /&gt;\r\n    &lt;title&gt;smallCMS Admin&lt;/title&gt;\r\n    &lt;link href=&quot;?admin/show/css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot;/&gt;\r\n    &lt;script type=&quot;text/javascript&quot;&gt;\r\n	function dialog_confirm(question, dest) \r\n	{\r\n  		if (confirm(question)) location = dest;\r\n	}\r\n    &lt;/script&gt;\r\n  &lt;/head&gt;\r\n&lt;body&gt;', NULL, NULL, '', 'text/html'),
(4, 'admin', 'index', '&lt;p&gt;Dies ist die Spielberichtsdatenbank des &lt;a href=&quot;http://forum.firegate.de&quot; target=&quot;_blank&quot;&gt;W40K Ressource Centers&lt;/a&gt;&lt;/p&gt;\r\n&lt;dl&gt;\r\n  &lt;dt&gt;&lt;b&gt;Templates&lt;/b&gt;&lt;/dt&gt;&lt;dd&gt;Hier k&ouml;nnen die HTML Templates der einzelnen Module angepasst werden&lt;/dd&gt;\r\n  &lt;dt&gt;&lt;b&gt;Datein&lt;/b&gt;&lt;/dt&gt;&lt;dd&gt;Upload von Datein&lt;/dd&gt;\r\n  &lt;dt&gt;&lt;b&gt;Games-DB&lt;/b&gt;&lt;/dt&gt;&lt;dd&gt;Hier k&ouml;nnen alle EInstellungen f&uuml;r die Spielberichtsdatnbank vorgenommen werden&lt;/dd&gt;\r\n  &lt;dt&gt;&lt;b&gt;User/Usergroup&lt;/b&gt;&lt;/dt&gt;&lt;dd&gt;Benutzer- und Benutzergruppenverwaltung&lt;/dd&gt;\r\n  &lt;dt&gt;&lt;b&gt;Settings&lt;/b&gt;&lt;/dt&gt;&lt;dd&gt;Ansehen und Ver&auml;ndern von globalen Settings&lt;/dd&gt;\r\n&lt;/dl&gt;', NULL, NULL, '', 'text/html'),
(5, 'admin', 'javascript', 'function insertTag(tagname) {\r\n  name = prompt(''Referenzname'',''hier Inhalte/Name eingeben'');\r\n  if (tagname == ''image'')\r\n    myValue = ''&lt;img src=&quot;${''+tagname+'':''+name+''}&quot; alt=&quot;&quot;/&gt;'';\r\n  else if (tagname == ''plink'')\r\n    myValue = ''&lt;a href=&quot;${''+tagname+'':''+name+''}&quot;&gt;linktext&lt;/a&gt;'';\r\n  else if (tagname == ''page'')\r\n    myValue = ''${''+tagname+'':''+name+''}'';\r\n  else\r\n    myValue = ''&lt;''+tagname+''&gt;''+name+''&lt;/''+tagname+''&gt;'';\r\n  if (document.selection) {\r\n    document.edittpl.tpl_content.focus();\r\n    sel = document.selection.createRange();\r\n    sel.text = myValue;\r\n  } //MOZILLA/NETSCAPE support\r\n  else if (document.edittpl.tpl_content.selectionStart\r\n         ||document.edittpl.tpl_content.selectionStart == ''0'') {\r\n    var startPos = document.edittpl.tpl_content.selectionStart;\r\n    var endPos = document.edittpl.tpl_content.selectionEnd;\r\n    document.edittpl.tpl_content.value =\r\n        document.edittpl.tpl_content.value.substring(0, startPos)\r\n      + myValue\r\n      + document.edittpl.tpl_content.value.substring(endPos,\r\n          document.edittpl.tpl_content.value.length);\r\n  } else {\r\n    document.edittpl.tpl_content.value += myValue;\r\n  }\r\n}', NULL, NULL, '', 'text/javascript'),
(6, 'admin', 'login', '&lt;html&gt;\r\n  &lt;head&gt;\r\n    &lt;link href=&quot;?admin/show/css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot;/&gt;\r\n	&lt;script&gt;\r\n		function dialog_confirm(question, dest) \r\n		{\r\n  			if (confirm(question)) location = dest;\r\n		}\r\n	&lt;/script&gt;\r\n  &lt;/head&gt;\r\n&lt;body&gt;\r\n&lt;h3&gt;Adminlogin&lt;/h3&gt;\r\n&lt;font color=&quot;#FF0000&quot;&gt;&lt;?=$error?&gt;&lt;/font&gt;\r\n&lt;form action=&quot;index.php&quot; method=&quot;POST&quot;&gt;\r\n  &lt;table&gt;\r\n    &lt;tr&gt;\r\n      &lt;td&gt;Benutzername&lt;/td&gt;\r\n      &lt;td&gt;&lt;input type=&quot;text&quot; name=&quot;login&quot;&gt;&lt;/td&gt;\r\n    &lt;/tr&gt;\r\n    &lt;tr&gt;\r\n      &lt;td&gt;Passwort&lt;/td&gt;\r\n      &lt;td&gt;&lt;input type=&quot;password&quot; name=&quot;password&quot;&gt;&lt;/td&gt;\r\n    &lt;/tr&gt;\r\n  &lt;/table&gt;\r\n  &lt;input type=&quot;submit&quot; value=&quot;login&quot;&gt;\r\n  &lt;input type=&quot;hidden&quot; name=&quot;class&quot; value=&quot;user&quot;&gt;\r\n  &lt;input type=&quot;hidden&quot; name=&quot;method&quot; value=&quot;login&quot;&gt;\r\n  &lt;input type=&quot;hidden&quot; name=&quot;ref&quot; value=&quot;?admin&quot;&gt;\r\n&lt;/form&gt;\r\n&lt;a href=&quot;index.php&quot;&gt;Zur&uuml;ck zur Startseite&lt;/a&gt;\r\n&lt;/body&gt;\r\n&lt;/html&gt;', NULL, NULL, '', 'text/html'),
(7, 'admin', 'topframe', '&lt;strong&gt;CMS Administration&lt;/strong&gt; - W40K Ressource Center', NULL, NULL, '', 'text/html');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ttcategory`
--

CREATE TABLE IF NOT EXISTS `ttcategory` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ttentry`
--

CREATE TABLE IF NOT EXISTS `ttentry` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `tttypeid` bigint(20) DEFAULT '0',
  `imageid` bigint(20) DEFAULT '0',
  `ttcategoryid` bigint(20) DEFAULT '0',
  `aufwand` bigint(20) NOT NULL DEFAULT '100',
  `morale_pc` tinyint(4) NOT NULL DEFAULT '0',
  `money_build` tinyint(4) NOT NULL DEFAULT '0',
  `money_cost` bigint(20) NOT NULL,
  `maxpopulation_pc` tinyint(4) NOT NULL DEFAULT '0',
  `max_per_island` int(11) NOT NULL DEFAULT '0',
  `max_per_player` int(11) NOT NULL DEFAULT '0',
  `max_per_archipel` int(11) NOT NULL DEFAULT '0',
  `max_per_ship` int(11) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `ttcategoryid` (`ttcategoryid`),
  KEY `imageid` (`imageid`),
  KEY `tttypeid` (`tttypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ttentry`
--

INSERT INTO `ttentry` (`id`, `name`, `description`, `tttypeid`, `imageid`, `ttcategoryid`, `aufwand`, `morale_pc`, `money_build`, `money_cost`, `maxpopulation_pc`, `max_per_island`, `max_per_player`, `max_per_archipel`, `max_per_ship`, `__createdon`, `__changedon`) VALUES
(0, 'RootTech', 'The Source of all', NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ttentrydependson`
--

CREATE TABLE IF NOT EXISTS `ttentrydependson` (
  `id` bigint(20) NOT NULL,
  `entry_id` bigint(20) NOT NULL DEFAULT '0',
  `dependson_id` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `entry_id` (`entry_id`,`dependson_id`),
  KEY `entry_id_2` (`entry_id`),
  KEY `dependson_id` (`dependson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ttentryrohstoff`
--

CREATE TABLE IF NOT EXISTS `ttentryrohstoff` (
  `rohstoffid` bigint(20) NOT NULL DEFAULT '0',
  `ttentry_id` bigint(20) NOT NULL DEFAULT '0',
  `id` bigint(20) NOT NULL,
  `res_cost` bigint(20) NOT NULL DEFAULT '0',
  `res_build` bigint(20) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rohstoffid` (`rohstoffid`),
  KEY `ttentry_id` (`ttentry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ttexplored`
--

CREATE TABLE IF NOT EXISTS `ttexplored` (
  `id` bigint(20) NOT NULL,
  `spieler_id` bigint(20) NOT NULL DEFAULT '0',
  `techtree_entry_id` bigint(20) NOT NULL DEFAULT '0',
  `start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `finished` tinyint(4) NOT NULL DEFAULT '0',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `spieler_id` (`spieler_id`,`techtree_entry_id`),
  KEY `finished` (`finished`),
  KEY `spieler_id_2` (`spieler_id`),
  KEY `techtree_entry_id` (`techtree_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tttype`
--

CREATE TABLE IF NOT EXISTS `tttype` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `beschreibung` text NOT NULL,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `groupid` bigint(20) NOT NULL DEFAULT '0',
  `signature` varchar(100) NOT NULL DEFAULT '',
  `show_email` tinyint(1) NOT NULL DEFAULT '0',
  `lastlogin` datetime DEFAULT NULL,
  `errorlogins` bigint(20) NOT NULL DEFAULT '0',
  `hash` varchar(100) NOT NULL DEFAULT '',
  `newgroup` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  KEY `groupid` (`groupid`),
  KEY `newgroup` (`newgroup`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `__createdon`, `__changedon`, `login`, `email`, `password`, `groupid`, `signature`, `show_email`, `lastlogin`, `errorlogins`, `hash`, `newgroup`) VALUES
(1, NULL, '0000-00-00 00:00:00', 'admin', '', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, '', 0, '0000-00-00 00:00:00', 0, '', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usergroup`
--

CREATE TABLE IF NOT EXISTS `usergroup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `usergroup`
--

INSERT INTO `usergroup` (`id`, `__createdon`, `__changedon`, `name`) VALUES
(1, '2006-03-30 15:49:41', '2006-09-11 15:02:08', 'Administrator');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userrights`
--

CREATE TABLE IF NOT EXISTS `userrights` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  `userright` varchar(100) NOT NULL DEFAULT '',
  `usergroupid` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `usergroupid` (`usergroupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `userrights`
--

INSERT INTO `userrights` (`id`, `__createdon`, `__changedon`, `userright`, `usergroupid`) VALUES
(1, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'configadmin', 1),
(2, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'settingsadmin', 1),
(3, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'templateadmin', 1),
(4, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'useradmin', 1),
(5, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'admin', 1),
(6, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'codexadmin', 1),
(7, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'missionadmin', 1),
(8, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'battletypeadmin', 1),
(9, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'gamesystemadmin', 1),
(10, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'w40kuser_intern', 1),
(11, '2006-09-11 15:02:08', '2006-09-11 15:02:08', 'w40kadmin', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `welt`
--

CREATE TABLE IF NOT EXISTS `welt` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `__createdon` datetime DEFAULT NULL,
  `__changedon` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `allianz`
--
ALTER TABLE `allianz`
  ADD CONSTRAINT `allianz_ibfk_1` FOREIGN KEY (`leader_id`) REFERENCES `spieler` (`id`);

--
-- Constraints der Tabelle `archipel`
--
ALTER TABLE `archipel`
  ADD CONSTRAINT `archipel_ibfk_1` FOREIGN KEY (`kartenabschnitt_id`) REFERENCES `kartenabschnitt` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `army`
--
ALTER TABLE `army`
  ADD CONSTRAINT `army_ibfk_6` FOREIGN KEY (`gamesystem`) REFERENCES `gamesystem` (`id`),
  ADD CONSTRAINT `army_ibfk_4` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `army_ibfk_5` FOREIGN KEY (`codex`) REFERENCES `codex` (`id`);

--
-- Constraints der Tabelle `battle`
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
-- Constraints der Tabelle `battletype`
--
ALTER TABLE `battletype`
  ADD CONSTRAINT `battletype_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `battletype` (`id`);

--
-- Constraints der Tabelle `bauplan_enthaelt`
--
ALTER TABLE `bauplan_enthaelt`
  ADD CONSTRAINT `bauplan_enthaelt_ibfk_4` FOREIGN KEY (`tech_id`) REFERENCES `ttentry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bauplan_enthaelt_ibfk_3` FOREIGN KEY (`bauplan_id`) REFERENCES `bauplan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `codex`
--
ALTER TABLE `codex`
  ADD CONSTRAINT `codex_ibfk_1` FOREIGN KEY (`gamesystem`) REFERENCES `gamesystem` (`id`);

--
-- Constraints der Tabelle `filecategory`
--
ALTER TABLE `filecategory`
  ADD CONSTRAINT `filecategory_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `filecategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `hatbuendnissmit`
--
ALTER TABLE `hatbuendnissmit`
  ADD CONSTRAINT `hatbuendnissmit_ibfk_2` FOREIGN KEY (`antragempfaenger_id`) REFERENCES `allianz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hatbuendnissmit_ibfk_1` FOREIGN KEY (`antragsteller_id`) REFERENCES `allianz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `hatquest`
--
ALTER TABLE `hatquest`
  ADD CONSTRAINT `hatquest_ibfk_2` FOREIGN KEY (`spieler_id`) REFERENCES `spieler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hatquest_ibfk_1` FOREIGN KEY (`quest_id`) REFERENCES `quest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`imagecategoryid`) REFERENCES `filecategory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `insel`
--
ALTER TABLE `insel`
  ADD CONSTRAINT `insel_ibfk_1` FOREIGN KEY (`archipel_id`) REFERENCES `archipel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `insel_ibfk_3` FOREIGN KEY (`spieler_id`) REFERENCES `spieler` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `insel_ibfk_4` FOREIGN KEY (`lager_id`) REFERENCES `lager` (`id`);

--
-- Constraints der Tabelle `istinallianz`
--
ALTER TABLE `istinallianz`
  ADD CONSTRAINT `istinallianz_ibfk_2` FOREIGN KEY (`spieler_id`) REFERENCES `spieler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `istinallianz_ibfk_1` FOREIGN KEY (`allianz_id`) REFERENCES `allianz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `kartenabschnitt`
--
ALTER TABLE `kartenabschnitt`
  ADD CONSTRAINT `kartenabschnitt_ibfk_3` FOREIGN KEY (`welt_id`) REFERENCES `welt` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kartenabschnitt_ibfk_1` FOREIGN KEY (`links_id`) REFERENCES `kartenabschnitt` (`id`),
  ADD CONSTRAINT `kartenabschnitt_ibfk_2` FOREIGN KEY (`rechts_id`) REFERENCES `kartenabschnitt` (`id`);

--
-- Constraints der Tabelle `lagerenthaelt`
--
ALTER TABLE `lagerenthaelt`
  ADD CONSTRAINT `lagerenthaelt_ibfk_2` FOREIGN KEY (`rohstoff_id`) REFERENCES `rohstoff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lagerenthaelt_ibfk_1` FOREIGN KEY (`lager_id`) REFERENCES `lager` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`receiver`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`gamesystem`) REFERENCES `gamesystem` (`id`);

--
-- Constraints der Tabelle `mitteilung`
--
ALTER TABLE `mitteilung`
  ADD CONSTRAINT `mitteilung_ibfk_2` FOREIGN KEY (`empfaenger`) REFERENCES `spieler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mitteilung_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `spieler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `multibattlearmy`
--
ALTER TABLE `multibattlearmy`
  ADD CONSTRAINT `multibattlearmy_ibfk_1` FOREIGN KEY (`army_id`) REFERENCES `army` (`id`),
  ADD CONSTRAINT `multibattlearmy_ibfk_2` FOREIGN KEY (`multibattle`) REFERENCES `multibattle` (`id`);

--
-- Constraints der Tabelle `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`questionaireid`) REFERENCES `questionaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `questionaireanswers`
--
ALTER TABLE `questionaireanswers`
  ADD CONSTRAINT `questionaireanswers_ibfk_1` FOREIGN KEY (`questionanswerid`) REFERENCES `questionanswer` (`id`),
  ADD CONSTRAINT `questionaireanswers_ibfk_2` FOREIGN KEY (`quserid`) REFERENCES `questionaireuser` (`id`);

--
-- Constraints der Tabelle `questionaireuser`
--
ALTER TABLE `questionaireuser`
  ADD CONSTRAINT `questionaireuser_ibfk_1` FOREIGN KEY (`lastquestionaire`) REFERENCES `questionaire` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints der Tabelle `questionanswer`
--
ALTER TABLE `questionanswer`
  ADD CONSTRAINT `questionanswer_ibfk_2` FOREIGN KEY (`answertype`) REFERENCES `questionanswertype` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questionanswer_ibfk_1` FOREIGN KEY (`questionid`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `rohstoffproduktion`
--
ALTER TABLE `rohstoffproduktion`
  ADD CONSTRAINT `rohstoffproduktion_ibfk_2` FOREIGN KEY (`rohstoff_id`) REFERENCES `rohstoff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rohstoffproduktion_ibfk_1` FOREIGN KEY (`insel_id`) REFERENCES `insel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `rohstoffshop`
--
ALTER TABLE `rohstoffshop`
  ADD CONSTRAINT `rohstoffshop_ibfk_2` FOREIGN KEY (`lager_id`) REFERENCES `lager` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rohstoffshop_ibfk_1` FOREIGN KEY (`insel_id`) REFERENCES `insel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `rohstoffverkauf`
--
ALTER TABLE `rohstoffverkauf`
  ADD CONSTRAINT `rohstoffverkauf_ibfk_2` FOREIGN KEY (`rohstoff_id`) REFERENCES `rohstoff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rohstoffverkauf_ibfk_1` FOREIGN KEY (`rohstoffshop_id`) REFERENCES `rohstoffshop` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `schiff`
--
ALTER TABLE `schiff`
  ADD CONSTRAINT `schiff_ibfk_2` FOREIGN KEY (`lager_id`) REFERENCES `lager` (`id`),
  ADD CONSTRAINT `schiff_ibfk_1` FOREIGN KEY (`flotten_id`) REFERENCES `flotte` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints der Tabelle `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `spieler`
--
ALTER TABLE `spieler`
  ADD CONSTRAINT `spieler_ibfk_1` FOREIGN KEY (`welt_id`) REFERENCES `welt` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `ttentry`
--
ALTER TABLE `ttentry`
  ADD CONSTRAINT `ttentry_ibfk_3` FOREIGN KEY (`ttcategoryid`) REFERENCES `ttcategory` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `ttentry_ibfk_1` FOREIGN KEY (`tttypeid`) REFERENCES `tttype` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `ttentry_ibfk_2` FOREIGN KEY (`imageid`) REFERENCES `image` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints der Tabelle `ttentrydependson`
--
ALTER TABLE `ttentrydependson`
  ADD CONSTRAINT `ttentrydependson_ibfk_2` FOREIGN KEY (`dependson_id`) REFERENCES `ttentry` (`id`),
  ADD CONSTRAINT `ttentrydependson_ibfk_1` FOREIGN KEY (`entry_id`) REFERENCES `ttentry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `ttentryrohstoff`
--
ALTER TABLE `ttentryrohstoff`
  ADD CONSTRAINT `ttentryrohstoff_ibfk_2` FOREIGN KEY (`ttentry_id`) REFERENCES `ttentry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ttentryrohstoff_ibfk_1` FOREIGN KEY (`rohstoffid`) REFERENCES `rohstoff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `ttexplored`
--
ALTER TABLE `ttexplored`
  ADD CONSTRAINT `ttexplored_ibfk_2` FOREIGN KEY (`techtree_entry_id`) REFERENCES `ttentry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ttexplored_ibfk_1` FOREIGN KEY (`spieler_id`) REFERENCES `spieler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_4` FOREIGN KEY (`newgroup`) REFERENCES `usergroup` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`groupid`) REFERENCES `usergroup` (`id`);

--
-- Constraints der Tabelle `userrights`
--
ALTER TABLE `userrights`
  ADD CONSTRAINT `userrights_ibfk_1` FOREIGN KEY (`usergroupid`) REFERENCES `usergroup` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
