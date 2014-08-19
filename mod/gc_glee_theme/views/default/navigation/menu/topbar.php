<?php
/**
* Topbar navigation menu
*
*/


$menu = elgg_extract('menu', $vars, array());
$item_class = elgg_extract('item_class', $vars, '');

$vars['name'] = 'topbar';

$class = "elgg-menu elgg-menu-{$vars['name']}";
if (isset($vars['class'])) {
    $class .= " {$vars['class']}";
}

$output = '';

// default
$items = elgg_extract('default', $menu, array());
$output .= elgg_view('navigation/menu/elements/section', array(
	'items' => $items,
	'class' => "$class elgg-menu-{$vars['name']}-default",
	'section' => 'default',
	'name' => $vars['name'],
	'show_section_headers' => false,
	'item_class' => $item_class,
));   

// alt
$items = elgg_extract('alt', $menu, array());
$output .= elgg_view('navigation/menu/elements/section', array(
	'items' => $items,
	'class' => "$class elgg-menu-{$vars['name']}-alt pull-right",
	'section' => 'alt',
	'name' => $vars['name'],
	'show_section_headers' => false,
	'item_class' => $item_class,
));

unset($menu['default']);
unset($menu['alt']);

foreach ($menu as $section => $menu_items) {
    $output .=  elgg_view('navigation/menu/elements/section', array(
		'items' => $menu_items,
		'class' => "$class elgg-menu-{$vars['name']}-$section",
		'section' => $section,
		'name' => $vars['name'],
		'show_section_headers' => false,
		'item_class' => $item_class,
    ));
}


echo $output;

