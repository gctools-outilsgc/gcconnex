<?php
elgg_push_context('group_profile');
$group = elgg_get_page_owner_entity();
elgg_entity_gatekeeper($group->guid, 'group');

$tab_menu = elgg_view('groups/profile/tab_menu');
$descript = elgg_view('groups/profile/fields', array('entity' => $group));
$content = elgg_view('groups/profile/widget_area', array('entity' => $group));

$title = 'ABOOT THIS GROUP';

$params = array(
  'content' => $tab_menu . $descript . $content,
  'sidebar' => $sidebar,
  'title' => $group->name,
);
$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($group->name, $body);