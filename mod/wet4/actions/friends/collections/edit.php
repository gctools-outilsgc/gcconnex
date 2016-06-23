<?php
/**
 * Friends collection edit action
 *
 * @package Elgg.Core
 * @subpackage Friends.Collections
 */

$collection_id = get_input('collection_id');
$friends = get_input('friends_collection');
$name = get_input('collection_name');

// check it exists and we can edit
if (!can_edit_access_collection($collection_id)) {
	system_message(elgg_echo('friends:collection:edit_failed'));
}

//get collection
$collection = get_access_collection($collection_id);

//find new name
$collection->name = $name;

$owner = elgg_get_logged_in_user_guid();

//change name using query
$query = "UPDATE elggaccess_collections SET name='$name' WHERE id='$collection_id' AND owner_guid='$owner';";
update_data($query);

if (update_access_collection($collection_id, $friends)) {
	system_message(elgg_echo('friends:collections:edited'));
} else {
	system_message(elgg_echo('friends:collection:edit_failed'));
}

//send back to colleague circles
forward(elgg_get_site_url() . 'collections/owner/' . elgg_get_logged_in_user_entity()->username);