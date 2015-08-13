<?php

elgg_register_event_handler('init', 'system', 'c_profile_changes_init');

function c_profile_changes_init() {
	//$url = elgg_get_plugins_path().'c_profile_changes/js/endorsements/';
	//$url = 'mod/c_profile_changes/js/endorsements/';
	//elgg_unregister_js('gcconnex-profile');
	//elgg_register_js('c_gcconnex-profile', $url . "c_gcconnex-profile.js");

	$action_path = elgg_get_plugins_path().'c_profile_changes/actions/c_profile_changes/';
	elgg_register_action('b_extended_profile/edit_profile', $action_path.'edit_profile.php');
}