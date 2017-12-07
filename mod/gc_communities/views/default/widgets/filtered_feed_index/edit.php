<?php

/**
 * Community page widgets
 */

$widget = $vars['entity'];

$num_items = $widget->num_items;
if (!isset($num_items)) {
	$num_items = 10;
}

$widget_title_en = $widget->widget_title_en;
$widget_title_fr = $widget->widget_title_fr;
$widget_tags = $widget->widget_tags;
$widget_tag_logic = $widget->widget_tag_logic;
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
	<?php echo elgg_echo('tags'); ?>:
	<?php
	echo elgg_view('input/text', array(
		'name' => 'params[widget_tags]',
		'value' => $widget_tags
	));
	?>
</p>
<p>
	<?php echo elgg_echo('Tag Logic'); ?>:
	<?php
	echo elgg_view('input/dropdown', array('name' => 'params[widget_tag_logic]', 'options_values' => array('or' => 'OR', 'and' => 'AND'), 'value' => $widget_tag_logic));
	?>
</p>
<p>
	<?php echo elgg_echo('widget:numbertodisplay'); ?>:
	<?php
	echo elgg_view('input/dropdown', array('name' => 'params[num_items]', 'options_values' => array('1' => '1', '3' => '3', '5' => '5', '8' => '8', '10' => '10', '12' => '12', '15' => '15', '20' => '20', '30' => '30', '40' => '40', '50' => '50', '100' => '100', ), 'value' => $num_items));
	?>
</p>
