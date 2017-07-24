<?php
/**
 * View an idea
 *
 * @package ideas
 */
$lang = get_current_language();
$idea = get_entity(get_input('guid'));

$page_owner = elgg_get_page_owner_entity();


	$crumbs_title = gc_explode_translation($page_owner->title,$lang);


if (elgg_instanceof($page_owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "ideas/group/$page_owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "ideas/owner/$page_owner->username");
}

	$title = gc_explode_translation($idea->title, $lang);



elgg_push_breadcrumb($title);

$content = elgg_view_entity($idea, array('full_view' => 'full'));
$content .= elgg_view_comments($idea);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar' => elgg_view('ideas/sidebar')
));

echo elgg_view_page($title, $body);
