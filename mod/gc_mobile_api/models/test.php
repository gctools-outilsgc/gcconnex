<?php
/*
 * Exposes API endpoints for Blog entities
 */

 elgg_ws_expose_function(
  "post.discussion",
  "post_discussion",
  array(
 	 "user" => array('type' => 'string', 'required' => true),
 	 "title" => array('type' => 'string', 'required' => true),
 	 "message" => array('type' =>'string', 'required' => true),
 	 "container_guid" => array('type' =>'string', 'required' => false, 'default' => ''),
 	 "access" => array('type' =>'int', 'required' => false, 'default' => 2),
 	 "open" => array('type' =>'int', 'required' => false, 'default' => 1),
	 "topic_guid" => array('type' =>'int', 'required' => false, 'default' => 0),
 	 "lang" => array('type' => 'string', 'required' => false, 'default' => "en")
  ),
  'Posts/Saves a new discussion topic',
  'POST',
  true,
  false
 );

 function post_discussion($user, $title, $message, $container_guid, $access, $open, $topic_guid, $lang)
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

		 //check required fields
		 $titles = json_decode($title);
		 $message = json_decode($message);
		 if (!$titles->en && !$titles->fr) { return elgg_echo("discussion:error:missing"); }
		 if (!$message->en && !$message->fr) { return elgg_echo("discussion:error:missing");  }
		 if (!($titles->en && $message->en) && !($titles->fr && $message->fr)) { return "require-same-lang"; }

		 $container = get_entity($container_guid);
		 if (!$container || !$container->canWriteToContainer(0, 'object', 'groupforumtopic')) {
			 return elgg_echo('discussion:error:permissions');
		 }

		 //Check if new topic or edit
		 $new_topic = true;
		 if ($topic_guid > 0) {
		 	$new_topic = false;
		 }

		 if ($new_topic) {
			 $topic = new ElggObject();
			 $topic->subtype = 'groupforumtopic';
		 } else {
			 $topic = get_entity($guid);
			 if (!elgg_instanceof($topic, 'object', 'groupforumtopic') || !$topic->canEdit()) {
				 return elgg_echo('discussion:topic:notfound');
			 }
		 }

		 //french english setup
		 $title1 = htmlspecialchars($titles->en, ENT_QUOTES, 'UTF-8');
		 $title2 = htmlspecialchars($titles->fr, ENT_QUOTES, 'UTF-8');
		 $title =  gc_implode_translation($title1, $title2);
		 $desc = gc_implode_translation($message->en, $message->fr);

     if ($access == 1 && !$container->isPublicMembership()){
       $access = 2; //Access cannot be public if group is not public. Default to group only.
     }
		 $access_id = $access;
		 if ($access_id === 2){
			 $access_id = $container->group_acl; //Sets access id to match group only id.
		 }


		 $topic->title = $title;
		 $topic->title2 = $title2;
		 $topic->description = $desc;
		 $topic->description2 = $message->fr;
		 $topic->status = ($open == 1) ? "open" : "closed";
		 $topic->access_id = $access_id;
		 $topic->container_guid = $container_guid;

		 $result = $topic->save();
		 if (!$result) {
			 return elgg_echo('discussion:error:notsaved');
		 }

		 //handle results differently for new topics and topic edits
		 if ($new_topic) {
			 system_message(elgg_echo('discussion:topic:created'));
			 elgg_create_river_item(array(
				 'view' => 'river/object/groupforumtopic/create',
				 'action_type' => 'create',
				 'subject_guid' => elgg_get_logged_in_user_guid(),
				 'object_guid' => $topic->guid,
			 ));
		 } else {
			 system_message(elgg_echo('discussion:topic:updated'));
		 }

		 return $topic->getURL();
 }
