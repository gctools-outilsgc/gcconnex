<?php
function import_process($input) {
    global $CONFIG, $site, $initiator;

    $site = elgg_get_site_entity();

    $initiator = get_entity($input["initiator_guid"]);
    if (!$initiator) {
        throw new Exception("Could not find initiator user");
    }
    set_exception_handler("import_exceptionhandler");
    register_shutdown_function("import_check_for_fatal");

    $ia = elgg_set_ignore_access(true);
    $stats = ModPleio\Import::run($input["csv_location"], $input["columns"], $initiator);
    elgg_set_ignore_access($ia);

    $from = $site->email ?: "noreply@" . get_site_domain($CONFIG->site_guid);
    elgg_send_email(
        $from,
        $initiator->email,
        elgg_echo("pleio:users_import:email:success:subject"),
        elgg_echo("pleio:users_import:email:success:body", [
            $initiator->name,
            $stats["created"],
            $stats["updated"],
            $stats["error"]
        ])
    );
}

function import_exceptionhandler($exception) {
    import_send_error($exception->getMessage());
}

function import_check_for_fatal() {
    $error = error_get_last();
    if ($error["type"] !== E_ERROR) {
        return;
    }

    import_send_error($error["message"]);
}

function import_send_error($message) {
    global $CONFIG, $site, $initiator;

    $from = $site->email ?: "noreply@" . get_site_domain($CONFIG->site_guid);
    elgg_send_email(
        $from,
        $initiator->email,
        elgg_echo("pleio:users_import:email:failed:subject"),
        elgg_echo("pleio:users_import:email:failed:body", [
            $initiator->name,
            $message
        ])
    );
}
