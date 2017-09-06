<?php
/**
 * Elgg questions plugin owner page
 *
 * @package Questions
 */
$lang = get_current_language();
$page_owner = elgg_get_page_owner_entity();
if (empty($page_owner)) {
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$page_owner = elgg_get_page_owner_entity();
}

if (empty($page_owner)) {
	forward(REFERER);
}

elgg_push_breadcrumb(gc_explode_translation($page_owner->name,$lang));

elgg_register_title_button();

// prepare options
$options = [
	'type' => 'object',
	'subtype' => 'question',
	'full_view' => false,
	'list_type_toggle' => false,
	'no_results' => elgg_echo('questions:none'),
];
if ($page_owner instanceof ElggGroup) {
	// groups are containers
	$options['container_guid'] = $page_owner->getGUID();
} else {
	// users list all owned questions
	$options['owner_guid'] = $page_owner->getGUID();
}

$tags = get_input('tags');
if (!empty($tags)) {
	if (is_string($tags)) {
		$tags = string_to_tag_array($tags);

	}
	$options['metadata_name_value_pairs'] = [
		'name' => 'tags',
		'value' => $tags,
	];
}

// build page elements
$title = elgg_echo('questions:owner', [gc_explode_translation($page_owner->name,$lang)]);

$content = elgg_list_entities_from_metadata($options);

// build page
$body = elgg_view_layout('content', [
	'title' => $title,
	'content' => $content,
	'filter_context' => ($page_owner->getGUID() === elgg_get_logged_in_user_guid()) ? 'mine' : '',
]);

// draw page
echo elgg_view_page($title, $body);
