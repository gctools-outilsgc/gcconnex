<?php

$plugin = elgg_get_plugin_from_id('linkedin_profile_importer');
$plugin_name = $plugin->getManifest()->getName();

$plugin->setSetting('debug_mode', get_input('debug_mode', false));
$plugin->setSetting('providers', serialize(get_input('providers', array())));

system_message(elgg_echo('plugins:settings:save:ok', array($plugin_name)));
forward(REFERER);