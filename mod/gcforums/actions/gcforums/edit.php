<?php

/*
 * GCFORUMS
 *
 *
 */

$dbprefix = elgg_get_config('dbprefix');

$entity_guid = get_input('entity_guid');
$entity = get_entity($entity_guid);

/// generic information
$title = get_input('txtTitle');
$description = get_input('txtDescription');
$access = get_input('ddAccess');


// TODO return system msg

$subtype = $entity->getSubtype();
switch ($subtype) {
	case 'hjforumcategory':
		$entity->title = $title;
		$entity->description = $description;
		$entity->access_id = $access;
		$entity->save();
		break;

	case 'hjforum':
		
		$entity->title = $title;
		$entity->description = $description;
		$entity->access_id = $access;

		$enable_category = get_input('chkEnableCategory');
		$enable_posting = get_input('chkEnablePost');

		$entity->enable_subcategories  = $enable_category[0];
		$entity->enable_posting = $enable_posting[0];
		$entity->save();

		/// TODO: check if parent forum has category

		/*
		$query = "SELECT * FROM {$dbprefix}entity_relationships	WHERE relationship = 'filed_in' AND guid_one = {$gcf_guid}";
		$filed_in = get_data($query);
		
		if (delete_relationship($filed_in[0]->id))
			add_entity_relationship($gcf_guid, 'filed_in', $gcf_file_in_category);
		*/
		break;


	case 'hjforumtopic':
		$entity->title = $title;
		$entity->description = $description;
		$entity->access_id = $access;

		// TODO: form for sticky
		$entity->sticky = 0;
		$entity->save();
		break;

	case 'hjforumpost':

		$entity->description = $description;
		$entity->save();
		break;

	default:
		return false;
}


// TODO: fix this
forward(get_input('hidden_forward_url'));



