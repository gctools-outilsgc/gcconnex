<?php

function au_subgroups_add_parent($event, $type, $object) {  
  // if we have an input, then we're setting the parent
  $parent_guid = get_input('au_subgroups_parent_guid', false);
  if ($parent_guid !== false) {
    au_subgroups_set_parent_group($object->guid, $parent_guid);
  }
  
  $parent = get_entity($parent_guid);
  // subgroups aren't enabled, how are we creating a new subgroup?
  if (elgg_instanceof($parent, 'group') && $parent->subgroups_enable == 'no') {
    register_error(elgg_echo('au_subtypes:error:create:disabled'));
    return FALSE;
  }
}

function au_subgroups_clone_layout_on_create($event, $type, $object) {
  if (elgg_is_active_plugin('group_custom_layout')) {
    $parent = au_subgroups_get_parent_group($object);
    
    if ($parent) {
      au_subgroups_clone_layout($object, $parent);
    }
  }
}

/**
 * when groups are created/updated, make sure subgroups have
 * access only by parent group acl
 */
function au_subgroups_group_visibility($event, $type, $object) {
  $parent = au_subgroups_get_parent_group($object);
  
  // make sure the visibility is what was set on the form
  $vis = get_input('vis', false);
  
  if ($vis !== false) { // this makes sure we only update access when it's done via form

    switch ($vis) {
      case 'parent_group_acl':
        $access_id = $parent->group_acl;
        break;
      
      case ACCESS_PRIVATE:
        $access_id = $object->group_acl;
        break;
      
      default:
        $access_id = $vis;
        break;
    }

    
    /*
     * Here we have some trickiness, because save is called twice with the visibility being
     * reset the second time.  So we have to make sure we're only updating the visibility
     * of the original (not a subgroup or parent) on subsequent calls.
     * 
     * To do this we're setting a temporary config variable to say that yes, we've been here once
     * and pass the guid of the group we're concerned with in another config variable.
     * That way we know only to update the vis of the matching guid
     */
    
    if (!elgg_get_config('au_subgroups_visupdate')) {
      // this is the first pass, lets mark it and save the guid of the group we care about
      elgg_set_config('au_subgroups_visupdate', true);
      elgg_set_config('au_subgroups_vis_guid', $object->guid);
    }
    
    if (elgg_get_config('au_subgroups_vis_guid') == $object->guid) {
      // we need to update it - first in memory, then in the db
      $object->access_id = $access_id;
      $q = "UPDATE " . elgg_get_config('dbprefix') . "entities SET access_id = {$access_id} WHERE guid = {$object->guid}";
      update_data($q);
      // make sure our metadata follows suit
      metadata_update('update', 'group', $object);
    }
   
    // if this group has subgroups, and we're making the visibility more restrictive
    // we need to check the subgroups to make sure they're not more visible than this group
    set_time_limit(0); // this is recursive and could take a while
    
    $children = au_subgroups_get_subgroups($object, 0);
    
    if ($children) {
      foreach($children as $child) {        
        switch ($access_id) {
          case ACCESS_PUBLIC:
              // do nothing, most permissive access
            break;

          case ACCESS_LOGGED_IN:
              // if child access is public, bump it up
              if ($child->access_id == ACCESS_PUBLIC) {
                $child->access_id = ACCESS_LOGGED_IN;
                $child->save();
              }
            break;
          
          default:
              // two options here, group->group_acl = hidden
              // or parent->group_acl = visible to parent group members
              // if the child is more permissive than the parent, we're changing the child to 
              // the next level up - in this case, visible to parent group
              if (!in_array($child->access_id, array($child->group_acl, $object->group_acl))) {
                $child->access_id = $object->group_acl;
                $child->save();
              }
            break;
        }
      }
    }
  }
}

/**
 * Prevents users from joining a subgroup if they're not a member of the parent
 * 
 * @param type $event
 * @param type $type
 * @param ElggRelationship $object
 * @return boolean
 */
function au_subgroups_join_group($event, $type, $object) {
  if ($object instanceof ElggRelationship) {
    $user = get_entity($object->guid_one);
    $group = get_entity($object->guid_two);
    $parent = au_subgroups_get_parent_group($group);
    
    if ($parent) {
      if (!$parent->isMember($user)) {
        register_error(elgg_echo('au_subgroups:error:notparentmember'));
        return false;
      }
    }
  }
}

/**
 * When leaving a group, make sure users are removed from any subgroups
 * 
 * @param type $event
 * @param type $type
 * @param type $object
 */
function au_subgroups_leave_group($event, $type, $params) {
  $guids = au_subgroups_get_all_children_guids($params['group']);
  
  foreach ($guids as $guid) {
    leave_group($guid, $params['user']->guid);
  }
}



function au_subgroups_pagesetup() {
  if (in_array(elgg_get_context(), array('au_subgroups', 'group_profile'))) {
    $group = elgg_get_page_owner_entity();
    if (elgg_instanceof($group, 'group')
			&& $group->canEdit()
			&& $group->subgroups_enable != 'no') {
      // register our title menu
      elgg_register_menu_item('title', array(
        'name' => 'add_subgroup',
        'href' => "groups/subgroups/add/{$group->guid}",
        'text' => elgg_echo('au_subgroups:add:subgroup'),
        'class' => 'elgg-button elgg-button-action'
      ));
    }
  }
}