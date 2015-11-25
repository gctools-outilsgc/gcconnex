<?php
/**
 * Site navigation menu
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['more']
 */

$default_items = elgg_extract('default', $vars['menu'], array());
$more_items = elgg_extract('more', $vars['menu'], array());

echo '<ul class=" list-inline menu clearfix">';
foreach ($default_items as $menu_item) {
	echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
}

// Wet 4 more menu items - You can un-comment this code below to add the more menu back in

/*
if ($more_items) {
    
	echo '<li class="elgg-more ">';

	$more = elgg_echo('more');
	echo '<a href="#moreCont" class="item" role="menuItem" aria-haspopup="true" >More</a>';
	
	echo elgg_view('navigation/menu/elements/section', array(
		'class' => ' sm list-unstyled ', 
        'id' => 'moreCont',
        'role' => 'menu',
		'items' => $more_items,
        
	));
	
	echo '</li>';
}
echo '</ul>';
*/