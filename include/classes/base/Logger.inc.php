<?php

define('LOGLEVEL_ERROR', 0);
define('LOGLEVEL_ACTION', 5);
define('LOGLEVEL_INFO', 7);
define('LOGLEVEL_DEBUG', 10);

/**
 * @package base
 */
abstract class Logger {
	protected $loglevel;


	abstract public function write($msg, $loglevel=0);

}

/**
 * @package base
 */
class FileLogger extends Logger {

	public function write($msg, $loglevel=0) {
		if ($loglevel > get_config('loglevel', 5)) // no logging
			return;
		$timestamp = Date::now();
		$userid = 0;
		$msg = "$timestamp ($userid): ".$msg."\n";
		$filename = 'cache/log.txt';
		file_put_contents($filename, $msg, FILE_APPEND);
	}

}
