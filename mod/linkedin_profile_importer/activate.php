<?php

$providers = elgg_get_plugin_setting('providers', 'linkedin_profile_importer');

if (is_null($providers)) {
	$providers = array(
		"LinkedIn" => array(
			"enabled" => false,
			"keys" => array("key" => "", "secret" => "")
		),
	);
} else {
	$providers = unserialize($providers);
}

elgg_set_plugin_setting('providers', serialize($providers), 'linkedin_profile_importer');

elgg_set_plugin_setting('base_url', elgg_normalize_url('linkedin/endpoint'), 'linkedin_profile_importer');
elgg_set_plugin_setting('debug_mode', false, 'linkedin_profile_importer');
elgg_set_plugin_setting('debug_file', elgg_get_plugins_path() . 'linkedin_profile_importer/debug.log', 'linkedin_profile_importer');
