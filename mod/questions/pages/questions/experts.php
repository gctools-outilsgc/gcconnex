<?php
/**
 * List all the experts of the page_owner (or site if missing)
 *
 * @package ElggQuestions
 */

$container = elgg_get_page_owner_entity();
if ($container instanceof ElggGroup) {
	elgg_push_breadcrumb($container->name, "questions/group/{$container->getGUID()}/all");
} else {
	$container = elgg_get_site_entity();
}

// build page elements
$title_text = elgg_echo('questions:experts:title');
elgg_push_breadcrumb($title_text);

// expert description
if ($container instanceof ElggGroup) {
	$desciption = elgg_view('output/longtext', [
		'value' => elgg_echo('questions:experts:description:group', [$container->name]),
	]);
} else {
	$desciption = elgg_view('output/longtext', [
		'value' => elgg_echo('questions:experts:description:site'),
	]);
}

// expert listing
$options = [
	'type' => 'user',
	'relationship' => QUESTIONS_EXPERT_ROLE,
	'relationship_guid' => $container->getGUID(),
	'inverse_relationship' => true,
	'full_view' => false,
];
$user_list = elgg_list_entities_from_relationship($options);
if (empty($user_list)) {
	$user_list = elgg_view('output/longtext', [
		'value' => elgg_echo('questions:experts:none', [$container->name]),
	]);
}

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $desciption . $user_list,
	'filter_context' => '',
]);

// draw page
echo elgg_view_page($title_text, $page_data);
