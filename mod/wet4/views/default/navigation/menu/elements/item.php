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
}
if (isset($vars['item_class']) && $vars['item_class']) {
	$item_class .= ' ' . $vars['item_class'];
}

if($item_role){
	$roles = "role=\"$item_role\" ";
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
