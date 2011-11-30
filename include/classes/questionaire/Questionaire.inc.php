<?php

$template_classes[] = 'questionaire';
$__userrights[] = array('name' => 'questionaireadmin', 'desc' => 'can edit own questionaires');
$__userrights[] = array('name' => 'questionairesuperadmin', 'desc' => 'can edit all questionaires');

/**
 * This is questionaire
 * 
 * @package questionaire
 */
class Questionaire extends AbstractClass
{

	protected $stats = array();

	/**
	 * get all answertye ids for one questionaire
	 * @param	int	$questionaireid
	 * @return	array
	 */
	public function getAnswertypeIDs($questionaireid = null)
	{
		global $mysql;
		$id = $this->get('id');
		if ($questionaireid != null)
			$id = $questionaireid;
		$query = "SELECT distinct qat.id
					FROM
					  questionanswertype qat,
					  questionanswer qa,
					  question q
					WHERE qat.id = qa.answertype
					AND qa.questionid = q.id
					AND q.questionaireid = $id
					ORDER BY q.id";
		return $mysql->select($query, true);
	}

	public function getAnswerCount()
	{
		global $mysql;
		$query = "SELECT anzahl FROM questionaire_answercount_view WHERE questionaireid = " . $this->get('id') . ";";
		$result = $mysql->select($query, true);
		return $result[0]['anzahl'];
	}

	public function getUsers()
	{
		global $mysql;
		$query = "SELECT email FROM questionaire_users_view WHERE questionaireid = " . $this->get('id') . ";";
		$result = $mysql->select($query, true);
		return $result;
	}

	/**
	 * get all given answers as assoc array
	 */
	public function getAnswerTable()
	{
		global $mysql;
		$query = "SELECT sem_id, questionanswervalue, quserid, __createdon
					FROM questionaire_answertable_view
					WHERE questionaireid = " . ($this->id) . ";";
		$result = $mysql->select($query, true);
		$return = array();
		foreach ($result as $answer)
		{
			$return[0][$answer['sem_id']] = $answer['sem_id'];
			$return[$answer['quserid']][$answer['sem_id']] = $answer['questionanswervalue'];
		}
		return $return;
	}

	public function csv_remote($vars)
	{
		// check remote login
		$u = new User();
		$u->login($vars);
		if ($this->hasright('admin') || $this->hasright('questionaireadmin'))
		{
			$this->csv($vars);
		} else
			die("Login failed");
		die;
	}

	public function list_remote($vars)
	{
		$u = new User();
		$u->login($vars);
		$list = array();
		if ($this->hasright('questionairesuperadmin'))
			$list = $this->getlist('', true, 'id', array('id', 'name'),
					'', '', array(array('key' => 'deleted', 'value' => 0)));
		else
			$list = $this->getlist('', true, 'id', array('id', 'name'),
					'', '', array(array('key' => 'deleted', 'value' => 0), array('key' => 'userid', 'value' => $this->loggedIn())));

		$content = '';
		foreach ($list as $entry)
		{
			foreach ($entry as $k => $v)
			{
				$content .= "\"$v\",";
			}
			$content .= "\n";
		}

		@header("Content-type: text/comma-separated-values;");
		@header("Content-disposition: attachment; filename=export_" . "questionaire" . "_" . (Date::now('%Y-%m-%d_%H:%M:%S')) . ".csv");
		print trim($content);
	}

	public function getFinishedCount()
	{
		$result = $this->getAnswerTable();
		$num_questions = count($result[0]);
		$num_full_qs = -1; // there is a header row!
		$num_dropped_qs = 0;
		$firstrow = true;
		foreach ($result as $userid => $row)
		{
			if (count($row) != $num_questions)
				$num_dropped_qs++;
			else
				$num_full_qs++;
		}
		if ($num_full_qs == -1)
			$num_full_qs = 0;
		return $num_full_qs;
	}

	public function csv($vars)
	{
		$result = $this->getAnswerTable();
		$num_questions = count($result[0]);
		$num_full_qs = -1; // there is a header row!
		$num_dropped_qs = 0;
		$content .= "\"userid\",";
		$firstrow = true;
		foreach ($result as $userid => $row)
		{
			if (count($row) != $num_questions)
			{
				$num_dropped_qs++;
				continue;
			} else
				$num_full_qs++;
			if (!$firstrow)
				$content .= "\"$userid\",";
			else
				$firstrow = false;
			foreach ($row as $cell)
			{
				$content .= "\"$cell\",";
			}
			$content .= "\n";
		}
		@header("Content-type: text/comma-separated-values;");
		@header("Content-disposition: attachment; filename=export_" . "questionaire" . "_" . (Date::now('%Y-%m-%d_%H:%M:%S')) . ".csv");
		print $content;
	}

	public function csv_emails($vars)
	{
		$result = $this->getUsers();
		$content = "";
		foreach ($result as $row)
		{
			foreach ($row as $cell)
			{
				$content .= "$cell;";
			}
			$content .= "\n";
		}
		@header("Content-type: text/comma-separated-values;");
		@header("Content-disposition: attachment; filename=export_" . "questionaireusers" . "_" . time() . ".csv");
		print $content;
	}

	public function acl($method)
	{
		if ($method == 'list_remote')
			return true;
		if (!$this->exists())
			return false;
		if ($method == 'csv_remote')
			return true;
		if (($method == 'csv') || ($method == 'csv_emails'))
			return ($this->hasright('admin') || $this->hasright('questionaireadmin'));
		if (($this->get('published') == 1) && ($this->get('closed') == 0))
		{
			if ($method == 'show')
				return true;
			if ($method == 'submit')
				return true;
		}
		return parent :: acl($method);
	}

	/**
	 * submit answers
	 */
	public function submit($vars)
	{
		if (!QuestionaireUser :: LoggedIn())
			error('Um an Umfragen teilzunehmen, muss man eingelogged sein', 'questionaire', 'submit', $vars);
		if (!isset($vars['question']) || !isset($vars['questionanswer']))
			return $this->show(array('err' => 'Es m&uuml;ssen alle Fragen beantwortet werden, bevor die Seite abgeschickt werden kann.'));
		// TODO �berpr�fen, ob dieser User diese Frage schon beantwortet hat
		$lastcc = Session::getCookie('questionaire_last_questioncount', null);
		if ($lastcc != count($vars['questionanswer']))
			return $this->show(array('err' => 'Es m&uuml;ssen alle Fragen beantwortet werden, bevor die Seite abgeschickt werden kann.'));
		foreach ($vars['question'] as $qid)
		{
			if (isset($vars['questionanswer'][$qid]))
			{ // there are questions with no answers
				foreach ($vars['questionanswer'][$qid] as $qaid => $value)
				{
					$qas = new QuestionaireAnswers();
					$qas->set('questionanswerid', $qaid);
					$qas->set('questionanswervalue', $value);
					$qas->set('quserid', QuestionaireUser :: LoggedIn());
					$qas->store();
				}
			}
		}
		return $this->show(array());
	}

	public function sendmail($quserid)
	{
		$qu = new QuestionaireUser($quserid);
		$from = $this->get('email');
		$to = $this->get('email');
		$subject = "Fragebogen abgeschlossen";
		$body = "Benutzer " . $qu->get('id') . " (" . $qu->get('email') . ")" .
			" hat die Beantwortung des Fragebogens " . $this->get('id') . " (" . $this->get('name') . ")" .
			" abgeschlossen.";
		$m = new Mailer();
		$m->simplesend($from, $to, $subject, $body);
	}

	public function show($vars)
	{
		$qu = new QuestionaireUser();
		if (!$qu->loggedin())
		{
			$vars['questionaireid'] = $this->get('id');
			return $qu->loginform($vars);
		}
		$qu = new QuestionaireUser(QuestionaireUser::LoggedIn());
		if ($qu->get('lastquestionaire') == 0)
		{
			$qu->set('lastquestionaire', $this->get('id'));
			$qu->store();
		}

		$questiontpl = 'default';
		if (($this->get('layout_question') != "") && ($this->get('layout_question') != 0))
		{
			$t = new Template($this->get('layout_question'));
			$questiontpl = $t->get('layout');
		}
		$array['id'] = $this->id;
		$questions = array();
		if (isset($vars['err']))
		{
			$array['error'] = $vars['err'];
			$questions = Session::getCookie('lastpage');
		}
		else
		{
			$questions = $this->getNextUnanswered(($this->get('randompages') == 1));
			Session::setCookie('lastpage', $questions);
		}
		if (count($questions) == 0)
		{
			$this->sendmail($qu->get('id'));
			//QuestionaireAnswers::finalize($this->get('id'), QuestionaireUser::LoggedIn());
			$qu->set('lastquestionaire', 0);
			$qu->store();
			$qu->dologout();
			$layoutend = $this->id . 'end';
			if (($this->get('layout_end') != "") && ($this->get('layout_end') != 0))
			{
				$t = new Template($this->get('layout_end'));
				$layoutend = $t->get('layout');
			}
			return $this->getLayout($array, $layoutend, $vars);
		}
		Session::setCookie('questionaire_last_questioncount', count($questions));
		$array['questions'] = '';
		$even = false;
		foreach ($questions as $question)
		{
			$question = new Question($question['qid']);
			$layout = $this->get('layout_question');
			if ($even)
			{
				$layout = $this->get('layout_question_alt');
			}
			$even = !$even;
			$array['questions'] .= $question->show($vars, $layout);
		}
		$layoutmain = $this->id;
		if (($this->get('layout_main') != "") && ($this->get('layout_main') != 0))
		{
			$t = new Template($this->get('layout_main'));
			$layoutmain = $t->get('layout');
		}
		$this->stats['abs_unanswered'] = Session::getCookie('abs_unanswered');
		$this->stats['abs_questions'] = Session::getCookie('abs_questions');
		$this->stats['abs_answered'] = Session::getCookie('abs_answered');
		$this->stats['abs_unanswered_in_page'] = Session::getCookie('abs_unanswered_in_page');
		$this->stats['pc_unanswered'] = Session::getCookie('pc_unanswered');
		$this->stats['pc_answered'] = Session::getCookie('pc_answered');
		$array = array_merge($array, $this->stats);
		$array = array_merge($array, $this->data);
		return $this->getLayout($array, $layoutmain, $vars);
	}

	/**
	 * __PRIVATE__
	 */
	private function getNextRandomPageFromBlock($questions)
	{
		$result = array();
		$qid = null;
		$pagenumbers = array();
		foreach ($questions as $question)
		{
			if ($qid == null)
			{
				$result[$question['groupname']][] = $question;
				$qid = $question['blockname'];
				$pagenumbers[] = $question['groupname'];
			}
			else
			{
				if ($question['blockname'] == $qid)
				{
					$result[$question['groupname']][] = $question;
					$pagenumbers[] = $question['groupname'];
				} else
					break;
			}
		}

		$pagecount = count($pagenumbers);
		$randompage = rand(0, $pagecount - 1);
		$result = $result[$pagenumbers[$randompage]];

		Session::setCookie('abs_unanswered_in_page', count($result));
		Session::setCookie('pc_unanswered', (Session::getCookie('abs_unanswered') / Session::getCookie('abs_questions')) * 100);
		Session::setCookie('pc_answered', 100 - Session::getCookie('pc_unanswered'));

		return $result;
	}

	/**
	 * return number of total questions
	 */
	public function getQuestioncount()
	{
		if (Session::getCookie('questionaire_abs_questions_' . $this->get('id'), false))
			return Session::getCookie('questionaire_abs_questions_' . $this->get('id'));
		$question = new Question();
		$count = count($question->getlistbyquestionaire($this->get('id')));
		Session::setCookie('questionaire_abs_questions_' . $this->get('id'), $count);
		return $count;
	}

	/**
	 * get all unanswered questions for logged in user but only next page
	 *
	 * @param	boolean	$random	if true, return not next page but random page
	 * from block
	 */
	protected function getNextUnanswered($random = false)
	{
		$questions = $this->getAllUnanswered();

		Session::setCookie('abs_unanswered', count($questions));
		Session::setCookie('abs_questions', $this->getQuestioncount());
		Session::setCookie('abs_answered', Session::getCookie('abs_questions') - Session::getCookie('abs_unanswered'));

		if ($random)
			return $this->getNextRandomPageFromBlock($questions);
		$result = array();
		$qid = null;
		foreach ($questions as $question)
		{
			if ($qid == null)
			{
				$result[] = $question;
				$qid = $question['groupname'];
			}
			else
			{
				if ($question['groupname'] == $qid)
					$result[] = $question;
				else
					break;
			}
		}

		Session::setCookie('abs_unanswered_in_page', count($result));
		Session::setCookie('pc_unanswered', (Session::getCookie('abs_unanswered') / Session::getCookie('abs_questions')) * 100);
		Session::setCookie('pc_answered', 100 - Session::getCookie('pc_unanswered'));

		return $result;
	}

	/**
	 * get all unanswered questions for logged in user
	 */
	protected function getAllUnanswered()
	{
		global $mysql;
		$quserid = QuestionaireUser :: loggedin();
		$query = "SELECT q.id as qid, qa.id as qaid, q.blockname, q.groupname
							FROM question q, questionanswer qa
							WHERE q.questionaireid = " . ($this->id) . "
							AND qa.questionid = q.id
							AND qa.id NOT IN (SELECT questionanswerid FROM questionaireanswers WHERE quserid=$quserid)
							ORDER BY blockname ASC, groupname ASC, qid ASC;";
		return $mysql->select($query, true);
	}

}
