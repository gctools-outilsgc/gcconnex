<?php
/**
 * show some information about the blog owner
 *
 * @uses $vars['entity'] to get the ownet of the blog
 * @users $vars['full_view'] only when in full view of the blog
 */

$entity = elgg_extract('entity', $vars);
$full_view = (bool) elgg_extract('full_view', $vars, false);

if (!$full_view) {
	return;
}

$setting = elgg_get_plugin_setting('show_full_owner', 'blog_tools');

if (($setting === 'optional') && ($entity->show_owner !== 'yes')) {
	return;
} elseif (($setting !== 'yes') && ($setting !== 'optional')) {
	return;
}

$owner = $entity->getOwnerEntity();
if (!($owner instanceof ElggUser)) {
	return;
}

$icon = elgg_view_entity_icon($owner, 'medium', [
	'use_hover' => false,
]);

$profile_fields = elgg_get_config('profile_fields');
$brief = false;
$description = false;

if (!empty($profile_fields)) {
	foreach ($profile_fields as $metadata_name => $type) {
		if ($metadata_name === 'briefdescription') {
			$brief = $type;
		} elseif ($metadata_name === 'description') {
			$description = $type;
		}
	}
}

$content = elgg_format_element('h3', [], elgg_view('output/url', [
	'text' => $owner->name,
	'href' => $owner->getURL(),
	'is_trusted' => true,
]));

if ($brief && $owner->briefdescription) {
	$content .= elgg_format_element('div', [], elgg_view("output/{$brief}", [
		'value' => $owner->briefdescription,
	]));
}

if ($description && $owner->description) {
	$sub_title = elgg_format_element('strong', [], elgg_echo('profile:description'));
	$content .= elgg_format_element('div', [], $sub_title . elgg_view("output/{$description}", [
		'value' => elgg_get_excerpt($owner->description, 200),
	]));
}

echo elgg_view_image_block($icon, $content, ['class' => 'mtm pam blog-tools-full-owner']);
