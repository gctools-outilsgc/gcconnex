<?php

$viewer = elgg_get_logged_in_user_entity();
$groups = elgg_get_entities_from_relationship(array(
	'types' => 'group',
	'relationship' => 'member',
	'relationship_guid' => $viewer->guid,
	'limit' => 0
));

if (!$groups) {
	echo '<p>' . elgg_echo('hj:forum:groups:notamember') . '</p>';
	return true;
}

foreach ($groups as $group) {
	$container_guids[] = $group->guid;
}

$params = array(
	'list_id' => "groupforums",
	'container_guids' => $container_guids,
	'subtypes' => array('hjforum', 'hjforumtopic')
);
echo elgg_view('framework/forum/lists/forums', $params);
