<?php
/**
 * @package lib
 */
class Cache {
	public static function read($key) {
		if (file_exists('./cache/files/'.$key))
			return file_get_contents('./cache/files/'.$key);
		else
			return false;
	}
	
	public static function write($key, $value) {
		if (!is_dir('./cache/files/'))
			mkdir('./cache/files/', 0777);
		file_put_contents('./cache/files/'.$key, $value);
	}
}
