<?php
$template_classes[] = 'questionanswertype';

/**
 * every answer has a type containing a template
 * 
 * @package questionaire
 */
class QuestionAnswertype extends AbstractClass {
	public function acl($method) {
		return false;
	}
}
