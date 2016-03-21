<?php

namespace AU\SubGroups;

$subgroup_guid = get_input('subgroup_guid');
$parent_guid = get_input('parent_guid');

$subgroup = get_entity($subgroup_guid);
$parent = get_entity($parent_guid);

$oldparent = get_parent_group($subgroup);

$child_groups = get_all_children_guids($subgroup);

//sanity check
if (!elgg_instanceof($subgroup, 'group') || !elgg_instanceof($parent, 'group')) {
  register_error(elgg_echo('au_subgroups:error:invalid:group'));
  forward(REFERER);
}

// we need to have edit permissions all the way up
if (!can_move_subgroup($subgroup, $parent)) {
  register_error(elgg_echo('au_subgroups:error:permissions'));
  forward(REFERER);
}

// remove any existing parent relationships
remove_parent_group($subgroup->guid);

set_parent_group($subgroup->guid, $parent->guid);

// determine the access_id of the new group, must be equal or more restrictive than the parent
switch ($parent->access_id) {
  case ACCESS_PUBLIC:
	  // only need to check that subgroup wasn't to old parent only
	  if ($subgroup->access_id == $oldparent->group_acl) {
		$subgroup->access_id = $parent->group_acl;
	  }
	break;
  case ACCESS_LOGGED_IN:
	  // subgroup cannot be public
	  if ($subgroup->access_id == ACCESS_PUBLIC) {
		$subgroup->access_id = ACCESS_LOGGED_IN;
	  }
	  elseif ($subgroup->access_id == $oldparent->group_acl) {
		$subgroup->access_id = $parent->group_acl;
	  }
	break;
  case $parent->group_acl:
  default:
	  // if none of the above, then parent is visible to it's parent
	  // lets keep that model
	  //hidden group, make sure subgroup can only be seen by parent, or is hidden itself
	  if ($subgroup->access_id != $subgroup->group_acl) {
		$subgroup->access_id = $parent->group_acl;
	  }
	break;
}

$subgroup->save();

//now we need to make sure that all members of the new subgroup are
// members of the parent group

// get all members of the subgroup - any members of subgroups have to be in this anyway

$options = array(
	'relationship' => 'member',
	'relationship_guid' => $subgroup->guid,
	'inverse_relationship' => true,
	'type' => 'user',
	'limit' => false,
);

$batch = new \ElggBatch('elgg_get_entities_from_relationship', $options);

// array of user guids we need to invite back into the group
$invite = array();

foreach ($batch as $member) {
  if (!is_group_member($parent_guid, $member->guid)) {
	$invite[] = $member->guid;
	// the user isn't a member of the parent group
	// so we have to remove them from this subgroup, and all subgroups of this subgroup
	// and send them an invitation
	// we'll set a plugin setting on the user, which we'll monitor for when they accept the invitation
	$groups_left = array($subgroup_guid);
	
	foreach ($child_groups as $child_guid) {
	  if (is_group_member($child_guid, $member_guid)) {
		$groups_left[] = $child_guid;
	  }
	}
	
	leave_group($subgroup_guid, $member_guid);
	
	// now we need to set a plugin user setting for this user that we can monitor
	elgg_set_plugin_user_setting('invitation_' . $subgroup_guid, serialize($groups_left), $member_guid, PLUGIN_ID);
	
	// invite the user
	add_entity_relationship($subgroup_guid, 'invited', $member_guid);
	
	$user = get_user($member_guid);
	
	if ($user) {
	  // notify the user
	  $url = elgg_normalize_url("groups/invitations/$user->username");
	  notify_user(
			$member_guid,
			$subgroup->owner_guid,
			elgg_echo('groups:invite:subject', array($user->name, $subgroup->name)),
			elgg_echo('au_subgroups:invite:body', array(
				$user->name,
				$subgroup->name,
				$parent->name,
				$url,
			))
	  );
	}
  }
}

system_message(elgg_echo('au_subgroups:move:success'));
forward(REFERER);