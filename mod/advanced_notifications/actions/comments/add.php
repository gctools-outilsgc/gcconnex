<?php
/**
 * Elgg add comment action
 *
 * NOTE: this file isn't registered as an action file, but is used by the plugin hook: advanced_notifications_comment_action_hook
 *
 * @package Elgg.Core
 * @subpackage Comments
 */

$entity_guid = (int) get_input("entity_guid");
$comment_text = get_input("generic_comment");

if (empty($comment_text)) {
	register_error(elgg_echo("generic_comment:blank"));
	forward(REFERER);
}

// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) {
	register_error(elgg_echo("generic_comment:notfound"));
	forward(REFERER);
}

$user = elgg_get_logged_in_user_entity();

$annotation = create_annotation($entity->getGUID(), "generic_comment", $comment_text, "", $user->getGUID(), $entity->access_id);

// tell user annotation posted
if (!$annotation) {
	register_error(elgg_echo("generic_comment:failure"));
	forward(REFERER);
}

// notify if poster wasn't owner
if ($entity->getOwnerGUID() != $user->getGUID()) {

	// get the notification settings for the owner
	$notification_settings = (array) get_user_notification_settings($entity->getOwnerGUID());
	
	if (!empty($notification_settings)) {
		// loop through the preferences
		foreach ($notification_settings as $method => $enabled) {
			if ($enabled) {
				if ($method == "email") {
					// send special (short) message
					notify_user($entity->getOwnerGUID(),
							$user->getGUID(),
							elgg_echo("generic_comment:email:subject"),
							elgg_echo("advanced_notifications:notification:email:body", array(
								$entity->getURL(),
							)),
							null,
							$method
					);
				} else {
					// send the normal message
					notify_user($entity->getOwnerGUID(),
							$user->getGUID(),
							elgg_echo("generic_comment:email:subject"),
							elgg_echo("generic_comment:email:body", array(
								$entity->title,
								$user->name,
								$comment_text,
								$entity->getURL(),
								$user->name,
								$user->getURL()
							)),
							null,
							$method
					);
				}
			}
		}
	}
	
}

system_message(elgg_echo("generic_comment:posted"));

//add to river
add_to_river("river/annotation/generic_comment/create", "comment", $user->getGUID(), $entity->getGUID(), "", 0, $annotation);

// Forward to the page the action occurred on
forward(REFERER);
