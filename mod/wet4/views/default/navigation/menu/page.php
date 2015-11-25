<?php
/**
 * Page menu
 *
 * @uses $vars['menu']
 * @uses $vars['selected_item']
 * @uses $vars['class']
 * @uses $vars['name']
 * @uses $vars['show_section_headers']
 */

$headers = elgg_extract('show_section_headers', $vars, false);

if (empty($vars['name'])) {
	$msg = elgg_echo('view:missing_param', array('name', 'navigation/menu/page'));
	elgg_log($msg, 'WARNING');
	$vars['name'] = '';
}

//making the tabs for page menus where there are page menus
$class = 'elgg-menu elgg-menu-page nav nav-tabs mrgn-bttm-md';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

if (isset($vars['selected_item'])) {
	$parent = $vars['selected_item']->getParent();
    //$active = 'active';
	while ($parent) {
		$parent->setSelected();
		$parent = $parent->getParent();
	}
}

//test to see if user is on the settings page
if((elgg_get_context() == 'settings')){
  foreach ($vars['menu'] as $section => $menu_items) {
      //trying to put the lists in dropdown menus, but then you can't tab to them :(
      //echo '<li class="dropdown pull-left">';
      //echo '<a class=" dropdown-toggle " type="button" id="dropdownMenu-'.$section.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'. $section .'<span class="caret"></span></a>';
	echo elgg_view('navigation/menu/elements/section', array(
		'items' => $menu_items,
		'class' => "$class elgg-menu-page-$section ",
		'section' => $section,
		'name' => $vars['name'],
		'show_section_headers' => $headers
	));
      //echo '</li>';
}     
}else{
  foreach ($vars['menu'] as $section => $menu_items) {
	echo elgg_view('navigation/menu/elements/section', array(
		'items' => $menu_items,
		'class' => "$class elgg-menu-page-$section",
		'section' => $section,
		'name' => $vars['name'],
		'show_section_headers' => $headers
	));
}  
    
}



