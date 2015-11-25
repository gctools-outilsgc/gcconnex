<?php
/**
 * Display latest comments that user has received to own content.
 */

$owner_guid = elgg_get_logged_in_user_guid();

$options = array(
	'annotation_name' => 'generic_comment',
	'owner_guid' => $owner_guid,
	'reverse_order_by' => true,
	'limit' => elgg_extract('limit', $vars, 4),
	'type' => 'object',
	'subtypes' => elgg_extract('subtypes', $vars, ELGG_ENTITIES_ANY_VALUE),
    'wheres' => array("n_table.owner_guid != $owner_guid")
);

$title = elgg_echo('activity:latest_comments');
$comments = elgg_get_annotations($options);
if ($comments) {
	$body = elgg_view('page/components/list', array(
		'items' => $comments,
		'pagination' => false,
		'list_class' => 'elgg-latest-comments',
		'full_view' => false,
	));

	echo elgg_view_module('aside', $title, $body);
}
