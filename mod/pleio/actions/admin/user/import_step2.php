<?php
$columns = get_input("columns");
$message = get_input("message");

$site = elgg_get_site_entity();
$loggedin_user = elgg_get_logged_in_user_entity();
$profile_fields = get_config("profile_fields");

set_time_limit(0);

if (empty($columns)) {
    register_error(elgg_echo("subsite_manager:action:import:step2:error:columns"));
    forward(REFERER);
}

if (!in_array("guid", $columns) && !in_array("username", $columns) && !in_array("email", $columns)) {
    register_error(elgg_echo("subsite_manager:action:import:step2:error:required_fields"));
    forward(REFERER);
}

$csv_location = $_SESSION["import"]["location"];
$fh = fopen($csv_location, "r");

if (!$fh) {
    register_error(elgg_echo("subsite_manager:action:import:step2:error:csv_file"));
    forward("/admin/users/import");
}

$stats = [
    "created" => 0,
    "updated" => 0,
    "error" => 0
];

$skip_first_line = true;

while (($data = fgetcsv($fh, 0, ";")) !== false) {
    if ($skip_first_line) {
        $skip_first_line = false;
        continue;
    }

    $data = ModPleio\Import::extractData($columns, $data);

    $user = ModPleio\Import::getUserByAttributes($data);
    if (!$user) {
        $user = ModPleio\Import::registerUser($data);
        if ($user) {
            $stats["created"] += 1;
        } else {
            $stats["error"] += 1;
        }
    } else {
        $stats["updated"] += 1;
    }

    if (!$user) {
        continue;
    }

    if ($data["email"] && $user->email !== $data["email"]) {
        $user->email = $data["email"];
    }

    if ($data["name"] && $user->name !== $data["name"]) {
        $user->name = $data["name"];
    }

    foreach ($columns as $id => $metadata_name) {
        $value = $data[$metadata_name];
        if (empty($value)) {
            continue;
        }

        if (!array_key_exists($metadata_name, $profile_fields)) {
            continue;
        }

        $field_type = $profile_fields[$metadata_name];

        if ($profile_fields[$metadata_name] == "tags") {
            elgg_delete_metadata([
                "guid" => $user->guid,
                "metadata_name" => $metadata_name,
                "limit" => 0
            ]);

            foreach (string_to_tag_array($value) as $v) {
                create_metadata($user->guid, $metadata_name, $v, "", $user->guid, get_default_access(), true, $site->guid);
            }
        } else {
            create_metadata($user->guid, $metadata_name, $value, "", $user->guid, get_default_access(), false, $site->guid);
        }
    }

    $user->save();
}

unset($_SESSION["subsite_manager_import"]);
unlink($csv_location);

system_message(elgg_echo("pleio:imported", [$stats["created"], $stats["updated"], $stats["error"]]));
forward("/admin/users/import");