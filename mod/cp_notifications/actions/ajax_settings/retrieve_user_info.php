<?php


if (!elgg_is_xhr()) {
	register_error('Sorry, Ajax only!');
	forward();
}


$username = get_input('username');
$user = get_user_by_username($username);

$query = "
SELECT r.guid_one, r.guid_two, o.title, es.subtype, e.container_guid, e.guid
FROM elggentity_relationships r
	LEFT JOIN elggentities e ON e.guid = r.guid_two
	LEFT JOIN elggobjects_entity o ON o.guid = r.guid_two
	LEFT JOIN elggentity_subtypes es ON es.id = e.subtype
WHERE r.guid_one = {$user->guid} AND r.relationship like 'cp_subscribed_%'
";

$informations = get_data($query);

$user_info = "";
foreach ($informations as $information) {
	error_log("???????? ".$information->title);
	$user_info .= "{$information->subtype} // {$information->title} // {$information->guid} <br/>";
}


echo json_encode([
	'userinfo' => $user_info,
]);


