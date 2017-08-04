<?php

$widget = elgg_extract('entity', $vars);

//get the num of blog entries the user wants to display
$num = (int) $widget->num_display;

//if no number has been set, default to 4
if ($num < 1) {
	$num = 4;
}

$options = [
	'type' => 'object',
	'subtype' => 'blog',
	'container_guid' => $widget->getOwnerGUID(),
	'limit' => $num,
	'full_view' => false,
	'pagination' => false,
	'metadata_name_value_pairs' => [],
];

if (!elgg_is_admin_logged_in() && !($widget->getOwnerGUID() == elgg_get_logged_in_user_guid())) {
	$options['metadata_name_value_pairs'][] = [
		'name' => 'status',
		'value' => 'published',
	];
}

if ($widget->show_featured == 'yes') {
	$options['metadata_name_value_pairs'][] = [
		'name' => 'featured',
		'value' => true,
	];
}

$content = elgg_list_entities_from_metadata($options);
if (!empty($content)) {
	echo $content;
	
	echo '<div class="elgg-widget-more">';
	$owner = $widget->getOwnerEntity();
	if ($owner instanceof ElggGroup) {
		echo elgg_view('output/url', [
			'text' => elgg_echo('blog:moreblogs'),
			'href' => "blog/group/{$owner->getGUID()}/all",
			'is_trusted' => true,
		]);
	} else {
		echo elgg_view('output/url', [
			'text' => elgg_echo('blog:moreblogs'),
			'href' => "blog/owner/{$owner->username}",
			'is_trusted' => true,
		]);
	}
	echo '</div>';
} else {
	echo elgg_echo('blog:noblogs');
}
