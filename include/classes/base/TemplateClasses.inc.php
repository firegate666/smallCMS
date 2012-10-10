<?php
/**
 * Description of TemplateClasses
 *
 * @author marco.behnke
 */
final class TemplateClasses {

	protected static $classes = array();

	public static function add($name) {
		self::$classes[] = $name;
	}

	public static function get() {
		sort(self::$classes);
		self::$classes = array_unique(self::$classes);
		return self::$classes;
	}
}
