<?php
/*
 * Exposes API endpoints for Blog entities
 */

elgg_ws_expose_function(
	"get.blogpost",
	"get_blogpost",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves a blog post & all replies based on user id and blog post id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.blogposts",
	"get_blogposts",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves blog posts & all replies based on user id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.blogpostsbyowner",
	"get_blogposts_by_owner",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en"),
		"target" => array('type' => 'string', 'required'=> false, 'default' => '')
	),
	'Retrieves blog posts & all replies based on user id',
	'POST',
	true,
	false
);

function get_blogpost($user, $guid, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	$entity = get_entity($guid);
	if (!isset($entity)) {
		return "Blog was not found. Please try a different GUID";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$blog_posts = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'blog',
		'guid' => $guid
	));
	$blog_post = json_decode($blog_posts)[0];

	$blog_post->title = gc_explode_translation($blog_post->title, $lang);
	$blog_post->description = gc_explode_translation($blog_post->description, $lang);

	$likes = elgg_get_annotations(array(
		'guid' => $blog_post->guid,
		'annotation_name' => 'likes'
	));
	$blog_post->likes = count($likes);

	$liked = elgg_get_annotations(array(
		'guid' => $blog_post->guid,
		'annotation_owner_guid' => $user_entity->guid,
		'annotation_name' => 'likes'
	));
	$blog_post->liked = count($liked) > 0;

	$blog_post->comments = get_entity_comments($blog_post->guid);

	$blog_post->userDetails = get_user_block($blog_post->owner_guid, $lang);

	$group = get_entity($blog_post->container_guid);
	$blog_post->group = gc_explode_translation($group->name, $lang);

	if (is_callable(array($group, 'getURL'))) {
		$blog_post->groupURL = $group->getURL();
	}

	return $blog_post;
}

function get_blogposts($user, $limit, $offset, $filters, $lang)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$filter_data = json_decode($filters);
	if (!empty($filter_data)) {
		$params = array(
			'type' => 'object',
			'subtype' => 'blog',
			'limit' => $limit,
			'offset' => $offset
		);

		if ($filter_data->name) {
			$db_prefix = elgg_get_config('dbprefix');
			$params['joins'] = array("JOIN {$db_prefix}objects_entity oe ON e.guid = oe.guid");
			$params['wheres'] = array("(oe.title LIKE '%" . $filter_data->name . "%' OR oe.description LIKE '%" . $filter_data->name . "%')");
		}

		$all_blog_posts = elgg_list_entities_from_metadata($params);
	} else {
		$all_blog_posts = elgg_list_entities(array(
			'type' => 'object',
			'subtype' => 'blog',
			'limit' => $limit,
			'offset' => $offset
		));
	}

	$blog_posts = json_decode($all_blog_posts);

	foreach ($blog_posts as $blog_post) {
		$blog_post->title = gc_explode_translation($blog_post->title, $lang);
		$blog_post->description = gc_explode_translation($blog_post->description, $lang);

		$likes = elgg_get_annotations(array(
			'guid' => $blog_post->guid,
			'annotation_name' => 'likes'
		));
		$blog_post->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $blog_post->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$blog_post->liked = count($liked) > 0;

		$blog_post->comments = get_entity_comments($blog_post->guid);

		$blog_post->userDetails = get_user_block($blog_post->owner_guid, $lang);

		$group = get_entity($blog_post->container_guid);
		$blog_post->group = gc_explode_translation($group->name, $lang);

		if (is_callable(array($group, 'getURL'))) {
			$blog_post->groupURL = $group->getURL();
		}
	}

	return $blog_posts;
}

function get_blogposts_by_owner($user, $limit, $offset, $lang, $target)
{
	$user_entity = is_numeric($user) ? get_user($user) : (strpos($user, '@') !== false ? get_user_by_email($user)[0] : get_user_by_username($user));
	if (!$user_entity) {
		return "User was not found. Please try a different GUID, username, or email address";
	}
	if (!$user_entity instanceof ElggUser) {
		return "Invalid user. Please try a different GUID, username, or email address";
	}

	$target_entity = $user_entity;
	if (!empty($target)){
		$target_entity =  is_numeric($target) ? get_user($target) : (strpos($target, '@') !== false ? get_user_by_email($target)[0] : get_user_by_username($target));
		if (!$target_entity) {
			return "Target user was not found. Please try a different GUID, username, or email address";
		}
		if (!$target_entity instanceof ElggUser) {
			return "Invalid target user. Please try a different GUID, username, or email address";
		}
	}

	if (!elgg_is_logged_in()) {
		login($user_entity);
	}

	$all_blog_posts = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'blog',
		'owner_guid' => $target_entity->guid,
		'limit' => $limit,
		'offset' => $offset
	));

	$blog_posts = json_decode($all_blog_posts);

	foreach ($blog_posts as $blog_post) {
		$blog_post->title = gc_explode_translation($blog_post->title, $lang);
		$blog_post->description = gc_explode_translation($blog_post->description, $lang);

		$likes = elgg_get_annotations(array(
			'guid' => $blog_post->guid,
			'annotation_name' => 'likes'
		));
		$blog_post->likes = count($likes);

		$liked = elgg_get_annotations(array(
			'guid' => $blog_post->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
		));
		$blog_post->liked = count($liked) > 0;

		$blog_post->comments = get_entity_comments($blog_post->guid);

		$blog_post->userDetails = get_user_block($blog_post->owner_guid, $lang);

		$group = get_entity($blog_post->container_guid);
		$blog_post->group = gc_explode_translation($group->name, $lang);

		if (is_callable(array($group, 'getURL'))) {
			$blog_post->groupURL = $group->getURL();
		}
	}

	return $blog_posts;
}
