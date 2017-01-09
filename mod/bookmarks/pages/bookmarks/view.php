<?php
/**
 * View a bookmark
 *
 * @package ElggBookmarks
 */

$guid = get_input('guid');

elgg_entity_gatekeeper($guid, 'object', 'bookmarks');

$bookmark = get_entity($guid);

$page_owner = elgg_get_page_owner_entity();

$lang = get_current_language();

elgg_group_gatekeeper();

if (!$page_owner->title){
	$crumbs_title = $page_owner->name;
}else{	
	$crumbs_title = gc_explode_translation($page_owner->title, $lang);
}

if (elgg_instanceof($page_owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "bookmarks/group/$page_owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "bookmarks/owner/$page_owner->username");
}

$title = gc_explode_translation($bookmark->title,$lang);

elgg_push_breadcrumb($title);

$content = elgg_view_entity($bookmark, array('full_view' => true));
$content .= elgg_view_comments($bookmark);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
