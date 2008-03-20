<?php
Setting::write('battle_defaultpagelimit', '', 'Battle Default Pagelimit', false);

class Battle extends W40K {

	protected $viewname = 'battle_view';

	protected $mbarmies1 = array();
	protected $mbarmies2 = array();

	public function getFields() {
		$fields[] = array('name' => 'points',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'gamesystem',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'name',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => true);
		$fields[] = array('name' => 'impdate',
                          'type' => 'string',
                          'size' => 20,
                          'notnull' => true);
		$fields[] = array('name' => 'comment',
                          'type' => 'string',
                          'size' => 10000,
                          'notnull' => false);
		$fields[] = array('name' => 'player1',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'player2',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'mission',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'vp1',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'vp2',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'userid',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'winner',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'day',
                          'type' => 'integer',
                          'min' => 1,
                          'size' => 2,
                          'notnull' => true);
		$fields[] = array('name' => 'month',
                          'type' => 'integer',
                          'min' => 1,
                          'size' => 2,
                          'notnull' => true);
		$fields[] = array('name' => 'year',
                          'type' => 'integer',
                          'min' => 4,
                          'size' => 4,
                          'notnull' => true);
		$fields[] = array('name' => 'battletypeid',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'multibattle',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'realdate',
                          'type' => 'date',
                          'notnull' => true);

		$fields[] = array('name' => 'score_t3',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'score_1',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'score_2',
                          'type' => 'integer',
                          'notnull' => false);

		return $fields;
	}

	public function acl($method) {
		if ($method == 'edit')
			if ($this->exists())
				return ($this->get('userid')==User::loggedIn())
					|| $this->hasright('admin')
					|| $this->hasright('w40kadmin');
			else
				return $this->hasright('w40kuser_intern')
					|| $this->hasright('w40kuser_extern')
					|| $this->hasright('w40kadmin');
		if ($method == 'delete')
			return $this->get('userid')==User::loggedIn()
				|| $this->hasright('w40kadmin');
		return parent::acl($method);
	}

	function delete($vars) {
		parent::delete();
		return redirect('index.php?battle/showlist//');//$this->showlist($vars);
	}

	function getListByArmy($armyid){
		global $mysql;
		$query = "SELECT *, CONCAT(year,'-',month,'-',day) as date FROM battle WHERE player1=$armyid OR player2=$armyid";
		return $mysql->select($query, true);
	}

	function showlist(&$vars) {
		$orderby = "realdate";
		if (isset($vars['orderby']))
			$orderby = $this->escape($vars['orderby']);
		$limit = Setting::read('battle_defaultpagelimit');
		$limitstart = '';
		if (isset($vars['limit']) && !empty($vars['limit'])) {
			$limit = $this->escape($vars['limit']);
			$limitstart = $this->escape($vars['limitstart']);
		} else if (isset($vars['limit']))
			$limit = '';

		$where = array();


		if (empty($vars['battletype']) && isset($vars['battletype2']))
			unset($vars['battletype2']);

		if (empty($vars['battletype2']))
			unset($vars['battletype2']);

		if(isset($vars['battletype2']) && ($vars['battletype2'] != '')) {
			$checkbt = new BattleType($vars['battletype2']);
			if ($checkbt->get('parent') != $vars['battletype'])
				$vars['battletype2'] = '';
		}

		if(isset($vars['gamesystem']) && ($vars['gamesystem'] != ''))
			$where[] = array('key'=>'gamesystem', 'value'=>$vars['gamesystem']);

		if(isset($vars['battletype2']) && ($vars['battletype2'] != ''))
			$where[] = array('key'=>'battletypeid', 'value'=>$vars['battletype2']);
		else if(isset($vars['battletype']) && ($vars['battletype'] != ''))
			$where[] = array('key'=>'battletypeid', 'value'=>$vars['battletype']);

		$list = $this->getlist('', false, $orderby,
				array('*'), $limitstart, $limit, $where);
		$array['orderby'] = $orderby;
		$array['prevlimit'] = '';
		$array['nextlimit'] = '';
		$array['limit'] = '';
		$array['limitstart'] = '';
		if ($limit != '') {
			$array['prevlimit'] = $limitstart - $limit;
			if ($array['prevlimit'] < 0)
				$array['prevlimit'] = 0;
			$array['nextlimit'] = '';
			if (count($list)==$limit)
				$array['nextlimit'] = $limitstart + $limit;
			$array['limit'] = $limit;
			$array['limitstart'] = $limitstart;
		}
		$rows = '';
		foreach($list as $entry) {
			if (!empty($entry['comment']))
				$entry['hastext'] = "T";
			$entry['day'] = leadingzero($entry['day']);
			$entry['month'] = leadingzero($entry['month']);
			$rows .= parent::show($vars, 'battle_list_row', $entry);
		}

		$gs = new GameSystem($vars['gamesystem']);
		$array['gamesystemoptionlist'] = $gs->getOptionList($vars['gamesystem'], false, 'name',
											true, 'id', 'id');
		$array['gamesystem'] = $vars['gamesystem'];

		$bt = new BattleType($vars['battletype']);
		$bt1_where[] = array('key'=>'parent', 'value'=>null, 'comp'=>' is ');
		$array['battletypeoptionlist'] = $bt->getOptionList($vars['battletype'], false, 'name',
											true, 'id', 'id', $bt1_where);

		if (!empty($vars['battletype'])) {
			$bt2 = new BattleType($vars['battletype2']);
			$comp = '=';
			if (empty($vars['battletype']))
				$comp = ' is ';
			$bt2_where[] = array('key'=>'parent', 'value'=>$vars['battletype'], 'comp'=>$comp);
			$array['battletypeoptionlist2'] = $bt2->getOptionList($vars['battletype2'], false, 'name',
												true, 'id', 'id', $bt2_where);
			if (!empty($vars['battletype2']))
				$bt = $bt2;
		}

		$array['orderby'] = $orderby;
		$array['rows'] = $rows;
		$statrows = '';
		$array['battletype'] = $vars['battletype'];
		if (!empty($vars['battletype2'])) {
			$array['battletype2'] = $vars['battletype2'];
			$stats = $this->getStats(null, $array['battletype2'], $vars['gamesystem']);
		} else
			$stats = $this->getStats(null, $array['battletype'], $vars['gamesystem']);
        $punkte = array();
        $score = array();
        $anzahl = array();
		foreach ($stats as $key => $row) {
	        $anzahl[$key] = $row['anzahl'];
	        $score[$key] = $row['score'];
	        $punkte[$key] = $row['punkte'];
		}
		if (($bt->get('sortfirst') != "") && ($bt->get('sortsecond') != "") && ($bt->get('sortthird') != "")) {
			$first = $bt->get('sortfirst');
			$second = $bt->get('sortsecond');
			$third = $bt->get('sortthird');
			array_multisort($$first, SORT_DESC, SORT_NUMERIC,
							$$second, SORT_DESC, SORT_NUMERIC,
							$$third, SORT_DESC, SORT_NUMERIC,
							$stats);
		}
		foreach($stats as $entry) {
			$statrows .= parent::show($vars, 'battle_stat_row', $entry);
		}
		$array['statrows'] = $statrows;
		return parent::show($vars, 'battle_list', $array);
	}

	function getStats($playerid=null, $battletype = null, $gamesystem = null) {
		global $mysql;
		$PLAYER = '';
		if ($playerid != null) {
			$PLAYER = "AND a.id='".$this->escape($playerid)."'";
		}

		$BATTLETYPE = '';
		if ($battletype != null) {
			$BATTLETYPE = "AND battletypeid='".$this->escape($battletype)."'";
		}

		if ($gamesystem != null) {
			$GAMESYSTEM = "AND a.gamesystem='".$this->escape($gamesystem)."'";
		}

		$query1 = "SELECT player1, sum(vp1) as plus, sum(vp2) as minus,
					count(*) as anzahl, a.id as armyid, a.name as army,
					IF(score_t3=0 AND winner=0, sum(1), sum(0)) as deuce,
					IF(score_t3=0 AND winner=1, sum(1), sum(0)) as wins,
					IF(score_t3=0 AND winner=2, sum(1), sum(0)) as lost,
					sum(score_1) as t3_score
				FROM battle, army a
				WHERE player1=a.id $GAMESYSTEM $BATTLETYPE $PLAYER AND multibattle is null
				GROUP BY player1, winner;";

		$query2 = "SELECT player2, sum(vp2) as plus, sum(vp1) as minus,
					count(*) as anzahl, a.id as armyid, a.name as army,
					IF(score_t3=0 AND winner=0, sum(1), sum(0)) as deuce,
					IF(score_t3=0 AND winner=1, sum(1), sum(0)) as lost,
					IF(score_t3=0 AND winner=2, sum(1), sum(0)) as wins,
					sum(score_2) as t3_score
				FROM battle, army a
				WHERE player2=a.id $GAMESYSTEM $BATTLETYPE $PLAYER AND multibattle is null
				GROUP BY player2, winner;";

		$result1 = $mysql->select($query1, true);
		$result2 = $mysql->select($query2, true);

		$result = array();

		foreach($result1 as $row)
			if (isset($result[$row["armyid"]])) {
				$result[$row["armyid"]]['plus'] += $row['plus'];
				$result[$row["armyid"]]['minus'] += $row['minus'];
				$result[$row["armyid"]]['anzahl'] += $row['anzahl'];
				$result[$row["armyid"]]['deuce'] += $row['deuce'];
				$result[$row["armyid"]]['wins'] += $row['wins'];
				$result[$row["armyid"]]['lost'] += $row['lost'];
				$result[$row["armyid"]]['punkte'] = $result[$row["armyid"]]['plus'] - $result[$row["armyid"]]['minus'];
				$result[$row["armyid"]]['score'] = 2*$result[$row["armyid"]]['wins'] + $result[$row["armyid"]]['deuce'] + $result[$row["armyid"]]['t3_score'];
			} else {
				$result[$row["armyid"]] = $row;
				$result[$row["armyid"]]['punkte'] = $row['plus'] - $row['minus'];
				$result[$row["armyid"]]['score'] = 2*$row['wins'] + $row['deuce'] + $result[$row["armyid"]]['t3_score'];
			}

		foreach($result2 as $row) {
			if (isset($result[$row["armyid"]])) {
				$result[$row["armyid"]]['plus'] += $row['plus'];
				$result[$row["armyid"]]['minus'] += $row['minus'];
				$result[$row["armyid"]]['anzahl'] += $row['anzahl'];
				$result[$row["armyid"]]['deuce'] += $row['deuce'];
				$result[$row["armyid"]]['wins'] += $row['wins'];
				$result[$row["armyid"]]['lost'] += $row['lost'];
				$result[$row["armyid"]]['punkte'] = $result[$row["armyid"]]['plus'] - $result[$row["armyid"]]['minus'];
				$result[$row["armyid"]]['score'] = 2*$result[$row["armyid"]]['wins'] + $result[$row["armyid"]]['deuce'] + $result[$row["armyid"]]['t3_score'];
			} else {
				$result[$row["armyid"]] = $row;
				$result[$row["armyid"]]['punkte'] = $row['plus'] - $row['minus'];
				$result[$row["armyid"]]['score'] = 2*$row['wins'] + $row['deuce'] + $result[$row["armyid"]]['t3_score'];
			}
		}

		return $result;
	}

	function parsefields($vars){
		if ($this->get('userid')==null)
			$vars['userid'] = User::loggedIn();
		else
			$vars['userid'] = $this->get('userid');
		if ($this->hasright('w40kuser_extern'))
			$vars['battletypeid'] = 0;
		$vars['impdate'] = '-';
		if (!empty($vars['year']) && !empty($vars['month']) && !empty($vars['day']))
			$vars['impdate'] = std2impDate("{$vars['year']}-{$vars['month']}-{$vars['day']}");
		$vars['realdate'] = "{$vars['year']}-{$vars['month']}-{$vars['day']}";


		$return = parent::parsefields($vars);

		if (!empty($vars['score_t3']) && ($vars['score_t3'] > '0')) {
			$this->set('score_t3', '1');
			if ($vars['score_1'] > $vars['score_2']) {
				$this->set('winner', '1');
			} else if ($vars['score_1'] < $vars['score_2']) {
				$this->set('winner', '2');
			} else {
				$this->set('winner', '0');
			}
		} else {
			$this->set('score_t3', '0');
		}

		// store multibattle
		if (($return === false) && ($vars['multibattle'] == 1)) {

			if (!is_array($vars['multibattle1']) || !is_array($vars['multibattle2']))
				$return[] = "No armies for multibattle selected";
			else {
				$mb = new MultiBattle();
				$mb->store();
				$this->set('multibattle', $mb->get('id'));

				$this->mbarmies1 = $vars['multibattle1'];
				foreach($vars['multibattle1'] as $army1) {
					$mba = new MultiBattleArmy();
					$mba->set('army_id', $army1);
					$mba->set('player', 1);
					$mba->set('multibattle', $mb->get('id'));
					$mba->store();
				}

				$this->mbarmies2 = $vars['multibattle2'];
				foreach($vars['multibattle2'] as $army2) {
					$mba = new MultiBattleArmy();
					$mba->set('army_id', $army2);
					$mba->set('player', 2);
					$mba->set('multibattle', $mb->get('id'));
					$mba->store();
				}
			}
		}

		if ($this->data['multibattle'] == 0)
			$this->data['multibattle'] = null;

		return $return;
	}

	function edit(&$vars) {
		$array = array();
		if (isset($vars['submitted'])) {
			$err = $this->parsefields($vars);
			if (!empty($err))
				$array['error'] = implode (", ", $err);
			else {
				$this->store();
				$array['error'] = "Object saved";
			}
		}

		$this->preloaddata($vars);

		$bt = new BattleType();
		if ($this->hasright('w40kuser_extern'))
			$array['battletypelist'] = "<option value='0'></option>";
		else
			$array['battletypelist'] = $bt->getOptionList($this->data['battletypeid'], false, 'name', true, 'name');
		$gamesystem = new GameSystem();
		$array['gamesystemlist'] = $gamesystem->getOptionList($this->data['gamesystem'], false, 'name', true, 'name');
		$where = array();
		$array['armylist1'] = "";
		$array['armylist2'] = "";
		$w40kuser = new User();
		$array['playerlist1'] = "";
		$array['playerlist2'] = "";
		$array['mbarmylist1'] = "";
		$array['mbarmylist2'] = "";
		$array['missionlist'] = "";
		if (!empty($this->data['gamesystem'])) {
			if (!empty($this->data['player1'])) {
				$ta = new Army($this->data['player1']);
				$vars['playerlist1'] = $ta->data['userid'];
			}
			if (!empty($this->data['player2'])) {
				$ta = new Army($this->data['player2']);
				$vars['playerlist2'] = $ta->data['userid'];
			}
			$array['playerlist1'] = $w40kuser->getOptionList($vars['playerlist1'], true, 'login', true, 'login');
			$array['playerlist2'] = $w40kuser->getOptionList($vars['playerlist2'], true, 'login', true, 'login');
			$where[] = array('key'=>'gamesystem', 'value'=>$this->data['gamesystem']);
			$where1 = array();
			$where2 = array();
			if (!empty($vars['playerlist1']))
				$where1[] = array('key'=>'userid', 'value'=>$vars['playerlist1']);
			if (!empty($vars['playerlist2']))
				$where2[] = array('key'=>'userid', 'value'=>$vars['playerlist2']);
			$army = new Army();
			$array['armylist1'] = $army->getOptionList($this->data['player1'], false, 'name', true, 'name', 'id', array_merge($where, $where1));
			$array['armylist2'] = $army->getOptionList($this->data['player2'], false, 'name', true, 'name', 'id', array_merge($where, $where2));

			$array['mbarmylist1'] = $army->getOptionList($this->mbarmies1, false, 'name', true, 'name', 'id', $where);
			$array['mbarmylist2'] = $army->getOptionList($this->mbarmies2, false, 'name', true, 'name', 'id', $where);

			$mission = new Mission();
			$array['missionlist'] = $mission->getOptionList($this->data['mission'], false, 'name', true, 'name', 'id', $where);
		}

		switch($this->get('multibattle')) {
			case 0: $array['multibattleno']="checked='checked'"; break;
			default: $array['multibattleyes']="checked='checked'"; break;
		}

		switch($this->get('winner')) {
			case 0: $array['deuce']="checked='checked'"; break;
			case 1: $array['win1']="checked='checked'"; break;
			case 2: $array['win2']="checked='checked'"; break;
			default: $array['deuce']="checked='checked'"; break;
		}

		switch($this->get('score_t3')) {
			case 0: $array['score_t3']=""; break;
			case 1: $array['score_t3']="checked='checked'"; break;
			default: $array['score_t3']=""; break;
		}

		$array['score_t3'] = $this->get('score_t3');
		$array['score_1'] = $this->get('score_1');
		$array['score_2'] = $this->get('score_2');

		$image = new Image();
		$ilist = $image->getlist('', true, 'prio', array('*'));
		$array['imagelist'] = "";
		foreach($ilist as $iobj) {
			if (($iobj['parent'] == $this->class_name()) && ($iobj['parentid'] == $this->get('id')))
				$array['imagelist'] .= $this->show($vars, 'battle_edit_image', $iobj);
		}
		return parent::show($vars, 'battle_edit', $array, true);
	}

	protected function loadMultibattles() {
		if (!$this->get('multibattle'))
			return;
		$mb = new Multibattle($this->get('multibattle'));
		$mba = new MultiBattleArmy();
		$where[] = array('key'=>'multibattle', 'value'=>$mb->get('id'));
		$list = $mba->getlist('', true, 'id', array('*'), '', '', $where);
		foreach($list as $entry) {
			if ($entry['player'] == 1)
				$this->mbarmies1[] = $entry['army_id'];
			if ($entry['player'] == 2)
				$this->mbarmies2[] = $entry['army_id'];
		}
	}

	public function Battle($id='') {
		parent::W40K($id);
		$this->loadMultibattles();
	}

	function view(&$vars) {
		$array = array();
		$m = new Mission($this->get('mission'));
		$array['missionname'] = $m->get('name');
		$army = new Army($this->get('player1'));
		$codex = new Codex($army->get('codex'));
		$array['army1name'] = $army->get('name');
		$array['army1commander'] = $army->get('commander');
		$array['codex1name'] = $codex->get('name');
		$array['codex1id'] = $codex->get('id');
		$army = new Army($this->get('player2'));
		$codex = new Codex($army->get('codex'));
		$array['army2name'] = $army->get('name');
		$array['army2commander'] = $army->get('commander');
		$array['codex2name'] = $codex->get('name');
		$array['codex2id'] = $codex->get('id');
		$array['day'] = leadingzero($this->get('day'));
		$array['month'] = leadingzero($this->get('month'));
		$u = new User($this->get('userid'));
		$array['username'] = $u->get('login');
		switch($this->get('winner')) {
			case 0 : $array['winnername'] = "-";break;
			case 1 : $array['winnername'] = $array['army1name'];break;
			case 2 : $array['winnername'] = $array['army2name'];break;
		}

		// NEW STYLE T3 Scores
		$score_t3 = $this->get('score_t3');
		$array['score_1'] = $this->get('score_1');
		$array['score_2'] = $this->get('score_2');
		if ($score_t3) {
			if ($array['score_1'] > $array['score_2']) {
				$array['winnername'] = $array['army1name'];
			} else if ($array['score_2'] > $array['score_1']) {
				$array['winnername'] = $array['army2name'];
			} else {
				$array['winnername'] = "-";
			}
		}
		// NEW STYLE

		$this->mbarmies1_names = array();
		$this->mbarmies2_names = array();
		foreach($this->mbarmies1 as $army_id) {
			$a = new Army($army_id);
			$this->mbarmies1_names[] = $a->get('name');
		}
		foreach($this->mbarmies2 as $army_id) {
			$a = new Army($army_id);
			$this->mbarmies2_names[] = $a->get('name');
		}
		$array['mbarmies1'] = implode(', ', $this->mbarmies1_names);
		$array['mbarmies2'] = implode(', ', $this->mbarmies2_names);
		$bt = new BattleType($this->get('battletypeid'));
		$array['battletypename'] = $bt->get('name');
		$image = new Image();
		$ilist = $image->getlist('', true, 'prio', array('*'));
		$array['imagelist'] = "";
		foreach($ilist as $iobj) {
			if (($iobj['parent'] == $this->class_name()) && ($iobj['parentid'] == $this->get('id')))
				$array['imagelist'] .= $this->show($vars, 'battle_view_image', $iobj);
		}
		return parent::show($vars, 'battle_view', $array);
	}

}


?>
