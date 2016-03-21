<?php

namespace AU\SubGroups;

/*
 * Called when a group is attempting to be deleted
 * Check if there are subgroups and sort out what happens them and content
 */

function delete_group($hook, $type, $return, $params) {
	$guid = get_input('guid');
	if (!$guid) {
		$guid = get_input('group_guid');
	}

	$group = get_entity($guid);

	if (elgg_instanceof($group, 'group')) {
		// determine if the group has any child groups
		$child = get_subgroups($group, 1);
		$parent = get_parent_group($group);

		if ($child || $parent) {
			// here we are, we're deleting something with subgroups or a parent
			// if we've already sorted out what happens to content
			// we'll have a special input
			$content_policy = get_input('au_subgroups_content_policy', false);

			if (!$content_policy) {
				forward(elgg_get_site_url() . "groups/subgroups/delete/{$group->guid}");
			}

		}
	}
}

function group_canedit($hook, $type, $return, $params) {
	$group = $params['entity'];
	$user = $params['user'];

	$parent = get_parent_group($group);

	if ($parent) {
		if ($parent->canEdit($user->guid)) {
			return true;
		}
	}
}

/**
 * prevent users from being invited to subgroups they can't join
 */
function group_invite($hook, $type, $return, $params) {
	$user_guid = get_input('user_guid');
	$group_guid = get_input('group_guid');
	$group = get_entity($group_guid);

	$parent = get_parent_group($group);

	// if $parent, then this is a subgroup they're being invited to
	// make sure they're a member of the parent
	if ($parent) {
		if (!is_array($user_guid)) {
			$user_guid = array($user_guid);
		}

		$invalid_users = array();
		foreach ($user_guid as $guid) {
			$user = get_user($guid);
			if ($user && !$parent->isMember($user)) {
				$invalid_users[] = $user;
			}
		}

		if (count($invalid_users)) {
			$error_suffix = "<ul>";
			foreach ($invalid_users as $user) {
				$error_suffix .= "<li>{$user->name}</li>";
			}
			$error_suffix .= "</ul>";

			register_error(elgg_echo('au_subgroups:error:invite') . $error_suffix);
			return false;
		}
	}
}

/**
 * re/routes some urls that go through the groups handler
 */
function groups_router($hook, $type, $return, $params) {
	breadcrumb_override($return);

	// subgroup options
	if ($return['segments'][0] == 'subgroups') {
		elgg_load_library('elgg:groups');
		$group = get_entity($return['segments'][2]);
		if (!elgg_instanceof($group, 'group') || (($group->subgroups_enable == 'no') && ($return['segments'][1] != "delete"))) {
			return $return;
		}

		elgg_set_context('groups');
		elgg_set_page_owner_guid($group->guid);

		switch ($return['segments'][1]) {
			case 'add':
				$return = array(
					'identifier' => 'au_subgroups',
					'handler' => 'au_subgroups',
					'segments' => array(
						'add',
						$group->guid
					)
				);
				
				return $return;
				break;

			case 'delete':
				$return = array(
					'identifier' => 'au_subgroups',
					'handler' => 'au_subgroups',
					'segments' => array(
						'delete',
						$group->guid
					)
				);
				
				return $return;
				break;

			case 'list':
				$return = array(
					'identifier' => 'au_subgroups',
					'handler' => 'au_subgroups',
					'segments' => array(
						'list',
						$group->guid
					)
				);
				
				return $return;
				break;
		}
	}

	// need to redo closed/open tabs provided by group_tools - if it's installed
	if ($return['segments'][0] == 'all' && elgg_is_active_plugin('group_tools')) {
		$filter = get_input('filter', false);

		if (empty($filter) && ($default_filter = elgg_get_plugin_setting("group_listing", "group_tools"))) {
			$filter = $default_filter;
			set_input("filter", $default_filter);
		}

		if (in_array($filter, array("open", "closed", "alpha"))) {
			$return = array(
					'identifier' => 'au_subgroups',
					'handler' => 'au_subgroups',
					'segments' => array(
						'openclosed',
						$filter
					)
				);
				
			return $return;
		}
	}
}

function river_permissions($hook, $type, $return, $params) {
	$group = get_entity($return['object_guid']);

	$parent = get_parent_group($group);

	if ($parent) {
		// it is a group, and it has a parent
		$return['access_id'] = $group->access_id;
	}

	return $return;
}

function titlemenu($h, $t, $r, $p) {
	if (in_array(elgg_get_context(), array('group_profile', 'groups'))) {
		$group = elgg_get_page_owner_entity();

		// make sure we're dealing with a group
		if (!elgg_instanceof($group, 'group')) {
			return $r;
		}

		// make sure the group is a subgroup
		$parent = get_parent_group($group);
		if (!$parent) {
			return $r;
		}

		// see if we're a member of the parent group
		if ($parent->isMember()) {
			return $r;
		}

		$actions = array();
		$url = elgg_get_site_url() . "action/groups/join?group_guid={$parent->getGUID()}";
		$url = elgg_add_action_tokens_to_url($url);
		if ($parent->isPublicMembership() || $parent->canEdit()) {
			$actions[$url] = 'groups:join';
		} else {
			// request membership
			$actions[$url] = 'groups:joinrequest';
		}

		// we're not a member, so we need to remove any 'join'/'request membership' links
		foreach ($r as $key => $item) {
			if (in_array($item->getName(), array('groups:join', 'groups:joinrequest'))) {
				$r[$key]->setHref($url);
				$r[$key]->setText(elgg_echo('subgroups:parent:need_join'));
			}
		}

		return $r;
	}
}
