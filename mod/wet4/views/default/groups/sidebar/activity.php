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

elgg_push_context('widgets');
$db_prefix = elgg_get_config('dbprefix');
$content = elgg_list_river(array(
	'limit' => 3,
	'pagination' => false,
	'joins' => array(
		"JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid",
		"LEFT JOIN {$db_prefix}entities e2 ON e2.guid = rv.target_guid",
	),
	'wheres' => array(
		"(e1.container_guid = $group->guid OR e2.container_guid = $group->guid)",
	),
));
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('groups:activity:none') . '</p>';
}

$all_link = elgg_view('output/url', array(
	'href' => "groups/activity/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

echo elgg_view('page/components/module', array(
	'title' => elgg_echo('groups:activity'),
	'body' => $content,
	'footer' => $all_link,
));