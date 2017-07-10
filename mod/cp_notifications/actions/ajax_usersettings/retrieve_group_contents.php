<?php

/**
 * Retrieve the contents within the Group
 *
 */

if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

$group_guid = (int)get_input('group_guid');
$user_guid = (int)get_input('user_guid');
elgg_load_library('elgg:gc_notification:functions');
$dbprefix = elgg_get_config('dbprefix');
$lang = get_current_language();

$options = array(
	'subtypes' => array(),
	'type' => 'object',
	'limit' => false,
	'container_guid' => $group_guid,
);
$group_contents = elgg_get_entities($options);
$group = get_entity($group_guid);

$group_objects = array();
foreach ($group_contents as $group_content) {
	if (check_entity_relationship($user_guid, 'cp_subscribed_to_email', $group_content->getGUID())) {
	    $title = gc_explode_translation($group_content->title,$lang);

		$group_item_content = "<p><a href='{$group_content->getURL()}'>{$title}</a></p> <sup>".elgg_echo('cp_notifications:subtype:'.$group_content->getSubtype())."</sup>";
		$group_item_left = "<div class='togglefield col-sm-10'>{$group_item_content}</div>";


        $unsubscribe_button = elgg_view('input/button', array(
            'class' =>'btn btn-default unsub-button',
            'id'=> $group_content->getGUID() .'_b',
            'value' => elgg_echo('cp_notifications:unsubscribe'),
        ));
		$group_item_right = "<div class='col-sm-2'>{$unsubscribe_button}</div>";

		$group_objects[$group_content->getGUID()] = "{$group_item_left}{$group_item_right}";
	}
}
 
// group forum topic
$query = "SELECT elgg_subtype.entity_guid, elgg_subtype.entity_subtype
FROM {$dbprefix}entity_relationships r
LEFT JOIN 
	(SELECT e.guid AS entity_guid, s.subtype AS entity_subtype FROM {$dbprefix}entities e, {$dbprefix}entity_subtypes s WHERE (s.subtype = 'hjforumtopic' OR s.subtype = 'hjforum') AND e.subtype = s.id) elgg_subtype ON elgg_subtype.entity_guid = r.guid_two 
WHERE r.guid_one = {$user_guid} AND r.relationship LIKE 'cp_subscribed_to_%'";

$group_contents = get_data($query);

foreach ($group_contents as $key => $group_content) {
	// make sure the Array Object is not empty
	if (!empty($group_content->entity_guid) && $group_content->entity_guid > 0) {
    	$content = get_entity($group_content->entity_guid);

    	$site = elgg_get_site_entity();
    	// information about the group content
    	$group_item_content = "<p><a href='{$site->getURL()}/gcforums/group/{$group_guid}/{$content->getGUID()}/hjforumtopic'>{$content->title}</a></p> <sup>".elgg_echo('cp_notifications:subtype:'.$group_content->entity_subtype)."</sup>";
		$group_item_left = "<div class='togglefield col-sm-10'>{$group_item_content}</div>";

		$unsubscribe_button = elgg_view('input/button', array(
            'class' =>'btn btn-default unsub-button',
            'id'=> $content->getGUID() .'_b',
            'value' => elgg_echo('cp_notifications:unsubscribe'),
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
	'text3' => $group_objects,
]);

