<?php

/**
 * grp_ajax_content - This is the ajax view that will display lists of content based on the subtype and group guid it is passed.
 *
 * grp_ajax_content - This takes the subtype and group guid and creates a list of content. It also tests if the user is a member of the group so they can create content in the group and sends an add button. It then gets formatted in a custom module view and echoed back to the page the ajax call came from.
 *
 * Add this AJAX view in order to load group content
 * @version 1.0
 * @author Nick
 */

$group = get_input('group_guid'); //get the guid through AJAX
$sub_type = get_input('sub_type'); // get the subtype through AJAX

$user = elgg_get_logged_in_user_guid();

if ($vars['entity']->forum_enable == 'no') {
	return true;
}

//Nick - Changed this to a switch
//Nick - Some sub_types and url paths are different from what was passed to this view
switch($sub_type){
	case 'groupforumtopic':
		$sub_type2 ='discussion';
    $all_link_location = '/owner/';
		break;
	case 'page_top':
		$sub_type2 = 'pages';
		$all_link_location = '/group/';
		break;
	case 'polls':
		$sub_type ='poll';
		$sub_type2 ='polls';
		$all_link_location = '/group/';
		break;
	case 'ideas':
		$sub_type ='idea';
		$sub_type2 ='ideas';
		$all_link_location = '/group/';
		break;
	case 'calendar':
		$sub_type2 ='event_calendar';
		$sub_type ='event_calendar';
		$all_link_location = '/group/';
		break;
	case 'albums':
		$sub_type2 ='photos';
		$sub_type ='album';
		$all_link_location = '/group/';
		$photos_class = ' col-sm-3';
		break;
	default:
		$sub_type2 = $sub_type;
		$all_link_location = '/group/';
}

$action_view_more = $sub_type2 . $all_link_location . $group; //some view all links are different by content

if($sub_type =='activity'){
    $action_view_more = 'groups/activity/' . $group;
}

if($sub_type =='related'){ //related group
    $action_view_more = 'groups/related/' . $group;
}

$all_link = elgg_view('output/url', array(
	'href' => $action_view_more,
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

if($sub_type =='related'){ //related groups
    $dbprefix = elgg_get_config("dbprefix");
    $options = array(
        "type" => "group",
        "limit" => 7,
        "relationship" => "related_group",
        "relationship_guid" => $group,
        "full_view" => false,
        "joins" => array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid"),
        "order_by" => "ge.name ASC",
        'no_results' => elgg_echo('groups_tools:related_groups:none'),
    );
    $content = elgg_list_entities_from_relationship($options);
}else if($sub_type =='activity'){
    elgg_push_context('group_activity_tab'); //force my own context here so I can modify it in the river view
    $content = elgg_list_group_river(array(
        'limit' => 10,
        'pagination' => false,
        'wheres1' => array(
            "oe.container_guid = $group",
        ),
        'wheres2' => array(
            "te.container_guid = $group",
        ),
    ));
    elgg_pop_context();
}else{ //all other content types
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

if(check_entity_relationship($user, 'member', $group)){ //are they a member?

    $action = $sub_type2 . "/add/" . $group;

    if($sub_type =='related'){ //if we want related groups then set the related_group var with the group guid
        $related_group = $group;
    }else if($sub_type =='activity'){
        //No add activity button, that doesn't make no sense yo
    }else if($sub_type == 'groupforumtopic'){
        $new_link = 'discuss';

    }else{ //else put the 'add' content button - permissions are dealt with in the module view below
        $new_link = elgg_view('output/url', array(
        'href' => $action ,
        'text' => elgg_echo($sub_type2.':add'),
        'is_trusted' => true,
    ));
    }
}

//echo out the module view for the content

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('discussion:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
    'clicked_related'=>$related_group,
    'user_guid'=> $user, //passing more vars to the module view
    'group_guid'=>$group,
));
//test if ajax goes through.
