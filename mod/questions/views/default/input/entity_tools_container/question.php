<?php

if (elgg_get_plugin_setting('limit_to_groups', 'questions', 'no') === 'yes') {
	$vars['add_users'] = false;
}

echo elgg_view('input/entity_tools_container', $vars);
