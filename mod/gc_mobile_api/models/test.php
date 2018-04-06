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
 		"title" => array('type' => 'string', 'required' => true),
		"excerpt" => array('type' =>'string', 'required' => false, 'default' => ''),
 		"body" => array('type' =>'string', 'required' => true),
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

      }
    }

  	return "end";
 }
