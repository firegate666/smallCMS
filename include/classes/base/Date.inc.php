<?php

	Setting::write('timestampformat', '%Y-%m-%d %H:%M:%S', 'Timestamp Format', false);

/**
 * @package base
 */
class Date {

	/**
	* get actual date formatted
	*
	* @param	String	$formatstring	format date, see php doc
	* @return	String	formatted date
	*/
	public static function now($formatstring = '') {
		if(empty($formatstring)) {
			$formatstring = Setting::read("timestampformat");
		}
		return strftime("$formatstring", time());
	}
}
