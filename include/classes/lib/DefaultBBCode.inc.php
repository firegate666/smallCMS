<?php

/**
 * Default implementation for bbcode
 *
 * @package lib
 */
class BBCode
{

	public function Parse($string)
	{
		global $bbcode;
		if (get_config('bbcode', false))
			return $bbcode->parse($string);
		else
			return $string;
	}

}

function convertlinebreaks($text)
{
	return preg_replace("/\015\012|\015|\012/", "\n", $text);
}

// Alles bis auf Neuezeile-Zeichen entfernen
function bbcode_stripcontents($text)
{
	return preg_replace("/[^\n]/", '', $text);
}

function do_bbcode_url($action, $attributes, $content, $params, $node_object)
{
	if ($action == 'validate')
	{
		return true;
	}
	if (!isset($attributes['default']))
	{
		return '<a href="' . htmlspecialchars($content) . '" target="_blank">' . htmlspecialchars($content) . '</a>';
	}
	return '<a href="' . htmlspecialchars($attributes['default']) . '" target="_blank">' . $content . '</a>';
}

// Funktion zum Einbinden von Bildern
function do_bbcode_img($action, $attributes, $content, $params, $node_object)
{
	if ($action == 'validate')
	{
		return true;
	}
	return '<img src="' . htmlspecialchars($content) . '" alt="">';
}

$bbcode = new StringParser_BBCode();
$bbcode->addFilter(STRINGPARSER_FILTER_PRE, 'convertlinebreaks');

//$bbcode->addParser(array ('block', 'inline', 'link', 'listitem'), 'htmlspecialchars');
$bbcode->addParser(array('block', 'inline', 'link', 'listitem'), 'nl2br');
$bbcode->addParser('list', 'bbcode_stripcontents');

$bbcode->addCode('quote', 'simple_replace', null, array('start_tag' => '<div class="quote">', 'end_tag' => '</div>'), 'inline', array('listitem', 'block', 'inline', 'link'), array());
$bbcode->addCode('b', 'simple_replace', null, array('start_tag' => '<b>', 'end_tag' => '</b>'), 'inline', array('listitem', 'block', 'inline', 'link'), array());
$bbcode->addCode('i', 'simple_replace', null, array('start_tag' => '<i>', 'end_tag' => '</i>'), 'inline', array('listitem', 'block', 'inline', 'link'), array());
$bbcode->addCode('url', 'usecontent?', 'do_bbcode_url', array('usecontent_param' => 'default'), 'link', array('listitem', 'block', 'inline'), array('link'));
$bbcode->addCode('link', 'callback_replace_single', 'do_bbcode_url', array(), 'link', array('listitem', 'block', 'inline'), array('link'));
$bbcode->addCode('img', 'usecontent', 'do_bbcode_img', array(), 'image', array('listitem', 'block', 'inline', 'link'), array());
$bbcode->addCode('bild', 'usecontent', 'do_bbcode_img', array(), 'image', array('listitem', 'block', 'inline', 'link'), array());
$bbcode->setOccurrenceType('img', 'image');
$bbcode->setOccurrenceType('bild', 'image');
$bbcode->setMaxOccurrences('image', 2);
$bbcode->addCode('list', 'simple_replace', null, array('start_tag' => '<ul>', 'end_tag' => '</ul>'), 'list', array('block', 'listitem'), array());
$bbcode->addCode('*', 'simple_replace', null, array('start_tag' => '<li>', 'end_tag' => '</li>'), 'listitem', array('list'), array());
$bbcode->setCodeFlag('*', 'closetag', BBCODE_CLOSETAG_OPTIONAL);
$bbcode->setCodeFlag('*', 'paragraphs', true);
$bbcode->setCodeFlag('list', 'paragraph_type', BBCODE_PARAGRAPH_BLOCK_ELEMENT);
$bbcode->setCodeFlag('list', 'opentag.before.newline', BBCODE_NEWLINE_DROP);
$bbcode->setCodeFlag('list', 'closetag.before.newline', BBCODE_NEWLINE_DROP);
//$bbcode->setRootParagraphHandling(true);
$bbcode->setGlobalCaseSensitive(false);
