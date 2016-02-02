<?php

//http://gcconnex12.gc.ca/gcforums/save/gcforums/save?gcf_action_type=category&__elgg_ts=1452790650&__elgg_token=aNWe4jtIMgI09YVfS8hdXA
$gcf_subtype = $vars['subtype'];
$gcf_container = $vars['container'];

$gcf_subtype = get_input('gcf_subtype');
//$gcf_group_guid = $vars['group_guid'];
//$gcf_container_guid = $vars[];

error_log('CREATE PHP CREATE PHP CREATE PHP CREATE PHP');
error_log("subtype: {$gcf_subtype}");


// TODO: make sure it is of relevant type

// TODO: temporarily highlight the thing you just created!

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

		
		$gcf_new_forum = new ElggObject();
		$gcf_new_forum->container_guid = $gcf_guid;
		$gcf_new_forum->title = $gcf_title;
		$gcf_new_forum->type = $gcf_type;
		$gcf_new_forum->access_id = $gcf_access;
		$gcf_new_forum->subtype = $gcf_subtype;
		$gcf_new_forum->description = $gcf_description;
		$gcf_new_forum->owner_guid = $gcf_owner;

		//$gcf_new_forum->save();

		error_log('GUID: '.$gcf_guid);
		error_log('TITLE: '.$gcf_title);
		error_log('TYPE: '.$gcf_type);
		error_log('ACCESS: '.$gcf_access);
		error_log('SUBTYPE: '.$gcf_subtype);
		error_log('FORWARD: '.$gcf_forward_url);
		error_log('DESCRIPTION: '.$gcf_description);
		error_log('OWNER: '.$gcf_owner);

		forward($gcf_forward_url);

		break;

	case 'hjforum':
		error_log("Create New Forum");

		// TODO: may not need to pass owner

		$gcf_guid = get_input('gcf_guid');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		//$gcf_class = get_subtype_class($gcf_type, $gcf_subtype);
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');
		$gcf_enable_category = get_input('gcf_allow_categories');
		$gcf_enable_posting = get_input('gcf_allow_posting');

		
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

		if ($gcf_new_forum->save())
			system_message(elgg_echo("Entity entitled '{$gcf_new_forum->title}' has been created successfully"));

		// TODO: will need to update relationship table
		add_entity_relationship($gcf_new_forum->getGUID(), 'descendant', $gcf_new_forum->getContainerGUID());

		/*

		error_log('GUID: '.$gcf_guid);
		error_log('TITLE: '.$gcf_title);
		error_log('TYPE: '.$gcf_type);
		error_log('ACCESS: '.$gcf_access);
		error_log('SUBTYPE: '.$gcf_subtype);
		error_log('FORWARD: '.$gcf_forward_url);
		error_log('DESCRIPTION: '.$gcf_description);
		error_log('OWNER: '.$gcf_owner);
		*/

		forward($gcf_forward_url);


		/*
"SELECT e.guid, oe.title, oe.description, r.relationship, r.guid_one, r.guid_two, e.subtype, e.container_guid
			FROM {$dbprefix}entity_subtypes es, {$dbprefix}entities e, {$dbprefix}entity_relationships r, {$dbprefix}objects_entity oe
			WHERE es.id = e.subtype
				AND oe.guid = e.guid
				AND r.guid_one = e.guid
				AND r.relationship = 'descendant'
				AND r.guid_two = $forum_guid
				AND es.subtype = 'hjforum';";*/
		break;

	case 'hjforumtopic':
		error_log("Create New Topic");
		break;

	case 'hjforumpost':
		error_log("Create New Post (Comments)");

		$gcf_guid = get_input('gcf_guid');
		$gcf_title = get_input('gcf_title');
		$gcf_type = get_input('gcf_type');
		$gcf_access = get_input('gcf_access');
		$gcf_subtype = get_input('gcf_subtype');
		$gcf_forward_url = get_input('gcf_forward_url');
		//$gcf_class = get_subtype_class($gcf_type, $gcf_subtype);
		$gcf_description = get_input('gcf_description');
		$gcf_owner = get_input('gcf_owner');


		error_log("TOPIC CREATE ------");
		error_log('GUID: '.$gcf_guid);
		error_log('TITLE: '.$gcf_title);
		error_log('TYPE: '.$gcf_type);
		error_log('ACCESS: '.$gcf_access);
		error_log('SUBTYPE: '.$gcf_subtype);
		error_log('FORWARD: '.$gcf_forward_url);
		error_log('DESCRIPTION: '.$gcf_description);
		error_log('OWNER: '.$gcf_owner);
		error_log("---------");

		$gcf_new_post = new ElggObject();
		$gcf_new_post->container_guid = $gcf_guid;
		$gcf_new_post->title = $gcf_title;
		$gcf_new_post->type = $gcf_type;
		$gcf_new_post->access_id = $gcf_access;
		$gcf_new_post->subtype = $gcf_subtype;
		$gcf_new_post->description = $gcf_description;
		$gcf_new_post->owner_guid = $gcf_owner;

		//if ($gcf_new_post->save())
			//system_message(elgg_echo("Entity entitled '{$gcf_new_post->title}' has been created successfully"));
	
		
		break;

	default:
		return false;
}