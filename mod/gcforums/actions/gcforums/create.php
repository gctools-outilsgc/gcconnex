<?php

$gcf_subtype = $vars['subtype'];
$gcf_container = $vars['container'];

$gcf_subtype = get_input('gcf_subtype');
//$gcf_group_guid = $vars['group_guid'];
//$gcf_container_guid = $vars[];

error_log("subtype: {$gcf_subtype}");


// TODO: make sure it is of relevant type
// TODO: temporarily highlight the thing you just created!
// TODO: build relationship through recursion

switch ($gcf_subtype) {
	case 'hjforumcategory':
		error_log("Create New Category");

		$gcf_guid = get_input('gcf_guid');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		//$gcf_class = get_subtype_class($gcf_type, $gcf_subtype);
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');

		
		$gcf_new_category = new ElggObject();
		$gcf_new_category->container_guid = $gcf_guid;
		$gcf_new_category->title = $gcf_title;
		$gcf_new_category->type = $gcf_type;
		$gcf_new_category->access_id = $gcf_access;
		$gcf_new_category->subtype = $gcf_subtype;
		$gcf_new_category->description = $gcf_description;
		$gcf_new_category->owner_guid = $gcf_owner;

		//$gcf_new_forum->save();

		error_log('---category-----------------');
		error_log('GUID: '.$gcf_guid);
		error_log('TITLE: '.$gcf_title);
		error_log('TYPE: '.$gcf_type);
		error_log('ACCESS: '.$gcf_access);
		error_log('SUBTYPE: '.$gcf_subtype);
		error_log('FORWARD: '.$gcf_forward_url);
		error_log('DESCRIPTION: '.$gcf_description);
		error_log('OWNER: '.$gcf_owner);
		error_log('--------------------');


	if ($new_guid = $gcf_new_category->save())
			system_message(elgg_echo("Entity entitled '{$gcf_new_category->title}' has been created successfully"));

		forward($gcf_forward_url);

		break;

	case 'hjforum':
		//error_log("Create New Forum");

		// TODO: may not need to pass owner

		$gcf_guid = get_input('gcf_guid');
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
		$gcf_new_forum->container_guid = $gcf_guid;
		$gcf_new_forum->title = $gcf_title;
		$gcf_new_forum->type = $gcf_type;
		$gcf_new_forum->access_id = $gcf_access;
		$gcf_new_forum->subtype = $gcf_subtype;
		$gcf_new_forum->description = $gcf_description;
		$gcf_new_forum->owner_guid = $gcf_owner;
		$gcf_new_forum->enable_subcategories = $gcf_enable_category;
		$gcf_new_forum->enable_posting = $gcf_enable_posting;

		// TODO: enable categories and posting

		if ($new_forum_guid = $gcf_new_forum->save()) {
			system_message(elgg_echo("Entity entitled '{$gcf_new_forum->title}' has been created successfully"));
		
			if ($gcf_file_in_category)
				add_entity_relationship($new_forum_guid, 'filed_in', $gcf_file_in_category);
			else 
				add_entity_relationship($new_forum_guid, 'descendant', $gcf_guid);
		} else
			system_message("Unable to create Forum");
		// TODO: will need to update relationship table


		forward($gcf_forward_url);

		break;

	case 'hjforumtopic':
		//error_log("Create New Topic");

		$gcf_container_guid = get_input('gcf_guid');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');


		$gcf_new_topic = new ElggObject();
		$gcf_new_topic->container_guid = $gcf_container_guid;
		$gcf_new_topic->title = $gcf_title;
		$gcf_new_topic->type = $gcf_type;
		$gcf_new_topic->access_id = $gcf_access;
		$gcf_new_topic->subtype = $gcf_subtype;
		$gcf_new_topic->description = $gcf_description;
		$gcf_new_topic->owner_guid = $gcf_owner;


		if ($new_guid = $gcf_new_topic->save())
			system_message(elgg_echo("Entity entitled '{$gcf_new_topic->title}' has been created successfully"));
	
		add_entity_relationship($new_guid, 'descendant', $gcf_container_guid);


		create_hjforumtopic_relationships($new_guid, $new_guid);


		break;

	case 'hjforumpost':
		//error_log("Create New Post (Comments)");

		$gcf_guid = get_input('gcf_guid');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');

		$gcf_new_post = new ElggObject();
		$gcf_new_post->container_guid = $gcf_guid;
		$gcf_new_post->title = $gcf_title;
		$gcf_new_post->type = $gcf_type;
		$gcf_new_post->access_id = $gcf_access;
		$gcf_new_post->subtype = $gcf_subtype;
		$gcf_new_post->description = $gcf_description;
		$gcf_new_post->owner_guid = $gcf_owner;

		if ($gcf_new_post->save())
			system_message(elgg_echo("Entity entitled '{$gcf_new_post->title}' has been created successfully"));
	
		
		break;

	default:
		return false;
}


// TODO: move to lib directory
// new entity guid / container guid
function create_hjforumtopic_relationships($static_guid, $e_guid) {
	error_log("current parameter: {$e_guid} comparing with: {$static_guid}");
	$entity = get_entity($e_guid);

	if ($entity instanceof ElggGroup) { // stop recursion when we reach the main page for group forum..
		
		add_entity_relationship($static_guid, 'descendant', $e_guid);

		error_log("finished recursion @ $e_guid");
		return;
	} else {

		//error_log("current guid: {$e_guid}");
		if ($static_guid != $e_guid)
			add_entity_relationship($static_guid, 'descendant', $e_guid);
		create_hjforumtopic_relationships($static_guid, $entity->getContainerGUID());
	}
}
