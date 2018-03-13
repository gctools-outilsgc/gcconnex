<?php
global $CONFIG;

$guid = get_input('guid');
$owner = get_entity($guid);

if (!$owner || !($owner instanceof ElggUser) || !$owner->canEdit()) {
	register_error(elgg_echo('avatar:upload:fail'));
	forward(REFERER);
}

if ($_FILES['avatar']['error'] != 0) {
	register_error(elgg_echo('avatar:upload:fail'));
	forward(REFERER);
}

$token = $owner->getPrivateSetting("pleio_token");
if (!$token) {
    register_error(elgg_echo('pleio:no_token_available'));
    forward(REFERER);
}

$client = new GuzzleHttp\Client();

try {
    $result = $client->request("POST", "{$CONFIG->pleio->url}api/users/me/change_avatar", [
        "headers" => [
            "Authorization" => "Bearer {$token}"
        ],
        "multipart" => [
            [
                "name" => "avatar",
                "contents" => fopen($_FILES['avatar']['tmp_name'], 'r'),
                "filename" => $_FILES['avatar']['name']
            ]
        ]
    ]);
} catch (GuzzleHttp\Exception\ServerException $e) {
	register_error(elgg_echo('avatar:upload:fail'));
	forward(REFERER);
}

$owner->icontime = time();
$owner->save();

system_message(elgg_echo("avatar:upload:success"));
forward(REFERER);
