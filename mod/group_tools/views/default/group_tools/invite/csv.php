<?php
/**
 * Upload a csv file to invite users to a group
 *
 * used in /forms/groups/invite
 */

echo elgg_format_element('div', [], elgg_echo('group_tools:group:invite:csv:description'));
echo elgg_view('input/file', [
	'name' => 'csv',
]);
