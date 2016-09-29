<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */
$lang = get_current_language();
$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('', '404');
}

// access check for closed groups
elgg_group_gatekeeper();

if(!$owner->title3){
	$title = elgg_echo('pages:owner', array($owner->name));
    elgg_push_breadcrumb($owner->name);
}else{
	$title = elgg_echo('pages:owner', array(gc_explode_translation($owner->title3, $lang)));
    elgg_push_breadcrumb(gc_explode_translation($owner->title3, $lang));
}



elgg_push_breadcrumb(gc_explode_translation($owner->title3, $lang));

elgg_register_title_button();

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'page_top',
	'container_guid' => elgg_get_page_owner_guid(),
	'full_view' => false,
	'no_results' => elgg_echo('pages:none'),
	'preload_owners' => true,
));

$filter_context = '';
if (elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$sidebar = elgg_view('pages/sidebar/navigation');
$sidebar .= elgg_view('pages/sidebar');

$params = array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);

if (elgg_instanceof($owner, 'group')) {
	$params['filter'] = '';
}

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
