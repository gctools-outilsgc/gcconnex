<?php

/*
$query2 = "SELECT *
FROM elgg_metastrings v
JOIN elgg_annotations n_table on n_table.value_id = v.id
WHERE n.string LIKE '%@admin%'";

$query = "SELECT n_table.*, n.string as name, v.string as value
FROM elgg_annotations n_table
JOIN elgg_metastrings v on n_table.value_id = v.id
JOIN elgg_metastrings n on n_table.name_id = n.id
WHERE v.string LIKE '%@admin%'
AND n.string = 'generic_comment'
LIMIT 0, 10";

$mentions = get_data($query, 'row_to_elggannotation');
*/

$user = elgg_get_logged_in_user_entity();
$username = "%@{$user->username}%";

$mentions = elgg_get_annotations(array(
	'annotation_name' => 'generic_comment',
	'reverse_order_by' => true,
	'limit' => elgg_extract('limit', $vars, 4),
	'type' => 'object',
	'subtypes' => elgg_extract('subtypes', $vars, ELGG_ENTITIES_ANY_VALUE),
	'wheres' => array("v.string LIKE '$username'"),
));

if ($mentions) {
	$mentions_list = elgg_view('page/components/list', array(
		'items' => $mentions,
		'pagination' => false,
		'list_class' => 'elgg-latest-mentions',
		'full_view' => false,
	));
	
	echo elgg_view_module('aside', elgg_echo('activity:module:mentions:title'), $mentions_list);
}