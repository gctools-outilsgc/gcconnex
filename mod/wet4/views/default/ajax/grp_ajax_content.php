<?php

/**
 * grp_ajax_content short summary.
 *
 * grp_ajax_content description.
 *
 * Add this AJAX view in order to load group content
 * @version 1.0
 * @author Owner
 */

$group = get_input('group_guid'); //get the guid through AJAX
$sub_type = get_input('sub_type'); // get the subtype through AJAX

if ($vars['entity']->forum_enable == 'no') {
	return true;
}   

//$group = $vars['entity'];
if($sub_type =='groupforumtopic'){ //some subtypes are different for list_entities
    $sub_type2 ='discussion';
}else if($sub_type =='page_top'){
    $sub_type2 = 'pages';
}else if($sub_type =='polls'){
    $sub_type ='poll';
    $sub_type2 ='polls';
}else if($sub_type =='ideas'){
    $sub_type ='idea';
    $sub_type2 ='ideas';
}else if($sub_type =='calendar'){
    $sub_type2 ='event_calendar';
    $sub_type ='event_calendar';
}else if($sub_type =='albums'){
    $sub_type2 ='photos';
    $sub_type ='album';
    
}else{
    $sub_type2 = $sub_type;
}


$all_link = elgg_view('output/url', array(
	'href' => "discussion/owner/$group",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));


$options = array(
	'type' => 'object',
	'subtype' => $sub_type,
	'container_guid' => $group,
	'limit' => 7,
	'full_view' => false,
	'pagination' => false,
    'distinct' => false,
	'no_results' => elgg_echo($sub_type2.':none'),
);
$content = elgg_list_entities($options);



$action = $sub_type2 . "/add/" . $group;

$new_link = elgg_view('output/url', array(
	'href' => $action ,
	'text' => elgg_echo($sub_type2.':add'),
	'is_trusted' => true,
));
//echo out the module view for the content 

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('discussion:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
//test if ajax goes through.
//echo 'Gratz You made an ajax call! Here us the page GUID = ' .$group;