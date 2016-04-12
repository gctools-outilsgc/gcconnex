<?php

error_log('UNSUBSCRIBE!');


gatekeeper(); // only logged in user can view this 
// TODO: check relationship exist or not
$user = elgg_get_logged_in_user_entity();

$options = array(
	'relationship' => 'cp_subscribed_to',
	'relationship_guid' => $user->getGUID()
);


$entity_guid = get_input('guid');


remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $entity_guid);
remove_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $entity_guid);