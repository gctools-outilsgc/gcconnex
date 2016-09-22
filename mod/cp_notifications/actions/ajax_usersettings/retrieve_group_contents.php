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
error_log($group->getGUID().' / '.$group->name);


$group_objects = array();
foreach ($group_contents as $group_content) {
	if (check_entity_relationship($user_guid, 'cp_subscribed_to_email', $group_content->getGUID())) {

		$group_item_content = "<p><a href='{$group_content->getURL()}'>{$group_content->title}</a></p> <sup>".cp_translate_subtype($group_content->getSubtype())."</sup>";
		$group_item_left = "<div class='togglefield col-sm-10'>{$group_item_content}</div>";


        $unsubscribe_button = elgg_view('input/button', array(
        	'src' => 'google.ca',
            'class' =>'btn btn-default unsub-button',
            'id'=> $group_content->getGUID() .'_b',
            'value' => elgg_echo("cp_notify:unsubscribe"),
        ));
		$group_item_right = "<div class='col-sm-2'>{$unsubscribe_button}</div>";

		$group_objects[$group_content->getGUID()] = "{$group_item_left}{$group_item_right}";
	}
}


echo json_encode([
	'text1' => $sample_text,
	'text2' => 12345,
	'text3' => $group_objects,
]);