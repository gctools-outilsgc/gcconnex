<?php

$widget = elgg_extract('entity', $vars);

$count = (int) $widget->file_count;
if ($count < 1) {
	$count = 8;
}

echo elgg_view_input('text', [
	'label' => elgg_echo('file:num_files'),
	'name' => 'params[file_count]',
	'value' => $count,
	'size' => 4,
	'maxlength' => 4,
]);
