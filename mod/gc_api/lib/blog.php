<?php

elgg_ws_expose_function("get.blog","get_api_entity", array("id" => array('type' => 'integer')),
	'Takes a blog id and returns the Title, exerpt, and body of the blog',
               'GET', false, false);

function get_api_entity($id) {
	$entity = get_entity($id);
	if ($entity == null){
		return "No object was found with id ".$id;
	}
	
	if($entity->getAccessID()!= 2){
		return "Blog's access is not set to public, cannot display";
	}

	$subtype = $entity->getSubtype();
	
	/*
	* TODO:
	* - date and time stamp (date published, date updated?)
	* - User info (username, dispaly name, profile link, profile image url)
	* - link to post
	* - comments (count, user, date, profile link, profile image url, comment text)
	*
	*/

	switch ($subtype){
		case 'blog':
			$output = get_blog($entity);
			break;
		default:
			$output = "not a blog";
			break;

	}
	
	
    return $output;
}
function get_blog($entity){
	/*
	* TODO:
	*  *COMPLETE* - date and time stamp (date published, date updated?)
	* - User info (username, dispaly name, profile link, profile image url)
	*  *COMPLETE* - link to post
	* - comments (count, user, date, profile link, profile image url, comment text)
	*
	*/

	//get the blog's title
	$blog['title'] = $entity->title;

	//get the excerept of the blog
	$blog['excerept'] = $entity->excerpt;

	//get the blog body
	$blog['body'] = $entity->description;

	// get the time the entity was created
	$blog['publishDate'] = date("Y-m-d H:i:s",$entity->time_created);

	//get the time of the last update
	$blog['lastEdit'] = date("Y-m-d H:i:s",$entity->getTimeUpdated());

	//get user entity
	$blog['blogURL'] = $entity->getURL();

	//get userblock info 
	$blog['userBlock'] = get_userBlock($entity->getOwner());
 	
 	$comments = $entity->getAnnotations();
 	/*$i = 0;
 	foreach ($comments as $comms) {
 		if ($comms->name == 'generic_comment'){
 			$i++;
 		}
 	}*/
 	$blog['comments_blocks'] = get_comments($entity);
 	//return constructed blog api info
	return $blog;

}

function get_comments($entity){
	$annotations = $entity->getAnnotations();
	$comments['count'] = 0;
	foreach ($annotations as $comment){
		if ($comment->name == 'generic_comment'){
 			$comments['count']++;
 			$comments['comment_'.$comments['count']] = array('comment_user'=>get_userBlock($comment->getOwner()),'comment_text'=>$comment->value,'comment_date'=>date("Y-m-d H:i:s",$comment->time_created));
 		}
	}
	return $comments;
}

function get_userBlock($userid){

	//set GUID of the user
	$user['user_id'] = $userid;

	//get the user entity
	$user_entity = get_user($userid);

	//get and store username
	$user['username'] = $user_entity->username;

	//get and store user display name
	$user['dispalyName'] = $user_entity->name;

	//get and store URL for profile
	$user['profileURL'] = $user_entity->getURL();

	//get and store URL of profile avatar
	$user['iconURL'] = $user_entity->geticon();

	//get and store date user entity was created
	$user['dateJoined'] = date("Y-m-d H:i:s",$user_entity->time_created);
	
	//return user array
	return $user;
}