<?php
/**
 *
 * Allow a user to provide a justification / reasoning for joining the group.
 *
 */

gatekeeper();

$guid = (int) get_input("group_guid");
elgg_set_page_owner_guid($guid);

$group = get_entity($guid);

$title = elgg_echo('groups:join:justification', array($group->name));

elgg_push_breadcrumb(elgg_echo('groups'), "groups/all");
elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_form('groups/join');

$params = array(
    'content' => $content,
    'title' => $title,
    'filter' => '',
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
