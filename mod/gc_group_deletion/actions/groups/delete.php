<?php
/**
 * Delete a group
 */
		
$guid = (int) get_input('guid');
$delete = (bool) get_input('delete', false);
if (!$guid) {
	// backward compatible
	elgg_deprecated_notice("Use 'guid' for group delete action", 1.8);
	$guid = (int)get_input('group_guid');
}
$entity = get_entity($guid);

if (!$entity->canEdit()) {
	register_error(elgg_echo('group:notdeleted'));
	forward(REFERER);
}

// check member count
$count = elgg_get_entities_from_relationship(array(
		'relationship' => 'member',
		'relationship_guid' => $guid,
		'inverse_relationship' => true,
		'type' => 'user',
		'limit' => 20,
));
if ( count( $count ) == 1 || $delete ){

	if (($entity) && ($entity instanceof ElggGroup)) {
		// delete group icons
		$owner_guid = $entity->owner_guid;
		$prefix = "groups/" . $entity->guid;
		$imagenames = array('.jpg', 'tiny.jpg', 'small.jpg', 'medium.jpg', 'large.jpg');
		$img = new ElggFile();
		$img->owner_guid = $owner_guid;
		foreach ($imagenames as $name) {
			$img->setFilename($prefix . $name);
			$img->delete();
		}

		// delete group
		if ($entity->delete()) {
			system_message(elgg_echo('group:deleted'));
		} else {
			register_error(elgg_echo('group:notdeleted'));
		}
	} else {
		register_error(elgg_echo('group:notdeleted'));
	}

	$url_name = elgg_get_logged_in_user_entity()->username;
	forward(elgg_get_site_url() . "groups/member/{$url_name}");
}

else
	forward(elgg_get_site_url() . "delete-group/{$guid}");
