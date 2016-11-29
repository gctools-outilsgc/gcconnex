<?php
/**
 * Elgg widget controls
 *
 * @uses $vars['widget']
 * @uses $vars['show_edit'] Whether to show the edit button (true)
 *
 * GC_MODIFICATION
 * Description: added wet-widgets-menu / layout changes
 * Author: GCTools Team
 */



echo elgg_view_menu('widget', array(
	'entity' => elgg_extract('widget', $vars),
	'show_edit' => elgg_extract('show_edit', $vars, true),
	'sort_by' => 'priority',
	'class' => 'wet-widget-menu testing list-unstyled pull-right',
));
