<?php

$id = get_input('id');
$type = get_input('type');
$title = get_input('title');

if (empty($id) || empty($type) || empty($title)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$fields = (array) get_input('field');
$operands = (array) get_input('operand');
$values = (array) get_input('value');

$patterns = [];

foreach ($values as $index => $value) {
	if (!isset($value) || $value === '') {
		continue;
	}
	
	$operand = elgg_extract($index, $operands);
	if ($operand === 'pregmatch') {
		$valid = @preg_match('/' . $value . '/', null);
		if (!$valid) {
			return elgg_error_response(elgg_echo('group_tools:action:admin:auto_join:additional:error:pregmatch'));
		}
	}
	
	$patterns[] = [
		'field' => elgg_extract($index, $fields),
		'operand' => $operand,
		'value' => $value,
	];
}

$config = [
	'id' => $id,
	'type' => $type,
	'title' => $title,
	'group_guids' => (array) get_input('group_guids', []),
	'patterns' => $patterns,
];

if (group_tools_save_auto_join_configuration($config)) {
	return elgg_ok_response('', elgg_echo('save:success'), REFERER);
}

return elgg_error_response(elgg_echo('save:fail'));
