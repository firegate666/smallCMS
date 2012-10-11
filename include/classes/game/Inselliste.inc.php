<?php

TemplateClasses::add('inselliste');

/**
 * list of islands, islandlistview
 */
class Inselliste extends AbstractNavigationClass {

	/**
	 * there are no views in database, only single islands
	 */
	function load() {

	}

	/**
	 * check if method is allowed
	 * @param	String	$method	method to test
	 * @return	boolean	true/false
	 */
	function acl($method) {
		return Login::isLoggedIn();
	}

	/**
	 * Show islandlist using template insel/page and insel/row
	 * @param	String[]	$vars	request parameter, ['mode'] is used, to
	 * limit which islands are shown (own, region, archipel, all)
	 */
	function show(&$vars) {
		$mode = "OWN";
		if (isset($vars["mode"])) {
			$mode = $vars["mode"];
		}
		switch (strtoupper($mode)) {
			case ("ALL") : return $this->show_all($vars);
				break;
			case ("REGION") : return $this->show_region($vars);
				break;
			case ("ARCHIPEL") : return $this->show_archipel($vars);
				break;
			case ("OWN") : return $this->show_own($vars);
				break;
			default : return $this->show_all($vars);
		}
		return $this->show_all();
	}

	function show_all(&$vars) {
		global $mysql;

		$limit = !empty($vars['limit']) ? min(intval($vars['limit']), 100) : 15;
		$limitstart = !empty($vars['limitstart']) ? intval($vars['limitstart']) : 0;

		$count = $mysql->select('SELECT count(*) as count FROM insel');
		$result = $mysql->select("SELECT i.id, i.name, i.groesse, a.name
                                          FROM insel i, archipel a
                                          WHERE a.id = i.archipel_id
										  LIMIT $limitstart, $limit;");

		$rows = '';
		foreach ($result as $row) {
			$array['id'] = $row[0];
			$array['name'] = $row[1];
			$array['groesse'] = $row[2];
			$array['archipel'] = $row[3];
			$rows .= $this->getLayout($array, "row", $vars);
		}

		$array = array('inseln' => $rows, 'mode' => 'ALL');
		$array = $this->pager($limit, $limitstart, $count[0][0], $array);

		return $this->getLayout($array, "page", $vars);
	}

	function show_region(&$vars) {
		$kartenabschnitt_id = $vars["kartenabschnitt_id"];
	}

	function show_archipel(&$vars) {
		$archipel_id = $vars["archipel_id"];
	}

	function show_own(&$vars) {
		global $mysql;

		$limit = !empty($vars['limit']) ? min(intval($vars['limit']), 100) : 15;
		$limitstart = !empty($vars['limitstart']) ? intval($vars['limitstart']) : 0;

		$count = $mysql->select('SELECT count(*) as count FROM insel WHERE spieler_id = ' . Session::getCookie('spieler_id'));
		$result = $mysql->select("SELECT i.id, i.name, i.groesse, a.name
                                          FROM insel i, archipel a
                                          WHERE a.id = i.archipel_id AND i.spieler_id=" . Session::getCookie('spieler_id') . " LIMIT $limitstart, $limit;");
		$rows = '';
		foreach ($result as $row) {
			$array['id'] = $row[0];
			$array['name'] = $row[1];
			$array['groesse'] = $row[2];
			$array['archipel'] = $row[3];
			$rows .= $this->getLayout($array, "row", $vars);
		}

		$array = array('inseln' => $rows, 'mode' => 'OWN');
		$array = $this->pager($limit, $limitstart, $count[0][0], $array);

		return $this->getLayout($array, "page", $vars);
	}

}
