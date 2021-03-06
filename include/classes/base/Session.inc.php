<?php

/**
 * @package base
 */
class Session extends AbstractClass {

	protected $sid;
	protected static $write_close = false;

	public function sequence_name() {
		return strtolower(get_class($this)) . '_sid_seq';
	}

	/**
	 * Return value from session, if not set return default
	 *
	 * @param	String	$name	name of value
	 * @param	String	$default	default value
	 * @return	String	value
	 */
	static function getCookie($name, $default = '') {
		if (isset($_SESSION[$name]))
			return $_SESSION[$name];
		else
			return $default;
	}

	static function getSubCookie($name, $section, $default = '') {
		$value = Session::getCookie($name);
		if (empty($value) || !is_array($value) || !array_key_exists($section, $value)) {
			return $default;
		}

		return $value[$section];
	}

	/**
	 * Unset value
	 *
	 * @param	String	$name	name of value
	 */
	static function unsetCookie($name) {
		Session::openIfClosed();
		unset($_SESSION[$name]);
	}

	/**
	 * set value
	 *
	 * @param	String	$name	name of value
	 * @param	String	$value	value
	 */
	static function setCookie($name, $value) {
		Session::openIfClosed();
		$_SESSION[$name] = $value;
	}

	static function setSubCookie($name, $section, $value) {
		Session::openIfClosed();
		$_SESSION[$name][$section] = $value;
		return;
		// TODO this code is broken
		$old_cookie = Session::getSubCookie($name, $section);
		if (empty($old_cookie) || !is_array($old_cookie)) {
			$old_cookie = array();
		}

		$old_cookie[$section] = $value;
		Session::setCookie($name, $old_cookie);
	}

	/**
	 * empty value
	 *
	 * @param	String	$name	name of value
	 */
	static function removeCookie($name) {
		Session::setCookie($name, null);
	}

	/**
	 * delete all values from session
	 */
	static function cleanUpCookies() {
		Session::openIfClosed();
		$_SESSION = array();
	}

	function __construct($userid = null) {
		$this->data["uid"] = $userid;
		$this->data["client_ip"] = getClientIP();
		$this->sid = $this->store();
	}

	function isRegistered() {
		return (($this->id != NULL) && ($this->username != NULL));
	}

	static function writeClose() {
		Session::$write_close = true;
		session_write_close();
	}

	static function openIfClosed() {
		if (Session::$write_close) {
			session_start();
			Session::$write_close = false;
		}
	}

}
