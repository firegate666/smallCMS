<?php

Setting::write('ttpointsfaktor', 0.1, 'Faktor mit denen erforschte Techs in die Punktzahl eingehen', false);
Setting::write('islandpointsfaktor', 1.7, 'Faktor mit denen eigene Inseln in die Punktzahl eingehen', false);

TemplateClasses::add('spieler');

/**
 * there he is, the player himself
 */
class Spieler extends AbstractNavigationClass {

	function getPunkte($spieler_id = '') {
		if (empty($spieler_id))
			$spieler_id = $this->id;
		$spieler = new Spieler($spieler_id);
		$result = $spieler->get('punkte');
		$result += $this->ttpoints();
		$result += $this->islandpoints();
		// anything else?
		return $result;
	}

	function islandpoints($spieler_id = '') {
		global $mysql;
		if (empty($spieler_id))
			$spieler_id = $this->id;

		$query = 'SELECT SUM(a.groessenklasse * i.groesse) as punkte FROM archipel a, insel i WHERE i.archipel_id = a.id AND spieler_id = ' . $spieler_id;
		$result = $mysql->executeSql($query);

		return ($result['punkte'] ? $result['punkte'] : 0)  * Setting::read('islandpointsfaktor', 1);
	}

	function ttpoints($spieler_id = '') {
		global $mysql;
		if (empty($spieler_id))
			$spieler_id = $this->id;

		$query = "SELECT sum(ttentry.aufwand) as punkte FROM ttentry, ttexplored
				WHERE techtree_entry_id = ttentry.id AND finished=1 AND spieler_id=" . $spieler_id . ";";
		$result = $mysql->executeSql($query);

		return $result['punkte'] * Setting::read('ttpointsfaktor', 1);
	}

	/**
	 * get all player ids
	 * private function I guess
	 */
	function playerids() {
		global $mysql;
		$result = $mysql->select("SELECT id FROM spieler", true);
		return $result;
	}

	/**
	 * show highscore table
	 * @param	String[]	$vars	request parameter
	 */
	function highscore(&$vars) {
		$ids = $this->playerids();
		$result = '';
		foreach ($ids as $id) {
			$p = new Spieler($id['id']);
			$array['id'] = $p->id;
			$array['spieler'] = $p->data['username'];
			$array['punkte'] = $p->getPunkte();
			$result .= $this->getLayout($array, "highscore_row", $vars);
		}
		$array['rows'] = $result;
		return $this->getLayout($array, "highscore", $vars);
	}

	function acl($method) {
		if ($method == 'highscore')
			return true;
		return false;
	}

}
