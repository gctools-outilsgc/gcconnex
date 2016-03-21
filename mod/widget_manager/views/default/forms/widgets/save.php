<?php
/**
 * Elgg widget edit settings
 *
 * @uses $vars['widget']
 * @uses $vars['show_access']
 */
$widget = $vars['widget'];

$show_access = elgg_extract('show_access', $vars, true);
$widget_context = $widget->context;

$edit_view = "widgets/$widget->handler/edit";
$custom_form_section = elgg_view($edit_view, array('entity' => $widget));

$access = '';
if ($show_access) {
	elgg_push_context("widget_access");
	$access = elgg_echo('access') . ': ' . elgg_view('input/access', array(
		'name' => 'params[access_id]',
		'entity' => $widget,
	));
	elgg_pop_context();
}

$advanced = elgg_view("widget_manager/forms/widgets/advanced", array("entity" => $widget, "widget_context" => $widget_context));

$hidden = elgg_view('input/hidden', array('name' => 'guid', 'value' => $widget->guid));
$submit = elgg_view('input/submit', array('value' => elgg_echo('save')));

$body = <<<___END
	$custom_form_section
	<div class='widget-manager-widget-access'>
		$access
	</div>
	
		$advanced
	<div class="elgg-foot">
		$hidden
		$submit
	</div>
___END;

echo $body;
