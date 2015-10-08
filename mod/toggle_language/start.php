<?php
 	global $CONFIG;
    function toggle_lang_init()
    {
		// Extend system CSS with our own styles for the language toggle button
		elgg_extend_view('css','toggle_language/css');
		
		// Add the language toggle button under the site name
       //elgg_extend_view('page_elements/header_content','toggle_language/toggle_lang');
	   elgg_extend_view('page/elements/header','toggle_language/toggle_lang');
    }
 
    elgg_register_event_handler('init','system','toggle_lang_init');
	
	// Create a session variable if is not already set
	$CONFIG->language="en";
	
	if ( _elgg_services()->session->get('language') == NULL ) { 
	
	if ($CONFIG->language) {
			_elgg_services()->session->set( 'language', $CONFIG->language );
		} else {
			_elgg_services()->session->set( 'language', 'en' );
		}
	}
	// Register actions
	elgg_register_action("toggle_language/toggle", true, $CONFIG->pluginspath . "toggle_language/actions/toggle.php");

    ?>