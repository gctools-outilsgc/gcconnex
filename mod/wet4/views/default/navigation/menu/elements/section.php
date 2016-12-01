<?php
/**
 * Menu group
 *
 * @uses $vars['items']                Array of menu items
 * @uses $vars['class']                Additional CSS class for the section
 * @uses $vars['name']                 Name of the menu
 * @uses $vars['section']              The section name
 * @uses $vars['item_class']           Additional CSS class for each menu item
 * @uses $vars['show_section_headers'] Do we show headers for each section
 *
 * GC_MODIFICATION
 * Description: now passing id and role to do special things
 * Author: GCTools Team
 */

$items = elgg_extract('items', $vars, array());
$headers = elgg_extract('show_section_headers', $vars, false);
$class = elgg_extract('class', $vars, '');
$item_class = elgg_extract('item_class', $vars, '');
$id = elgg_extract('id', $vars, '');
$get_role = elgg_extract('role', $vars, '');
if ($headers) {
	$name = elgg_extract('name', $vars);
	$section = elgg_extract('section', $vars);
	echo '<h2>' . elgg_echo("menu:$name:header:$section") . '</h2>';
}

echo "<ul class=\"$class\" id=\"$id\" role=\"$get_role\" >";

if (is_array($items)) {
	foreach ($items as $menu_item) {
		echo elgg_view('navigation/menu/elements/item', array(
			'item' => $menu_item,
			'item_class' => $item_class,
		));
	}
}

echo '</ul>';
