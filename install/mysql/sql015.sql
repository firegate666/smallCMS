ALTER TABLE `allianz` ADD `__createdon` DATETIME;
ALTER TABLE archipel ADD `__createdon` DATETIME;
ALTER TABLE bauplan ADD `__createdon` DATETIME;
ALTER TABLE bauplan_enthaelt ADD `__createdon` DATETIME;
ALTER TABLE flotte ADD `__createdon` DATETIME;
ALTER TABLE guestbook ADD `__createdon` DATETIME;
ALTER TABLE hatbuendnissmit ADD `__createdon` DATETIME;
ALTER TABLE hatquest ADD `__createdon` DATETIME;
ALTER TABLE image ADD `__createdon` DATETIME;
ALTER TABLE imagecategory ADD `__createdon` DATETIME;
ALTER TABLE insel ADD `__createdon` DATETIME;
ALTER TABLE istinallianz ADD `__createdon` DATETIME;
ALTER TABLE kartenabschnitt ADD `__createdon` DATETIME;
ALTER TABLE lager ADD `__createdon` DATETIME;
ALTER TABLE lagerenthaelt ADD `__createdon` DATETIME;
ALTER TABLE mitteilung ADD `__createdon` DATETIME;
ALTER TABLE page ADD `__createdon` DATETIME;
ALTER TABLE pagestatistic ADD `__createdon` DATETIME;
ALTER TABLE quest ADD `__createdon` DATETIME;
ALTER TABLE rohstoff ADD `__createdon` DATETIME;
ALTER TABLE rohstoffproduktion ADD `__createdon` DATETIME;
ALTER TABLE rohstoffshop ADD `__createdon` DATETIME;
ALTER TABLE rohstoffverkauf ADD `__createdon` DATETIME;
ALTER TABLE schiff ADD `__createdon` DATETIME;
ALTER TABLE seawars ADD `__createdon` DATETIME;
ALTER TABLE session ADD `__createdon` DATETIME;
ALTER TABLE setting ADD `__createdon` DATETIME;
ALTER TABLE spieler ADD `__createdon` DATETIME;
ALTER TABLE template ADD `__createdon` DATETIME;
ALTER TABLE ttcategory ADD `__createdon` DATETIME;
ALTER TABLE ttentry ADD `__createdon` DATETIME;
ALTER TABLE ttentrydependson ADD `__createdon` DATETIME;
ALTER TABLE ttentryrohstoff ADD `__createdon` DATETIME;
ALTER TABLE ttexplored ADD `__createdon` DATETIME;
ALTER TABLE tttype ADD `__createdon` DATETIME;
ALTER TABLE welt ADD `__createdon` DATETIME;

ALTER TABLE `allianz` ADD `__changedon` DATETIME;
ALTER TABLE archipel ADD `__changedon` DATETIME;
ALTER TABLE bauplan ADD `__changedon` DATETIME;
ALTER TABLE bauplan_enthaelt ADD `__changedon` DATETIME;
ALTER TABLE flotte ADD `__changedon` DATETIME;
ALTER TABLE guestbook ADD `__changedon` DATETIME;
ALTER TABLE hatbuendnissmit ADD `__changedon` DATETIME;
ALTER TABLE hatquest ADD `__changedon` DATETIME;
ALTER TABLE image ADD `__changedon` DATETIME;
ALTER TABLE imagecategory ADD `__changedon` DATETIME;
ALTER TABLE insel ADD `__changedon` DATETIME;
ALTER TABLE istinallianz ADD `__changedon` DATETIME;
ALTER TABLE kartenabschnitt ADD `__changedon` DATETIME;
ALTER TABLE lager ADD `__changedon` DATETIME;
ALTER TABLE lagerenthaelt ADD `__changedon` DATETIME;
ALTER TABLE mitteilung ADD `__changedon` DATETIME;
ALTER TABLE page ADD `__changedon` DATETIME;
ALTER TABLE pagestatistic ADD `__changedon` DATETIME;
ALTER TABLE quest ADD `__changedon` DATETIME;
ALTER TABLE rohstoff ADD `__changedon` DATETIME;
ALTER TABLE rohstoffproduktion ADD `__changedon` DATETIME;
ALTER TABLE rohstoffshop ADD `__changedon` DATETIME;
ALTER TABLE rohstoffverkauf ADD `__changedon` DATETIME;
ALTER TABLE schiff ADD `__changedon` DATETIME;
ALTER TABLE seawars ADD `__changedon` DATETIME;
ALTER TABLE session ADD `__changedon` DATETIME;
ALTER TABLE setting ADD `__changedon` DATETIME;
ALTER TABLE spieler ADD `__changedon` DATETIME;
ALTER TABLE template ADD `__changedon` DATETIME;
ALTER TABLE ttcategory ADD `__changedon` DATETIME;
ALTER TABLE ttentry ADD `__changedon` DATETIME;
ALTER TABLE ttentrydependson ADD `__changedon` DATETIME;
ALTER TABLE ttentryrohstoff ADD `__changedon` DATETIME;
ALTER TABLE ttexplored ADD `__changedon` DATETIME;
ALTER TABLE tttype ADD `__changedon` DATETIME;
ALTER TABLE welt ADD `__changedon` DATETIME;

UPDATE flotte SET __createdon=timestamp, __changedon=timestamp;
UPDATE guestbook SET __createdon=timestamp, __changedon=timestamp;
UPDATE insel SET __createdon=timestamp, __changedon=timestamp;
UPDATE mitteilung SET __createdon=datum, __changedon=datum;
UPDATE pagestatistic SET __createdon=timestamp, __changedon=timestamp;
UPDATE session SET __createdon= concat( date, ' ', time ), __changedon= concat( date, ' ', time );

ALTER TABLE flotte DROP COLUMN timestamp;
ALTER TABLE guestbook DROP COLUMN timestamp;
ALTER TABLE insel DROP COLUMN timestamp;
ALTER TABLE mitteilung DROP COLUMN datum;
ALTER TABLE pagestatistic DROP COLUMN timestamp;
ALTER TABLE session DROP COLUMN date;
ALTER TABLE session DROP COLUMN time;