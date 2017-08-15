<?php

$guid = (int) get_input('guid');
if (empty($guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$group = get_entity($guid);
if (!($group instanceof ElggGroup) || !$group->canEdit()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$group->group_tools_stale_touch_ts = time();

return elgg_ok_response('', elgg_echo('save:success'));
