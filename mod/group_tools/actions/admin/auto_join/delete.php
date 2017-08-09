<?php

$id = get_input('id');
if (empty($id)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$config = group_tools_get_auto_join_configuration($id);
if (empty($config)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$title = elgg_extract('title', $config);
if (group_tools_delete_auto_join_configuration($id)) {
	return elgg_ok_response('', elgg_echo('entity:delete:success', [$title]), REFERER);
}

return elgg_error_response(elgg_echo('entity:delete:fail', [$title]));
