<?php
$template_classes[] = 'userview';

class UserView extends AbstractClass {

	protected $template = '';
	
	public function acl($method) {
		if ($method == 'show')
			return true;
	}
	
	public function show($vars) {
		$u = new User(User::loggedIn());
		$ug = new Usergroup($u->get('groupid'));
		$array = $u->getData();
		$array['id'] = $u->get('id');
		$array['groupname'] = $ug->get('name');
		return parent::show($vars, $this->template, $array);
	}
	
	public function UserView($id) {
		$this->template = $id;
	}

}
?>
