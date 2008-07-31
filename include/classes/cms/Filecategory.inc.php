<?php
/**
 * @package cms
 */
class Filecategory extends AbstractClass {

	public function Filecategory($id='') {
		parent::AbstractClass($id);
	}
	
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
		$fields[] = array('name' => 'parent',
                          'type' => 'integer',
                          'notnull' => false,
                          'htmltype' => 'select',
                          'desc'=>'Parent',
                          'join' => 'filecategory');
		return $fields;
	}	
	
	function parsefields($vars) {
		if ($vars['parent'] == '')
			$vars['parent'] = null;
		if (($this->get('id') != '') && ($vars['parent'] == $this->get('id'))) 
			return array("Recursion detected, parent can not be itself");
		
		if (!empty($vars['parent'])) {
			$parent = new Filecategory($vars['parent']);
			if ($parent->get('parent') != 0)
				return array("Only one step deep in parents is allowed. Chosen parent is child too.");
		}
		return parent::parsefields($vars);
	}
	
}
?>