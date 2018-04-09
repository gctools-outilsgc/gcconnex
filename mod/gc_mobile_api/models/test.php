<?php
/*
 * Exposes API endpoints being tested
 */

 elgg_ws_expose_function(
 	"get.groupblogstest",
 	"get_group_blogstest",
 	array(
 		"user" => array('type' => 'string', 'required' => true),
 		"guid" => array('type' => 'int', 'required' => true),
 		"limit" => array('type' => 'int', 'required' => false, 'default' => 10),
 		"offset" => array('type' => 'int', 'required' => false, 'default' => 0),
 		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
 	),
 	'Retrieves a group\'s blogs based on user id and group id',
 	'POST',
 	true,
 	false
 );

 function foreach_blog($blogs, $user_entity, $lang)
 {
   foreach ($blogs as $blog_post) {
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
   return $blogs;
 }

 function get_group_blogstest($user, $guid, $limit, $offset, $lang)
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

 	$group = get_entity($guid);
 	if (!$group) {
 		return "Group was not found. Please try a different GUID";
 	}
 	if (!$group instanceof ElggGroup) {
 		return "Invalid group. Please try a different GUID";
 	}

 	$all_blog_posts = elgg_list_entities(array(
 		'type' => 'object',
 		'subtype' => 'blog',
 		'container_guid' => $guid,
 		'limit' => $limit,
 		'offset' => $offset,
 		'order_by' => 'e.last_action desc'
 	));

  $blog_posts = json_decode($all_blog_posts);

  $blogs_final = foreach_blog($blog_posts, $user_entity, $lang);

  return $blogs_final;
 }
