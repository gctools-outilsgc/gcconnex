<?php

$gcf_container = $vars['container_guid'];
$gcf_subtype = get_input('gcf_subtype');
$gcf_group = get_input('gcf_group');

switch ($gcf_subtype) {
	case 'hjforumcategory':

		$gcf_container = get_input('gcf_container');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');

		$gcf_new_category = new ElggObject();
		$gcf_new_category->container_guid = $gcf_container;
		$gcf_new_category->title = $gcf_title;
		$gcf_new_category->type = $gcf_type;
		$gcf_new_category->access_id = $gcf_access;
		$gcf_new_category->subtype = $gcf_subtype;
		$gcf_new_category->description = $gcf_description;
		$gcf_new_category->owner_guid = $gcf_owner;

		if ($new_category_guid = $gcf_new_category->save())
			system_message(elgg_echo("Entity entitled '{$gcf_new_category->title}' has been created successfully"));

		add_entity_relationship($new_category_guid, 'descendant', $gcf_container);

		$forward_url = elgg_get_site_url()."gcforums/group/{$gcf_group}/{$gcf_container}";
		forward($forward_url);

		break;
	case 'hjforum':

		$gcf_container = get_input('gcf_container');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');
		$gcf_enable_category = get_input('gcf_allow_categories');
		$gcf_enable_posting = get_input('gcf_allow_posting');

		$gcf_file_in_category = get_input('gcf_file_in_category');	// TODO: file under a category if required

		$gcf_new_forum = new ElggObject();
		$gcf_new_forum->container_guid = $gcf_container;
		$gcf_new_forum->title = $gcf_title;
		$gcf_new_forum->type = $gcf_type;
		$gcf_new_forum->access_id = $gcf_access;
		$gcf_new_forum->subtype = $gcf_subtype;
		$gcf_new_forum->description = $gcf_description;
		$gcf_new_forum->owner_guid = $gcf_owner;
		$gcf_new_forum->enable_subcategories = $gcf_enable_category;
		$gcf_new_forum->enable_posting = $gcf_enable_posting;

		if ($new_forum_guid = $gcf_new_forum->save()) {
			//error_log("--> filed_in: {$new_forum_guid} / {$gcf_file_in_category}");
			add_entity_relationship($new_forum_guid, 'filed_in', $gcf_file_in_category);
			//error_log("--> descendant: {$new_forum_guid} / {$gcf_container}");
			add_entity_relationship($new_forum_guid, 'descendant', $gcf_container);
			system_message(elgg_echo("Entity entitled '{$gcf_new_forum->title}' has been created successfully"));
		} else
			system_message("Unable to create Forum");

		$forward_url = elgg_get_site_url()."gcforums/group/{$gcf_group}/{$gcf_container}";
		forward($forward_url);

		break;
	case 'hjforumtopic':

		$gcf_container = get_input('gcf_container');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');
		$gcf_sticky = get_input('gcf_sticky');

		$gcf_new_topic = new ElggObject();
		$gcf_new_topic->container_guid = $gcf_container;
		$gcf_new_topic->title = $gcf_title;
		$gcf_new_topic->type = $gcf_type;
		$gcf_new_topic->access_id = $gcf_access;
		$gcf_new_topic->subtype = $gcf_subtype;
		$gcf_new_topic->description = $gcf_description;
		$gcf_new_topic->owner_guid = $gcf_owner;
		$gcf_new_topic->sticky = $gcf_sticky;

		if ($new_guid = $gcf_new_topic->save())
			system_message(elgg_echo("Entity entitled '{$gcf_new_topic->title}' has been created successfully"));
	
		add_entity_relationship($new_guid, 'descendant', $gcf_container);

		create_hjforumtopic_relationships($new_guid, $new_guid);

		$forward_url = elgg_get_site_url()."gcforums/group/{$gcf_group}/{$new_guid}/hjforumtopic";
		
		gcforums_notify_subscribed_users($gcf_new_topic, $forward_url);

		//error_log("topic url: {$gcf_new_topic->getURL()}");
		forward($forward_url);

		break;
	case 'hjforumpost':

		$gcf_container = get_input('gcf_container');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');

		$gcf_new_post = new ElggObject();
		$gcf_new_post->container_guid = $gcf_container;
		$gcf_new_post->title = $gcf_title;
		$gcf_new_post->type = $gcf_type;
		$gcf_new_post->access_id = $gcf_access;
		$gcf_new_post->subtype = $gcf_subtype;
		$gcf_new_post->description = $gcf_description;
		$gcf_new_post->owner_guid = $gcf_owner;

		if ($new_guid = $gcf_new_post->save())
			system_message(elgg_echo("Entity entitled '{$gcf_new_post->title}' has been created successfully"));
	
		create_hjforumtopic_relationships($new_guid, $new_guid);
		$forward_url = elgg_get_site_url()."gcforums/group/{$gcf_group}/{$gcf_container}/hjforumtopic";

		gcforums_notify_subscribed_users($gcf_new_post, $forward_url);

		break;
	default:
		return false;
}


// TODO: move to lib directory
function gcforums_notify_subscribed_users($hjobject, $hjlink) {
	$hjobject_subtype = $hjobject->subtype;
	if ($hjobject->getSubtype() === 'hjforumpost')
		$hjobject_guid = $hjobject->getContainerGUID();
	else 
		$hjobject_guid = $hjobject->guid;

	error_log("subtype: $hjobject_subtype / guid: $hjobject_guid");
	$options = array(
		'type' => 'user',
		'relationship' => 'subscribed',
		'relationship_guid' => $hjobject_guid,
		'inverse_relationship' => true,
		'limit' => 0
	);
	$users = elgg_get_entities_from_relationship($options);

	// notify_user(to, from, subject, message)
	$subscribers = array();
	foreach ($users as $user) {
		error_log($user->email);
		$subscribers[] = (string)$user->guid;
	}

	$name = $hjobject->getOwnerEntity()->name;
	$content = $hjobject->description;
	$link = $hjlink;
	$topic_name = $hjobject->title;

	$from = elgg_get_site_entity()->guid;
	if ($hjobject_subtype === 'hjforumtopic') { // when a forum topic is made
		$subject = elgg_echo('gcforums:notification_subject_topic');
		$message = elgg_echo('gcforums:notification_body_topic', array($name, $topic_name, $content, $link));
	} else { // when a forum post is made
		$subject = elgg_echo('gcforums:notification_subject_post');
		$message = elgg_echo('gcforums:notification_body_post', array($name, $topic_name, $content, $link));
	}
	// $subject = "Hello!";
	// $message = "World :-)";

	notify_user($subscribers, $from, $subject, $message);
}

// new entity guid / container guid
function create_hjforumtopic_relationships($static_guid, $e_guid) {
	$entity = get_entity($e_guid);
	if ($entity instanceof ElggGroup) { // stop recursion when we reach the main page for group forum..
		if ($entity->guid != $static_guid) {
			add_entity_relationship($static_guid, 'descendant', $e_guid);
			return;
		}
	} else {

		if ($static_guid != $e_guid)
			add_entity_relationship($static_guid, 'descendant', $e_guid);
		create_hjforumtopic_relationships($static_guid, $entity->getContainerGUID());
	}
}
