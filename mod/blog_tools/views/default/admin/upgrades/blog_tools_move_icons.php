<?php

// Upgrade also possible hidden entities. This feature get run
// by an administrator so there's no need to ignore access.
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$count = 0;

// make sure no left over from previous run
$session = elgg_get_session();
$session->remove('blog_tools_move_icon_offset');

// check if upgrade is done
$path = 'admin/upgrades/blog_tools_move_icons';
$factory = new \ElggUpgrade();
$upgrade = $factory->getUpgradeFromPath($path);
if (empty($upgrade) || !$upgrade->isCompleted()) {
	// get the count off the items to move
	$count = elgg_get_entities_from_metadata([
		'type' => 'object',
		'subtype' => 'blog',
		'metadata_name' => 'icontime',
		'count' => true,
	]);
}

echo elgg_view('output/longtext', ['value' => elgg_echo('admin:upgrades:blog_tools_move_icons:description')]);

echo elgg_view('admin/upgrades/view', [
	'count' => $count,
	'action' => 'action/blog_tools/upgrades/move_icons',
]);

access_show_hidden_entities($access_status);
