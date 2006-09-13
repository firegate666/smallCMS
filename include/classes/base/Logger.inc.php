<?php
abstract class Logger {
	protected $loglevel;
	
	
	abstract public function write($msg, $loglevel=0);
	
}

class FileLogger extends Logger {

	public function write($msg, $loglevel=0) {
		$timestamp = Date::now();
		$userid = User::loggedIn();
		$msg = "$timestamp ($userid): ".$msg."\n";
		$filename = 'cache/log.txt';
		file_put_contents($filename, $msg, FILE_APPEND);
	}
	
}
?>