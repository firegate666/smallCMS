<?php
/**
 * handle mailsending
 */
class Mailer {

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
			return @mail($to, $subject, $body, $headers);
		}
	}
}
?>