<?php
/**
* Idea save action
*
* @package ideas
*/

gatekeeper();

$page_owner = elgg_get_page_owner_entity();

// system_message("huzzah" . $page_owner->access_id);

elgg_make_sticky_form('idea');

$title = strip_tags(get_input('title'));
$description = get_input('description');
$tags = get_input('tags');
$guid = (int)get_input('guid');
$container_guid = (int)get_input('container_guid', elgg_get_page_owner_guid());

$owner = get_entity($container_guid);

$user_guid = elgg_get_logged_in_user_guid();

if (!$container_guid) {
	register_error(elgg_echo('ideas:idea:save:nogroup'));
	forward(elgg_get_site_url() . "ideas/all");
}

$container = get_entity($container_guid);

if (!$container || !$container->canWritetoContainer()) {
	register_error(elgg_echo('ideas:idea:save:nogroup'));
	forward(REFERER);
}

if (!$title || !$description ) {
	register_error(elgg_echo('ideas:idea:save:empty'));
	forward(REFERER);
}

if ($guid == 0) {
	$idea = new ElggObject;
	$idea->subtype = "idea";
	$idea->container_guid = $container_guid;
	$new = true;
} else {
	register_error(elgg_echo('ideas:idea:save:failed'));
	forward(REFERER);
}

$tagarray = string_to_tag_array($tags);

$idea->title = $title;
$idea->description = $description;
$idea->access_id = $owner->access_id;
$idea->tags = $tagarray;

if ($idea->save()) {

	elgg_clear_sticky_form('idea');

	system_message(elgg_echo('ideas:idea:save:success'));

	// if this is a New idea, automatically "like" by current user and add to river
	if ($new ) {
				
		$annotation = new ElggObject($idea->getGUID());
		if ( create_annotation($annotation->getGUID(), 'point', 1, 'integer', $user_guid, $annotation->getAccessID()) ) {
		} else {
			register_error(elgg_echo('ideas:idea:rate:error'));
		}
        
		// what is the river?
		add_to_river('river/object/ideas/create','create', $user_guid, $idea->getGUID());
	}

	forward($idea->getURL());
} else {
	register_error(elgg_echo('ideas:idea:save:failed'));
	forward(REFERER);
}
