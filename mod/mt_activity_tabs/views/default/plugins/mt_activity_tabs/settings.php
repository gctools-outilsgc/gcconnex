<?php

namespace AU\ActivityTabs;

$options = array(
	'name' => 'params[user_activity]',
	'value' => $vars['entity']->user_activity ? $vars['entity']->user_activity : 'yes',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	),
);

echo elgg_echo('activity_tabs:user_activity:description') . "<br>";
echo elgg_view('input/dropdown', $options) . "<br><br>";
