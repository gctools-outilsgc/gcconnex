<?php

gatekeeper();
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

		forward($gcf_forward_url);
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

		$gcf_file_in_category = get_input('gcf_file_in_category');

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

			add_entity_relationship($new_forum_guid, 'filed_in', $gcf_file_in_category);
			add_entity_relationship($new_forum_guid, 'descendant', $gcf_container);
			system_message(elgg_echo("Entity entitled '{$gcf_new_forum->title}' has been created successfully"));
		} else
			system_message("Unable to create Forum");

		forward($gcf_forward_url.'/'.$new_forum_guid);

		break;
	case 'hjforumtopic':

		// cyu - this is a hack job
		$old_access = elgg_get_ignore_access();
		elgg_set_ignore_access(true);

		$gcf_container = get_input('gcf_container');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');
		$gcf_sticky = get_input('gcf_sticky');
		if (!$gcf_sticky) $gcf_sticky = 0;

		$gcf_new_topic = new ElggObject();
		$gcf_new_topic->title = trim($gcf_title);
		$gcf_new_topic->type = trim($gcf_type);
		$gcf_new_topic->description = $gcf_description;
		$gcf_new_topic->subtype = trim('hjforumtopic');
		$gcf_new_topic->access_id = $gcf_access;
		$gcf_new_topic->container_guid = $gcf_container;

		$the_guid = $gcf_new_topic->save();

		elgg_set_ignore_access($old_access);

		if ($the_guid) {
			$new_guid = $the_guid;

			system_message(elgg_echo("Entity entitled '{$gcf_new_topic->title}' has been created successfully"));

			add_entity_relationship($new_guid, 'descendant', $gcf_container);

			$forward_url = elgg_get_site_url()."gcforums/group/{$gcf_group}/{$new_guid}/hjforumtopic";

			gcforums_notify_subscribed_users($gcf_new_topic, $forward_url);
			create_hjforumtopic_relationships($new_guid, $new_guid);

			// cyu - auto subscribe when user create the topic
			if (elgg_is_active_plugin('cp_notifications')) {
				add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_email', $the_guid);
				add_entity_relationship(elgg_get_logged_in_user_guid(), 'cp_subscribed_to_site_mail', $the_guid);
			}

			forward($forward_url);
		} else
			system_message(elgg_echo("Entity entitled '{$gcf_new_topic->title}' has not been created successfully"));

		break;

	case 'hjforumpost':

		$old_access = elgg_get_ignore_access();
		elgg_set_ignore_access(true);

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

		elgg_set_ignore_access($old_access);

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

	// notify_user(to, from, subject, message)
	$subscribers = array();
	foreach ($users as $user) {
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

		if (trim($hjobject->getSubtype()) === 'hjforumtopic') { // topic made

			$message = array(
				'cp_topic_author' => $hjobject->getOwnerEntity()->name,
				'cp_topic_description' => $hjobject->description,
				'cp_topic_url' => $hjlink,
				'cp_topic_title' => $hjobject->title,
				'cp_msg_type' => 'cp_hjtopic',
				'cp_subscribers' => $subscribers,
			);
		} else { // post made
			$message = array(
				'cp_topic_author' => $hjobject->getOwnerEntity()->name,
				'cp_topic_description' => $hjobject->description,
				'cp_topic_url' => $hjlink,
				'cp_topic_title' => $hjobject->getContainerEntity()->title,
				'cp_subscribers' => $subscribers,
				'cp_msg_type' => 'cp_hjpost',
			);
		}

		$result = elgg_trigger_plugin_hook('cp_overwrite_notification','all',$message);
	} else
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
