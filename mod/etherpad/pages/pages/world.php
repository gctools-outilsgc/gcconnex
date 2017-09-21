<?php
/**
 * List all pages
 *
 * @package ElggPages
 */

$title = elgg_echo('pages:all');

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('pages'));

elgg_register_title_button();

$integrate_in_pages = elgg_get_plugin_setting('integrate_in_pages', 'etherpad') == 'yes';

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => $integrate_in_pages ? array('page_top', 'etherpad') : 'page_top',
	'full_view' => false,
));
if (!$content) {
	$content = '<p>' . elgg_echo('pages:none') . '</p>';
}

if ($integrate_in_pages && elgg_is_logged_in()) {
	$url = "docs/add/" . elgg_get_logged_in_user_guid();
	elgg_register_menu_item('title', array(
			'name' => 'elggpad',
			'href' => $url,
			'text' => elgg_echo('etherpad:add'),
			'link_class' => 'elgg-button elgg-button-action',
			'priority' => 200,
	));
}

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('pages/sidebar'),
));

echo elgg_view_page($title, $body);
