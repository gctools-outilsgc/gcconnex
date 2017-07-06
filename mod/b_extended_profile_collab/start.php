<?php

elgg_register_event_handler('init', 'system', 'b_extended_profile_collab_init');

function b_extended_profile_collab_init() {
    // Register the endorsements js library
    $url = 'mod/b_extended_profile_collab/js/endorsements/';
    // js file containing code for edit, save, cancel toggles and the events that they trigger, plus more
    elgg_register_js('gcconnex-profile', $url . "gcconnex-profile.js");

	// register the action for saving profile fields
	$action_path = elgg_get_plugins_path() . 'b_extended_profile_collab/actions/b_extended_profile/';
	elgg_register_action('b_extended_profile/edit_profile', $action_path . 'edit_profile.php');

	// The new views used for the Opt-In section.
    elgg_register_ajax_view('b_extended_profile/opt-in');
    elgg_register_ajax_view('b_extended_profile/edit_opt-in');

    // Register the gcconnex profile css libraries
    $css_url = 'mod/b_extended_profile_collab/css/gcconnex-profile.css';
    elgg_register_css('gcconnex-css', $css_url);
}