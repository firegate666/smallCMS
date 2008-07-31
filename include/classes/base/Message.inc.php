<?

Setting::write('message_defaultpagelimit', '', 'Message Default Pagelimit', false);
$template_classes[]='message';

/**
 * @package base
 */
class Message extends AbstractClass {

	protected $receiverlist = array();
	protected $send = false;

	public function acl($method) {
		if (($method=='inbox') || ($method=='outbox'))
			return User::loggedIn();
		if ($method=='edit')
			return ($this->get('id') == '') && User::loggedIn();
		if ($method=='delall')
			return ($this->get('id') == '') && $this->loggedIn();
		if (($method=='view') || ($method=='delete'))
			return ($this->get('sender') == $this->loggedIn())
				|| ($this->get('receiver') == $this->loggedIn());
		return false;
	}

	/**
	 * delete all commited messages
	 *
	 * @param	Array	$vars['msgid']	message ids to delete
	 */
	public function delall($vars) {
		if (isset($vars['msgid'])) {
			foreach($vars['msgid'] as $id) {
				$m = new Message($id);
				$m->delete($vars);
			}
		}
		return redirect($vars['ref']);
	}

	public function getFields() {
		$fields[] = array('name' => 'sender',
                          'type' => 'integer',
                          'notnull' => true);

		$fields[] = array('name' => 'receiver',
                          'type' => 'integer',
                          'notnull' => false);

		$fields[] = array('name' => 'subject',
                          'type' => 'string',
                          'size' => 100,
                          'notnull' => true);

		$fields[] = array('name' => 'body',
                          'type' => 'string',
                          'notnull' => true);

		$fields[] = array('name' => 'unread',
                          'type' => 'integer',
                          'notnull' => false,
                          'default' => true);

		$fields[] = array('name' => 'sender_deleted',
                          'type' => 'integer',
                          'notnull' => false,
                          'default' => false);

		$fields[] = array('name' => 'receiver_deleted',
                          'type' => 'integer',
                          'notnull' => false,
                          'default' => false);

		$fields[] = array('name' => 'read_on',
                          'type' => 'date',
                          'notnull' => false);

		return $fields;
	}

	function parsefields($vars) {
		$err = false;

		$vars['sender'] = $this->loggedIn();

		$err = parent::parsefields($vars);
		$this->receivercheck($vars['receiver_list'], $err);

		return $err;
	}

	/**
	 * check submitted receivers and set receiverlist
	 */
	function receivercheck($receiver, &$err) {
		$receiverlist = explode(',', $receiver);
		if (empty($receiverlist)) {
			$err[] = "No receiver set";
			return;
		}

		$u = new User();
		foreach($receiverlist as $user) {
			$user = trim($user);
			if (empty($user))  {
				$err[] = "No receiver set";
				return;
			}
			$result = $u->search($user, 'login');
			if (empty($result))
				$err[] = "User $user not found";
			else
				$this->receiverlist[] = $result[0]['id'];
		}

	}

	/**
	 * store message and send email notification to receiver
	 */
	function store() {
		if (!empty($this->receiverlist)) {
			foreach ($this->receiverlist as $receiver) {
				$message = new Message();
				$message->data = $this->data;
				$message->data['receiver'] = $receiver;
				$message->store();
				$u = new User($message->data['receiver']);
				$u2 = new User(User::loggedIn());
				if ($u->get('email') != '') {
					$m = new Mailer();
					$m->simplesend('', $u->get('email'), "You've got mail from ".$u2->get('login')." ({$message->get('subject')})",
						"You have received a new message on ".get_config('system'));
				}
			}
		} else
			parent::store();
	}

	/**
	 * edit message
	 */
	function edit(&$vars) {
		$array = array();
		$array['receiver_list'] = "";
		if (isset($vars['receiver_list']))
			$array['receiver_list'] = $vars['receiver_list'];
		if (isset($vars['submit'])) {
			$err = $this->parsefields($vars);
			if (!empty($err))
				$array['error'] = implode (", ", $err);
			else {
				$this->store();
				return redirect('?message/inbox');
			}
		}
		if (isset($vars['reply-to']))
			$array['receiver_list'] = $vars['reply-to'];
		if (isset($vars['subject']))
			$this->set('subject', $vars['subject']);
		if (isset($vars['cite'])) {
			$m = new Message($vars['cite']);
			$msg = "\n[quote]".$m->get('body', true)."[/quote]";
			$array['body'] = $msg;
		}
		return parent::show($vars, 'edit', $array);
	}

	/**
	 * view message
	 */
	function view(&$vars) {
		if (($this->get('unread') == 1) && ($this->get('receiver') == $this->loggedin())){
			$this->set('unread', 0);
			$this->set('read_on', Date::now());
			$this->store();
		}
		$array = array();
		$u = new User($this->get('receiver'));
		$array['receivername'] = $u->get('login');
		$u = new User($this->get('sender'));
		$array['sendername'] = $u->get('login');
		return parent::show($vars, 'view', $array);
	}

	/**
	 * show message inbox
	 */
	function inbox($vars) {
		$array = array();
		$orderby = "__createdon";
		$orderasc = false;
		if (isset($vars['orderby']))
			$orderby = $this->escape($vars['orderby']);
		if (isset($vars['orderasc']))
			$orderasc = $vars['orderasc'] == 1;

		$limit = Setting::read('message_defaultpagelimit');
		$limitstart = '';
		if (isset($vars['limit']) && !empty($vars['limit'])) {
			$limit = $this->escape($vars['limit']);
			$limitstart = $this->escape($vars['limitstart']);
		} else if (isset($vars['limit']))
			$limit = '';
		$where[] = array('key'=>'receiver', 'value'=>$this->loggedin());
		$where[] = array('key'=>'receiver_deleted', 'value'=>0);
		$list = $this->getlist('', $orderasc, $orderby, array('id'),
			$limitstart, $limit, $where);
		$rows = '';
		foreach($list as $entry) {
			$msg = new Message($entry['id']);
			$entry = $msg->getData();
			$entry['id'] = $msg->get('id');
			$u = new User($entry['sender']);
			$entry['sendername'] = $u->get('login');
			$rows .= parent::show($vars, 'inbox_row', $entry);
		}
		$array['rows'] = $rows;
		$array['orderby'] = $orderby;
		$array['orderasc'] = ($orderasc) ? 0 : 1;
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
		return parent::show($vars, 'inbox', $array);
	}

	/**
	 * show message outbox
	 */
	function outbox($vars) {
		$array = array();
		$orderby = "__createdon";
		$orderasc = false;
		if (isset($vars['orderby']))
			$orderby = $this->escape($vars['orderby']);
		if (isset($vars['orderasc']))
			$orderasc = $vars['orderasc'] == 1;

		$limit = Setting::read('message_defaultpagelimit');
		$limitstart = '';
		if (isset($vars['limit']) && !empty($vars['limit'])) {
			$limit = $this->escape($vars['limit']);
			$limitstart = $this->escape($vars['limitstart']);
		} else if (isset($vars['limit']))
			$limit = '';
		$where[] = array('key'=>'sender', 'value'=>$this->loggedin());
		$where[] = array('key'=>'sender_deleted', 'value'=>0);
		$list = $this->getlist('', $orderasc, $orderby, array('id'),
			$limitstart, $limit, $where);
		$rows = '';
		foreach($list as $entry) {
			$msg = new Message($entry['id']);
			$entry = $msg->getData();
			$entry['id'] = $msg->get('id');
			$u = new User($entry['receiver']);
			$entry['receivername'] = $u->get('login');
			$rows .= parent::show($vars, 'outbox_row', $entry);
		}
		$array['rows'] = $rows;
		$array['orderby'] = $orderby;
		$array['orderasc'] = ($orderasc) ? 0 : 1;
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
		return parent::show($vars, 'outbox', $array);
	}

	/**
	 * mark message as deleted for sender or receiver
	 * if both marked them, remove from database
	 */
	function delete($vars) {
		if ($this->loggedin() == $this->get('sender'))
			$this->set('sender_deleted', 1);
		if ($this->loggedin() == $this->get('receiver'))
			$this->set('receiver_deleted', 1);
		$this->store();
		if ($this->get('sender_deleted') && $this->get('receiver_deleted'))
			parent::delete();
		return redirect($vars['ref']);
	}
}
?>