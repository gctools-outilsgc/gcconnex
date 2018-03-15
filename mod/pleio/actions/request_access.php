<?php
if (!$_SESSION["pleio_resource_owner"]) {
    register_error("pleio:could_not_find_user_info");
    forward(REFERER);
}

$fields = pleio_get_required_profile_fields();
foreach ($fields as $field) {
    $value = get_input("custom_profile_fields_{$field->metadata_name}");
    if (!$value) {
        register_error(elgg_echo("profile_manager:register_pre_check:missing", array($field->getTitle())));
        forward(REFERER);
    }
}

$resourceOwner = new ModPleio\ResourceOwner($_SESSION["pleio_resource_owner"]);
$loginHandler = new ModPleio\LoginHandler($resourceOwner);
$loginHandler->requestAccess();

forward("/access_requested");