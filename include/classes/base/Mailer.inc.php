<?php
/**
 * handle mailsending
 * 
 * States:
 * 0: waiting
 * 1: send
 * 2: error
 * 
 * @package base
 */
class Mailer extends AbstractClass{

	/**
	 * send email
	 * 
	 * @param	String	$from	message sender
	 * @param	String	$to	message receiver
	 * @param	String	$subject	message subject
	 * @param	String	$body	message body
	 * 
	 * @return	boolean	send result
	 */
	function simplesend($from, $to, $subject, $body) {
		
		if ($from == '')
			$from = get_config('sender', false);
			
		if ($to == '')
			$to = get_config('receiver', false);
		
		if (($from === false) || ($to === false)) {
			error('Email could not be send because no system sender and/or receiver is set',
				'Mailer', 'simplesend',
				array('from'=>$from, 'to'=>$to, 'subject'=>'subject', 'body'=>$body));
		} else {
			$headers = "From: $from";
			$this->set('mto', $to);
			$this->set('msubject', $subject);
			$this->set('mbody', $body);
			$this->set('mheader', $headers);
			$this->store();
			return $this->mail();
			//return @mail($to, $subject, $body, $headers);
		}
	}
	
	function mail() {
		if(@mail($this->get('mto'),$this->get('msubject'),$this->get('mbody'),$this->get('mheader'))) {
			$this->set('mstate', 1);
			$this->store();
			return true;
		} else {
			$this->set('mstate', 2);
			$this->store();
			return false;
		}
	}
}
?>