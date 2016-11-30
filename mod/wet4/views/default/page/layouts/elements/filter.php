<?php
/**
 * filter.php
 * 
 * Layout content filter
 *
 * @uses $vars['filter']         HTML for overriding the default filter (override)
 *
 * @package wet4
 * @author GCTools Team
 */

if (isset($vars['filter'])) {
	echo $vars['filter'];
	return;
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'list-inline mrgn-lft-sm'));
