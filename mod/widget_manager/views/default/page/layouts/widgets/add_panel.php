<?php
/**
 * Widget add panel
 *
 * @uses $vars['context']     The context for this widget layout
 * @uses $vars['exact_match'] Only use widgets that match the context
 * @uses $vars['container']   Container to optional limit widgets for. Defaults to page_owner_entity
 */

if (!elgg_is_xhr()) {
	return;
}

$context = elgg_extract('context', $vars);
$widget_context = elgg_extract('widget_context', $vars, $context);
$show_access = (int) elgg_extract('show_access', $vars);
$exact = elgg_extract('exact_match', $vars, false);

$owner_guid = (int) elgg_extract('owner_guid', $vars);
$context_stack = elgg_extract('context_stack', $vars);

if (!empty($context_stack)) {
	elgg_set_context_stack($context_stack);
}

elgg_set_page_owner_guid($owner_guid);
$owner = elgg_get_page_owner_entity();
$container = elgg_extract('container', $vars, elgg_get_page_owner_entity());

echo elgg_view('input/hidden', [
	'name' => 'widget_context',
	'value' => $widget_context,
]);
echo elgg_view('input/hidden', [
	'name' => 'show_access',
	'value' => $show_access
]);
	
$widget_context = str_replace('default_', '', $context);

$available_widgets_context = elgg_trigger_plugin_hook('available_widgets_context', 'widget_manager', [], $widget_context);

$widgets = elgg_get_widget_types($available_widgets_context, $exact);
$widgets = elgg_get_widget_types([
	'context' => $available_widgets_context,
	'exact' => $exact,
	'container' => $container,
]);
widget_manager_sort_widgets($widgets);

$user_widgets = elgg_extract('user_widgets', $vars);
if (!isset($vars['user_widgets'])) {
	$user_widgets = elgg_get_widgets($owner->guid, $context);
}

$current_handlers = [];
if (!empty($user_widgets)) {
	// check for already used widgets
	foreach ($user_widgets as $column_widgets) {
		// foreach column
		foreach ($column_widgets as $column_widget) {
			// for each widgets
			$current_handlers[] = $column_widget->handler;
		}
	}
}

$search_box = elgg_view('input/text', [
	'title' => elgg_echo('search'),
	'placeholder' => elgg_echo('widget_manager:filter_widgets'),					// GCconnex patch to clarify the purpose of the text box
	'onkeyup' => 'elgg.widget_manager.widgets_search($(this).val());'
]);

// make nice lightbox popup title
$lan_key = 'widget_manager:widgets:lightbox:title:' . strtolower($context);
if (!elgg_language_key_exists($lan_key)) {
	add_translation(get_current_language(), [$lan_key => $context]);
}

$title = elgg_format_element('div', ['id' => 'widget_manager_widgets_search'], $search_box);
$title .= elgg_echo("widget_manager:widgets:lightbox:title:{$context}");

$module_type = elgg_in_context('admin') ? 'inline' : 'info';

if (empty($widgets)) {
	echo elgg_view_module($module_type, $title, elgg_echo('notfound'), ['id' => 'widget_manager_widgets_select']);
	return;
}

$body = '';
foreach ($widgets as $handler => $widget) {
	$can_add = widget_manager_get_widget_setting($handler, 'can_add', $widget_context);
	$allow_multiple = $widget->multiple;
	$hide = widget_manager_get_widget_setting($handler, 'hide', $widget_context);
	
	if (!$can_add || $hide) {
		// can not add or should be hidden
		continue;
	}

	$available = ($allow_multiple || !in_array($handler, $current_handlers));

	$li_class = [];
	$li_class[] = $available ? 'elgg-state-available' : 'elgg-state-unavailable';
	$li_class[] = $allow_multiple ? 'elgg-widget-multiple' : 'elgg-widget-single';
	
	$li_content = '';
	if (!$allow_multiple) {
		$li_content .= elgg_format_element('span', ['class' => 'elgg-quiet'], elgg_echo('widget:unavailable'));
	}
	$li_content .= elgg_view('input/button', [
		'class' => 'elgg-button-submit',
		'value' => elgg_echo('widget_manager:button:add')
	]);
	
	$li = elgg_format_element('li',[
		'class' => $li_class,
		'data-elgg-widget-type' => $handler,
	], $li_content);
	
	$ul = elgg_format_element('ul',[], $li);
	
	$widget_content = elgg_format_element('span',['class' => 'widget_manager_widgets_lightbox_actions'], $ul);
	$widget_content .= elgg_format_element('div', [], elgg_format_element('b', [], $widget->name));
	
	$description = $widget->description ?: '&nbsp;'; // need to fill up for correct layout

	$widget_content .= elgg_format_element('div', ['class' => 'elgg-quiet'], $description);
	
	$body .= elgg_format_element('div',['class' => 'widget_manager_widgets_lightbox_wrapper clearfix'], $widget_content);
}

echo "<div class='elgg-widgets-add-panel hidden wb-invisible'>" . elgg_view_module($module_type, $title, $body, array("id" => "widget_manager_widgets_select")) . "</div>";
