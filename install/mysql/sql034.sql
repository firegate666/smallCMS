-- fix image types
update image set type ='image/png' where url like '%.png';
update image set type ='image/gif' where url like '%.gif';
update image set type ='image/jpeg' where url like '%.jpg';

INSERT INTO dbversion(sql_id, sql_subid) VALUES (34, 0);
