<?php
/**
 * Avatar upload action
 */

 // https://github.com/euautomation/graphql-client
require_once __DIR__ . '/../../vendor/autoload.php';

use EUAutomation\GraphQL\Client;

$guid = get_input('guid');
$owner = get_entity($guid);

if (!$owner || !($owner instanceof ElggUser) || !$owner->canEdit()) {
	register_error(elgg_echo('avatar:upload:fail'));
	forward(REFERER);
}

$error = elgg_get_friendly_upload_error($_FILES['avatar']['error']);
if ($error) {
	register_error($error);
	forward(REFERER);
}

$icon_sizes = elgg_get_config('icon_sizes');

// get the images and save their file handlers into an array
// so we can do clean up if one fails.
$files = array();
foreach ($icon_sizes as $name => $size_info) {
	$resized = get_resized_image_from_uploaded_file('avatar', $size_info['w'], $size_info['h'], $size_info['square'], $size_info['upscale']);

	if ($resized) {
		//@todo Make these actual entities.  See exts #348.
		$file = new ElggFile();
		$file->owner_guid = $guid;
		$file->setFilename("profile/{$guid}{$name}.jpg");
		$file->open('write');
		$file->write($resized);
		$file->close();
		$files[] = $file;
	} else {
		// cleanup on fail
		foreach ($files as $file) {
			$file->delete();
		}

		register_error(elgg_echo('avatar:resize:fail'));
		forward(REFERER);
	}
}

// reset crop coordinates
$owner->x1 = 0;
$owner->x2 = 0;
$owner->y1 = 0;
$owner->y2 = 0;

$owner->icontime = time();

// Prepare for GraphQL query to PaaS

$dbprefix = elgg_get_config("dbprefix");
$service_url = elgg_get_plugin_setting("graphql_client", "paas_integration");
$dev_url = elgg_get_plugin_setting("dev_url", "paas_integration");

$session = elgg_get_session();
$token = $session->get('token');

$result = get_data_row("SELECT pleio_guid FROM {$dbprefix}users_entity WHERE guid = $guid");
if ($result->pleio_guid) {
	$gcID = $result->pleio_guid;
}

if($dev_url){
	$site_url = $dev_url;
} else {
	$site_url = elgg_get_site_url();
}

$lastlogin = $owner->last_login;
$joindate = $owner->time_created;

$avatar = "$site_url/mod/profile/icondirect.php?guid=$guid&size=large&lastcache=$lastcache&joindate=$joindate";

$client = new Client($service_url);

$headers = [
	"Authorization" => "Bearer $token"
];

$query = 'mutation ($gcID: ID!, $data: ModifyProfileInput!) {
	modifyProfile(gcID: $gcID, data: $data) {
		name
		avatar
	}
}';

$variables = array(
	'gcID' => $gcID,
	'data' => array(
		'avatar' => $avatar
	)
);

// Send data to PaaS
$response = $client->response($query, $variables, $headers);

error_log("///////////////////////////////////////////////////////////////////////////////////////////// ".serialize($response->errors()));
error_log("///////////////////////////////////////////////////////////////////////////////////////////// ".$response->modifyProfile->avatar);
error_log("\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\".serialize($response->all()));

if (elgg_trigger_event('profileiconupdate', $owner->type, $owner)) {
	system_message(elgg_echo("avatar:upload:success"));

	$view = 'river/user/default/profileiconupdate';
	elgg_delete_river(array('subject_guid' => $owner->guid, 'view' => $view));
	elgg_create_river_item(array(
		'view' => $view,
		'action_type' => 'update',
		'subject_guid' => $owner->guid,
		'object_guid' => $owner->guid,
	));
}

forward(REFERER);
