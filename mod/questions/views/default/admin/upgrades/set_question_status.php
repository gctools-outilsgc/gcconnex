<?php

$dbprefix = elgg_get_config('dbprefix');
$status_id = elgg_get_metastring_id('status');

$status_where = "NOT EXISTS (
	SELECT 1
	FROM {$dbprefix}metadata md
	WHERE md.entity_guid = e.guid
	AND md.name_id = {$status_id})";

// Upgrade also possible hidden entities. This feature get run
// by an administrator so there's no need to ignore access.
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$count = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => \ElggQuestion::SUBTYPE,
	'wheres' => [
		$status_where,
	],
	'count' => true,
]);

access_show_hidden_entities($access_status);

if (empty($count)) {
	// mark upgrade as completed
	$factory = new ElggUpgrade();
	$upgrade = $factory->getUpgradeFromPath('admin/upgrades/set_question_status');
	if ($upgrade instanceof ElggUpgrade) {
		$upgrade->setCompleted();
	}
}

echo elgg_view('output/longtext', [
	'value' => elgg_echo('admin:upgrades:set_question_status:description'),
]);

echo elgg_view('admin/upgrades/view', [
	'count' => $count,
	'action' => 'action/questions/upgrades/set_question_status',
]);
