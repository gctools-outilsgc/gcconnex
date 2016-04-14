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

$user = elgg_get_logged_in_user_guid();

if ($vars['entity']->forum_enable == 'no') {
	return true;
}   

//$group = $vars['entity'];
if($sub_type =='groupforumtopic'){ //some subtypes are different for list_entities
    $sub_type2 ='discussion';
    $all_link_location = '/owner/';
}else if($sub_type =='page_top'){
    $sub_type2 = 'pages';
    $all_link_location = '/group/';
}else if($sub_type =='polls'){
    $sub_type ='poll';
    $sub_type2 ='polls';
    $all_link_location = '/group/';
}else if($sub_type =='ideas'){
    $sub_type ='idea';
    $sub_type2 ='ideas';
    $all_link_location = '/group/';
}else if($sub_type =='calendar'){
    $sub_type2 ='event_calendar';
    $sub_type ='event_calendar';
    $all_link_location = '/group/';
}else if($sub_type =='albums'){
    $sub_type2 ='photos';
    $sub_type ='album';
    $all_link_location = '/group/';
    $photos_class = ' col-sm-3';
}else{
    $sub_type2 = $sub_type;
    $all_link_location = '/group/';
}
$action_view_more = $sub_type2 . $all_link_location . $group;

$all_link = elgg_view('output/url', array(
	'href' => $action_view_more,
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

if($sub_type =='related'){
    $dbprefix = elgg_get_config("dbprefix");
    $options = array(
        "type" => "group",
        "limit" => 7,
        "relationship" => "related_group",
        "relationship_guid" => $group,
        "full_view" => false,
        "joins" => array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid"),
        "order_by" => "ge.name ASC",
        'no_results' => elgg_echo('none'),
    );
    $content = elgg_list_entities_from_relationship($options);
}else{
    $options = array(
        'type' => 'object',
        'subtype' => $sub_type,
        'container_guid' => $group,
        'limit' => 7,
        'full_view' => false,
        'pagination' => false,
        'distinct' => false,
        'list-class'=>' '.$photos_class,
        'no_results' => elgg_echo($sub_type2.':none'),
    );
    $content = elgg_list_entities($options);
}

if(check_entity_relationship($user, 'member', $group)){
    $action = $sub_type2 . "/add/" . $group;

    $new_link = elgg_view('output/url', array(
        'href' => $action ,
        'text' => elgg_echo($sub_type2.':add'),
        'is_trusted' => true,
    ));
}else{
    $new_link ='';
}


//echo out the module view for the content 

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('discussion:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
//test if ajax goes through.
//echo 'Gratz You made an ajax call! Here us the page GUID = ' .$group;