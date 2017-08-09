<?php

$contexts = elgg_extract('contexts', $vars);
$widget_definition = elgg_extract('widget', $vars);
if (!($widget_definition instanceof \Elgg\WidgetDefinition)) {
	return;
}

$originals = $widget_definition->originals;

$body = elgg_view('output/longtext', ['value' => $widget_definition->description]);

$body .= '<table class="elgg-table mbm">';
$body .= '<tr>';
$body .= '<th>' . elgg_echo('widget_manager:forms:manage_widgets:context') . '</th>';
$body .= '<th class="center">' . elgg_echo('widget_manager:forms:manage_widgets:can_add') . '</th>';
$body .= '<th class="center">' . elgg_echo('hide') . '</th>';
$body .= '</tr>';
foreach ($contexts as $context) {
	$body .= '<tr><td>';
	
	$options = [
		'name' => "widgets_config[{$widget_definition->id}][contexts][{$context}][enabled]",
		'label' => $context,
		'value' => 1,
		'checked' => in_array($context, $widget_definition->context),
		'label_class' => [],
	];
	
	if (!in_array($context, $originals['context'])) {
		$options['label_class'][] = 'widget-manager-unsupported-context';
	}
	
	if (in_array($context, $widget_definition->context)) {
		if (!in_array($context, $originals['context'])) {
			$options['label_class'][] = 'widget-manager-manage-widgets-non-default';
			$options['title'] = elgg_echo('widget_manager:forms:manage_widgets:non_default');
		}
	} elseif (in_array($context, $originals['context'])) {
		$options['label_class'][] = 'widget-manager-manage-widgets-non-default';
		$options['title'] = elgg_echo('widget_manager:forms:manage_widgets:non_default');
	}

	$body .= elgg_view('input/checkbox', $options);
	$body .= '</td><td class="center">';
	$body .= elgg_view('input/checkbox', [
		'name' => "widgets_config[{$widget_definition->id}][contexts][{$context}][can_add]",
		'value' => 1,
		'checked' => widget_manager_get_widget_setting($widget_definition->id, 'can_add', $context),
	]);
	$body .= '</td><td class="center">';
	$body .= elgg_view('input/checkbox', [
		'name' => "widgets_config[{$widget_definition->id}][contexts][{$context}][hide]",
		'value' => 1,
		'checked' => widget_manager_get_widget_setting($widget_definition->id, 'hide', $context),
	]);
	
	$body .= '</td></tr>';
}
$body .= '</table>';


// multiple
$options = [
	'#type' => 'checkbox',
	'#label' => elgg_echo('widget_manager:forms:manage_widgets:multiple'),
	'name' => "widgets_config[{$widget_definition->id}][multiple]",
	'value' => 1,
	'checked' => $widget_definition->multiple,
];
if ($widget_definition->multiple !== $originals['multiple']) {
	$options['label_class'] = 'widget-manager-manage-widgets-non-default';
	$options['title'] = elgg_echo('widget_manager:forms:manage_widgets:non_default');
}
$body .= elgg_view_field($options);

echo elgg_view_module('inline', $widget_definition->name . ' [' . $widget_definition->id . ']', $body, ['class' => 'man']);