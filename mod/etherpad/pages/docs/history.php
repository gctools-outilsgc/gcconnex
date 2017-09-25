<?php
/**
 * History of revisions of a doc
 *
 * @package ElggPad
 */

$doc_guid = get_input('guid');
$lang = get_current_language();

$doc = get_entity($doc_guid);
if (!$doc) {

}

$container = $doc->getContainerEntity();
if (!$container) {

}

elgg_set_page_owner_guid($container->getGUID());

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb(gc_explode_translation($container->name, $lang), "docs/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "docs/owner/$container->username");
}
elgg_push_breadcrumb($doc->title, $doc->getURL());
elgg_push_breadcrumb(elgg_echo('etherpad:timeslider'));

$title = $doc->title . ": " . elgg_echo('etherpad:timeslider');

$content = elgg_view_entity($doc, array(
	'timeslider' => true,
	'full_view' => true,
));

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
