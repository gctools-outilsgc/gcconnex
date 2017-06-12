<?php

$gcf_type = get_input('gcf_type');
$gcf_forward_url = str_replace("amp;","",get_input('gcf_forward_url'));
$object = get_entity($gcf_guid);
$gcf_group = get_input('gcf_group');
$dbprefix = elgg_get_config('dbprefix');

switch ($gcf_type) {
	case 'hjforumcategory':

		$title = get_input('gcf_title');
		$description = get_input('gcf_description');

		if (!$description) {
			register_error(elgg_echo('gcforums:missing_description'));
			return false;
		}


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

		if (!$description) {
			register_error(elgg_echo('gcforums:missing_description'));
			return false;
		}

		$access = get_input('gcf_access_id');
		$enable_categories = get_input('gcf_allow_categories');
		$enable_posting = get_input('gcf_allow_posting');
		// get the following hidden field inputs as well
		$gcf_guid = get_input('gcf_guid');
		$gcf_container = get_input('gcf_container');
		$gcf_type = get_input('gcf_type');

		$gcf_file_in_category = get_input('gcf_file_in_category');	// TODO: file under a category if required

		// TODO: validate data (check for empty field)
		// TODO: if error forward back to form
		$forum_object = get_entity($gcf_guid);
		$forum_object->title = $title;
		$forum_object->description = $description;
		$forum_object->access_id = $access;
		$forum_object->enable_subcategories = $enable_categories;
		$forum_object->enable_posting = $enable_posting;

		$query = "SELECT * FROM {$dbprefix}entity_relationships	WHERE relationship = 'filed_in' AND guid_one = {$gcf_guid}";

		$filed_in = get_data($query);
		

		if (delete_relationship($filed_in[0]->id))
			add_entity_relationship($gcf_guid, 'filed_in', $gcf_file_in_category);

		// TODO: categories change
		$forum_object->save();

		forward($gcf_forward_url);
		break;
	case 'hjforumtopic':

		$title = get_input('gcf_title');
		$description = get_input('gcf_description');

		if (!$description) {
			register_error(elgg_echo('gcforums:missing_description'));
			return false;
		}

		$access = get_input('gcf_access_id');
		// get the following hidden field inputs as well
		$gcf_guid = get_input('gcf_guid');
		$gcf_container = get_input('gcf_container');
		$gcf_type = get_input('gcf_type');
		$gcf_sticky = get_input('gcf_sticky');

		$forum_object = get_entity($gcf_guid);
		$forum_object->title = $title;
		$forum_object->description = $description;
		$forum_object->access_id = $access;
		$forum_object->sticky = $gcf_sticky;
		$forum_object->save();

		forward($gcf_forward_url);
		break;
	case 'hjforumpost':

		$gcf_guid = get_input('gcf_guid');
		$post_object = get_entity($gcf_guid);
		$description = get_input('gcf_description');

		if (!$description) {
			register_error(elgg_echo('gcforums:missing_description'));
			return false;
		}

		$post_object->description = $description;
		$post_object->save();
		forward($gcf_forward_url);

		break;
	default:
		return false;
}