<?
	$template_classes[] = 'page';
	$template_classes[] = 'admin';

/**
 * This is a page
 */
class Page extends AbstractClass {

	protected $name = '';
	protected $tags = '';

	function acl($method) {
		if ($method == 'show')
			return true;
		return false;
	}

	function Page($name='') {
		$this->name = $name;
	}

	/**
	 * if admin is logged in, show adminbar
	 */
	function adminbar($layout){
		$result = '';
		$attr = array(
			'href' => 'index.php?admin&template&tpl_class=page&tpl_layout='.$layout,
			'target' => '_blank',
		);
		$result .= HTML::tag('a', "Edit Template {$this->name}", $attr);

		$result .= ' - ';

		$attr = array(
			'href' => 'index.php?user/logout//',
		);
		$result .= HTML::tag('a', "Edit Template {$this->name}", $attr);

		$result .= HTML::tag('hr', '', array(), false);

		return HTML::tag('span', $result, array('class'=>'adminbar'));
	}

	function show(&$vars) {
		if($this->name=='') return error("Pagename not given",$this->class_name(),"show");
		$output = $this->getLayout(array(),$this->name, $vars);
		if($this->hasright('templateadmin') && get_config('quickedit'))
			$output = $this->adminbar($this->name).$output;
		return $output;
	}

	function contenttype() {
		global $mysql;
		if($this->name=='') return error("Pagename not given",$this->class_name(),"show");
		$result = $mysql->select("SELECT contenttype FROM template WHERE class='page' AND layout='".$this->name."'");
		$contenttype = $result[0][0];
		return $contenttype;
	}
}
?>