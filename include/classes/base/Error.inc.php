<?php

$template_classes[] = 'error';

/**
 * The Error-Class, gets pages for different errors
 * 
 * @package base
 */
class Error extends AbstractClass
{

	protected $class = '';
	protected $method = '';
	protected $msg = '';

	/**
	 * constructor
	 *
	 * @param	String	$msg	message to be shown
	 * @param	String	$class	who throws the error
	 * @param	String	$method	when?
	 */
	function __construct($msg, $class='', $method='')
	{
		$this->msg = $msg;
		$this->class = $class;
		$this->method = $method;
	}

	/**
	 * show errorpage
	 */
	function show(&$vars)
	{
		if (get_config('cms', false))
		{
			$array = array(
				"message" => $this->msg,
				"class" => $this->class,
				"method" => $this->method
			);
			return $this->getLayout($array, "page", $vars);
		}
		else
		{
			$result = "Error " . $this->class . "/" . $this->method . ": " . $this->msg;
			return $result;
		}
	}

}
