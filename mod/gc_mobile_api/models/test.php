<?php
/*
 * Exposes API endpoints for Blog entities
 */
// https://github.com/gctools-outilsgc/gcconnex/blob/master/mod/blog/actions/blog/save.php
// https://github.com/gctools-outilsgc/gcconnex/blob/master/mod/blog_tools/actions/blog/save.php

 elgg_ws_expose_function(
 	"post.blog",
 	"post_blog",
 	array(
 		"user" => array('type' => 'string', 'required' => true),
 		"title" => array('type' => 'string', 'required' => false, 'default' => ''),
		"excerpt" => array('type' =>'string', 'required' => false, 'default' => ''),
 		"body" => array('type' =>'string', 'required' => false, 'default' => ''),
		"container_guid" => array('type' =>'string', 'required' => false, 'default' => ''),
    "comments" => array('type' =>'int', 'required' => false, 'default' => 1),
    "access" => array('type' =>'int', 'required' => false, 'default' => 1),
    "status" => array('type' =>'int', 'required' => false, 'default' => 0),
 		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
 	),
 	'Posts a new blog post',
 	'POST',
 	true,
 	false
 );

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

		//check required fields being not empty
		if (($title == '' || $body == '')){ return "Missing required fields (title, or body)"; }


		//If no group container, use user guid.
		if ($container_guid==''){ $container_guid = $user_entity->guid; }

    return elgg_echo("test: pre blog creation");

		//Create blog
		$blog = new ElggBlog();
		$blog->subtype = 'blog';
    $blog->container_guid = $container_guid;
		$new_post = TRUE;



  	return elgg_echo("api up");
 }
