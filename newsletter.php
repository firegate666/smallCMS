<?php

// TODO better handling in newsletter class
require_once dirname(__FILE__) . '/config/All.inc.php';

session_save_path('cache');
session_start();

require_once dirname(__FILE__) . '/include/All.inc.php';
$s = new Session();

if (!empty($_REQUEST['email'])) {
	global $mysql;
	$query = "INSERT INTO newsletter(email) VALUES('{$_REQUEST['email']}');";
	$id = $mysql->insert($query, 'newsletter_id_seq');
	$to = 'marco@firegate.de';
	$subject = "Newslettereintrag";
	$body = "Eine neue Newsletteranmeldung liegt vor von {$_REQUEST['email']}";
	$headers = 'From: ' . $to . "\r\n" . 'Reply-To: ' . $to . "\r\n" . 'X-Mailer: PHP/' . phpversion();
	mail($to, $subject, $body, $headers);
	header("Location: " . $_REQUEST['ref']);
} else
	header("Location: " . $_REQUEST['referr']);
