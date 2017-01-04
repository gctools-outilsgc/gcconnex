<?php

/*
 * Retrieve the contents within the Group
 *
 */

if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$group_guid = (int)get_input('group_guid');
$user_guid = (int)get_input('user_guid');

$no_notification_available = array('widget','hjforumcategory','messages','MySkill','experience','education','hjforumpost','hjforumtopic','hjforum');

$options = array(
	'subtypes' => array(),
	'type' => 'object',
	'limit' => false,
	'container_guid' => $group_guid,
);
$group_contents = elgg_get_entities($options);//elgg_get_entities_from_relationship($options);
$group = get_entity($group_guid);
//$group_contents = $group->getObjects();
//error_log($group->getGUID().' / '.$group->name);


$group_objects = array();
foreach ($group_contents as $group_content) {
	if (check_entity_relationship($user_guid, 'cp_subscribed_to_email', $group_content->getGUID())) {

		$group_item_content = "<p><a href='{$group_content->getURL()}'>{$group_content->title}</a></p> <sup>".cp_translate_subtype($group_content->getSubtype())."</sup>";
		$group_item_left = "<div class='togglefield col-sm-10'>{$group_item_content}</div>";


        $unsubscribe_button = elgg_view('input/button', array(
            'class' =>'btn btn-default unsub-button',
            'id'=> $group_content->getGUID() .'_b',
            'value' => elgg_echo("cp_notify:unsubscribe"),
        ));
		$group_item_right = "<div class='col-sm-2'>{$unsubscribe_button}</div>";

		$group_objects[$group_content->getGUID()] = "{$group_item_left}{$group_item_right}";
	}
}
 
// group forum topic
$query = "SELECT elgg_subtype.entity_guid, elgg_subtype.entity_subtype
FROM elggentity_relationships r
LEFT JOIN 
	(SELECT e.guid AS entity_guid, s.subtype AS entity_subtype FROM elggentities e, elggentity_subtypes s WHERE (s.subtype = 'hjforumtopic' OR s.subtype = 'hjforum') AND e.subtype = s.id) elgg_subtype ON elgg_subtype.entity_guid = r.guid_two 
WHERE r.guid_one = {$user_guid} AND r.relationship = 'cp_subscribed_to_site_mail'";

$group_contents = get_data($query);
foreach ($group_contents as $key => $group_content) {
	// make sure the Array Object is not empty
	if (!empty($group_content->entity_guid) && $group_content->entity_guid > 0) {
    	$content = get_entity($group_content->entity_guid);

    	$site = elgg_get_site_entity();
    	// information about the group content
    	$group_item_content = "<p><a href='{$site->getURL()}/gcforums/group/{$group_guid}/{$content->getGUID()}/hjforumtopic'>{$content->title}</a></p> <sup>".$group_content->entity_subtype."</sup>";
		$group_item_left = "<div class='togglefield col-sm-10'>{$group_item_content}</div>";

		$unsubscribe_button = elgg_view('input/button', array(
            'class' =>'btn btn-default unsub-button',
            'id'=> $content->getGUID() .'_b',
            'value' => elgg_echo("cp_notify:unsubscribe"),
        ));
		$group_item_right = "<div class='col-sm-2'>{$unsubscribe_button}</div>";


    	// we want the forum topic that resides in the group
    	$container_id = (strcmp($content->getSubtype(), 'hjforumtopic') == 0) ? $content->getContainerGUID() : $container_id = $content->getGUID();
    	
    	if (get_forum_in_group($container_id,$container_id) == $group_guid)
    		$group_objects[$content->getGUID()] = "{$group_item_left}{$group_item_right}";
	}
}

$number_of_content = count($group_objects);


echo json_encode([
	'num_content' => $number_of_content,
	'text1' => $sample_text,
	'text2' => 12345,
	'text3' => $group_objects,
]);


// recursive, to get group id
function get_forum_in_group($entity_guid_static, $entity_guid) {
	$entity = get_entity($entity_guid);
	if ($entity instanceof ElggGroup) { // stop recursing when we reach group guid
		//error_log('stop at GUID: '.$entity_guid.' / '.$entity->name);
		return $entity_guid;
	} else { // keep going...
		return get_forum_in_group($entity_guid_static, $entity->getContainerGUID());
	}
}