<?php

	/* 
	 * Registration page changes
	 */
/***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * TLaw/ISal 	n/a 			GC Changes
 * CYu 			April 8 2014 	overriding core code
 * 						
 *
 ***********************************************************************/
	
	function gcRegistration_init() 
	{
		elgg_register_action('register/ajax', elgg_get_plugins_path() . "gcRegistration/actions/registerAJAX.php", 'public');
		elgg_register_action('register', elgg_get_plugins_path() . 'gcRegistration/actions/register.php', 'public');

		elgg_register_simplecache_view('js/gcRegistration/registration_js');
		$url = elgg_get_simplecache_url('js','gcRegistration/registration_js');
		elgg_register_js('gcRegistration', $url);
		//////////////Troy
		elgg_register_action('saveDept', elgg_get_plugins_path() . 'gcRegistration/actions/saveDept.php', 'public');
		

	}
	
	register_elgg_event_handler('init','system','gcRegistration_init');		
?>