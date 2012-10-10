<?php

UserPrivileges::add('configadmin', 'can view config');
UserPrivileges::add('settingsadmin', 'can edit settings');

/**
 * @package base
 */
class Setting extends AbstractClass {

	public function __construct($name = null) {
		if (($name != null) && ($name != '')) {
			global $mysql;
			$result = $mysql->executeSql("SELECT id FROM setting WHERE name='" . $mysql->escape($name) . "';");
			$this->id = $result['id'];
			if (!empty($this->id)) {
				$this->load();
			}
		}
	}

	/**
	 * set setting in db
	 * @param	String	$name	name of setting
	 * @param	String	$value	value of setting
	 * @param	boolean	$override	if true, overwrite if setting already exists
	 * @return	false, if $override = false and setting existed, else true
	 */
	function write($name, $value, $description = '', $override = true) {
		global $mysql;
		$name = $mysql->escape($name);
		$value = $mysql->escape($value);
		$description = $mysql->escape($description);
		$setting = new Setting($name);
		$setting->data['name'] = $name;
		$setting->data['description'] = $description;
		if ($override || !$setting->exists()) {
			$setting->data['value'] = $value;
			$setting->store();
		}
		Session::setSubCookie('setting', $name, $setting->data['value']);
		Session::setSubCookie('settingdesc', $name, $setting->data['description']);
		return true;
	}

	/**
	 * return setting value from db
	 *
	 * @param	String	$name	name of setting
	 * @param	String	$default	default if not set
	 * @return	String	value of setting
	 */
	function read($name, $default = '', $description = '') {
		if (Session::getSubCookie('setting', $name, false))
			return Session::getSubCookie('setting', $name, false);
		global $mysql;
		$result = null;
		$setting = new Setting($name);
		if (!$setting->exists()) {
			$result = $default;
		} else {
			$result = $setting->data['value'];
			$description = $setting->data['description'];
		}
		Session::setSubCookie('setting', $name, $result);
		Session::setSubCookie('settingdesc', $name, $description);
	}

}
