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
		$filed_in_category = get_input('ddCategoryFiling');

		$entity->enable_subcategories = $enable_category[0];
		$entity->enable_posting = $enable_posting[0];
		$entity->save();

		$query = "SELECT * FROM {$dbprefix}entity_relationships	WHERE relationship = 'filed_in' AND guid_one = {$entity->getGUID()}";
		$filed_in = get_data($query);

		delete_relationship($filed_in[0]->id);
		add_entity_relationship($entity->getGUID(), 'filed_in', $filed_in_category);

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

system_message(elgg_echo("gcforums:saved:success", array($entity->title)));
// TODO: fix this
if ($subtype === 'hjforumpost') {
	forward("{$site}gcforums/topics/view/{$entity->getContainerGUID()}");
} else {
	forward("{$site}gcforums/view/{$entity->getContainerGUID()}");
}
