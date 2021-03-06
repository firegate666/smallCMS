<?php

/**
 * Templatehandling
 */
UserPrivileges::add('templateadmin', 'can edit templates &amp; images');

/**
 * @package base
 */
class Template extends AbstractClass {

	protected $layout;
	protected $tags = array();

	function contenttypeoptionlist($class, $layout) {
		global $mysql;
		$list[] = "text/html";
		$list[] = "text/plain";
		$list[] = "text/css";
		$list[] = "text/javascript";
		$list[] = "text/xml";
		$result = $mysql->select("SELECT contenttype FROM template WHERE class='$class' AND layout='$layout'");
		$contenttype = $result[0][0];
		$return = "";
		foreach ($list as $item) {
			$SELECTED = "";
			if ($item == $contenttype)
				$SELECTED = "selected='selectetd'";
			$return .= "<option $SELECTED value='$item'>$item</option>\n";
		}
		return $return;
	}

	function idbyname($name) {

	}

	/**
	 * checks whether it is allowed to call method from outside 	or	 who is
	 * allowed to call.
	 *
	 * @param	String	$method	function to test
	 * @return	boolean	true if allowed, else false
	 */
	function acl($method) {
		if ($method == 'clearcache')
			return true;
		return false;
	}

	/**
	 * remove all templates from cache
	 */
	function clearcache() {
		if (get_config('cache_enabled', false)) {
			Session::removeCookie('template');
		}
		die('cache geleert');
	}

	/**
	 * Remove all not substituted tags from $template
	 *
	 * @param	String	$template	template contents
	 */
	function removeLostTags(& $template) {
		$suchmuster = '/\$\{.*\}/i';
		$template = preg_replace($suchmuster, '', $template);
	}

	/**
	 * parse $template for known tags and store them
	 *
	 * @param	String	$template	template contents
	 */
	function parseTags($template) {
		$result = array();
		$suchmuster = '/\$\{(\w*):(\w*\|?\w+)\}/i';
		$temp = array();
		preg_match_all($suchmuster, $template, $temp, PREG_SET_ORDER);
		foreach ($temp as $item) {
			$result[$item[1] . ':' . $item[2]] = array('type' => $item[1], 'value' => $item[2]);
		}
		$this->tags = $result;
	}

	/**
	 * Delete template
	 *
	 * @param	String	$class	category
	 * @param	String	$layout	name
	 */
	function deleteTemplate($class, $layout) {
		global $mysql;
		$class = $mysql->escape($class);
		$layout = $mysql->escape($layout);
		$query = "DELETE FROM template WHERE class='$class' AND layout='$layout';";
		$mysql->update($query);
	}

	/**
	 * Create template
	 *
	 * @param	String	$class	category
	 * @param	String	$layout	name
	 */
	function createTemplate($class, $layout) {
		global $mysql;
		$class = $mysql->escape($class);
		$layout = $mysql->escape($layout);
		$query = "INSERT INTO template(class, layout) VALUES('$class', '$layout');";
		$mysql->insert($query);
	}

//	/**
//	* public constructor
//	*/
//	function Template() {
//	}

	/**
	 * get all layouts for $class
	 *
	 * @param	String	$class	category
	 * @return	String[]	all layouts
	 */
	function getLayouts($class) {
		global $mysql;
		$class = $mysql->escape($class);
		$result = $mysql->select("SELECT layout, id FROM template WHERE class='$class';");
		return $result;
	}

	public function getLayoutOptions($class, $default) {
		$list = Template::getLayouts($class);
		$return = "<option value='0'></option>";
		foreach ($list as $layout) {
			$selected = "";
			if ($layout[1] == $default)
				$selected = "SELECTED='SELECTED'";
			$return .= "<option $selected value='{$layout[1]}'>{$layout[0]}</option>";
		}
		return $return;
	}

	protected function getCachedLayout($class, $layout) {
		if (!get_config('cache_enabled', false)) {
			return false;
		}

		$cached = Session::getSubCookie('template', $class);
		if (empty($cached) || !is_array($cached) || !array_key_exists($layout, $cached)) {
			return false;
		}

		return $cached[$layout];
	}

	protected function setCachedLayout($class, $layout, $value) {
		if (!get_config('cache_enabled', false)) {
			return;
		}

		$cached = Session::getSubCookie('template', $class);
		if (empty($cached) || !is_array($cached)) {
			$cached = array();
		}

		$cached[$layout] = $value;
		Session::setSubCookie('template', $class, $cached);
	}

	/**
	 * Returns parsed template
	 *
	 * @param	String	$class	category
	 * @param	String	$layout	template name
	 * @param	String[]	$array	array of elements to replace tags in
	 * template
	 * @param	boolean	$noparse	if true, no replacement is made
	 * @param	String[]$vars	request parameters
	 * @param	boolean	$nocache	if false, take template from session cache
	 * @return	String	template as string
	 */
	function getLayout($class, $layout, $array = array(), $noparse = false, $vars = array(), $nocache = false) {
		global $mysql;
		$class = $mysql->escape($class);
		$layout = $mysql->escape($layout);
		$string = '';
		if (isset($vars['ref']))
			$array['__ref__'] = $vars['ref'];

		if (!$nocache && $this->getCachedLayout($class, $layout))
			$string = $this->getCachedLayout($class, $layout);
		else {
			$result = $mysql->select("SELECT content FROM template WHERE class='$class' AND layout='$layout'");
			if (isset($result[0]) && isset($result[0][0]))
				$string = $result[0][0];
			if (get_config('cache_enabled', false))
				$this->setCachedLayout($class, $layout, $string);
		}
		if ($noparse)
			return $string;
		$string = html_entity_decode($string, ENT_COMPAT, Setting::read('charset', 'UTF-8'));
		$string = HTML::convert_specialchars($string);
		$keys = array_keys($array);
		foreach ($keys as $key) {
			$string = stripcslashes(str_replace('${' . $key . '}', $array[$key], $string));
		}
		$this->parseTags($string);
		foreach ($this->tags as $key => $item) {
			$type = $mysql->escape($item['type']);
			$value = $mysql->escape($item['value']);
			if ($type == 'image')
				$array[$key] = '?image/show/' . $value;
			else {
				$obj = new $type($value);
				$temp = $obj->show($vars);
				/* if ($this->loggedIn()) // debuginfo
				  $temp = "<!-- start $type/$value -->" . $temp . "<!-- end $type/$value -->"; */
				$array[$key] = $temp;
			}
		}
		$keys = array_keys($array);
		foreach ($keys as $key) {
			$string = str_replace('${' . $key . '}', $array[$key], $string);
		}
		$this->removeLostTags($string);
		/* if ($this->loggedIn()) // debuginfo
		  $string = "<!-- start $class/$layout -->" . $string . "<!-- end $class/$layout -->"; */
		return $string;
	}

}
