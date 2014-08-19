<?php
/**
 * Group blog module
 */

$group = elgg_get_page_owner_entity();

if ($group->subgroups_enable == "no") {
	return true;
}

$all_link = '';

if ($group->canEdit()) {
  $all_link = elgg_view('output/url', array(
    'href' => "groups/subgroups/{$group->guid}/all",
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
  ));
}

elgg_push_context('widgets');
$content = au_subgroups_list_subgroups($group, 10);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('au_subgroups:nogroups') . '</p>';
}

if ($group->canEdit()) {
  $new_link = elgg_view('output/url', array(
    'href' => "groups/subgroups/add/$group->guid",
    'text' => elgg_echo('au_subgroups:add:subgroup'),
    'is_trusted' => true,
  ));
}
else {
  $new_link = '';
}

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('au_subgroups'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
