<?php
/**
 * Site navigation menu
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['more']
 *
 * GC_MODIFICATION
 * Description: formats site menu to look and function like the wet template
 * Author: GCTools Team
 */

$default_items = elgg_extract('default', $vars['menu'], array());
$more_items = elgg_extract('more', $vars['menu'], array());

echo '<ul class="list-inline menu col-md-6" style="font-weight:500" tabindex="0" color:#333333;>';

foreach ($default_items as $menu_item) {
	echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item, 'item-role' => 'none'));
}

echo '</ul>';
