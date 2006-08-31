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
		
		$message = new Message();
		$where[] = array('key'=>'receiver', 'value'=>$this->loggedin());
		$where[] = array('key'=>'receiver_deleted', 'value'=>0);
		$where[] = array('key'=>'unread', 'value'=>1);
		$list = $message->getlist('', false, '__createdon', array('id'),
			'', '', $where);
		$array['unreadmsg'] = count($list);
		
		$where = array();
		$where[] = array('key'=>'receiver', 'value'=>$this->loggedin());
		$where[] = array('key'=>'receiver_deleted', 'value'=>0);
		$list = $message->getlist('', false, '__createdon', array('id'),
			'', '', $where);
		$array['msgtotal'] = count($list);
		
		return parent::show($vars, $this->template, $array);
	}
	
	public function UserView($id) {
		$this->template = $id;
	}

}
?>
