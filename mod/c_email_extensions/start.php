<?php

elgg_register_event_handler('init', 'system', 'c_email_extensions_init');

function c_email_extensions_init() {
	elgg_register_library('c_ext_lib', elgg_get_plugins_path() . 'c_email_extensions/lib/functions.php');
	elgg_load_library('c_ext_lib');
	
	requirements_check();

	$action_path = elgg_get_plugins_path() . 'c_email_extensions/actions/c_email_extensions';
	elgg_register_action('c_email_extensions/delete', "$action_path/delete.php");
}
