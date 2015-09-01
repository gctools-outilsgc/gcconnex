<?php

// Site menu
// elgg_register_menu_item('site', array(
// 	'name' => 'forum',
// 	'text' => elgg_echo('forums'),
// 	'href' => 'forum',
// ));

// cyu - 12/15/2014 : modified to put a menu item in the site navigation (JMP request)
elgg_register_menu_item('site', array(
	'name' => 'Forum',
	'text' => elgg_echo('forums:jmp_menu'),
	'href' => elgg_echo('forums:jmp_url'),
));

elgg_register_plugin_hook_handler('register', 'menu:entity', 'hj_forum_entity_menu');
elgg_register_plugin_hook_handler('register', 'menu:title', 'hj_forum_entity_title_menu');
elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'hj_forum_owner_block_menu');

/**
 * Forum menus
 */
function hj_forum_entity_menu($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, false);

	if (!elgg_instanceof($entity))
		return $return;

	switch ($entity->getSubtype()) {

		default :
			return $return;
			break;

			// this is the thing that creates the links in the far right column of the forum table
		case 'hjforum' :
			if (HYPEFORUM_SUBSCRIPTIONS && elgg_is_logged_in()) {
				$items['subscription'] = array(
					'text' => ($entity->isSubscribed()) ? elgg_echo('hj:forum:subscription:remove') : elgg_echo('hj:forum:subscription:create'),
					'href' => $entity->getSubscriptionURL(),
					'class' => 'elgg-button-forum-subscription',
					'priority' => 500
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforum') && HYPEFORUM_SUBFORUMS) {
				$items['create:subforum'] = array(
					'text' => elgg_echo('hj:forum:create:subforum'),
					'href' => "forum/create/forum/$entity->guid",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}


			if ($entity->canWriteToContainer(0, 'object', 'hjforumtopic')) {
				$items['create:topic'] = array(
					'text' => elgg_echo('hj:forum:create:topic'),
					'href' => "forum/create/topic/$entity->guid",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 855
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumcategory') && HYPEFORUM_CATEGORIES && $entity->enable_subcategories) {
				$items['create:category'] = array(
					'text' => elgg_echo('hj:forum:create:category'),
					'href' => "forum/create/category/$entity->guid",
					'class' => 'elgg-button-create-entity',
					'data-callback' => 'refresh:lists::framework',
					'data-toggle' => 'dialog',
					'priority' => 860
				);
			}

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'data-uid' => $entity->guid,
					'priority' => 995
				);
				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}
			break;

		case 'hjforumtopic' :
			if (HYPEFORUM_SUBSCRIPTIONS && elgg_is_logged_in()) {
				$items['subscription'] = array(
					'text' => ($entity->isSubscribed()) ? elgg_echo('hj:forum:subscription:remove') : elgg_echo('hj:forum:subscription:create'),
					'href' => $entity->getSubscriptionURL(),
					'class' => ($entity->isSubscribed()) ? 'elgg-button-forum-subscription elgg-state-active' : 'elgg-button-forum-subscription',
					'priority' => 500
				);
			}

			if (HYPEFORUM_BOOKMARKS && elgg_is_logged_in()) {
				$items['bookmark'] = array(
					'text' => ($entity->isBookmarked()) ? elgg_echo('hj:forum:bookmark:remove') : elgg_echo('hj:forum:bookmark:create'),
					'href' => $entity->getBookmarkURL(),
					'class' => ($entity->isBookmarked()) ? 'elgg-button-forum-bookmark elgg-state-active' : 'elgg-button-forum-bookmark',
					'priority' => 500
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumpost')) {
				$items['create:forumpost'] = array(
					'text' => elgg_echo('hj:forum:create:post'),
					'href' => "forum/create/post/$entity->guid#reply",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
				$items['create:forumpost:quote'] = array(
					'text' => elgg_echo('hj:forum:create:post:quote'),
					'href' => "forum/create/post/$entity->guid?quote=$entity->guid#reply",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}
			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'data-uid' => $entity->guid,
					'priority' => 995
				);
				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}
			break;


		case 'hjforumpost' :
			$topic = $entity->getContainerEntity();
			if ($topic->canWriteToContainer(0, 'object', 'hjforumpost')) {
				$items['create:forumpost:quote'] = array(
					'text' => elgg_echo('hj:forum:create:post:quote'),
					'href' => "forum/create/post/$topic->guid?quote=$entity->guid#reply",
					'class' => 'elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'data-uid' => $entity->guid,
					'priority' => 995
				);
				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}
			break;

		case 'hjforumcategory' :
			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'editedcategory::framework:forum',
					'data-uid' => $entity->guid,
					'priority' => 850
				);
				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}

			break;
	}

	if ($items) {
		foreach ($items as $name => $item) {
			foreach ($return as $key => $val) {
				if (!$val instanceof ElggMenuItem) {
					unset($return[$key]);
				}
				if ($val instanceof ElggMenuItem && $val->getName() == $name) {
					unset($return[$key]);
				}
			}
			$item['name'] = $name;
			$return[$name] = ElggMenuItem::factory($item);
		}
	}

	return $return;
}

function hj_forum_entity_title_menu($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params, false);

	if (!elgg_instanceof($entity))
		return $return;

	switch ($entity->getSubtype()) {

		case 'hjforum' :

			if (HYPEFORUM_SUBSCRIPTIONS) {
				$items['subscription'] = array(
					'text' => ($entity->isSubscribed()) ? elgg_echo('hj:forum:subscription:remove') : elgg_echo('hj:forum:subscription:create'),
					'href' => $entity->getSubscriptionURL(),
					'class' => ($entity->isSubscribed()) ? 'elgg-button elgg-button-action elgg-button-forum-subscription elgg-state-active' : 'elgg-button elgg-button-action elgg-button-forum-subscription',
					'priority' => 500
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforum') && HYPEFORUM_SUBFORUMS) {
				$items['create:subforum'] = array(
					'text' => elgg_echo('hj:forum:create:subforum'),
					'href' => "forum/create/forum/$entity->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}

			// cyu - 01/05/2015: allows moderators to allow/disallow topic posting on some levels of the forums
			if ($entity->canWriteToContainer(0, 'object', 'hjforumtopic') && $entity->enable_posting != 1) {
				$items['create:topic'] = array(
					'text' => elgg_echo('hj:forum:create:topic'),
					'href' => "forum/create/topic/$entity->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 855
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumcategory') && HYPEFORUM_CATEGORIES && $entity->enable_subcategories) {
				$items['create:category'] = array(
					'text' => elgg_echo('hj:forum:create:category'),
					'href' => "forum/create/category/$entity->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'priority' => 860
				);
			}

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button elgg-button-action elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-uid' => $entity->guid,
					'priority' => 995
				);

				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button elgg-button-delete elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}

			break;

		case 'hjforumtopic' :

			if (HYPEFORUM_SUBSCRIPTIONS && !$entity->getContainerEntity()->isSubscribed()) {
				$items['subscription'] = array(
					'text' => ($entity->isSubscribed()) ? elgg_echo('hj:forum:subscription:remove') : elgg_echo('hj:forum:subscription:create'),
					'href' => $entity->getSubscriptionURL(),
					'class' => ($entity->isSubscribed()) ? 'elgg-button-forum-subscription elgg-state-active' : 'elgg-button-forum-subscription',
					'priority' => 500
				);
			}

			if (HYPEFORUM_BOOKMARKS) {
				$items['bookmark'] = array(
					'text' => ($entity->isBookmarked()) ? elgg_echo('hj:forum:bookmark:remove') : elgg_echo('hj:forum:bookmark:create'),
					'href' => $entity->getBookmarkURL(),
					'class' => ($entity->isBookmarked()) ? 'elgg-button elgg-button-action elgg-button-forum-bookmark elgg-state-active' : 'elgg-button elgg-button-action elgg-button-forum-bookmark',
					'priority' => 500
				);
			}

			if ($entity->canWriteToContainer(0, 'object', 'hjforumpost')) {
				$items['create:forumpost'] = array(
					'text' => elgg_echo('hj:forum:create:post'),
					'href' => "forum/create/post/$entity->guid#reply",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
				$items['create:forumpost:quote'] = array(
					'text' => elgg_echo('hj:forum:create:post:quote'),
					'href' => "forum/create/post/$entity->guid?quote=$entity->guid#reply",
					'parent_name' => 'options',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 850
				);
			}

			if ($entity->canEdit()) {
				$items['edit'] = array(
					'text' => elgg_echo('edit'),
					'href' => $entity->getEditURL(),
					'class' => 'elgg-button elgg-button-action elgg-button-edit-entity',
					'data-toggle' => 'dialog',
					'data-uid' => $entity->guid,
					'priority' => 995
				);

				$items['delete'] = array(
					'text' => elgg_echo('delete'),
					'href' => $entity->getDeleteURL(),
					'class' => 'elgg-button elgg-button-delete elgg-button-delete-entity',
					'data-uid' => $entity->guid,
					'priority' => 1000
				);
			}
			break;
	}

	if ($items) {
		foreach ($items as $name => $item) {
			foreach ($return as $key => $val) {
				if (!$val instanceof ElggMenuItem) {
					unset($return[$key]);
				}
				if ($val instanceof ElggMenuItem && $val->getName() == $name) {
					unset($return[$key]);
				}
			}
			$item['name'] = $name;
			$return[$name] = ElggMenuItem::factory($item);
		}
	}

	return $return;
}

function hj_forum_register_dashboard_title_buttons($dashboard = 'site') {

	switch ($dashboard) {

		case 'site' :

			if (elgg_is_admin_logged_in()) {

				$site = elgg_get_site_entity();

				elgg_register_menu_item('title', array(
					'name' => 'create:forum',
					'text' => elgg_echo('hj:forum:create:forum'),
					'href' => "forum/create/forum/$site->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 100
				));

				if (HYPEFORUM_CATEGORIES_TOP) {
					elgg_register_menu_item('title', array(
						'name' => 'create:category',
						'text' => elgg_echo('hj:forum:create:category'),
						'href' => "forum/create/category/$site->guid",
						'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
						'data-callback' => 'newcategory::framework:forum',
						'data-toggle' => 'dialog',
						'priority' => 200
					));
				}
			}

			break;

		case 'group' :
			// X cyu - modified: purges the ability to create new forum (no button at the top)
			// cyu - 02/02/2015 modified: allow owners, (site/group) administrators and operators to create forums
			$group = elgg_get_page_owner_entity();
			$group_owner_guid = $group->getOwnerEntity()->guid;
			$allow_group_access = false;

			// we will need to check for operators as well, so we'll use the library functions from the group operators module
			elgg_register_library('group_operator', elgg_get_plugins_path().'group_operators/lib/group_operators.php');
			elgg_load_library('group_operator');	// load the library so we can use the functions

			// get the group of operators for this group
			$group_operator_list = get_group_operators($group);

			// check if user is a group operator
			foreach ($group_operator_list as $groupOperator_user)
				if ($groupOperator_user->guid == get_loggedin_user()->guid)
					$allow_group_access = true;

			// extract the list of group admins
			$group_admin_list = elgg_get_entities_from_relationship(array(
				"relationship" => "group_admin",
				"relationship_guid" => $group->guid,
				"inverse_relationship" => true,
				"type" => "user",
				"limit" => false,
				"wheres" => array("e.guid <> ".$group_owner_guid)
			));

			// check if user is a group administrator
			foreach ($group_admin_list as $group_admin_user)
				if ($group_admin_user->guid == get_loggedin_user()->guid)
					$allow_group_access = true;

			// check if user is a site administrator
			if (get_loggedin_user()) {
				if (get_loggedin_user()->isAdmin())
					$allow_group_access = true;
			}
			
			// check if user is the owner of the group
			if ($group_owner_guid == get_loggedin_user()->guid)
				$allow_group_access = true;

			//if ($group->canWriteToContainer()) {
			//if (get_loggedin_user()->guid == $group_owner->guid) {
			if ($allow_group_access) {
				elgg_register_menu_item('title', array(
					'name' => 'create:forum',
					'text' => elgg_echo('hj:forum:create:forum'),
					'href' => "forum/create/forum/$group->guid",
					'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
					'data-toggle' => 'dialog',
					'data-callback' => 'refresh:lists::framework',
					'priority' => 100
				));

				if (HYPEFORUM_CATEGORIES_TOP) {
					elgg_register_menu_item('title', array(
						'name' => 'create:category',
						'text' => elgg_echo('hj:forum:create:category'),
						'href' => "forum/create/category/$group->guid",
						'class' => 'elgg-button elgg-button-action elgg-button-create-entity',
						'data-callback' => 'newcategory::framework:forum',
						'data-toggle' => 'dialog',
						'priority' => 200
					));
				}
			}
			break;
	}
}

function hj_forum_owner_block_menu($hook, $type, $return, $params) {
	$entity = elgg_extract('entity', $params);

	if (HYPEFORUM_GROUP_FORUMS && elgg_instanceof($entity, 'group') && $entity->forums_enable !== 'no') {

		// cyu - 23/12/2014: fixed so that group forum does not appear in menus for existing groups..
		if (!$entity->forums_enable) {
			return $return;
		}

		$return[] = ElggMenuItem::factory(array(
					'name' => 'group:forums',
					'text' => elgg_echo('hj:forum:group'),
					'href' => "forum/group/$entity->guid"
				));
	}

	return $return;
}