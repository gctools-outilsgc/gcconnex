<?php
/**
* Elgg reading list save action
*
* @package reading_list
*/
$guid = get_input('guid');

//Get details of the item to read 
if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'blog'))
	{
		// Todo - Check if already in the list
		$title = $entity->title;
		$description = $entity->description;
		$url = $entity->getURL();
		$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());
	}
	else{
		register_error(elgg_echo('reading_list:save:notsuportedentry'));
	}
}
else{
	register_error(elgg_echo('reading_list:save:missingid'));
}

$link = new ElggObject();
$link->subtype = 'readinglistitem';
$link->container_guid = (int)get_input('container_guid', elgg_get_logged_in_user_guid());
$link->title = $title;
$link->title2 = $title;
$link->title3 = $title;
$link->address = $url;
$link->description = $description;
$link->description2 = $description;
$link->description3 = $description;

$link_guid = $link->save();

if ($link_guid) {
   system_message(elgg_echo('reading_list:save:success'));
} else {
   register_error(elgg_echo('reading_list:save:failed'));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}
