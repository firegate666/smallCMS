<?php

/**
 * every questions has 1 to n answers to answer
 * 
 * @package questionaire
 */
class QuestionAnswer extends AbstractClass {
	public function acl($method) {
		return false;
	}
}
