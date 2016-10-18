<?php
/**
 * Elgg ideas plugin group page
 *
 * @package ideas
 */
$page_owner = elgg_get_page_owner_entity();
$lang = get_current_language();

if($page_owner->title3){
	$title_breadcrumbs = gc_explode_translation($page_owner->title3, $lang);
}else{
	$title_breadcrumbs = $page_owner->name;
}

elgg_push_breadcrumb($title_breadcrumbs);;
elgg_push_breadcrumb(elgg_echo('ideas:filter:new'));

if ($page_owner->canEdit() || elgg_is_admin_logged_in()) {
	elgg_register_menu_item('title', array(
		'name' => 'settings',
		'href' => "ideas/group/$page_owner->guid/settings",
		'text' => elgg_echo('ideas:group_settings'),
		'link_class' => 'elgg-button elgg-button-action edit-button gwfb group_admin_only',
	));
}

$offset = (int)get_input('offset', 0);
$order_by = get_input('order', 'desc');

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'idea',
	'container_guid' => $page_owner->guid,
	'limit' => 10,
	'offset' => $offset,
	'pagination' => true,
	'order_by' => 'time_created ' . $order_by,
	'full_view' => false,
	'list_class' => 'ideas-list',
	'item_class' => 'elgg-item-idea'
));

if (!$content) {
	$content = elgg_echo('ideas:none');
}

$title = elgg_echo('ideas:owner', array($page_owner->name));

$vars = array(
	'filter_context' => 'new',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('ideas/sidebar'),
);

$body = elgg_view_layout('ideas', $vars);

echo elgg_view_page($title, $body);