<?php

/**
 * Custom index widgets
 */
 
 	$widget = $vars['entity'];
 	
	$display_avatar = $widget->display_avatar;
	if( !isset($display_avatar) ) $display_avatar = 'yes';
	
	$widget_users = $widget->widget_users;
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
	<?php echo elgg_echo('user'); ?>: 
	<?php
		echo elgg_view('input/text', array(
			'name' => 'params[widget_users]',                        
			'value' => $widget_users
		));
	?>
</p>
<p>
	<?php echo elgg_echo('custom_index_widgets:display_avatar'); ?>
	<?php
		echo elgg_view('input/dropdown', array(
			'name' => 'params[display_avatar]',
			'options_values' => array('yes' => 'Yes', 'no' => 'No'),
			'value' => $display_avatar
		));
	?>
</p>