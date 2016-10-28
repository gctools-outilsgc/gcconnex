<?php

	/*
	 *  User picture badges
	*/

	/* Initialise the theme */
	function gcProfilePictureBadges_init(){
		
		//elgg_extend_view('icon/user/default', 'gcProfilePictureBadges/default');
		elgg_register_action( "avatar/crop", elgg_get_plugins_path() . "gcProfilePictureBadges/actions/avatar/crop.php" );

		//add pledge to group sidebar
			 elgg_extend_view('groups/sidebar/sidebar', 'groups/sidebar/pledge', 1);

			 //add style so badge doesnt break in admin menu
			 elgg_extend_view('admin/header', 'widgets/avatar_style', 1);

			 //pledge action to add badge to avatar without havign to edit avatar
			 elgg_register_action('badge/pledge', elgg_get_plugins_path() . "gcProfilePictureBadges/actions/pledge.php");

			 //badge css
			 elgg_extend_view('css/elgg', 'gcProfilePictureBadges/css');
	}

	// Initialise log browser
	elgg_register_event_handler('init','system','gcProfilePictureBadges_init');

?>
