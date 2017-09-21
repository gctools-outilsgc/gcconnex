<?php
/**
 * Group pages
 *
 * @package ElggPad
 */


$group = elgg_get_page_owner_entity();

if ($group->etherpad_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "docs/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));


elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtypes' => array('etherpad', 'subpad'),
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('etherpad:none') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "docs/add/$group->guid",
	'text' => elgg_echo('etherpad:add'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('etherpad:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
