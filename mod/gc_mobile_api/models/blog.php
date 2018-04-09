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

elgg_ws_expose_function(
 "get.blogpostsbycontainer",
 "get_blogposts_by_container",
 array(
	 "user" => array('type' => 'string', 'required' => true),
	 "guid" => array('type' => 'int', 'required' => true),
	 "limit" => array('type' => 'int', 'required' => false, 'default' => 10),
	 "offset" => array('type' => 'int', 'required' => false, 'default' => 0),
	 "lang" => array('type' => 'string', 'required' => false, 'default' => "en")
 ),
 'Retrieves a container\'s blogs based on user id and container guid. Used for groups, as a group\'s blogs have container_id of the group.',
 'POST',
 true,
 false
);

elgg_ws_expose_function(
 "post.blog",
 "post_blog",
 array(
	 "user" => array('type' => 'string', 'required' => true),
	 "title" => array('type' => 'string', 'required' => true),
	 "excerpt" => array('type' =>'string', 'required' => false, 'default' => ''),
	 "body" => array('type' =>'string', 'required' => true),
	 "container_guid" => array('type' =>'string', 'required' => false, 'default' => ''),
	 "comments" => array('type' =>'int', 'required' => false, 'default' => 1),
	 "access" => array('type' =>'int', 'required' => false, 'default' => 1),
	 "status" => array('type' =>'int', 'required' => false, 'default' => 0),
	 "lang" => array('type' => 'string', 'required' => false, 'default' => "en")
 ),
 'Posts/Saves a new blog post',
 'POST',
 true,
 false
);

function foreach_blogs($blogs, $user_entity, $lang)
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

	$blogs = foreach_blogs($blog_posts, $user_entity, $lang);

	return $blogs;
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

	$blogs = foreach_blogs($blog_posts, $user_entity, $lang);

	return $blogs;
}

function get_blogposts_by_container($user, $guid, $limit, $offset, $lang)
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

 $blogs_final = foreach_blogs($blog_posts, $user_entity, $lang);

 return $blogs_final;
}

function post_blog($user, $title, $excerpt, $body, $container_guid, $comments, $access, $status, $lang)
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
	 $error = FALSE;
	 //check required fields being not empty
	 $titles = json_decode($title);
	 $bodies = json_decode($body);
	 $excerpts = json_decode($excerpt);
	 //Check Required
	 if (!$titles->en && !$titles->fr) { return elgg_echo("blog:error:missing:title"); }
	 if (!$bodies->en && !$bodies->fr) { return elgg_echo("blog:error:missing:description");  }
	 if (!($titles->en && $bodies->en) && !($titles->fr && $bodies->fr)) { return "require-same-lang"; }
	 //Default any Missing or faulty
	 if (!$titles->en) { $titles->en = ''; }
	 if (!$titles->fr) { $titles->fr = ''; }
	 if (!$bodies->en) { $bodies->en = ''; }
	 if (!$bodies->fr) { $bodies->fr = ''; }
	 if (!$excerpts->en) { $excerpts->en = ''; }
	 if (!$excerpts->fr) { $excerpts->fr = ''; }
	 if ($comments != 0 && $comments != 1) { $comments = 1; }
	 if ($access != 0 && $access != 1 && $access != -2 ) { $access = 1; }
	 if ($status != 0 && $status != 1) { $status = 0; }

	 //If no group container, use user guid.
	 if ($container_guid==''){ $container_guid = $user_entity->guid; }

	 //Set int variables to correct
	 if ($status == 1) { $status = 'published'; } else { $status = 'draft'; }
	 if ($comments == 1) { $comments = 'On'; } else { $comments = 'Off'; }
	 if ($access == 1 ) { $access = ACCESS_PUBLIC; }
	 if ($status == 'draft') { $access = ACCESS_PRIVATE; }
	 $titles->en = htmlspecialchars($titles->en, ENT_QUOTES, 'UTF-8');
	 $titles->fr = htmlspecialchars($titles->fr, ENT_QUOTES, 'UTF-8');
	 $excerpts->en = elgg_get_excerpt($excerpts->en);
	 $excerpts->fr = elgg_get_excerpt($excerpts->fr);

	 $values = array(
		 'title' => JSON_encode($titles),
		 'title2' => '',
		 //'title3' => '',
		 'description' => JSON_encode($bodies),
		 'description2' => '',
		 'description3' => '',
		 'status' => $status,
		 'access_id' => $access,
		 'comments_on' => $comments,
		 'excerpt' => JSON_encode($excerpts),
		 'excerpt2' => '',
		 'excerpt3' => '',
		 'tags' => '',
		 'publication_date' => '',
		 'expiration_date' => '',
		 'show_owner' => 'no'
	 );

	 //return $values;
	 //return elgg_echo("test: pre blog creation");
	 //Create blog
	 $blog = new ElggBlog();
	 $blog->subtype = 'blog';
	 $blog->container_guid = $container_guid;
	 $new_post = TRUE;

	 $old_status = $blog->status;

	 // assign values to the entity, stopping on error.
	 if (!$error) {
		 foreach ($values as $name => $value) {
			 if (($name != 'title2') && ($name != 'description2') &&  ($name != 'excerpt2')){ // remove input 2 in metastring table
			 $blog->$name = $value;
			 }
		 }
	 }

	 if (!$error){
		 if ($blog->save()){

				 $icon_file = get_resized_image_from_uploaded_file("icon", 100, 100);
				 $icon_sizes = elgg_get_config("icon_sizes");

				 if (!empty($icon_file) && !empty($icon_sizes)) {
					 // create icon
					 $prefix = "blogs/" . $blog->getGUID();

					 $fh = new ElggFile();
					 $fh->owner_guid = $blog->getOwnerGUID();

					 foreach ($icon_sizes as $icon_name => $icon_info) {
						 $icon_file = get_resized_image_from_uploaded_file("icon", $icon_info["w"], $icon_info["h"], $icon_info["square"], $icon_info["upscale"]);
						 if (!empty($icon_file)) {
							 $fh->setFilename($prefix . $icon_name . ".jpg");

							 if ($fh->open("write")) {
								 $fh->write($icon_file);
								 $fh->close();
							 }
						 }
					 }

					 $blog->icontime = time();
			 }
			 // no longer a brand new post.
			 $blog->deleteMetadata('new_post');

			 $status = $blog->status;
				 // add to river if changing status or published, regardless of new post
				 // because we remove it for drafts.
				 if (($new_post || $old_status == 'draft' ||  $old_status == 'published') && $status == 'published') {
					 elgg_create_river_item(array(
						 'view' => 'river/object/blog/create',
						 'action_type' => 'create',
						 'subject_guid' => $blog->owner_guid,
						 'object_guid' => $blog->getGUID(),
					 ));
					 // we only want notifications sent when post published
					 elgg_trigger_event('publish', 'object', $blog);

					 // reset the creation time for posts that move from draft to published
					 if ($guid) {
						 $blog->time_created = time();
						 $blog->save();
					 }
				 } elseif ($old_status == 'published' && $status == 'draft') {
					 elgg_delete_river(array(
						 'object_guid' => $blog->guid,
						 'action_type' => 'create',
					 ));
				 }
				 if ($blog->status == 'published' || $save == false) {
					 return ($blog->getURL());
				 } else {
					 return ("blog/edit/$blog->guid");
				 }

		 } else {
			 return elgg_echo('blog:error:cannot_save');
		 }
	 }
}
