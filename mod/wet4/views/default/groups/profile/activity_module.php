<?php
/**
 * Groups latest activity
 *
 * @todo add people joining group to activity
 * 
 * @package Groups
 */

if ($vars['entity']->activity_enable == 'no') {
	return true;
}

$group = $vars['entity'];
if (!$group) {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "groups/activity/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$db_prefix = elgg_get_config('dbprefix');
$content = elgg_list_group_river(array(
	'limit' => 4,
	'pagination' => false,
    'distinct' => false,
	'wheres1' => array(
		"oe.container_guid = $group->guid",
	),
	'wheres2' => array(
		"te.container_guid = $group->guid",
	),
));
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('groups:activity:none') . '</p>';
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('groups:activity'),
	'content' => $content,
	'all_link' => $all_link,
));
