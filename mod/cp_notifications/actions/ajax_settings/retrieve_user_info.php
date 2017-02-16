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

	$query = "SELECT DISTINCT r.guid_one, r.guid_two, o.title, es.subtype, e.container_guid, e.guid, o.description FROM elggentity_relationships r 	LEFT JOIN elggentities e ON e.guid = r.guid_two LEFT JOIN elggobjects_entity o ON o.guid = r.guid_two 	LEFT JOIN elggentity_subtypes es ON es.id = e.subtype WHERE r.guid_one = {$user->guid} AND r.relationship like 'cp_subscribed_%' ";


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
		$content_url = $site->getURL()."{$subtype}/view/{$information->guid}/{$information->title}";
		$user_info .= "<div id='item_{$information->guid}'> <strong> {$information->guid} </strong> {$information->subtype} - <a href='{$content_url}'> {$content_title} </a> <strong><a href='#' id='unsubscribe_link' style='color:red' onClick='onclick_link({$information->guid})'> unsubscribe </a></strong> </div>";
	}
	$user_info .= "</p>";

}

echo json_encode([
	'userinfo' => $user_info,
]);


