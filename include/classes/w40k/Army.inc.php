<?php
Setting::write('army_defaultpagelimit', '', 'Army Default Pagelimit', false);

class Army extends W40K {

	protected $viewname = 'army_view';

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
			return ($this->exists()) && ($this->get('userid')==User::loggedIn());
		return parent::acl($method);
	}

	function delete($vars) {
		parent::delete();
		return redirect('index.php?army/showlist//');//$this->showlist($vars);
	}

	function parsefields($vars){
		if ($this->get('userid')==null)
			$vars['userid'] = User::loggedIn();
		else if ($this->hasright('w40kadmin') && (!empty($vars['userid'])))
			$vars['userid'] = $vars['userid'];
		else
			$vars['userid'] = $this->get('userid');
		return parent::parsefields($vars);
	}

	function edit(&$vars) {
		$array = array();
		if (isset($vars['delete'])) {
			$bool = $this->delete(true);
			if ($bool) return $this->showlist($vars);
			else $array['error'] = 'Delete failed, there might be references on this object, e.g. battles';
		}
		else if (isset($vars['submitted'])) {
			$err = $this->parsefields($vars);
			if (!empty($err))
				$array['error'] = implode (", ", $err);
			else {
				$this->store();
				$array['error'] = "Object saved";
			}
		}
		$this->preloaddata($vars);

		if (empty($this->data['userid']))
			$this->data['userid'] = User::loggedIn();
		$w40kuser = new User();
		$user_me = array();
		if (!$this->hasright('w40kadmin'))
			$user_me[] = array('key'=>'id', 'value'=>User::loggedIn());
		$array['playerlist'] = $w40kuser->getOptionList($this->data['userid'], false, 'login', true, 'login', 'id', $user_me);

		$gamesystem = new GameSystem();
		$array['gamesystemlist'] = $gamesystem->getOptionList($this->data['gamesystem'], true, 'name', true, 'name');
		$where = array();
		$array['codexlist'] = '';
		if (!empty($this->data['gamesystem'])) {
			$where[] = array('key'=>'gamesystem', 'value'=>$this->data['gamesystem']);
			$codex = new Codex();
			$array['codexlist'] = $codex->getOptionList($this->data['codex'], false, 'name', true, 'name', 'id', $where);
		}
		$image = new Image();
		$ilist = $image->getlist('', true, 'name', array('*'));
		$array['imagelist'] = "";
		foreach($ilist as $iobj) {
			if (($iobj['parent'] == $this->class_name()) && ($iobj['parentid'] == $this->get('id')))
				$array['imagelist'] .= $this->show($vars, 'army_edit_image', $iobj);
		}
		return parent::show($vars, 'army_edit', $array, true);
	}

	function view(&$vars) {
		$codex = new Codex($this->get('codex'));
		$array['codexname'] = $codex->get('name');

		$b = new Battle();
		$battles = $b->getListByArmy($this->get('id'));
		$battlerows = "";
		foreach($battles as $entry) {
			$mission = new Mission($entry['mission']);
			$entry['missionname'] = $mission->get('name');
			$bt = new BattleType($entry['battletypeid']);
			$entry['battletypename'] = $bt->get('name');
			if (!empty($entry['comment']))
				$entry['hastext'] = "T";
			$entry['icount'] = "&nbsp;";//$this->numImages($entry['id']);
			$battlerows .= $b->show($vars, 'battle_list_row', $entry);
		}
		$array['battlerows'] = $battlerows;

		$array = array_merge($array, $this->getPlayerStats());

		$image = new Image();
		$ilist = $image->getlist('', true, 'name', array('*'));
		$array['imagelist'] = "";
		foreach($ilist as $iobj) {
			if (($iobj['parent'] == $this->class_name()) && ($iobj['parentid'] == $this->get('id')))
				$array['imagelist'] .= $this->show($vars, 'army_view_image', $iobj);
		}
		$u = new User($this->get('userid'));
		$array['username'] = $u->get('login');
		return parent::show($vars, 'army_view', $array);
	}

	function getPlayerStats($playerid=null) {
		if ($playerid == null)
			$playerid = $this->get('id');
		$array['win'] = 0;
		$array['deuce'] = 0;
		$array['lost'] = 0;
		$array['winpc'] = 0;
		$array['deucepc'] = 0;
		$array['lostpc'] = 0;
		$array['vpplus'] = 0;
		$array['vpminus'] = 0;
		$array['vp'] = 0;
		$b = new Battle();
		$stats = $b->getStats($playerid);
		$array['battlecount'] = $stats[$playerid]['anzahl'];
		if ($array['battlecount'] > 0) {
			$array['win'] = $stats[$playerid]['wins'];
			$array['deuce'] = $stats[$playerid]['deuce'];
			$array['lost'] = $stats[$playerid]['lost'];
			$array['winpc'] = round($array['win'] / $array['battlecount'], 2)*100;
			$array['deucepc'] = round($array['deuce'] / $array['battlecount'], 2)*100;
			$array['lostpc'] = round($array['lost'] / $array['battlecount'], 2)*100;
			$array['vpplus'] = $stats[$playerid]['plus'];
			$array['vpminus'] = $stats[$playerid]['minus'];
			$array['vp'] = $stats[$playerid]['punkte'];
		} else
			$array['battlecount'] = 0;
		return $array;
	}

	function showlist(&$vars) {
		$orderby = "name";
		if (isset($vars['orderby']))
			$orderby = $this->escape($vars['orderby']);
		$limit = Setting::read('army_defaultpagelimit');
		$limitstart = '';
		if (isset($vars['limit']) && !empty($vars['limit'])) {
			$limit = $this->escape($vars['limit']);
			$limitstart = $this->escape($vars['limitstart']);
		} else if (isset($vars['limit']))
			$limit = '';
		$where = array();
		if (isset($vars['gamesystem']) && ($vars['gamesystem'] != ''))
			$where[] = array('key'=>'gamesystem', 'value'=>$vars['gamesystem']);

		$list = $this->getlist('', true, $orderby,
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

		$gs = new GameSystem($vars['gamesystem']);
		$array['gamesystemoptionlist'] = $gs->getOptionList($vars['gamesystem']);
		$array['gamesystem'] = $vars['gamesystem'];

		foreach($list as $entry) {
			if (!empty($entry['comment']))
				$entry['hastext'] = "T";
			$rows .= parent::show($vars, 'army_list_row', $entry);
		}
		$array['rows'] = $rows;
		return parent::show($vars, 'army_list', $array);
	}


	/**
	 * all fields used in class
	 */
	public function getFields() {
		$fields[] = array('name' => 'userid',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'gamesystem',
                          'type' => 'integer',
                          'notnull' => true);
		$fields[] = array('name' => 'points',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'commander',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => true);
		$fields[] = array('name' => 'name',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => true);
		$fields[] = array('name' => 'codex',
                          'type' => 'integer',
                          'notnull' => false);
		$fields[] = array('name' => 'comment',
                          'type' => 'string',
                          'size' => 100000,
                          'notnull' => false);

		return $fields;
	}

}
?>
