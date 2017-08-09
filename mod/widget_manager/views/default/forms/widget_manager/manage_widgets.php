<?php

$widgets = elgg_extract('widgets', $vars);
$contexts = elgg_extract('contexts', $vars);

if (empty($widgets)) {
	echo elgg_echo('widget_manager:forms:manage_widgets:no_widgets');
	return;
}

elgg_require_js('widget_manager/manage_widgets');

$widget_output = [];

foreach ($widgets as $widget_definition) {
	$key = $widget_definition->name . '_' . $widget_definition->id;
	$widget_output[$key] = elgg_view('forms/widget_manager/manage_widgets/widget', ['widget' => $widget_definition, 'contexts' => $contexts]);
}

ksort($widget_output);

echo implode('', $widget_output);
echo elgg_view('input/submit', ['value' => elgg_echo('save')]);
