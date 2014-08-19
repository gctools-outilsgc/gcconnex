<?php

// definitions
define('AU_SUBGROUPS_RELATIONSHIP', 'au_subgroup_of');

// include our functions
require_once 'lib/events.php';
require_once 'lib/functions.php';
require_once 'lib/hooks.php';

elgg_register_event_handler('init', 'system', 'au_subgroups_init');


function au_subgroups_init() {
  // add in our own css
  elgg_extend_view('css/elgg', 'au_subgroups/css');
  elgg_extend_view('forms/groups/edit', 'forms/au_subgroups/edit');
  elgg_extend_view('navigation/breadcrumbs', 'au_subgroups/breadcrumb_override', 1);
  elgg_extend_view('group/elements/summary', 'au_subgroups/group/elements/summary');
  elgg_extend_view('groups/tool_latest', 'au_subgroups/group_module');
  elgg_extend_view('groups/sidebar/members', 'au_subgroups/sidebar/subgroups');
  
  // after group creation or editing we need to check the permissions
  elgg_register_event_handler('update', 'group', 'au_subgroups_group_visibility');
  elgg_register_event_handler('create', 'member', 'au_subgroups_join_group');
  elgg_register_event_handler('leave', 'group', 'au_subgroups_leave_group');
  // break up the create/update events to be more manageable
  elgg_register_event_handler('create', 'group', 'au_subgroups_add_parent', 1000);
  elgg_register_event_handler('create', 'group', 'au_subgroups_clone_layout_on_create', 1000);
  elgg_register_event_handler('create', 'group', 'au_subgroups_group_visibility', 1000);
  elgg_register_event_handler('pagesetup', 'system', 'au_subgroups_pagesetup');

  // replace the existing groups library so we can push some display options
  elgg_register_library('elgg:groups', elgg_get_plugins_path() . 'au_subgroups/lib/groups.php');
  
  add_group_tool_option('subgroups', elgg_echo('au_subgroups:group:enable'));
  
  // route some urls that go through 'groups' handler
  elgg_register_plugin_hook_handler('route', 'groups', 'au_subgroups_groups_router', 499);
  
  // make sure river entries have the correct access
  elgg_register_plugin_hook_handler('creating', 'river', 'au_subgroups_river_permissions');
  
  // admins of the parent group can edit the sub-group
  elgg_register_plugin_hook_handler('permissions_check', 'group', 'au_subgroups_group_canedit');
  
  // sort out what happens when a parent group is deleted
  elgg_register_plugin_hook_handler('action', 'groups/delete', 'au_subgroups_delete_group');
  
  // prevent users from being invited into a subgroup they can't join
  elgg_register_plugin_hook_handler('action', 'groups/invite', 'au_subgroups_group_invite');
  
  // remove 'join' and 'request membership' title links on subgroups for people not members of the parent
  elgg_register_plugin_hook_handler('register', 'menu:title', 'au_subgroups_titlemenu');
  
  // register our widget
  elgg_register_widget_type('au_subgroups', elgg_echo('au_subgroups'), elgg_echo('au_subgroups:widget:description'), 'groups');
  
  // fix some problems
  if (elgg_is_admin_logged_in()) {
    run_function_once('au_subgroups_bugfix_20121024a');
  }
}


function au_subgroups_bugfix_20121024a() {
  $options = array(
     'types' => 'group',
     'limit' => 0
  );
  
  // using ElggBatch because there may be many, many groups in the installation
  // try to avoid oom errors
  $batch = new ElggBatch('elgg_get_entities', $options, 'au_subgroups_fix_acls_20121024a', 50);
}

function au_subgroups_fix_acls_20121024a($result, $getter, $options) {
  if ($result->group_acl === NULL) {
    // group has no acl... create it and add all the members
    $ac_name = elgg_echo('groups:group') . ": " . $result->name;
    $group_acl = create_access_collection($ac_name, $result->guid);
		$result->group_acl = $group_acl;
    
    // now add all members of the group to the acl
    $members = $result->getMembers(0, 0, false);
    
    if (is_array($members) && count($members)) {
      foreach ($members as $member) {
        add_user_to_access_collection($member->guid, $group_acl);
      }
    }
  }
}