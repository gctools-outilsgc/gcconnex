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
 */

$headers = elgg_extract('show_section_headers', $vars, false);
$class = elgg_extract('class', $vars, '');
$item_class = elgg_extract('item_class', $vars, '');

echo "<ul class=\"nav $class\">";
if ($headers) {
    $name = elgg_extract('name', $vars);
    $section = elgg_extract('section', $vars);
    echo '<li class="nav-header">' . elgg_echo("menu:$name:header:$section") . '</li>';
}
foreach ($vars['items'] as $menu_item) {
	echo elgg_view('navigation/menu/elements/item', array(
		'item' => $menu_item,
		'item_class' => $item_class,
	));
}
echo '</ul>';
