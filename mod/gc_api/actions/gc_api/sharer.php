<?php
/*
 * sharer.php
 * 
 * Author: Troy T. Lawson, Troy.Lawson@tbs-sct.gc.ca; Lawson.Troy@gmail.com
 * 
 * Purpose: This file is the action file used for building and saving the bookmark object to the database,
 * adding the saved bookmark to the river for activity/new feeds on the site, and also creates a wire post
 * if indicate by the user
 * 
 */

 // Get inputs from sharer form.
$title = htmlspecialchars(get_input('title', '', false), ENT_QUOTES, 'UTF-8'); 
$description = get_input('description');
$address = get_input('address');
$access_id = get_input('access_id'); 
$containerGuid = get_input('share_group'); //if bookmark is saved to a group this is group guid
$shareToWire = get_input('share_on_wire'); //checkbox to mark if also shared to wire
$userID = elgg_get_logged_in_user_guid();
$personalFlag = get_input('share_destination'); //radio button to show if personal or group bookmark

//title and address manditory.
if (!$title || !$address) {
	register_error(elgg_echo('bookmarks:save:failed'));
	forward(REFERER);
}
//no group selected, default to personal bookmark
if ($containerGuid == 'NA'){
	$containerGuid = $userID;
}

//build bookmark object
$bookmark = new ElggObject;
$bookmark->subtype = "bookmarks";
//check incase container_guid is set and personal selected. personal ovrides group.
$bookmark->container_guid = $containerGuid;
if ($personalFlag == 'Add to personal Bookmarks'){
	$bookmark->container_guid = $userID;
}
$bookmark->title = $title;
$bookmark->address = $address;
$bookmark->description = $description;
$bookmark->access_id = $access_id;

//save object 
if (!$bookmark->save()) {
	register_error(elgg_echo('bookmarks:save:failed'));
	$destinationURL = elgg_get_site_url().'share_bookmarks/share?close=true';
	forward($destinationURL);
}

//create river item for activity / news feed
elgg_create_river_item(array(
			'view' => 'river/object/bookmarks/create',
			'action_type' => 'create',
			'subject_guid' => elgg_get_logged_in_user_guid(),
			'object_guid' => $bookmark->getGUID(),
		));

//if share to wire build wire post
if($shareToWire!='0'){
	//calls function from wire plugin to build the post
	$guid = thewire_tools_save_post($title, elgg_get_logged_in_user_guid(), ACCESS_PUBLIC, 0, "site", $bookmark->getGUID());
}

//returns to page view with flag set to close the window
$destinationURL = elgg_get_site_url().'share_bookmarks/share?close=true';
forward($destinationURL);

?>