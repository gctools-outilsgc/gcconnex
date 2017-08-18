<?php
/*
* wire_posts.php
*
* Calls The elgg
*/

$query = get_input('query');
if ($query) {
	$content = get_wire_entries_by_query($query, get_input('limit'), get_input('offset'));
} else {
	$params = array(
		'type' => 'object',
		'subtype' => 'thewire',
		'limit' => get_input('limit'),
		'offset' => get_input('offset'),
		'preload_owners' => true,
		'pagination' =>false,
	);

	$username = get_input('user');
	if ($username) {
		$params['owner_guids'] = array(get_user_by_username($username)->guid);
	}

	$friends = get_input('friends');
	if ($friends) {
		$params['relationship'] = 'friend';
		$params['relationship_guid'] = get_user_by_username($friends)->guid;
		$params['relationship_join_on'] = 'container_guid';
		$content = elgg_list_entities_from_relationship($params);
	} else {
		$content = elgg_list_entities($params);
	}
}



echo $content;
?>