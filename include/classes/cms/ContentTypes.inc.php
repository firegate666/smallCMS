<?
abstract class ContentType {
	public function acl($method){
		return ($method=='show');
	}
}

/**
 * create real links
 */
class Link extends ContentType {
	protected $value;
	protected $link;

	function show(& $vars) {
		return $this->link.$this->value;
	}

	function Link($value) {
		$this->link = 'index.php?';
		$this->value = $value;
	}
}

/**
 * Internal Pagelink
 */
class PLink extends Link {

	function PLink($value) {
		parent::Link($value);
		$this->link = 'index.php?page/show/';
	}
}

/**
 * real links
 */
class Loggedin extends ContentType {

	protected $loggedin = "";
	protected $loggedout = "";

	function show(& $vars) {
		if (User::loggedIn()) {
			if (empty($this->loggedin))
				return "";
			$p = new Page($this->loggedin);
			return $p->show($vars);
		} else {
			if (empty($this->loggedout))
				return "";
			$p = new Page($this->loggedout);
			return $p->show($vars);
		}
	}

	function Loggedin($value) {
		$value = explode("|", $value);
		if(isset($value[0]))
			$this->loggedin = $value[0];
		if(isset($value[1]))
			$this->loggedout = $value[1];
	}
}

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

/**
 * include page with name from postdata
 */
class Varspage extends ContentType {

	protected $attr = '';

	function Varspage($id='') {
		$this->attr = $id;
	}

	function show(&$vars){
		if(isset($vars[$this->attr]) && !empty($vars[$this->attr])) {
			$p = new Page($vars[$this->attr]);
			return $p->show($vars);
		} else
			return '<!-- empty -->';
	}
}
?>