<?php
/**
 * List most rated ideas on group profile page
 *
 * @package ideas
 */

$group_guid = elgg_get_page_owner_entity();
$group = $vars['entity'];		// $groups seems to require re-assignment

if ($group->ideas_enable == "no") {
	return true;
}

elgg_push_context('widgets');

$content = elgg_list_entities_from_annotation_calculation(array(
	'type' => 'object',
	'subtype' => 'idea',
	'container_guid' => $group->guid,
	'annotation_names' => 'point',
	'order_by' => 'annotation_calculation desc',
	'full_view' => 'no_vote',
	'item_class' => 'elgg-item-idea pts pbs',
	'list_class' => 'group-idea-list',
	'limit' => 6,
	'pagination' => false
));
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('ideas:none') . '</p>';
}

$all_link = elgg_view('output/url', array(
	'href' => "ideas/group/$group->guid/all",
	'text' => elgg_echo('ideas:view:all'),
));

$new_link = elgg_view('output/url', array(
	'href' => "ideas/add/$group->guid",
	'text' => ucfirst(elgg_echo('ideas:add')),
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('ideas:group:idea'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));