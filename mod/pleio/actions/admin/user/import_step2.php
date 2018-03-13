<?php
$loggedin_user = elgg_get_logged_in_user_entity();
$columns = get_input("columns");

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
fclose($fh);

pleio_schedule_in_background("import_process", [
    "initiator_guid" => $loggedin_user->guid,
    "csv_location" => $csv_location,
    "columns" => $columns
]);

unset($_SESSION["subsite_manager_import"]);

system_message(elgg_echo("pleio:users_import:started_in_background"));
forward("/admin/users/import");
