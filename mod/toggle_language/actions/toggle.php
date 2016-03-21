<?php

    /**
	 * Toggle language action
	 */
	
	// Register actions
	//register_action("togglelang");
	
    // Toggle language 
	global $SESSION;
	
	if (_elgg_services()->session->get('language') == 'en') {
		_elgg_services()->session->set( 'language', 'fr' );
	} else {
		_elgg_services()->session->set( 'language', 'en' );
	}
	
	forward($_SERVER['HTTP_REFERER']);

?>