<?php

$group_guids = get_input('group_guids');

if (!empty($group_guids)) {
	if (!is_array($group_guids)) {
		$group_guids = [$group_guids];
	}
	
	$group_guids = array_map(function($value) {
		return (int) $value;
	}, $group_guids);
}

if (empty($group_guids)) {
	elgg_unset_plugin_setting('auto_join', 'group_tools');
} else {
	elgg_set_plugin_setting('auto_join', implode(',', $group_guids), 'group_tools');
}

return elgg_ok_response('', elgg_echo('save:success'));
