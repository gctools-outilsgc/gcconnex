<?php
/*
 *
 * Contact Us
 *
 *
 * 
 *
 */

elgg_register_event_handler('init', 'system', 'contactus_init');

/**
 * Initialize the plugin
 */
function contactus_init() {

	elgg_register_page_handler('contactus', 'contactus_page_handler');

		$href = "/contactus";
		
		// register footer menu item
		elgg_register_menu_item('footer', array(
			'name' => 'contact',
			'href' => $href,
			'title' => elgg_echo('contactus'),
			'text' => elgg_echo('contactus'),
			'priority' => 500,
			'section' => 'alt',
		));

		// register sidebar menu item
		elgg_register_menu_item('site', array(
        'name' => 'contact',
		'href' => $href,
		'title' => elgg_echo('contactus'),
		'text' => elgg_echo('contactus'),
         'priority' => 101,
    ) );
}

function contactus_page_handler($page) {
	gatekeeper();

	$content .= elgg_view_title(elgg_echo('contactus'));
	$content .= elgg_echo('contactus:pagecontent');

	$params = array(
		'content' => $content,
	);
	$body = elgg_view_layout('page', $params);

	echo elgg_view_page(elgg_echo('contactus'), $body);
	return true;
}