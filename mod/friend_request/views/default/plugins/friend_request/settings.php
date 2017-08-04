<?php

$plugin = elgg_extract('entity', $vars);

$yesno_options = [
	'yes' => elgg_echo('option:yes'),
	'no' => elgg_echo('option:no'),
];

$add_river = elgg_echo('friend_request:settings:add_river');
$add_river .= elgg_view('input/select', [
	'name' => 'params[add_river]',
	'value' => $plugin->add_river,
	'options_values' => $yesno_options,
	'class' => 'mls',
]);

echo elgg_format_element('div', [], $add_river);
