<?php

/**
 * Group blog module
 */
$group = elgg_get_page_owner_entity();

if ($group->forums_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "forum/group/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
		));


$topics = hj_forum_get_latest_topics($group->guid, 5, false, true);

if (!$topics) {
	$content = '<p>' . elgg_echo("hj:framework:list:empty") . '</p>';
} else {
	elgg_push_context('widgets');
	$content = elgg_view_entity_list($topics, array(
		'full_view' => false
			));
	elgg_pop_context();
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('hj:forum:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => false,
));
