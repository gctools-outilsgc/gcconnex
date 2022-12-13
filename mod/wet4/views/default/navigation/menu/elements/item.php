<?php
/**
 * A single element of a menu.
 *
 * @package Elgg.Core
 * @subpackage Navigation
 *
 * @uses $vars['item']       ElggMenuItem
 * @uses $vars['item_class'] Additional CSS class for the menu item
 *
 * GC_MODIFICATION
 * Description: add list-unstyled class
 * Author: GCTools Team
 */

 // CL 20221213 - Get the current user and the base url
 // CL 20221213 - re: https://github.com/gctools-outilsgc/gcconnex/issues/2474
$user = elgg_get_logged_in_user_entity();
$username = $user->username;
$url = elgg_get_site_url();

$item = $vars['item'];
$item_role = elgg_extract('item-role', $vars, '');
$link_class = 'elgg-menu-closed';
if ($item->getSelected()) {
	// @todo switch to addItemClass when that is implemented
	//$item->setItemClass('elgg-state-selected');
	$link_class = 'elgg-menu-opened';
}

$children = $item->getChildren();
if ($children) {
	$item->addLinkClass($link_class);
	$item->addLinkClass('elgg-menu-parent');
}

$item_class = $item->getItemClass();
if ($item->getSelected()) {
    //finds the active tab in the menu and gives it the active class
	$item_class = "$item_class elgg-state-selected active";

	//CL 20220907 - Checks to see if the active menu item is My Groups and sets a hidden H2
	//CL 20220907 - for smoother screen reading navigation
	if(strpos($item_class, 'yours') == true){
		$title = elgg_echo('groups:yours');
		echo "<h2 class=\"wb-inv\">".$title."</h2>";
	}
}

if (isset($vars['item_class']) && $vars['item_class']) {
	$item_class .= ' ' . $vars['item_class'];
}

if($item_role){
	$roles = "role=\"$item_role\" ";
}

// CL 20221213 - Get the menu title, if matches Network or Réseau change the url to friend/$username instead of /members
// CL 20221213 - re: https://github.com/gctools-outilsgc/gcconnex/issues/2474
if($item->getText() == 'Network' || $item->getText() == "Réseau"){
	$item->setHref($url."friends/$username");
	
	
}

echo "<li $roles class=\"$item_class\">";
echo elgg_view_menu_item($item);
if ($children) {
	echo elgg_view('navigation/menu/elements/section', array(
		'items' => $children,
		'role' => 'menu',
		'item-role' => 'listitem',
		'class' => ' elgg-child-menu sm list-unstyled',
	));
}
echo '</li>';




