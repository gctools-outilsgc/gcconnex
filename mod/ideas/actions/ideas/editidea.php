<?php
/**
* Idea save action
*
* @package ideas
*/

gatekeeper();

elgg_make_sticky_form('idea');

if (is_null( $guid = get_input('guid') )) {
	system_message(elgg_echo('ideas:idea:save:failed'));
	forward(REFERER);
} else {
	$idea = get_entity($guid);
    $container_guid = (int)get_input('container_guid', elgg_get_page_owner_guid());

    $owner = get_entity($container_guid);
}

$title = strip_tags(get_input('title'));
if (!$title) $title = $idea->title;
$description = get_input('description');
$tags = get_input('tags');

$user_guid = elgg_get_logged_in_user_guid();

if (!$title || !$description ) {
	register_error(elgg_echo('ideas:idea:save:empty'));
	forward(REFERER);
}

$idea->title = $title;
$idea->description = $description;
$idea->access_id =$owner->access_id;
$idea->tags = string_to_tag_array($tags);

if ($idea->save()) {

	add_to_river('river/object/ideas/update', 'update', $user_guid, $idea->getGUID());

	system_message(elgg_echo('ideas:idea:save:success'));

	elgg_clear_sticky_form('idea');
	forward($idea->getURL());

} else {
	register_error(elgg_echo('ideas:idea:save:failed'));
	forward(REFERER);
}
