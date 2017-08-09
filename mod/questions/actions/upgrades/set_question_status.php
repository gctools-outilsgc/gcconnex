<?php
/**
 * Set the status metadata on a question
 */

$success_count = 0;
$error_count = 0;

$offset = (int) get_input('offset');
$upgrade_completed = (bool) get_input('upgrade_completed');

if ($upgrade_completed) {
	$factory = new ElggUpgrade();
	$upgrade = $factory->getUpgradeFromPath('admin/upgrades/set_question_status');
	if ($upgrade instanceof ElggUpgrade) {
		$upgrade->setCompleted();
		
		return elgg_ok_response();
	}
}

// prepare upgrade
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

$batch = new ElggBatch('elgg_get_entities', [
	'type' => 'object',
	'subtype' => \ElggQuestion::SUBTYPE,
	'wheres' => [
		$status_where,
	],
	'limit' => 50,
	'offset' => $offset,
]);
$batch->setIncrementOffset(false);

/* @var $question \ElggQuestion */
foreach ($batch as $question) {
	$question->reopen();
	
	$success_count++;
}

// restore hidden entities
access_show_hidden_entities($access_status);

// Give some feedback for the UI
return elgg_ok_response(json_encode([
	'numSuccess' => $success_count,
	'numErrors' => $error_count,
]));
