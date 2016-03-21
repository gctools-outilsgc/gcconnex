<?php

error_log('SUBSCRIBE!');


gatekeeper(); // only logged in user can view this 
// TODO: check relationship exist or not
$user = elgg_get_logged_in_user_entity();

$options = array(
	'relationship' => 'cp_subscribed_to',
	'relationship_guid' => $user->getGUID()
);

$entity_guid = get_input('guid');
error_log("subscribing to {$entity_guid}");

add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $entity_guid);

