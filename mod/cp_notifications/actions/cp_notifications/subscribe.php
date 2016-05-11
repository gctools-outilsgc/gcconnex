<?php

/*
 * .../actions/cp_notifications/subscribe.php
 *
 * subscription action file, allows users to subscribe to a specific content 
 *
 */

gatekeeper();
$user = elgg_get_logged_in_user_entity();
$options = array(
	'relationship' => 'cp_subscribed_to',
	'relationship_guid' => $user->getGUID()
);
$entity_guid = get_input('guid');

// is - add_entity_relationship() already checks for duplicates
add_entity_relationship($user->getGUID(), 'cp_subscribed_to_email', $entity_guid);
add_entity_relationship($user->getGUID(), 'cp_subscribed_to_site_mail', $entity_guid);
