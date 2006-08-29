--remove the rest of seawars

DROP TABLE `allianz`, `archipel`, `bauplan`,
	`bauplan_enthaelt`, `flotte`, `hatbuendnissmit`,
	`hatquest`, `insel`, `istinallianz`, `kartenabschnitt`,
	`lager`, `lagerenthaelt`, `mitteilung`, `quest`,
	`rohstoff`, `rohstoffproduktion`, `rohstoffshop`,
	`rohstoffverkauf`, `schiff`, `seawars`, `spieler`,
	`ttcategory`, `ttentry`, `ttentrydependson`,
	`ttentryrohstoff`, `ttexplored`, `tttype`, `welt`;
	
INSERT INTO dbversion(sql_id, sql_subid) VALUES (26, 0);