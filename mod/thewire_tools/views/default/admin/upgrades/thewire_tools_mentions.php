<?php

// Upgrade also possible hidden entities. This feature get run
// by an administrator so there's no need to ignore access.
$access_status = access_get_show_hidden_status();
access_show_hidden_entities(true);

$options = array(
	"type" => "user",
	"plugin_id" => "thewire_tools",
	"plugin_user_setting_name" => "notify_mention",
	"count" => true
);
$count = elgg_get_entities_from_plugin_user_settings($options);

echo elgg_view("admin/upgrades/view", array(
	"count" => $count,
	"action" => "action/thewire_tools/mentions_upgrade",
));

access_show_hidden_entities($access_status);