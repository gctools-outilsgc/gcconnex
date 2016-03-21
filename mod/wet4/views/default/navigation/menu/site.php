<?php
/**
 * Site navigation menu
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['more']
 */

$default_items = elgg_extract('default', $vars['menu'], array());
$more_items = elgg_extract('more', $vars['menu'], array());

echo '<ul class=" list-inline menu">';

echo '<li><a href="' . elgg_get_site_url() . 'newsfeed/">' . elgg_echo('newsfeed')  .  '</a></li>';

foreach ($default_items as $menu_item) {
	echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
}

// Wet 4 more menu items - You can un-comment this code below to add the more menu back in

if ($more_items) {

	//echo '<li class="elgg-more ">';<a href="#jobs" class="item">Jobs</a>
    echo '<li><a href="#moreCont" class="item">'.elgg_echo('wet:more').'<span class="expicon glyphicon glyphicon-chevron-down"></span></a>';

	//echo '<a href="#moreCont" class="item" role="menuItem" aria-haspopup="true" >More<span class="expicon glyphicon glyphicon-chevron-down"></span></a>';
	
	echo elgg_view('navigation/menu/elements/section', array(
		'class' => ' sm list-unstyled ', 
        'id' => 'moreCont',
        'role' => 'menu',
		'items' => $more_items,
        
	));
	
	echo '</li>';
}
echo '</ul>';
