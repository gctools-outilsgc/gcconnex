<?php
/*
 * mentions.php
 *
 * Display mentions for a particular user
 *
 * @package wet4
 * @author GCTools Team
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
