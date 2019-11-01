<?php
/**
 *
 * @uses $vars['items']                Array of menu items
 * @uses $vars['class']                Additional CSS class for the section
 * @uses $vars['name']                 Name of the menu
 * @uses $vars['section']              The section name
 * @uses $vars['item_class']           Additional CSS class for each menu item
 * @uses $vars['show_section_headers'] Do we show headers for each section
 *
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

if(elgg_in_context('profile')){
    $num_items = 7;
}else{
    $num_items = 4;
}

if($id) {
	$ids = "id=\"$id\" ";
}
if($get_role){
	$roles = "role=\"$get_role\" ";
}

$count = 0;
$more_menu = '';
echo "<ul class=\"$class\" $ids $roles >";

if (is_array($items)) {
	foreach ($items as $menu_item) {
        if($menu_item->getName() != 'activity'){
            $count++;

            if($count <= $num_items){
                echo elgg_view('navigation/menu/elements/item', array(
                    'item' => $menu_item,
                    'item_class' => $item_class,
                ));
            } else {
                $more_menu .= elgg_view('navigation/menu/elements/item', array(
                    'item' => $menu_item,
                    'item_class' => $item_class,
                ));
            }
        }
    }

    if($count > $num_items){
        echo '<li><a href="" data-toggle="dropdown" class="elgg-menu-content dropdown-toggle" aria-expanded="true">'.elgg_echo('gprofile:more').'<b class="caret"></b></a>';
        echo elgg_format_element('ul', ['class' => 'dropdown-menu pull-right'], $more_menu);
        echo '</li>';
    }

}

echo '</ul>';
