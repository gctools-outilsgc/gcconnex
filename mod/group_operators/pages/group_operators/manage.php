<?php
/**
 * Manage group operators
 *
 * @package ElggGroupOperators
 */

elgg_load_library('elgg:group_operators');

$group_guid = (int) get_input('group_guid');
$group = new ElggGroup($group_guid);
if (!$group) {
	forward();
}
if (!$group->canEdit()) {
	forward($group->getURL());
}

group_gatekeeper();

elgg_set_page_owner_guid($group->guid);
elgg_set_context('groups');

elgg_push_breadcrumb(elgg_echo('group'), "groups/all");
elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb(elgg_echo("group_operators:operators"));

$title = sprintf(elgg_echo("group_operators:title"), $group->name);

$content = elgg_view_group_operators_list($group);

$form_vars = array();
$body_vars = group_operators_prepare_form_vars($group);

$content .= elgg_view_form('group_operators/add', $form_vars, $body_vars);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);