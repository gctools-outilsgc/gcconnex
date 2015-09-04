<?php

$group_guids = get_input("group_guids");

if (empty($group_guids)) {
	register_error(elgg_echo("group_tools:action:error:input"));
	forward(REFERER);
}

// this could take a while
set_time_limit(0);

$options = array(
	"type" => "group",
	"guids" => $group_guids,
	"limit" => false
);

$batch = new ElggBatch("elgg_get_entities", $options, "elgg_batch_delete_callback", 25, false);

if ($batch->callbackResult) {
	system_message(elgg_echo("group_tools:action:bulk_delete:success"));
} else {
	register_error(elgg_echo("group_tools:action:bulk_delete:error"));
}

forward(REFERER);