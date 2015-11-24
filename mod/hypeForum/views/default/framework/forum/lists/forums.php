<?php

$list_id = elgg_extract('list_id', $vars, "forumlist");
$container_guids = elgg_extract('container_guids', $vars, ELGG_ENTITIES_ANY_VALUE);
$subtypes = elgg_extract('subtypes', $vars, array('hjforum', 'hjforumtopic'));

// get information of the group owner to restrict access to some functionality
$forum_guid = $container_guids[0];
$group = get_entity($forum_guid)->getContainerEntity();

// cyu - 01/22/2015: checks if it is a groups object
if ($group instanceof ElggGroup)
	$group_owner = $group->getContainerEntity();
$current_user = elgg_get_logged_in_user_entity();

$title = false;

$getter_options = array(
	'types' => 'object',
	'subtypes' => $subtypes,
	'container_guids' => $container_guids,
);

if (!get_input("__ord_$list_id")) {
	$getter_options = hj_framework_get_order_by_clause('forum.sticky', 'DESC', $getter_options);
}

$list_options = array(
	'list_type' => 'table',
	'list_class' => 'hj-forumlist',
	'list_view_options' => array(
		'table' => array(
			'head' => array(
				'forum' => array(
					'text' => elgg_echo('hj:forum:tablecol:forum'),
					'sortable' => true,
					'sort_key' => 'oe.title',
				),
				'topics' => ($container_subtype !== 'hjforum' || HYPEFORUM_SUBFORUMS) ? array(
					'text' => elgg_echo('hj:forum:tablecol:topics'),
					'sortable' => true,
					'sort_key' => 'forum.topics'
				) : NULL,
				'posts' => array(
					'text' => elgg_echo('hj:forum:tablecol:posts'),
					'sortable' => true,
					'sort_key' => 'forum.posts'
				),
				'last_post' => array(
					'text' => elgg_echo('hj:forum:tablecol:last_post'),
					'sortable' => true,
					'sort_key' => 'e.last_action'
				),
				'menu' => array(
					'text' => '',
					'sortable' => false
				),
			)
		)
	),
	'pagination' => true
);

// X cyu - 12/22/2014: only want group owner to have access to this menu, users only need to reply to topic
// cyu - 01/22/2014: pageowner returns bool, check if entity is a user
// cyu - 02/02/2015 modified: we want owner, group admin, admin and operator to manage forums

// cyu - must check if group is not null
if ($group->getOwnerEntity()->guid) {
	$group_owner_guid = $group->getOwnerEntity()->guid;
	$allow_group_access = false;

	// load the library so we can get a list of operators
	elgg_register_library('group_operator', elgg_get_plugins_path().'group_operators/lib/group_operators.php');
	elgg_load_library('group_operator');	// load the library so we can use the functions

	// get a list of group operators
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

	if (get_loggedin_user()->guid == $group_owner_guid)
		$allow_group_access = true;

	if (!$allow_group_access)
		unset($list_options['list_view_options']['table']['head']['menu']);
}

$viewer_options = array(
	'full_view' => true
);

$content .= hj_framework_view_list($list_id, $getter_options, $list_options, $viewer_options, 'elgg_get_entities');

echo elgg_view_module('forum-category', $title, $content);