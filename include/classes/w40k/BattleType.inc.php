<?php
BattleType::addRelation('battletype', 'battletype');

class BattleType extends W40K {

	public function acl($method) {
		return false;
	}

	/**
	 * all fields used in class
	 */
	public function getFields() {
		$fields[] = array('name' => 'name',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => true,
                          'htmltype' => 'input',
                          'desc'=>'Name');
		$fields[] = array('name' => 'comment',
                          'type' => 'string',
                          'size' => 1000000,
                          'notnull' => false,
                          'htmltype' => 'textarea',
                          'desc'=>'Comment');
		$fields[] = array('name' => 'parent',
                          'type' => 'integer',
                          'notnull' => false,
                          'htmltype' => 'select',
                          'desc'=>'Parent',
                          'join' => 'battletype');
		$fields[] = array('name' => 'sortfirst',
                          'type' => 'string',
                          'notnull' => false,
                          'htmltype' => 'select',
                          'desc'=>'Sort First',
                          'join' => array('Anzahl Spiele'=>'anzahl', 'Siegespunkte'=>'punkte', 'Punkte'=>'score'));
		$fields[] = array('name' => 'sortsecond',
                          'type' => 'string',
                          'notnull' => false,
                          'htmltype' => 'select',
                          'desc'=>'Sort Second',
                          'join' => array('Anzahl Spiele'=>'anzahl', 'Siegespunkte'=>'punkte', 'Punkte'=>'score'));
		$fields[] = array('name' => 'sortthird',
                          'type' => 'string',
                          'notnull' => false,
                          'htmltype' => 'select',
                          'desc'=>'Sort Third',
                          'join' => array('Anzahl Spiele'=>'anzahl', 'Siegespunkte'=>'punkte', 'Punkte'=>'score'));
		return $fields;
	}	
	
	function parsefields($vars) {
		if (($this->get('id') != '') && ($vars['parent'] == $this->get('id'))) 
			return array("Recursion detected, parent can not be itself");
		
		if (!empty($vars['parent'])) {
			$parent = new BattleType($vars['parent']);
			if ($parent->get('parent') != 0)
				return array("Only one step deep in parents is allowed. Chosen parent is child too.");
		}
		return parent::parsefields($vars);
	}
	
}
?>