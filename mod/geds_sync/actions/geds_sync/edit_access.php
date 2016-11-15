<?php
/*
* Edit acccess permissions on who can view Location and organization metadata
* Adding metadata about address and organization tree is not optional and we provide no ability to edit or delete this metadata. 
* For this reason we decided to allow them the ability to at least control who can see it in the event the informaation is wrong.
* If GEDS info is wrong, Links are provided to contact data administrators.
*
* This action is called by clicking the save button on the ../geds_sync/edit page.
* Edit page is accessable to users who have not synced geds. Action file returns errors if Org or loaction info is not found in their profile.
*
* this will only ever edit your own profile. Admins cannot edit another users profile, no info is passed about which profile the edit button was pressed on.
* 
*/

//get current user
$user = elgg_get_logged_in_user_entity();
//get inputs
$org_access = get_input('org_access_id');
$loc_access = get_input('loc_access_id');

//check user for org data. It has to check for french and english both as they are stored as seperate pieces of metadata
if (!$user->orgStructFr && !$user->orgStruct){

	register_error(elgg_echo("geds:edit:error"));
	forward(REFERER);
}
// check for address in both english and french
if (!$user->addressString && !$user->addressStringFr){

	register_error("No addressString");
	forward(REFERER);
}

////////////////////////////////////////////////////////
// Update access id on ORG metadata  
/////////////////////////////////////////////////////

//first we need to get the current metadata
$options = array(
		'metadata_owner_guids'=>  array(elgg_get_logged_in_user_guid()),
		'limit' => 0,
		'metadata_names' => array('orgStruct') //english 
	);
$metadata = elgg_get_metadata($options);
//returns an array so we just take the first element
$metadata = $metadata[0];
//update metadata with new access ID passed in from form and saved in $org_access
update_metadata($metadata->id,$metadata->name,$metadata->value,	$metadata->value_type,	$metadata->owner_guid,	$org_access);

//Both french and english org metadata shoudl have the same access level so we set them both 
$options = array(
		'metadata_owner_guids'=>  array(elgg_get_logged_in_user_guid()),
		'limit' => 0,
		'metadata_names' => array('orgStructFr') //french
	);
$metadata = elgg_get_metadata($options);
$metadata = $metadata[0];
update_metadata($metadata->id,$metadata->name,$metadata->value,	$metadata->value_type,	$metadata->owner_guid,	$org_access);

/////////////////////////////////////////////////////////////////////////////
// Update access id on location
/////////////////////////////////////////////////////

//same process for location as with org
$options = array(
		'metadata_owner_guids'=>  array(elgg_get_logged_in_user_guid()),
		'limit' => 0,
		'metadata_names' => array('addressString') //english
	);
$metadata = elgg_get_metadata($options);
$metadata = $metadata[0];
update_metadata($metadata->id,$metadata->name,$metadata->value,	$metadata->value_type,	$metadata->owner_guid,	$loc_access);

$options = array(
		'metadata_owner_guids'=>  array(elgg_get_logged_in_user_guid()),
		'limit' => 0,
		'metadata_names' => array('addressStringFr') //french
	);
$metadata = elgg_get_metadata($options);
$metadata = $metadata[0];
update_metadata($metadata->id,$metadata->name,$metadata->value,	$metadata->value_type,	$metadata->owner_guid,	$loc_access);

//Set sucess message and forward to logged in users url.
system_message(elgg_echo('geds:org:edit:success'));
forward($user->getURL());