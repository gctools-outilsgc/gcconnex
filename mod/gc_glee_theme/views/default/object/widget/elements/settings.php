<?php
/**
 * Elgg widget edit settings
 *
 * @uses $vars['widget']
 */

$widget = elgg_extract('widget', $vars);
?>

<div class="elgg-widget-edit" id="widget-edit-<?php echo $widget->guid; ?>">
	<?php echo str_replace( "<fieldset>", "<fieldset><legend><h4>". $widget->getTitle() ." Widget Settings</h4></legend>" , elgg_view_form('widgets/save', array(), $vars) ); ?>
</div>
