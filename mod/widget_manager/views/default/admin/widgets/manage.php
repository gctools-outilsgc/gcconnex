<?php
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

echo elgg_view_form('widget_manager/manage_widgets', [], ['widgets' => $configured_widgets, 'contexts' => $contexts]);
