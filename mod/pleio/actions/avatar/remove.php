<?php
/**
 * Avatar remove action
 */

$user_guid = get_input('guid');
$user = get_user($user_guid);

if (!$user || !$user->canEdit()) {
	register_error(elgg_echo('avatar:remove:fail'));
	forward(REFERER);
}

$token = $user->getPrivateSetting("pleio_token");
if (!$token) {
    register_error(elgg_echo('pleio:no_token_available'));
    forward(REFERER);
}

$client = new GuzzleHttp\Client();

try {
    $result = $client->request("POST", "{$CONFIG->pleio->url}api/users/me/remove_avatar", [
        "headers" => [ "Authorization" => "Bearer {$token}" ]
    ]);
} catch (GuzzleHttp\Exception\ServerException $e) {
	register_error(elgg_echo('avatar:remove:fail'));
	forward(REFERER);
}

// Remove crop coords
unset($user->x1);
unset($user->x2);
unset($user->y1);
unset($user->y2);

// Remove icon
$user->icontime = time();
$user->save();

system_message(elgg_echo('avatar:remove:success'));
forward(REFERER);
