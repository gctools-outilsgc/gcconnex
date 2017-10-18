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

//grab profile information entities subtypes
$edu = get_subtype_id('object', 'education');
$work = get_subtype_id('object', 'experience');
$skill = get_subtype_id('object', 'MySkill');

$transfer_profile = get_input('profile');

//ignore these subtypes if not transfering profile
if(!$transfer_profile){
  $avoid = " AND subtype NOT IN ( $edu, $work, $skill )";
}
//transfering all object entities to new account
$data = get_data("SELECT * FROM {$db_prefix}entities WHERE owner_guid = {$oldGUID} AND type='object'".$avoid);

foreach($data as $object){

  if($object->container_guid != $oldGUID){
    update_data("UPDATE {$db_prefix}entities SET owner_guid = '$newGUID' where guid = '$object->guid'");
  } else {
    update_data("UPDATE {$db_prefix}entities SET owner_guid = '$newGUID', container_guid = '$newGUID' where guid = '$object->guid'");

    //handle transfering profile info entities to new user
    if($transfer_profile){
      switch($object->subtype){
        //education
        case $edu:
          $education = $new_user->education;

          if($education == NULL){
            $new_user->education = $object->guid;
          } else if(is_array($education)){
            array_push($education, $object->guid);
            $new_user->education = $education;
          } else if(!is_array($education)){
            $new_user->education = array($education, $object->guid);
          }
          update_data("UPDATE {$db_prefix}metadata SET owner_guid = '$newGUID' where entity_guid = '$object->guid'");
          break;
        //work experience
        case $work:
          $experience = $new_user->work;

          if($experience == NULL){
            $new_user->work = $object->guid;
          } else if(is_array($experience)){
            array_push($experience, $object->guid);
            $new_user->work = $experience;
          } else if(!is_array($experience)){
            $new_user->work = array($experience, $object->guid);
          }
          update_data("UPDATE {$db_prefix}metadata SET owner_guid = '$newGUID' where entity_guid = '$object->guid'");
          break;
        //skills
        case $skill:
          $skills = $new_user->gc_skills;

          if($skills == NULL){
            $new_user->gc_skills = $object->guid;
          } else if(is_array($skills)){
            if(count($skills) < 15){ //max 15 skill
              array_push($skills, $object->guid);
              $new_user->gc_skills = $skills;
            }
          } else if(!is_array($skills)){
            $new_user->gc_skills = array($skills, $object->guid);
          }

          break;
      }
    }
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



  //cover photo
  if(elgg_is_active_plugin('gc_group_layout')){
    gc_group_layout_transfer_coverphoto($groupEnt, $new_user);
  }

  group_tools_transfer_group_ownership($groupEnt, $new_user);

  //metadata
  update_data("UPDATE {$db_prefix}metadata SET owner_guid = '$newGUID' where entity_guid = $groupGUID");

}

//lets also do group membership
$transfer_membership = get_input('membership');

if($transfer_membership){
  $old_groups = get_data("SELECT * FROM {$db_prefix}entity_relationships WHERE guid_one = {$oldGUID} AND relationship='member'");

  foreach($old_groups as $group){
    $groupEnt = get_entity($group->guid_two);

    if(!$groupEnt->isMember($new_user)){
      $groupEnt->join($new_user);
    }
  }
}

//now time to do colleagues
$transfer_friends = get_input('friends');

if($transfer_friends){
  $old_friends = $old_user->getFriends(array('limit' => 0));

  foreach($old_friends as $friend){
    //check if friends
    if(!$friend->isFriendOf($newGUID) && $friend != $new_user){
      //have to add relationhip to both of them
      add_entity_relationship($friend->guid, 'friend', $newGUID);
      add_entity_relationship($newGUID, 'friend', $friend->guid);
    }
  }

}

system_message('All content and groups has been transfered to '.$new_user->name.' and the account '.$old_user->name);

//unset from old account so entities are not deleted as well
if($transfer_profile){
  unset($old_user->education);
  unset($old_user->work);
  unset($old_user->gc_skills);
}

//lets say goodbye to this old user
$delete = get_input('delete');

if($delete){
  $old_user->delete();
}

elgg_trigger_plugin_hook('action', 'admin/site/flush_cache', null, true);
?>
