<?php
$db_prefix = elgg_get_config('dbprefix');

//get usernames
$old = get_input('olduser');
$new = get_input('newuser');

if(!$old || !$new){
  register_error('No input');
	forward('admin/merge_users/merge');
}

//get user entities
$old_user = get_user_by_username($old);
$new_user = get_user_by_username($new);

if(!$old_user || !$new_user){
  register_error('Could not find user.');
	forward('admin/merge_users/merge');
}

$oldGUID = $old_user->guid;
$newGUID = $new_user->guid;

//transfering all object entities to new account
$data = get_data("SELECT * FROM {$db_prefix}entities WHERE owner_guid = {$oldGUID} AND type='object'");

foreach($data as $object){

  if($object->container_guid != $oldGUID){
    update_data("UPDATE {$db_prefix}entities SET owner_guid = '$newGUID' where guid = '$object->guid'");
  } else {
    update_data("UPDATE {$db_prefix}entities SET owner_guid = '$newGUID', container_guid = '$newGUID' where guid = '$object->guid'");
  }
}

//transfering group ownership and making sure new account is a member of the group they are now the owner of
$dataGroups = get_data("SELECT * FROM {$db_prefix}entities WHERE owner_guid = {$oldGUID} AND type='group'");

foreach($dataGroups as $group){
  $groupEnt = get_entity($group->guid);

  $groupGUID = $group->guid;

  //make sure new user is a group member
  if(!$groupEnt->isMember($new_user)){
    $groupEnt->join($new_user);
  }

  // We also change icons owner
	$old_filehandler = new ElggFile();
	$old_filehandler->owner_guid = $groupEnt->owner_guid;
	$old_filehandler->setFilename('groups');
	$old_path = $old_filehandler->getFilenameOnFilestore();

	$new_filehandler = new ElggFile();
	$new_filehandler->owner_guid = $newGUID;
	$new_filehandler->setFilename('groups');
	$new_path = $new_filehandler->getFilenameOnFilestore();

	foreach(array('', 'tiny', 'small', 'medium', 'large') as $size) {
		rename("$old_path/{$groupGUID}{$size}.jpg", "$new_path/{$groupGUID}{$size}.jpg");
	}

  //cover photo
  if(elgg_is_active_plugin('gc_group_layout')){
    gc_group_layout_transfer_coverphoto($groupEnt, $new_user);
  }

  //transfer ownership
  update_data("UPDATE {$db_prefix}entities SET owner_guid = '$newGUID', container_guid = '$newGUID' where guid = '$groupGUID'");
  //metadata
  update_data("UPDATE {$db_prefix}metadata SET owner_guid = '$newGUID' where entity_guid = $groupGUID");



}

system_message('All content and groups has been transfered to '.$new_user->name.' and the account '.$old_user->name.' has been deleted');

$old_user->delete();
?>
