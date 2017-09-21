<?php
/**
 * View a single page
 *
 * @package ElggPages
 */

$page_guid = get_input('guid');
$lang = get_current_language();

$page = get_entity($page_guid);
if (!$page) {
	forward();
}

elgg_set_page_owner_guid($page->getContainerGUID());

group_gatekeeper();

$container = elgg_get_page_owner_entity();
if (!$container) {
}

$title = $page->title;

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb(gc_explode_translation($container->name, $lang), "pages/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "pages/owner/$container->username");
}
pages_prepare_parent_breadcrumbs($page);
elgg_push_breadcrumb($title);

$content = elgg_view_entity($page, array('full_view' => true));
if(in_array($page->getSubtype(), array('page', 'page_top')) ||
elgg_get_plugin_setting('show_comments', 'etherpad') == 'yes'){
	$content .= elgg_view_comments($page);
}

if ($page->canEdit() && $container->canWriteToContainer()) {
	$url = "pages/add/$page->guid";
	elgg_register_menu_item('title', array(
			'name' => 'subpage',
			'href' => $url,
			'text' => elgg_echo('pages:newchild'),
			'link_class' => 'elgg-button elgg-button-action',
	));
	if(elgg_get_plugin_setting('integrate_in_pages', 'etherpad') == 'yes'){
		$url = "docs/add/$page->guid";
		elgg_register_menu_item('title', array(
				'name' => 'subpad',
				'href' => $url,
				'text' => elgg_echo('etherpad:newchild'),
				'link_class' => 'elgg-button elgg-button-action',
				'priority' => 200,
		));
	}
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('pages/sidebar/navigation'),
));

echo elgg_view_page($title, $body);
