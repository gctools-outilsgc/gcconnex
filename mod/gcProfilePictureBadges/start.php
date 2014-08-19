<?php

	/* 
	 *  User picture badges
	*/
	
	/* Initialise the theme */
	function gcProfilePictureBadges_init(){
		//elgg_extend_view('css/elgg', 'gcProfilePictureBadges/css');
		//elgg_extend_view('icon/user/default', 'gcProfilePictureBadges/default');
		elgg_register_action( "avatar/crop", elgg_get_plugins_path() . "gcProfilePictureBadges/actions/avatar/crop.php" );
	}
	
	// Initialise log browser
	elgg_register_event_handler('init','system','gcProfilePictureBadges_init');
	
?>