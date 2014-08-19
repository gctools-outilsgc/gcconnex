<?php
/**
* Site navigation menu
*
* @uses $vars['menu']['default']
* @uses $vars['menu']['more']
*/


$menu = elgg_extract('menu', $vars, array());
$item_class = elgg_extract('item_class', $vars, '');

$vars['name'] = 'site';

$class = "elgg-menu elgg-menu-{$vars['name']}";
if (isset($vars['class'])) {
    $class .= " {$vars['class']}";
}

// default
$section = 'default';
$items = elgg_extract($section, $menu, array());
echo elgg_view('navigation/menu/elements/site/section', array(
	'items' => $items,
	'class' => "$class elgg-menu-{$vars['name']}-$section",
	'section' => $section,
	'name' => $vars['name'],
	'show_section_headers' => true,
	'item_class' => $item_class,
));   

// more
$section = 'more';
$items = elgg_extract($section, $menu, array());
if (!empty($items)) {
    echo elgg_view('navigation/menu/elements/site/section', array(
    	'items' => $items,
    	'class' => "$class elgg-menu-{$vars['name']}-$section",
    	'section' => $section,
    	'name' => $vars['name'],
    	'show_section_headers' => true,
    	'item_class' => $item_class,
    ));
}