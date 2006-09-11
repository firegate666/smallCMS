--remove the rest of seawars

DROP TABLE `allianz`;
DROP TABLE `archipel`;
DROP TABLE `bauplan`;
DROP TABLE `bauplan_enthaelt`;
DROP TABLE `flotte`;
DROP TABLE `hatbuendnissmit`;
DROP TABLE `hatquest`;
DROP TABLE `insel`;
DROP TABLE `istinallianz`;
DROP TABLE `kartenabschnitt`;
DROP TABLE `lager`;
DROP TABLE `lagerenthaelt`;
DROP TABLE `mitteilung`;
DROP TABLE `quest`;
DROP TABLE `rohstoff`;
DROP TABLE `rohstoffproduktion`;
DROP TABLE `rohstoffshop`;
DROP TABLE `rohstoffverkauf`;
DROP TABLE `schiff`;
DROP TABLE `seawars`;
DROP TABLE `spieler`;
DROP TABLE `ttcategory`;
DROP TABLE `ttentry`;
DROP TABLE `ttentrydependson`;
DROP TABLE `ttentryrohstoff`;
DROP TABLE `ttexplored`;
DROP TABLE `tttype`;
DROP TABLE `welt`;
	
INSERT INTO dbversion(sql_id, sql_subid) VALUES (26, 0);