<?php

elgg_register_event_handler('init', 'system', 'contactform_init');

function contactform_init() {

	// get the site's main url path
	$site = elgg_get_site_entity();
	$action_path = elgg_get_plugins_path() . 'contactform/';
    
    elgg_register_library('contact_lib', "{$action_path}/lib/functions.php");
    elgg_load_library('contact_lib');

	elgg_register_action('contactform/delete', "{$action_path}/actions/contactform/delete.php");
	elgg_register_page_handler('contactform','contactform_page_handler');
	elgg_extend_view('css/elgg', 'pages/css');

    requirements_check2();
	
	// Add menu link
	elgg_register_menu_item('site', array(
		'name' => 'Help',
        'href' => "{$site->getURL()}mod/contactform/",
        'text' => elgg_echo('contactform:help_menu_item'),
        'priority' => 1000,
	));
}

function contactform_page_handler($page) {
	include elgg_get_plugins_path() . 'contactform/index.php';
}

