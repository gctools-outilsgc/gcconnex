<?php

$widgets_config = get_input('widgets_config');

$contexts = ['index'];

// Use contexts defined for default widgets
$list = elgg_trigger_plugin_hook('get_list', 'default_widgets', null, []);
foreach ($list as $context_opts) {
	$contexts[] = $context_opts['widget_context'];
}

$configured_widgets = [];
foreach ($contexts as $context) {
	$configured_widgets += elgg_get_widget_types($context);
}

foreach ($widgets_config as $widget_id => $widget_config) {
	$configured_widget = elgg_extract($widget_id, $configured_widgets);
	if (empty($configured_widget)) {
		continue;
	}
		
	// only store if different
	if ((bool) $widget_config['multiple'] == (bool) $configured_widget->originals['multiple']) {
		unset($widgets_config[$widget_id]['multiple']);
	}
	
	$configured_contexts = $configured_widget->originals['context'];
	foreach ($widget_config['contexts'] as $context => $context_config) {
		if ($context_config['enabled']) {
			if (in_array($context, $configured_contexts)) {
				unset($widgets_config[$widget_id]['contexts'][$context]['enabled']);
			}
		} elseif (!in_array($context, $configured_contexts)) {
			unset($widgets_config[$widget_id]['contexts'][$context]['enabled']);
		}
	}
}

elgg_set_plugin_setting('widgets_config', json_encode($widgets_config), 'widget_manager');

system_message(elgg_echo('widget_manager:action:manage:success'));

forward(REFERER);
