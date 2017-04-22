<?php


if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}

// TODO check if user exists
$username = get_input('username');
$user = get_user_by_username($username);

if (!$user) {

	$user_info = "<p><label>This user does not exist : {$username}</label></p>";

} else {

	$query = "SELECT DISTINCT r.guid_one, r.guid_two, o.title, e.type, es.subtype, e.container_guid, e.guid, o.description, g.name FROM elggentity_relationships r 	LEFT JOIN elggentities e ON e.guid = r.guid_two LEFT JOIN elgggroups_entity g ON e.guid = g.guid LEFT JOIN elggobjects_entity o ON o.guid = r.guid_two 	LEFT JOIN elggentity_subtypes es ON es.id = e.subtype WHERE r.guid_one = {$user->guid} AND r.relationship like 'cp_subscribed_%' ";


	$informations = get_data($query);

	$user_info = "<p>";
	$user_info .= "<p><label>List all subscriptions for : {$username}</label></p>";
	foreach ($informations as $information) {

		$content_title = $information->title;
		if ($information->subtype === 'thewire') {
			$content_title = "wire post: {$information->description}";
		}

		$subtype = $information->subtype;
		if ($information->subtype === 'page_top') {
			$subtype = 'pages';
		}

		$site = elgg_get_site_entity();
		$url = elgg_add_action_tokens_to_url("/action/cp_notify/unsubscribe?guid={$information->guid}");


		$entity_name = ($information->type === 'group') ? $information->name : $information->title;
		$content_url = ($information->type === 'group') ? $site->getURL()."groups/profile/{$information->guid}" : $site->getURL()."{$subtype}/view/{$information->guid}/{$entity_name}";
		$content_type = ($information->type === 'group' || $information->type === 'user') ? $information->type : $information->subtype;

			
		$user_info .= "<div id='item_{$information->guid}'> <strong> {$information->guid} </strong> {$content_type} - <a href='{$content_url}'> {$entity_name} </a> <strong><a href='#' id='unsubscribe_link' style='color:red' onClick='onclick_link({$information->guid})'> unsubscribe </a></strong> </div>";
	}
	$user_info .= "</p>";

}

echo json_encode([
	'userinfo' => $user_info,
]);


