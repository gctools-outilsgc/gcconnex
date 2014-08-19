<?php

	$session_id = $_POST['PHPSESSID'];
	session_id($session_id);
	
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/engine/start.php');
	
	action("file/upload");