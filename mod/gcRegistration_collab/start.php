<?php

/* 
 * Registration Init file
 */

/***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * TLaw/ISal 	n/a 			GC Changes
 * CYu 			April 8 2014 	overriding core code
 * TLaw			n/a 			save department	
 * MWooff 		Jan 18 2017		Re-built for GCcollab-specific functions				
 *
 ***********************************************************************/
	
function gcRegistration_collab_init() {
	elgg_register_action('register/ajax', elgg_get_plugins_path() . "gcRegistration_collab/actions/registerAJAX.php", 'public');
	elgg_register_action('register', elgg_get_plugins_path() . 'gcRegistration_collab/actions/register.php', 'public');
	
	elgg_register_action('gcRegistration_collab/save', elgg_get_plugins_path() . 'gcRegistration_collab/actions/gcRegistration_collab/save.php');
	elgg_register_action('gcRegistration_collab/delete', elgg_get_plugins_path() . 'gcRegistration_collab/actions/gcRegistration_collab/delete.php');

	elgg_register_simplecache_view('js/gcRegistration_collab/registration_js');
	$url = elgg_get_simplecache_url('js','gcRegistration_collab/registration_js');
	elgg_register_js('gcRegistration_collab', $url);
}

register_elgg_event_handler('init','system','gcRegistration_collab_init');		
