<?php

/**
 * index.php, one file to rule them all
 *
 * load all needed classes, start session
 * decode input handle class & action
 */
// load config
$config = dirname(__FILE__) . '/config/config.inc.php';
if (!file_exists($config))
	die('Configuration file is missing. Run installer-');
require_once $config;
// start/restore session
session_save_path('cache');
session_start();

// load classbase
require_once dirname(__FILE__) . '/include/All.inc.php';

// store session
$s = new Session(User::loggedIn());
Session::writeClose();

// if admincall load admin scene
if (isset($_REQUEST["admin"]))
{
	require ('admin/admin.php');
	$mysql->disconnect();
	die();
}

// decode query string
$vars = array();
if (isset($_REQUEST['class']) || isset($_REQUEST['method']) || isset($_REQUEST['id']))
{
	// old style, used in HTML forms
	$class = isset($_REQUEST["class"]) ? $_REQUEST["class"] : '';
	$method = isset($_REQUEST["method"]) ? $_REQUEST["method"] : '';
	$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : '';
	$vars = array_merge(array(), $_REQUEST);
}
else
{
	// new style
	$qs = $_SERVER['QUERY_STRING'];
	decodeURI($qs, $class, $method, $id, $vars);
}

// decode file upload in query string
if (!empty($_FILES['filename']['tmp_name']))
	$vars['__files'] = $_FILES;
if (!isset($vars['ref']) && isset($_SERVER['HTTP_REFERER']))
	$vars['ref'] = $_SERVER['HTTP_REFERER'];
if (empty($vars['ref']))
	$vars['ref'] = $_SERVER['REQUEST_URI'];

// default handling
if (get_config('usedefaults', true))
{
	if (empty($class) or ($class == ''))
		$class = get_config("default_class");
	if (empty($method) or ($method == ''))
		$method = get_config("default_method");
	if (empty($id))
		$id = get_config("default_id");
}

// Class and method invoking
if (class_exists($class))
{ // is there a class with that name?
	$newclass = new $class($id);
	if (method_exists($newclass, $method))
	{ // is there a method with that name for that class
		if (!$newclass->acl($method))  // are you allowed to call?
			error("DENIED", $class, $method);
		$result = $newclass->$method($vars);
		if ((strtolower($class) == "page") || (strtolower($class) == "admin"))
		{ // are you a page
			/* count statistic */
			$ps = new PageStatistic();
			$ps->set('template', $id);
			$ps->store();
			// output
			$ct = $newclass->contenttype();
			header("Content-Type: $ct;");
			print $result;
		}
		else // no page? who are you?
		if (is_string($result)) // results a string?
			print $result;
		else
		if (is_array($result))
		{ // results an array?
			switch (strtoupper($result['content']))
			{
				case "URL" :
					header("Location: " . $result['target']);
					die;
				case "XML" :
					{
						header("Content-Type: text/xml; charset=" . Setting :: get('charset', ''));
						print $result['output'];
						die;
					}
				default :
					error("Wrong content found", 'index.php', 'return handling');
			}
		}
	} else
		error("Method not not found", $class, $method);
} else
{
	error("Class not found", $class, $method);
}
// debug output, this one has to be moved to parseTags in template as it destroys layout
if (get_config('debug', false))
{
	print "<hr><b>Queries executed:</b> " . ($mysql->getQuerycount());
	print " - ";
	print '<a href="?class=template&method=clearcache">Clear Cache</a>';
}
// clean up the mess
$mysql->disconnect();
