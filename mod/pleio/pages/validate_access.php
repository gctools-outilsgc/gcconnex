<?php
$code = get_input("code");
$data = ModPleio\Helpers::loadSignedData($code);

if (!$data) {
    register_error(elgg_echo("pleio:validate_access:error"));
    forward("/login");
}

$accessRequests = new ModPleio\AccessRequests();
$accessRequest = $accessRequests->get($data["request_id"]);

if (!$accessRequest || $accessRequest->user["guid"] !== $data["guid"]) {
    register_error(elgg_echo("pleio:validate_access:error"));
    forward("/login");
}

$resourceOwner = new ModPleio\ResourceOwner($accessRequest->user);

if (!ModPleio\Helpers::emailInWhitelist($resourceOwner->getEmail())) {
    register_error(elgg_echo("pleio:validate_access:error"));
    forward("/login");
}

$loginHandler = new ModPleio\LoginHandler($resourceOwner);
$user = $loginHandler->createUser();

if ($user) {
    login($user);
    $accessRequest->remove();
}

forward("/");
