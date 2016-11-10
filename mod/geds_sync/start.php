<?php
/**
 * Plugin: GEDS Sync
 * @package GEDS
 * Author: Troy Lawson - troy.lawson@tbs-sct.gc.ca 
 * Purpose: Populate Profile with info from GEDS. Info icnluded is basic contact information, address, and location
 * Requires: This plug in expands on the plugin Extended Profile by Bryden. It also requires a small tweak in the code of the extended profile plugin. A id must be added to a certain div.
 */
elgg_register_event_handler('init', 'system', 'geds_sync_init');

/**
 * Init GEDS Sync plugin.
 */
function geds_sync_init() {
	//Bootstrap data table for selecting GEDS fields to link up
	$url = 'mod/geds_sync/vendors/Bootstrap-Table/';
	elgg_register_css('bsTable', $url.'bootstrap-table.min.css');
	elgg_register_js('bsTablejs', $url.'bootstrap-table.min.js');
	
	//Loading spinner 
	elgg_register_js('spinner', 'mod/geds_sync/vendors/jquery.spin.js');
	elgg_register_css('spinnerCSS', 'mod/geds_sync/vendors/jquery.spin.css');
	//custom css - must be after extended profile to ensure this css overrides that plugins
	$url = 'mod/geds_sync/views/default/geds_sync/';
	elgg_register_css('geds-special', $url.'special.css');
    
    //adds sync button and functionality onto profile page
    elgg_extend_view('profile/details','geds_sync/geds_sync_button', 450);

    //adds location field to the profile with pop up window and map.
    elgg_extend_view('profile/details','geds_sync/location', 650);

    //adds the organizations tab to profile.
    elgg_extend_view('profile/wrapper','geds_sync/geds_org', 600);

    //ajax organizations and people functionality
    elgg_register_ajax_view('geds_sync/org-panel');

    //ajax organizations box
    elgg_register_ajax_view('geds_sync/org-orgs');

    //ajax view of people in selected organization
    elgg_register_ajax_view('geds_sync/org-people');

    //register actions to save profile and edit permisions.
    $action_path = elgg_get_plugins_path() . 'geds_sync/actions/geds_sync/';
    elgg_register_action('geds_sync/saveGEDSProfile', $action_path . 'saveGEDSProfile.php');
    elgg_register_action('geds_sync/edit', $action_path . 'edit_access.php');

    //register page handler. Plugin only has one page of its own
    elgg_register_page_handler('geds_sync', 'geds_sync_page_handler');
}

/*
* GEDS Sync page handeler.
* There is only one page for this plug in. A page to edit permissions
*/
function geds_sync_page_handler($segments) {
    if ($segments[0] == 'edit') {
        include elgg_get_plugins_path() . 'geds_sync/pages/geds_sync/edit.php';
       
        return true;
    }
   
    return false;
}
