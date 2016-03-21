<?php
	/*
	 * Author: National Research Council Canada
	 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
	 * 
	 * License: Creative Commons Attribution 3.0 Unported License
	 * Copyright: Her Majesty the Queen in Right of Canada, 2015
	 */

	/*
	 * This plugin adds a section to the GCConnex profile where users can opt-in to several different learning, teaching or professional experiences.
	 * This plugin requires the b_extended_profile plugin and overrides 3 of its files (edit_profile.php, gcconnex-profile.js, wrapper.php).
	 */
	elgg_register_event_handler('init', 'system', missions_profile_extension_init);
	
	function missions_profile_extension_init() {
		// The new views used for the Opt-In section.
		elgg_register_ajax_view('b_extended_profile/opt-in');
		elgg_register_ajax_view('b_extended_profile/edit_opt-in');
		
		// Overriding the original javascript file with the modified version.
		// The modified version adds code to the ready, editProfile and saveProfile functions.
		elgg_register_js('gcconnex-profile', 'mod/missions_profile_extend/js/endorsements/gcconnex-profile.js');
		
		//The old action needs to be removed before the modified one can be registered.
		elgg_unregister_action('b_extended_profile/edit_profile');
		
		// The new action saves the data gathered from the new views.
		elgg_register_action('b_extended_profile/edit_profile', elgg_get_plugins_path() . 'missions_profile_extend/actions/b_extended_profile/edit_profile.php');
	}