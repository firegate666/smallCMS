<?/**
* one file to rule them all
*/
require_once dirname(__FILE__).'/config/All.inc.php';

// start/restore session
session_save_path('cache');
session_start();

require_once dirname(__FILE__).'/include/All.inc.php';

$s = new Session(User::loggedIn());

/**
 * Admincall?
 */
if (isset ($_REQUEST["admin"])) {
	include ('admin/admin.php');	$mysql->disconnect(); // remember to close connection
	die();
}

/**
 * decode query string
 */
$vars = array ();
if (isset ($_REQUEST['class']) || isset ($_REQUEST['method']) || isset ($_REQUEST['id'])) {
	$class = $_REQUEST["class"];
	$method = $_REQUEST["method"];
	$id = $_REQUEST["id"];
	$vars = array_merge(array (), $_REQUEST);
} else {
	// new style
	$qs = $_SERVER['QUERY_STRING'];
	decodeURI($qs, $class, $method, $id, $vars);
}
if (!empty($HTTP_POST_FILES['filename']['tmp_name']))	$vars['__files'] = $HTTP_POST_FILES;if (!isset ($vars['ref']))
	$vars['ref'] = $_SERVER['HTTP_REFERER'];
if (empty ($vars['ref']))
	$vars['ref'] = $_SERVER['REQUEST_URI'];

/**
 * Default handling
 */
if (get_config('usedefaults', true)) {
	if (empty ($class) or ($class == ''))
		$class = get_config("default_class");
	if (empty ($method) or ($method == ''))
		$method = get_config("default_method");
	if (empty ($id))
		$id = get_config("default_id");
}
/**
* Class and method invoking
*/
if (class_exists($class)) { // is there a class with that name?
	$newclass = new $class ($id);
	if (method_exists($newclass, $method)) { // is there a method with that name for that class
		if (!$newclass->acl($method))
			error("DENIED", $class, $method); // are you allowed to call?
		$result = $newclass-> $method ($vars);
		if ((strtolower($class) == "page") || (strtolower($class) == "admin")) { // are you a page
			/* count statistic */
			$ps = new PageStatistic();
			$ps->set('template', $id);
			$ps->store();			// output				$ct = $newclass->contenttype();			header("Content-Type: $ct;");		
			print $result;
		} else
			if (is_string($result)) // results a string?
				print $result;
			else
				if (is_array($result)) { // results an array?
					switch (strtoupper($result['content'])) {
						case "URL" :
							header("Location: ".$result['target']);
							die;
						case "XML" :
							{
								header("Content-Type: text/xml; charset=".Setting :: get('charset', ''));
								print $result['output'];
								die;
							}
						default :
							error("Wrong content found", 'index.php', 'return handling');
					}
				}
	} else
		error("Method not not found", $class, $method);
} else {
	error("Class not found", $class, $method);
}
if (get_config('debug', false)) {
	print "<hr><b>Queries executed:</b> ". ($mysql->getQuerycount());
	print " - ";
	print '<a href="?class=template&method=clearcache">Clear Cache</a>';
}
// clean up the mess
$mysql->disconnect();
?>