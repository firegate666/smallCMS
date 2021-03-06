CREATE OR REPLACE VIEW battle_view AS
SELECT
	b.*,
	m.name as missionname,
	bt.name as battletypename,
	(SELECT count(*) FROM image WHERE parent='battle' AND parentid=b.id) as icount,
	a1.name as player1name,
	a2.name as player2name
FROM battle b, mission m, battletype bt, army a1, army a2
WHERE
	b.mission = m.id AND
	b.battletypeid = bt.id AND
	a1.id = player1 AND
	a2.id = player2
ORDER BY b.id ASC;

CREATE OR REPLACE VIEW army_view AS
SELECT
	a.*,
	c.name as codexname,
	u.login as username,
	g.name as gamesystemname,
	(SELECT count(*) FROM image WHERE parent='army' AND parentid=a.id) as icount
FROM army a, codex c, `user` u, gamesystem g
WHERE
	a.userid = u.id AND
	a.codex = c.id AND
	a.gamesystem = g.id
ORDER BY a.id ASC;

CREATE OR REPLACE VIEW userrights_view AS
SELECT
	ur.*,
	ug.name as usergroupname
FROM userrights ur, usergroup ug
WHERE
	ur.usergroupid = ug.id
ORDER BY ur.id ASC;

CREATE OR REPLACE VIEW user_view AS
SELECT
	u.*,
	ug1.name as groupname,
	ug2.name aS newgroupname,
	(SELECT count(*) FROM army WHERE userid = u.id) as armycount,
	(SELECT count(*) FROM battle WHERE userid = u.id) as battlecount
FROM `user` u
LEFT JOIN usergroup ug1 ON u.groupid = ug1.id
LEFT JOIN usergroup ug2 ON u.newgroup = ug2.id
ORDER BY u.id ASC;

CREATE OR REPLACE VIEW questionaire_answercount_view AS
SELECT
	q.questionaireid,
	count(DISTINCT qas.quserid) as anzahl
FROM question q, questionaireanswers qas, questionanswer qa
WHERE
	qas.questionanswerid = qa.id AND
	qa.questionid = q.id
GROUP BY q.questionaireid ORDER  BY qas.quserid, q.id;

CREATE OR REPLACE VIEW questionaire_users_view AS
SELECT
	DISTINCT qu.email,
	q.questionaireid
FROM question q, questionaireanswers qas, questionanswer qa, questionaireuser qu
WHERE
	qas.quserid = qu.id AND
	qas.questionanswerid = qa.id AND
	qa.questionid = q.id
ORDER BY qas.quserid, q.id;

CREATE OR REPLACE VIEW questionaire_answertable_view AS
SELECT q.sem_id, qas.questionanswervalue, qas.quserid, qas.__createdon, q.questionaireid
FROM question q, questionaireanswers qas, questionanswer qa
WHERE qas.questionanswerid = qa.id AND qa.questionid = q.id
ORDER BY q.id, qas.quserid, qas.__createdon;