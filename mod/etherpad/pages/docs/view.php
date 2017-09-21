<?php
/**
 * View a single doc
 *
 * @package ElggPad
 */

$doc_guid = get_input('guid');
$lang = get_current_language();

$doc = get_entity($doc_guid);
if (!$doc) {
	forward();
}

elgg_set_page_owner_guid($doc->getContainerGUID());

group_gatekeeper();

$container = elgg_get_page_owner_entity();
if (!$container) {
}

$title = $doc->title;

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb(gc_explode_translation($container->name, $lang), "docs/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "docs/owner/$container->username");
}
elgg_push_breadcrumb($title);

$content = elgg_view_entity($doc, array('full_view' => true));
if(in_array($doc->getSubtype(), array('etherpad', 'subpad')) ||
elgg_get_plugin_setting('show_comments', 'etherpad') == 'yes'){
	$content .= elgg_view_comments($doc);
}

$body = elgg_view_layout('one_column', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
