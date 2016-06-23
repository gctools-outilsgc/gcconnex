<?php
/**
 * Elgg add a collection of friends
 *
 * @package Elgg.Core
 * @subpackage Social.Collections
 */

// You need to be logged in for this one
elgg_gatekeeper();

//get which collection we are using
$collection = (int) get_input("collection");

//add page menu items back for edit page
//friends
$params = array(
			'name' => 'friends',
			'text' => elgg_echo('friends'),
			'href' => 'friends/' . elgg_get_logged_in_user_entity()->username,
			'contexts' => array('friends')
		);
elgg_register_menu_item('page', $params);
//friend circles
elgg_register_menu_item('page', array(
			'name' => 'friends:view:collections',
			'text' => elgg_echo('friends:collections'),
			'href' => "collections/owner/" . elgg_get_logged_in_user_entity()->username,
			'contexts' => array('friends')
		));
//friend request
$menu_item = array(
    "name" => "friend_request",
    "text" => elgg_echo("friend_request:menu") . $extra,
    "href" => "friend_request/" . $page_owner->username,
    "contexts" => array("friends", "friendsof", "collections")
);
elgg_register_menu_item("page", $menu_item);


$title = elgg_echo('friends:collections:edit');

elgg_set_context('friends');

$content = elgg_view_form('friends/collections/edit', array(), array(
	'friends' => elgg_get_logged_in_user_entity()->getFriends(array('limit' => 0)),
    'collection' => get_access_collection($collection),
));

$body = elgg_view_layout('one_sidebar', array(
	'title' => $title,
	'content' => $content
));

echo elgg_view_page($title, $body);