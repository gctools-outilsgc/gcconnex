<?php

elgg_register_event_handler('init', 'system', 'paas_integration_init');

function paas_integration_init() {

    elgg_register_action("avatar/upload", elgg_get_plugins_path() . "paas_integration/actions/avatar/upload.php");
    
}
