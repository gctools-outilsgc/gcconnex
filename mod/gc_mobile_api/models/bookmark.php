<?php
/*
* Exposes API endpoints for Bookmark entities
*/
elgg_ws_expose_function(
	"get.bookmark",
	"get_bookmark",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"guid" => array('type' => 'int', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves an bookmark based on user id and bookmark id',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
    "get.bookmarks",
    "get_bookmarks",
    array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves bookmarks on GCcollab',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
	"get.bookmarkscolleague",
	"get_bookmarks_colleague",
	array(
		"user" => array('type' => 'string', 'required' => true),
		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
		"filters" => array('type' => 'string', 'required' => false, 'default' => ""),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Retrieves bookmarks posted by colleagues of a given user',
	'POST',
	true,
	false
);

elgg_ws_expose_function(
  "get.bookmarksbyuser",
  "get_bookmarks_by_owner",
  array(
    "user" => array('type' => 'string', 'required' => true),
    "limit" => array('type' => 'int', 'required' => false, 'default' => 10),
    "offset" => array('type' => 'int', 'required' => false, 'default' => 0),
    "filters" => array('type' => 'string', 'required' => false, 'default' => ""),
    "lang" => array('type' => 'string', 'required' => false, 'default' => "en"),
    "target" => array('type' => 'string', 'required' => false, 'default' => "")
  ),
  'Retrieves bookmarks posed by a user',
  'POST',
  true,
  false
);

function get_bookmark($user, $guid, $lang)
{
  // Check provided USER information.
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

  $entity = get_entity($guid);
  if (!$entity) {
    return "Event was not found. Please try a different GUID";
  }
  //check if entity is bookmark? subtype bookmarks

  $bookmark_ent = elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'bookmarks',
    'guid' => $guid
  ));
  $bookmarks = json_decode($bookmark_ent);

  foreach ($bookmarks as $bookmark) {
    $bookmark->title = gc_explode_translation($bookmark->title, $lang);

    $likes = elgg_get_annotations(array(
			'guid' => $bookmark->guid,
			'annotation_name' => 'likes'
		));
		$bookmark->likes = count($likes);
		$liked = elgg_get_annotations(array(
			'guid' => $bookmark->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
        ));
    $bookmark->liked = count($liked) > 0;

    $bookmarkObject = get_entity($bookmark->guid);
    $bookmark->description = gc_explode_translation($bookmarkObject->description, $lang);
    $bookmark->address = $bookmarkObject->address;

    $bookmark->userDetails = get_user_block($bookmark->owner_guid, $lang); //Should go through and only pass revelant infromation
    $bookmark->group_guid = "";
    if ($bookmark->container_guid != $bookmark->owner_guid){
      $bookmark->group_guid = $bookmark->container_guid;
      $bookmarkGroup = get_entity($bookmark->group_guid);
      $bookmark->group = gc_explode_translation($bookmarkGroup->name, $lang);
    }
  }
  return $bookmarks;
}//end get_bookmark

function get_bookmarks($user, $limit, $offset, $filters, $lang)
{
    // Check provided USER information.
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


  //Check FILTER information would go here
  $all_bookmarks = elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'bookmarks',
    'limit' => $limit,
    'offset' => $offset
  ));
  $bookmarks = json_decode($all_bookmarks);

  foreach ($bookmarks as $bookmark) {
    $bookmark->title = gc_explode_translation($bookmark->title, $lang);

    $likes = elgg_get_annotations(array(
			'guid' => $bookmark->guid,
			'annotation_name' => 'likes'
		));
		$bookmark->likes = count($likes);
		$liked = elgg_get_annotations(array(
			'guid' => $bookmark->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
        ));
    $bookmark->liked = count($liked) > 0;

    $bookmarkObject = get_entity($bookmark->guid);
    $bookmark->description = gc_explode_translation($bookmarkObject->description, $lang);
    $bookmark->address = $bookmarkObject->address;

    $bookmark->userDetails = get_user_block($bookmark->owner_guid, $lang); //Should go through and only pass revelant infromation
    $bookmark->group_guid = "";
    if ($bookmark->container_guid != $bookmark->owner_guid){
      $bookmark->group_guid = $bookmark->container_guid;
      $bookmarkGroup = get_entity($bookmark->group_guid);
      $bookmark->group = gc_explode_translation($bookmarkGroup->name, $lang);
    }
  }

  return $bookmarks;
}

function get_bookmarks_colleague($user, $limit, $offset, $filters, $lang)
{
  // Check provided USER information.
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

  $all_bookmarks = elgg_list_entities_from_relationship(array(
    'type' => 'object',
		'subtype' => 'bookmarks',
		'relationship' => 'friend',
		'relationship_guid' => $user_entity->guid,
		'relationship_join_on' => 'container_guid',
		'limit' => $limit,
		'offset' => $offset
  ));
  $bookmarks = json_decode($all_bookmarks);

  foreach ($bookmarks as $bookmark) {
    $bookmark->title = gc_explode_translation($bookmark->title, $lang);

    $likes = elgg_get_annotations(array(
			'guid' => $bookmark->guid,
			'annotation_name' => 'likes'
		));
		$bookmark->likes = count($likes);
		$liked = elgg_get_annotations(array(
			'guid' => $bookmark->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
        ));
    $bookmark->liked = count($liked) > 0;

    $bookmarkObject = get_entity($bookmark->guid);
    $bookmark->description = gc_explode_translation($bookmarkObject->description, $lang);
    $bookmark->address = $bookmarkObject->address;

    $bookmark->userDetails = get_user_block($bookmark->owner_guid, $lang); //Should go through and only pass revelant infromation
    $bookmark->group_guid = "";
    if ($bookmark->container_guid != $bookmark->owner_guid){
      $bookmark->group_guid = $bookmark->container_guid;
      $bookmarkGroup = get_entity($bookmark->group_guid);
      $bookmark->group = gc_explode_translation($bookmarkGroup->name, $lang);
    }
  }

  return $bookmarks;

}

function get_bookmarks_by_owner($user, $limit, $offset, $filters, $lang, $target)
{
  // Check provided USER information.
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
  $target_entity = $user_entity;
  if ($target != ''){
    $target_entity = get_entity($target);
  }

  //add conditional for target later
  $all_bookmarks = elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'bookmarks',
    'container_guid' => $target_entity->guid,
    'limit' => $limit,
    'offset' => $offset
  ));
  $bookmarks = json_decode($all_bookmarks);

  foreach ($bookmarks as $bookmark) {
    $bookmark->title = gc_explode_translation($bookmark->title, $lang);

    $likes = elgg_get_annotations(array(
			'guid' => $bookmark->guid,
			'annotation_name' => 'likes'
		));
		$bookmark->likes = count($likes);
		$liked = elgg_get_annotations(array(
			'guid' => $bookmark->guid,
			'annotation_owner_guid' => $user_entity->guid,
			'annotation_name' => 'likes'
        ));
    $bookmark->liked = count($liked) > 0;

    $bookmarkObject = get_entity($bookmark->guid);
    $bookmark->description = gc_explode_translation($bookmarkObject->description, $lang);
    $bookmark->address = $bookmarkObject->address;

    $bookmark->userDetails = get_user_block($bookmark->owner_guid, $lang); //Should go through and only pass revelant infromation
    $bookmark->group_guid = "";
    if ($bookmark->container_guid != $bookmark->owner_guid){
      $bookmark->group_guid = $bookmark->container_guid;
      $bookmarkGroup = get_entity($bookmark->group_guid);
      $bookmark->group = gc_explode_translation($bookmarkGroup->name, $lang);
    }
  }

  return $bookmarks;
}
