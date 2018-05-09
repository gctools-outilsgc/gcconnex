<?php

gatekeeper();
$dbprefix = elgg_get_config('dbprefix');
$site = elgg_get_site_entity();
/// generic information
$title = get_input('txtTitle');
$description = get_input('txtDescription');
$access = get_input('ddAccess');
$container_guid = get_input('entity_guid');

$group_guid = get_input('group_guid');
$subtype = get_input('subtype');
$type = 'object';

switch ($subtype) {
	case 'hjforumcategory':
		$entity = new ElggObject();
		$entity->container_guid = $container_guid;
		$entity->title = $title;
		$entity->type = $type;
		$entity->access_id = $access;
		$entity->subtype = $subtype;
		$entity->description = $description;
		$entity_guid = $entity->save();
		add_entity_relationship($entity_guid, 'descendant', $container_guid);
		break;

	case 'hjforum':
		$category_filing = get_input('ddCategoryFiling');
		$enable_subcategories = get_input('chkEnableCategory');
		$enable_posting = get_input('chkEnablePost');

		$entity = new ElggObject();
		$entity->container_guid = $container_guid;
		$entity->title = $title;
		$entity->type = $type;
		$entity->access_id = $access;
		$entity->subtype = $subtype;
		$entity->description = $description;
		$entity->enable_subcategories = $enable_subcategories;
		$entity->enable_posting = $enable_posting;

		$entity_guid = $entity->save();

		add_entity_relationship($entity_guid, 'filed_in', $category_filing);
		add_entity_relationship($entity_guid, 'descendant', $container_guid);
		break;

	case 'hjforumtopic':
		// cyu - this is a hack job
		$old_access = elgg_get_ignore_access();
		elgg_set_ignore_access(true);

		$sticky = get_input('gcf_sticky');
		if (!$sticky[0]) {
			$sticky = 0;
		}

		$entity = new ElggObject();
		$entity->title = $title;
		$entity->type = $type;
		$entity->description = $description;
		$entity->subtype = $subtype;
		$entity->access_id = $access;
		$entity->container_guid = $container_guid;
		$entity->sticky = $sticky;
		$entity_guid = $entity->save();

		elgg_set_ignore_access($old_access);

		add_entity_relationship($entity_guid, 'descendant', $container_guid);
		gcforums_notify_subscribed_users($entity, "{$site->getURL()}gcforums/topic/view/{$entity->getGUID()}");
		create_hjforumtopic_relationships($entity_guid, $entity_guid);

		// cyu - auto subscribe when user create the topic
		if (elgg_is_active_plugin('cp_notifications')) {
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $entity_guid);
			add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $entity_guid);
		}

		elgg_create_river_item(array(
			'view' => 'river/object/hjforumtopic/create',
			'action_type' => 'create',
			'subject_guid' => $entity->getOwnerGUID(),
			'object_guid' => $entity->getGUID()
		));

		break;

	case 'hjforumpost':
		$old_access = elgg_get_ignore_access();
		elgg_set_ignore_access(true);

		$entity = new ElggObject();
		$entity->container_guid = $container_guid;
		$entity->title = $title;
		$entity->type = $type;
		$entity->access_id = $access;
		$entity->subtype = $subtype;
		$entity->description = $description;
		$entity_guid = $entity->save();

		elgg_set_ignore_access($old_access);

		create_hjforumtopic_relationships($entity_guid, $entity_guid);
		gcforums_notify_subscribed_users($entity, "{$site}gcforums/topic/view/{$entity->getContainerGUID()}");
		break;

	default:
		return false;
}
system_message(elgg_echo("gcforums:saved:success", array($entity->title)));


if ($subtype === 'hjforumpost') {
	forward("{$site}gcforums/topic/view/{$entity->getContainerGUID()}");
} else {
	forward("{$site}gcforums/view/{$entity->getContainerGUID()}");
}


// TODO: move to lib directory
function gcforums_notify_subscribed_users($hjobject, $hjlink)
{
	$hjobject_subtype = $hjobject->subtype;
	if ($hjobject->getSubtype() === 'hjforumpost') {
		$hjobject_guid = $hjobject->getContainerGUID();
	} else {
		$hjobject_guid = $hjobject->guid;
	}

	$notification_object_guid = $hjobject->getContainerGUID();

	if (elgg_is_active_plugin('cp_notifications')) {
		$relationship_string = 'cp_subscribed_to_email';
	} else {
		$relationship_string = 'subscribed';
	}

	$options = array(
		'type' => 'user',
		'relationship' => $relationship_string,
		'relationship_guid' => $notification_object_guid,
		'inverse_relationship' => true,
		'limit' => 0
	);
	$users = elgg_get_entities_from_relationship($options);

	$subscribers = array();
	foreach ($users as $user) {

		// do not self-notify
		if (strcmp($hjobject->getOwnerEntity()->username, $user->username) == 0) {
			continue;
		}

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

	// if cp notification plugin is active, use that for notifications
	if (elgg_is_active_plugin('cp_notifications')) {
		if (strcmp(trim($hjobject->getSubtype()), 'hjforumtopic') == 0) { // topic made

			$message = array(
				'cp_topic_author' => $hjobject->getOwnerEntity()->name,
				'cp_topic_author_username' => $hjobject->getOwnerEntity()->username,
				'cp_topic_description' => $hjobject->description,
				'cp_topic_url' => $hjlink,
				'cp_topic_title' => $hjobject->title,
				'cp_msg_type' => 'cp_hjtopic',
				'cp_subscribers' => $subscribers,
				'cp_topic' => $hjobject
			);
		} else { // post made
			$message = array(
				'cp_post' => $hjobject,
				'cp_topic_author' => $hjobject->getOwnerEntity()->name,
				'cp_topic_author_username' => $hjobject->getOwnerEntity()->username,
				'cp_topic_description' => $hjobject->description,
				'cp_topic_url' => $hjlink,
				'cp_topic_title' => $hjobject->getContainerEntity()->title,
				'cp_subscribers' => $subscribers,
				'cp_msg_type' => 'cp_hjpost',
			);
		}

		if (strcmp(trim($hjobject->getSubtype()), 'hjforumtopic') == 0 || strcmp(trim($hjobject->getSubtype()), 'hjforumpost') == 0) {
			$result = elgg_trigger_plugin_hook('cp_overwrite_notification', 'all', $message);
		}
	} else {
		notify_user($subscribers, $from, $subject, $message);
	}
}


// new entity guid / container guid
function create_hjforumtopic_relationships($static_guid, $e_guid)
{
	$entity = get_entity($e_guid);
	if ($entity instanceof ElggGroup) { // stop recursion when we reach the main page for group forum..
		if ($entity->guid != $static_guid) {
			add_entity_relationship($static_guid, 'descendant', $e_guid);
			return;
		}
	} else {
		if ($static_guid != $e_guid) {
			add_entity_relationship($static_guid, 'descendant', $e_guid);
		}

		create_hjforumtopic_relationships($static_guid, $entity->getContainerGUID());
	}
}
