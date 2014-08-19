<?php
/**
* Idea save action
*
* @package ideas
*/

gatekeeper();
group_gatekeeper();

elgg_make_sticky_form('ideas_settings');
$description = get_input('ideas_description', '');
$question = get_input('ideas_question', elgg_echo('ideas:search'));
$group_guid = (int)get_input('guid', elgg_get_page_owner_guid());
$user_guid = elgg_get_logged_in_user_guid();

if (!$group_guid || !$user_guid ) {
	register_error(elgg_echo('ideas:group:settings:failed'));
	forward(REFERER);
}

$group = get_entity($group_guid);

if (!$group->canEdit()) {
	register_error(elgg_echo('ideas:group:settings:failed'));
	forward(REFERER);
}

$group->ideas_description = $description;
$group->ideas_question = $question;

if ($group->save()) {

	elgg_clear_sticky_form('ideas_settings');

	system_message(elgg_echo('ideas:group:settings:save:success'));

	forward("ideas/group/$group_guid/top");
} else {
	register_error(elgg_echo('ideas:group:settings:failed'));
	forward(REFERER);
}
