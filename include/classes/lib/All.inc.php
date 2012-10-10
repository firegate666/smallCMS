<?php

$d = dirname(__FILE__) . '/';

require_once $d . 'Cache.inc.php';
require_once $d . 'TSP.inc.php';
require_once $d . 'XML.inc.php';

if (get_config('bbcode', true)) {
	require_once $d . 'stringparser_bbcode.class.php';
	require_once $d . 'DefaultBBCode.inc.php';
}
