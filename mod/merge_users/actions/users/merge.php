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
	forward('admin/users/merge_users');
}

$oldGUID = $old_user->guid;
$newGUID = $new_user->guid;

//grab profile information entities subtypes
$edu = get_subtype_id('object', 'education');
$work = get_subtype_id('object', 'experience');
$skill = get_subtype_id('object', 'MySkill');

//subtypes to not transfer
$image = get_subtype_id('object', 'image');
$file = get_subtype_id('object', 'file');
$album = get_subtype_id('object', 'album');

//check if we are transfering content
$transfer_content = get_input('content');

if($transfer_content){
    //transfering all object entities to new account
    $data = get_data("SELECT * FROM {$db_prefix}entities WHERE owner_guid = {$oldGUID} AND type='object' AND subtype NOT IN ( $edu, $work, $skill, $image, $file, $album )");

    $event = get_subtype_id('object', 'event_calendar');
    $file = get_subtype_id('object', 'file');

    foreach($data as $object){

      if($object->container_guid != $oldGUID){ //entities in a group

        //handle different entitites a certain way
        switch($object->subtype){
          case $event:
            add_entity_relationship($newGUID,'personal_event', $object->guid);
          break;
          default:
        }

        update_data("UPDATE {$db_prefix}entities SET owner_guid = '$newGUID' where guid = '$object->guid'");

      } else { //entities under the user

        //handle different entitites a certain way
        switch($object->subtype){
          case $event:
            add_entity_relationship($newGUID,'personal_event', $object->guid);
          default:
        }

        update_data("UPDATE {$db_prefix}entities SET owner_guid = '$newGUID', container_guid = '$newGUID' where guid = '$object->guid'");

      }

    }
}


$transfer_profile = get_input('profile');

//handle transfering profile info entities to new user
if($transfer_profile){

  $profile_data = get_data("SELECT * FROM {$db_prefix}entities WHERE owner_guid = {$oldGUID} AND type='object' AND subtype IN ( $edu, $work, $skill )");

  foreach($profile_data as $object){

    update_data("UPDATE {$db_prefix}entities SET owner_guid = '$newGUID', container_guid = '$newGUID' where guid = '$object->guid'");

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

system_message('The account <b>'.$new_user->name.'</b> has been merged into the account <b>'.$old_user->name.'</b>.');

//unset from old account so entities are not deleted as well
if($transfer_profile){
  unset($old_user->education);
  unset($old_user->work);
  unset($old_user->gc_skills);
}

//Test for deactivate
$deactivate = get_input('deactivate');

if($deactivate){
  $old_user->gcdeactivate = true;
  $old_user->gcdeactivatereason = "";
  $old_user->gcdeactivatetime = time();
}

//lets say goodbye to this old user
$delete = get_input('delete');

if($delete){
  $old_user->delete();
}

elgg_trigger_plugin_hook('action', 'admin/site/flush_cache', null, true);
?>
