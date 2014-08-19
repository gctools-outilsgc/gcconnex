<?php
/**
 * View for task object
 *
 * @package ElggPages
 *
 * @uses $vars['entity']    The task object
 * @uses $vars['full_view'] Whether to display the full view
 * @uses $vars['revision']  This parameter not supported by elgg_view_entity()
 */


$full = elgg_extract('full_view', $vars, FALSE);
$task = elgg_extract('entity', $vars, FALSE);
$revision = elgg_extract('revision', $vars, FALSE);

if (!$task) {
	return TRUE;
}

// tasks used to use Public for write access
if ($task->write_access_id == ACCESS_PUBLIC) {
	// this works because this metadata is public
	$task->write_access_id = ACCESS_LOGGED_IN;
}


if ($revision) {
	$annotation = $revision;
} else {
	$annotation = $task->getAnnotations('task', 1, 0, 'desc');
	if ($annotation) {
		$annotation = $annotation[0];
	}
}

$task_icon = elgg_view('tasks/icon', array('annotation' => $annotation, 'size' => 'small'));

$editor = get_entity($annotation->owner_guid);
$editor_link = elgg_view('output/url', array(
	'href' => "tasks/owner/$editor->username",
	'text' => $editor->name,
	'is_trusted' => true,
));

$date = elgg_view_friendly_time($annotation->time_created);
$editor_text = elgg_echo('tasks:strapline', array($date, $editor_link));
$tags = elgg_view('output/tags', array('tags' => $task->tags));
$categories = elgg_view('output/categories', $vars);

$comments_count = $task->countComments();
//only display if there are commments
if ($comments_count != 0 && !$revision) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $task->getURL() . '#task-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'tasks',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$editor_text $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets') || $revision) {
	$metadata = '';
}

if ($full) {
	$body = elgg_view('output/longtext', array('value' => $annotation->value));

	$params = array(
		'entity' => $task,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $task,
		'title' => false,
		'icon' => $task_icon,
		'summary' => $summary,
		'body' => $body,
	));

} else {
	// brief view

	$excerpt = elgg_get_excerpt($task->description);

	$params = array(
		'entity' => $task,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($task_icon, $list_body);
}
