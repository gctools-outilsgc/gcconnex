<?php
/**
 * Group module (also called a group widget)
 *
 * @uses $vars['title']    The title of the module
 * @uses $vars['content']  The module content
 * @uses $vars['all_link'] A link to list content
 * @uses $vars['add_link'] A link to create content
 
 2015/10/13-
 Placed widgets into tab content divs instead of li's
 moved view all link to footer of module
 */

$group = elgg_get_page_owner_entity();

//$header = "<span class=\"groups-widget-viewall\">{$vars['all_link']}</span>";
$header = $vars['title'];

$content = $vars['content'];

$footer = $vars['all_link'];

if ($group->canWriteToContainer() && isset($vars['add_link'])) {
    
    /*
    Original code
    
	$vars['content'] .= "<span class='elgg-widget-more'>{$vars['add_link']}</span>";
    */
    
    //gather info from $vars['add_link'] to use in our button
    $buttonHREF = explode('"', $vars['add_link']);
    
    //seperate text from system genereated link
    $throwaway = explode('>', $vars['add_link']);
    $buttonText = explode('<', $throwaway[1]);
    
    //create button from gathered variables
    $addButton = elgg_view('output/url', array(
        'text' =>  $buttonText[0],
        'class' => 'btn btn-primary mrgn-bttm-sm',
        'style' => 'color:white',
        'href' => $buttonHREF[1],
    ));
    
    $content = '<div class="text-right">' . $addButton . '</div>' . $vars['content'];
}



//remove group from title to create an id for module
$id = explode(' ', $vars['title']);

if(get_current_language() == 'en'){
    if($id[1] == 'calender'){
        $id[1] = 'events';
    }
    $modID = $id[1];
} else {
    $modID = strtolower($id[0]);
}

if($vars['title'] == 'Most recent albums' || $vars['title'] == 'Most recent images'){
    $modID = $id[2];
}

echo elgg_view_module('GPmod', '', $content, array(
	'class' => 'tab-pane fade-in',
    'id' => $modID,
    'footer' => $footer,
));

