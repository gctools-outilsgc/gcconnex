<?php


//http://gcconnex12.gc.ca/gcforums/save/gcforums/edit?__elgg_ts=1452790650&__elgg_token=aNWe4jtIMgI09YVfS8hdXA
$gcf_type = get_input('gcf_type');
error_log('TYPE:'.$gcf_type);

$gcf_forward_url = str_replace("amp;","",get_input('gcf_forward_url'));
error_log("FORWARD TO...".$gcf_forward_url);
$object = get_entity($gcf_guid);


// TODO: clean up functions
switch ($gcf_type) {
	case 'hjforumcategory':
		error_log("Edit Category");

		$title = get_input('gcf_title');
		$description = get_input('gcf_description');
		$access = get_input('gcf_access_id');
		// get the following hidden field inputs as well
		$gcf_guid = get_input('gcf_guid');
		$gcf_container = get_input('gcf_container');
		$gcf_type = get_input('gcf_type');

		$forum_object = get_entity($gcf_guid);
		$forum_object->title = $title;
		$forum_object->description = $description;
		$forum_object->access_id = $access;
		$forum_object->save();

		forward($gcf_forward_url);

		break;

	case 'hjforum':

		$title = get_input('gcf_title');
		$description = get_input('gcf_description');
		$access = get_input('gcf_access_id');
		$enable_categories = get_input('gcf_allow_categories');
		$enable_posting = get_input('gcf_allow_posting');
		// get the following hidden field inputs as well
		$gcf_guid = get_input('gcf_guid');
		$gcf_container = get_input('gcf_container');
		$gcf_type = get_input('gcf_type');

		// TODO: validate data (check for empty field)
		// TODO: if error forward back to form
		$forum_object = get_entity($gcf_guid);
		$forum_object->title = $title;
		$forum_object->description = $description;
		$forum_object->access_id;
		$forum_object->enable_subcategories = $enable_categories;
		$forum_object->enable_posting = $enable_posting;
		$forum_object->save();

		forward($gcf_forward_url);
		break;

	case 'hjforumtopic':
		error_log("Edit Topic");

		$title = get_input('gcf_title');
		$description = get_input('gcf_description');
		$access = get_input('gcf_access_id');
		// get the following hidden field inputs as well
		$gcf_guid = get_input('gcf_guid');
		$gcf_container = get_input('gcf_container');
		$gcf_type = get_input('gcf_type');

		$forum_object = get_entity($gcf_guid);
		$forum_object->title = $title;
		$forum_object->description = $description;
		$forum_object->access_id;
		$forum_object->save();

		forward($gcf_forward_url);
		break;

	case 'hjforumpost':
		error_log("Edit Post (Comments)");
		break;
	
	default:
		return false;
}


// TODO: move to lib folder

