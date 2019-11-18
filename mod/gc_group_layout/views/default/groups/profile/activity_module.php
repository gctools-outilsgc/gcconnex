<?php
/**
 * Groups latest activity
 *
 * @todo add people joining group to activity
 * 
 * @package Groups
 */

$group = $vars['entity'];
if (!$group) {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "groups/activity/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('activity');
$db_prefix = elgg_get_config('dbprefix');
$content = newsfeed_list_river(array(
	'limit' => 10,
	'pagination' => false,
    'distinct' => false,
	'wheres' => array(
		"(oe.container_guid = $group->guid OR te.container_guid = $group->guid)",
	),
));
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('groups:activity:none') . '</p>';
}


echo '<div>'.elgg_view('groups/profile/tab_menu'). '</div>';

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('groups:activity'),
	'content' => $content,
	'all_link' => $all_link,
));
