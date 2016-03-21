<?php

namespace AU\SubGroups;

// formats a replacement array of breadcrumbs
// note that the array is built backwards due to the recursive
// getting of parents
function breadcrumb_override($params) {
	switch ($params['segments'][0]) {
		case 'profile':
			$group = get_entity($params['segments'][1]);
			if (!$group) {
				return;
			}

			$breadcrumbs[] = array('title' => elgg_echo('groups'), 'link' => elgg_get_site_url() . 'groups/all');
			$parentcrumbs = parent_breadcrumbs($group, false);

			foreach ($parentcrumbs as $parentcrumb) {
				$breadcrumbs[] = $parentcrumb;
			}

			$breadcrumbs[] = array(
				'title' => $group->name,
				'link' => NULL
			);

			set_input('au_subgroups_breadcrumbs', $breadcrumbs);
			break;

		case 'edit':
			$group = get_entity($params['segments'][1]);
			if (!$group) {
				return;
			}

			$breadcrumbs[] = array('title' => elgg_echo('groups'), 'link' => elgg_get_site_url() . 'groups/all');
			$parentcrumbs = parent_breadcrumbs($group, false);

			foreach ($parentcrumbs as $parentcrumb) {
				$breadcrumbs[] = $parentcrumb;
			}
			$breadcrumbs[] = array('title' => $group->name, 'link' => $group->getURL());
			$breadcrumbs[] = array('title' => elgg_echo('groups:edit'), 'link' => NULL);

			set_input('au_subgroups_breadcrumbs', $breadcrumbs);
			break;
	}
}

/**
 * Clones the custom layout of a parent group, for a newly created subgroup
 * @param type $group
 * @param type $parent
 */
function clone_layout($group, $parent) {
	if (!elgg_is_active_plugin('group_custom_layout') || !group_custom_layout_allow($parent)) {
		return false;
	}

	// get the layout object for the parent
	if ($parent->countEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION) <= 0) {
		return false;
	}

	$parentlayout = $parent->getEntitiesFromRelationship(GROUP_CUSTOM_LAYOUT_RELATION);
	$parentlayout = $parentlayout[0];

	$layout = new \ElggObject();
	$layout->subtype = GROUP_CUSTOM_LAYOUT_SUBTYPE;
	$layout->owner_guid = $group->getGUID();
	$layout->container_guid = $group->getGUID();
	$layout->access_id = ACCESS_PUBLIC;

	$layout->save();

	// background image
	$layout->enable_background = $parentlayout->enable_background;
	$parentimg = elgg_get_config('dataroot') . 'group_custom_layout/backgrounds/' . $parent->getGUID() . '.jpg';
	$groupimg = elgg_get_config('dataroot') . 'group_custom_layout/backgrounds/' . $group->getGUID() . '.jpg';
	if (file_exists($parentimg)) {
		copy($parentimg, $groupimg);
	}

	$layout->enable_colors = $parentlayout->enable_colors;
	$layout->background_color = $parentlayout->background_color;
	$layout->border_color = $parentlayout->border_color;
	$layout->title_color = $parentlayout->title_color;
	$group->addRelationship($layout->getGUID(), GROUP_CUSTOM_LAYOUT_RELATION);
}


/**
 * recursively travels down all routes to gather all guids of
 * groups that are children of the supplied group
 * 
 * @param type $group
 * @param type $guids
 * @return type
 */
function get_all_children_guids($group, $guids = array()) {
	// get children and delete them
	$children = get_subgroups($group, 0);

	if (!$children) {
		return $guids;
	}

	foreach ($children as $child) {
		$guids[] = $child->guid;
	}

	foreach ($children as $child) {
		$guids = get_all_children_guids($child, $guids);
	}

	return $guids;
}


/**
 * Determines if a group is a subgroup of another group
 * 
 * @param type $group
 * return ElggGroup | false
 */
function get_parent_group($group) {
	if (!elgg_instanceof($group, 'group')) {
		return false;
	}

	$parent = elgg_get_entities_from_relationship(array(
		'types' => array('group'),
		'limit' => 1,
		'relationship' => AU_SUBGROUPS_RELATIONSHIP,
		'relationship_guid' => $group->guid,
	));

	if (is_array($parent)) {
		return $parent[0];
	}

	return false;
}

function get_subgroups($group, $limit = 10, $sortbytitle = true) {
	$options = array(
		'types' => array('group'),
		'relationship' => AU_SUBGROUPS_RELATIONSHIP,
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'limit' => $limit,
	);

	if ($sortbytitle) {
		$options['joins'] = array("JOIN " . elgg_get_config('dbprefix') . "groups_entity g ON e.guid = g.guid");
		$options['order_by'] = "g.name ASC";
	}

	return elgg_get_entities_from_relationship($options);
}

function list_subgroups($group, $limit = 10) {
	$options = array(
		'types' => array('group'),
		'relationship' => AU_SUBGROUPS_RELATIONSHIP,
		'relationship_guid' => $group->guid,
		'inverse_relationship' => true,
		'joins' => array("JOIN " . elgg_get_config('dbprefix') . "groups_entity g ON e.guid = g.guid"),
		'order_by' => "g.name ASC",
		'limit' => $limit,
		'full_view' => false
	);

	return elgg_list_entities_from_relationship($options);
}


/**
 * Sets breadcrumbs from 'All groups' to current parent
 * iterating through all parent groups
 * @param type $group
 */
function parent_breadcrumbs($group, $push = true) {
	$parents = array();

	while ($parent = get_parent_group($group)) {
		$parents[] = array('title' => $parent->name, 'link' => $parent->getURL());
		$group = $parent;
	}

	$parents = array_reverse($parents);

	if ($push) {
		elgg_push_breadcrumb(elgg_echo('groups'), elgg_get_site_url() . 'groups/all');
		foreach ($parents as $breadcrumb) {
			elgg_push_breadcrumb($breadcrumb['title'], $breadcrumb['link']);
		}
	} else {
		return $parents;
	}
}

// links the subgroup with the parent group
function set_parent_group($group_guid, $parent_guid) {
	add_entity_relationship($group_guid, AU_SUBGROUPS_RELATIONSHIP, $parent_guid);
}

function remove_parent_group($group_guid) {
	$group = get_entity($group_guid);

	$parent = get_parent_group($group);

	if ($parent) {
		remove_entity_relationship($group_guid, AU_SUBGROUPS_RELATIONSHIP, $parent->guid);
	}
}

// can a user edit the group and it's parent, recursively up to the top level parent?
function can_edit_recursive($group, $user = NULL) {
	if (!elgg_instanceof($user, 'user')) {
		$user = elgg_get_logged_in_user_entity();
	}

	if (!$user) {
		return false;
	}

	$full_perms = true;
	$tmp_subgroup = $group;
	while ($tmp_parent = get_parent_group($tmp_subgroup)) {
		if (!$tmp_parent->canEdit() || !$tmp_subgroup->canEdit()) {
			$full_perms = false;
			break;
		}

		$tmp_subgroup = $tmp_parent;
	}

	return $full_perms;
}

function join_parents_recursive($group, $user = NULL) {
	if (!elgg_instanceof($user, 'user')) {
		$user = elgg_get_logged_in_user_entity();
	}

	if (!$user) {
		return false;
	}

	while ($parent = get_parent_group($group)) {
		if (!$parent->isMember($user)) {
			$parent->join($user);
		}

		$group = $parent;
	}

	return true;
}

/**
 * Determines if a subgroup could potentially be moved
 * To a parent group
 * Makes sure permissions are in order, and that the subgroup isn't already a parent
 * of the parent or anything weird like that
 * 
 * @param type $user ElggUser
 * @param type $subgroup_guid
 * @param type $parentgroup_guid
 */
function can_move_subgroup($subgroup, $parent, $user = NULL) {
	if (!elgg_instanceof($user, 'user')) {
		$user = elgg_get_logged_in_user_entity();
	}

	if (!$user) {
		return false;
	}

	// make sure they're really groups
	if (!elgg_instanceof($subgroup, 'group') || !elgg_instanceof($parent, 'group')) {
		return false;
	}

	// make sure we can edit them
	if (!$subgroup->canEdit($user->guid) || !$parent->canEdit($user->guid)) {
		return false;
	}

	// make sure we can edit all the way up, and we're not trying to move a group into itself
	if (!can_edit_recursive($subgroup) || $subgroup->guid == $parent->guid) {
		return false;
	}

	// make sure we're not moving a group into it's existing parent
	$current_parent = get_parent_group($subgroup);
	if ($current_parent && $current_parent->guid == $parent->guid) {
		return false;
	}

	// also make sure the potential parent isn't a subgroup of the subgroup
	$children = get_all_children_guids($subgroup);
	if (in_array($parent->guid, $children)) {
		return false;
	}

	return true;
}
