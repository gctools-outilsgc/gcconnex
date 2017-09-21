<?php
/**
 * List a user's friends' pages
 *
 * @package ElggPages
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('pages/all');
}

elgg_push_breadcrumb($owner->name, "pages/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('pages:friends');

$integrate_in_pages = elgg_get_plugin_setting('integrate_in_pages', 'etherpad') == 'yes';

$content = list_user_friends_objects($owner->guid, $integrate_in_pages ? array('page_top', 'etherpad') : 'page_top', 10, false);
if (!$content) {
	$content = elgg_echo('pages:none');
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

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
