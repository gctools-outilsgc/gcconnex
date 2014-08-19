<?php

	/**
	 * Hook to handle emails send by elgg_send_email
	 * 
	 * @param string $hook
	 * @param string $type
	 * @param bool $return
	 * @param array $params
	 * 		to 		=> who to send the email to
	 * 		from 	=> who is the sender
	 * 		subject => subject of the message
	 * 		body 	=> message
	 * 		params 	=> optional params
	 */
	function html_email_handler_email_hook($hook, $type, $return, $params){
		// generate HTML mail body
		$html_message = html_email_handler_make_html_body($params["subject"], $params["body"]);
		
		// set options for sending
		$options = array(
			"to" => $params["to"],
			"from" => $params["from"],
			"subject" => $params["subject"],
			"html_message" => $html_message,
			"plaintext_message" => $params["body"]
		);
		
		return html_email_handler_send_email($options);
	}