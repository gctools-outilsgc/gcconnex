<?php

$thead_guid = (int) get_input("thread");
$guid = (int) get_input("guid");

if (empty($thead_guid) || empty($guid)) {
	return;
}

$options = array(
	"type" => "object",
	"subtype" => "thewire",
	"metadata_name_value_pairs" => array(
		"name" => "wire_thread",
		"value" => $thead_guid
	)
);

elgg_push_context("thewire_tools_thread");
echo elgg_list_entities_from_metadata($options);
elgg_pop_context();