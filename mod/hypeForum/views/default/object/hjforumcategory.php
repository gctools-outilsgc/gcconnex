<?php

$entity = $category = elgg_extract('entity', $vars);
$title = $entity->getTitle();

// grabs the information of the group (where this forum is situated) and the current user
$container = $entity->getContainerEntity();
$current_user = get_loggedin_user();

if ($container->canEdit()) {
	$handle = elgg_view_icon('cursor-drag-arrow', 'hj-draggable-element-handle');
}

$params = array(
	'entity' => $entity,
	'class' => 'elgg-menu-hz elgg-menu-forum-category',
	'sort_by' => 'priority',
	'handler' => 'forumcategory',
	'dropdown' => false
);

$menu = elgg_view_menu('entity', $params);

$title = elgg_view_image_block($handle, $title, array(
	'image_alt' => $menu
		));

$content = elgg_view('framework/bootstrap/object/elements/description', $vars);

$list_id = "fc$category->guid";

$getter_options = array(
	'types' => 'object',
	'subtypes' => array('hjforum', 'hjforumtopic'),
	'relationship' => 'filed_in',
	'relationship_guid' => $category->guid,
	'inverse_relationship' => true,
);

if (!get_input("__ord_$list_id")) {
	$getter_options = hj_framework_get_order_by_clause('forum.sticky', 'DESC', $getter_options);
}

// this constructs the table that will list all the forums
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
				'topics' => array(
					'text' => elgg_echo('hj:forum:tablecol:topics'),
					'sortable' => true,
					'sort_key' => 'forum.topics'
				),
				'posts' => array(
					'text' => elgg_echo('hj:forum:tablecol:posts'),
					'sortable' => true,
					'sort_key' => 'forum.posts'
				),
				'last_post' => array(
					'text' => elgg_echo('hj:forum:tablecol:last_post'),
					'sortable' => true,
					'sort_key' => 'e.last_action',
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

// X cyu - 12/22/2014: we only want the group owner to be able to see the last column of the table so that
// cyu - 02/03/2015 modified: we want owner, group admin, admin and operator to see the last column of the table 
// normal users aren't allowed to create subforms of the existing forums
$group_ = $container;							// container is actually the group entity ($entity is the category)
$group_owner = $group_->getOwnerEntity();		// group owner
$group_owner_guid = $group_owner->guid;			// group owner guid
$current_user_guid = $current_user->guid;		// current user
$allow_group_access = false;

// we will need to check for operators as well, so we'll use the library functions from the group operators module
elgg_register_library('group_operator', elgg_get_plugins_path().'group_operators/lib/group_operators.php');
elgg_load_library('group_operator');	// load the library so we can use the functions

$group_operator_list = get_group_operators($group_);

// check if user is a group operator
foreach ($group_operator_list as $groupOperator_user)
	if ($groupOperator_user->guid == get_loggedin_user()->guid)
		$allow_group_access = true;

// extract the list of group admins
$group_admin_list = elgg_get_entities_from_relationship(array(
	"relationship" => "group_admin",
	"relationship_guid" => $group_->guid,
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

if (!$allow_group_access)
	unset($list_options['list_view_options']['table']['head']['menu']);


$viewer_options = array(
	'full_view' => true
);

$content .= hj_framework_view_list($list_id, $getter_options, $list_options, $viewer_options, 'elgg_get_entities_from_relationship');

$module = elgg_view_module('forum-category', $title, $content);

if ($entity->canEdit()) {
	$module = "<div id=\"uid-$entity->guid\"class=\"hj-draggable-element\" data-uid=\"$entity->guid\">$module</div>";
}

echo $module;