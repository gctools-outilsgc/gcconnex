<?php

$pattern = elgg_extract('pattern', $vars, []);

$user_options = group_tools_get_auto_join_pattern_user_options();
$operand_options = [
	'equals' => elgg_echo('group_tools:auto_join:pattern:operand:equals'),
	'not_equals' => elgg_echo('group_tools:auto_join:pattern:operand:not_equals'),
	'contains' => elgg_echo('group_tools:auto_join:pattern:operand:contains'),
	'not_contains' => elgg_echo('group_tools:auto_join:pattern:operand:not_contains'),
	'pregmatch' => elgg_echo('group_tools:auto_join:pattern:operand:pregmatch'),
];

$field_name = elgg_extract('field', $pattern);
if (!array_key_exists($field_name, $user_options)) {
	// profile field was removed
	$user_options[$field_name] = $field_name;
}

$field = elgg_view('input/select', [
	'name' => 'field[]',
	'value' => $field_name,
	'options_values' => $user_options,
	'class' => [
		'group-tools-auto-join-match-pattern-field',
		'mrs',
	],
]);
$operand = elgg_view('input/select', [
	'name' => 'operand[]',
	'value' => elgg_extract('operand', $pattern),
	'options_values' => $operand_options,
	'class' => [
		'group-tools-auto-join-match-pattern-operand',
		'mrs',
	],
]);
$value = elgg_view('input/text', [
	'name' => 'value[]',
	'value' => elgg_extract('value', $pattern),
	'placeholder' => elgg_echo('group_tools:auto_join:pattern:value:placeholder'),
	'class' => [
		'group-tools-auto-join-match-pattern-value',
		'mrs',
	],
]);

echo elgg_format_element('div', ['class' => 'group-tools-auto-join-match-pattern'], $field . $operand . $value);
