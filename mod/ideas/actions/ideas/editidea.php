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
$title2 = strip_tags(get_input('title2'));
if (!$title) $title = $idea->title;
if (!$title2) $title2 = $idea->title2;
$description = $description1 = get_input('description');
$description2 = get_input('description2');
$tags = get_input('tags');

$user_guid = elgg_get_logged_in_user_guid();

if ((!$title || !$description) && (!$title2 || !$description2)) {
	register_error(elgg_echo('ideas:idea:save:empty'));
	forward(REFERER);
}

if($description && $description2){
	$description = $description .'->'. $description2;
}else if (!$description && $description2){
	$description = $description2;
}

$idea->title = $title;
$idea->title2 = $title2;
$idea->description = $description;
$idea->description1 = $description1;
$idea->description2 = $description2;
$idea->description3 = gc_implode_translation($description1, $description2);
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
