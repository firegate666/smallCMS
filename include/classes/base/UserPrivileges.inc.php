<?php
/**
 * Description of UserRights
 *
 * @author marco.behnke
 */
final class UserPrivileges {

	protected static $rights = array();

	public static function add($name, $description) {
		self::$rights[] = array('name' => $name, 'desc' => $description);
	}

	public static function get() {
		return self::$rights;
	}
}
