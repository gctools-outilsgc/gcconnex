<?php

/**
 * subscription action file, allows users to unsubscribe to a specific content 
 * @param guid 			extract the entity guid that the user is about to unsubscribe from
 * @param user_guid 	extract the user that is making the unsubscribe action
 */

gatekeeper(); 
$user = elgg_get_logged_in_user_entity();
$entity_guid = get_input('guid');
$user_guid = get_input('user_guid');

$user_guid = ($user_guid) ? $user_guid : $user->getGUID();

remove_entity_relationship($user_guid, 'cp_subscribed_to_email', $entity_guid);
remove_entity_relationship($user_guid, 'cp_subscribed_to_site_mail', $entity_guid);