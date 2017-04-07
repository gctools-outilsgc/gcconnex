<?php
/**
 * Register the ElggBlog class for the object/blog subtype
 */

if (get_subtype_id('object', 'blog')) {
	update_subtype('object', 'blog', 'ElggBlog');
} else {
	add_subtype('object', 'blog', 'ElggBlog');
}
elgg_register_event_handler('init','system','carpool_init');

function carpool_init() {
	elgg_register_menu_item('site', array(
		'name' => 'carpool_init',
		'text' => elgg_echo('Carpool'),
		'href' => 'Carpool/all'

	));
	elgg_register_page_handler('Carpool', 'Carpool_page_handler');
}

function Carpool_page_handler($page) {

		if (!isset($page[0])) {
		$page[0] = 'all';
	}




	$pages = dirname(__FILE__) . '/GCcarpool/';

	switch ($page[0]) {
		case "all":
			include "$pages/main.php";
			break;

		
		default:
			return false;
	}

	//elgg_pop_context();
	return true;
}
