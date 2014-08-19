<?php

    /**
	 * Toggle language action
	 */
	
	// Register actions
	//register_action("togglelang");
	
    // Toggle language 
	global $SESSION;
	
	if ($SESSION['language'] == 'en') {
		$_SESSION['language'] = "fr";
	} else {
		$_SESSION['language'] = "en";
	}
	
	forward($_SERVER['HTTP_REFERER']);

?>