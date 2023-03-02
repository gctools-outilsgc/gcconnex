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

echo '<ul class="list-inline menu col-md-6">';

foreach ($default_items as $menu_item) {
	echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item, 'item-role' => 'none'));
}

// Wet 4 more menu items - You can un-comment this code below to add the more menu back in

if ($more_items) {
  echo '<li role="none"><a href="#moreCont" class="item">'.elgg_echo('wet:more').'<span class="expicon glyphicon glyphicon-chevron-down"></span></a>';	
	echo elgg_view('navigation/menu/elements/section', array(
		'class' => ' sm list-unstyled ',
		'id' => 'moreCont',
		'role' => 'menu',
		'item-role' => 'none',
		'items' => $more_items,
	));
	echo '</li>';
}

echo '</ul>';

if (!elgg_is_logged_in()) {
    echo '<ul nav="navigation" class="text-right col-md-12 mrgn-tp-sm user-z-index">';
        
    echo elgg_view('page/elements/login_menu', $vars);

    echo '</nav>';
} else{
	echo '<ul class="list-inline menu col-md-4" role="menubar">';
		//echo elgg_view('page/elements/topbar', $vars);
		echo elgg_view('page/elements/user_menu', $vars);
	echo '</ul>';
}


echo '<div class="collapse " id="collapseSearch"> <div class="well">'; 
	echo elgg_view('input/text', array(
        'id' => 'tagSearch',
    	'name' => 'tag',
        'class' => 'elgg-input-search mbm',
    	'placeholder' => elgg_echo('wet:searchgctools'),
        'required' => true
    ));
	echo '</div>';
echo '</div>';
