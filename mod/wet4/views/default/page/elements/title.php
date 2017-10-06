<?php
/**
 * Elgg title element
 *
 * @uses $vars['title'] The page title
 * @uses $vars['class'] Optional class for heading
 */

if (!isset($vars['title'])) {
	return;
}

$page_owner = elgg_get_page_owner_entity();
//$class= '';
//if (isset($vars['class'])) {
//    $class = " class=\"{$vars['class']}\"";
//}

//Nick - if this content is in a group the group title will be the h1, the content title will be h2 as it is a child ofthe group
if($page_owner instanceof ElggGroup){
    echo "<h2 property='name' class=\"h1 title\">{$vars['title']}</h2>";
}else{
    echo "<h1 property='name' class='title'{$class}>{$vars['title']}</h1>";
}