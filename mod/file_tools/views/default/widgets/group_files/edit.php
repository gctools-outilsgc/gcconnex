<?php

$widget = elgg_extract('entity', $vars);

$file_count = (int) $widget->file_count;
if ($file_count < 1) {
	$file_count = 4;
}

echo elgg_view_input('select', [
	'label' => elgg_echo('file:num_files'),
	'name' => 'params[file_count]',
	'options' => range(1, 10),
	'value' => $file_count,
]);
