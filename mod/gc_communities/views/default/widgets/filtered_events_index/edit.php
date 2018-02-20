<?php

/**
 * Community page widgets
 */

$widget = $vars['entity'];

$num_items = $widget->num_items;
if (!isset($num_items)) {
	$num_items = 5;
}

$mode = $widget->mode;
if (!isset($mode)) {
	$mode = "month";
}

$widget_groups = $widget->widget_groups;
if (!isset($widget_groups)) {
	$widget_groups = ELGG_ENTITIES_ANY_VALUE;
}

$widget_title_en = $widget->widget_title_en;
$widget_title_fr = $widget->widget_title_fr;
?>
<p>
	<?php echo elgg_echo('widget_manager:widgets:edit:custom_title'); ?> (EN):
	<?php
	echo elgg_view('input/text', array(
		'name' => 'params[widget_title_en]',
		'value' => $widget_title_en
	));
	?>
</p>
<p>
	<?php echo elgg_echo('widget_manager:widgets:edit:custom_title'); ?> (FR):
	<?php
	echo elgg_view('input/text', array(
		'name' => 'params[widget_title_fr]',
		'value' => $widget_title_fr
	));
	?>
</p>
<p>
	<?php echo elgg_echo('groups'); ?>:
	<?php
	$groups = elgg_get_entities(array("type" => 'group', 'limit' => 100));
	$group_list = array();
	$group_list[0] = elgg_echo('custom_index_widgets:widget_all_groups');
	if ($groups) {
		foreach ($groups as $group) {
			$group_list[$group->getGUID()] = $group->name;
		}
	}
	echo elgg_view('input/dropdown', array('name' => 'params[widget_groups]', 'options_values' => $group_list, 'value' => $widget_groups, 'multiple' => true, 'style' => 'width: 100%; display: block;'));
	?>
</p>
<p>
	<?php echo elgg_echo('widget:numbertodisplay'); ?>:
	<?php
	echo elgg_view('input/dropdown', array('name' => 'params[num_items]', 'options_values' => array('1' => '1', '3' => '3', '5' => '5', '8' => '8', '10' => '10', '12' => '12', '15' => '15', '20' => '20', '30' => '30', '40' => '40', '50' => '50', '100' => '100', ), 'value' => $num_items));
	?>
</p>
<p>
	<?php echo elgg_echo('event_calendar:widget_title'); ?>:
	<?php
	echo elgg_view('input/dropdown', array('name' => 'params[mode]', 'options_values' => array('day' => elgg_echo('event_calendar:day_label'), 'week' => elgg_echo('event_calendar:week_label'), 'month' => elgg_echo('event_calendar:month_label'), '90 days' => '90 days'), 'value' => $mode));
	?>
</p>
