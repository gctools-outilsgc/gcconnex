<?php

/**
 * Community page widgets
 */

$widget = $vars['entity'];
$object_type = 'thewire';

$widget->title = (get_current_language() == "fr") ? $widget->widget_title_fr : $widget->widget_title_en;

$num_items = $widget->num_items;
$widget_hashtag = $widget->widget_hashtag;
if (strpos($widget_hashtag, ',') !== false) {
	$widget_hashtag = array_map('trim', explode(',', $widget_hashtag));
}

if (!isset($num_items)) {
	$num_items = 10;
}
elgg_set_context('search');

$dbprefix = elgg_get_config('dbprefix');
$typeid = get_subtype_id('object', 'thewire');
$query = "SELECT wi.guid FROM {$dbprefix}objects_entity wi LEFT JOIN {$dbprefix}entities en ON en.guid = wi.guid WHERE en.type = 'object' AND en.subtype = {$typeid} ";

if (is_array($widget_hashtag)) {
	$all_hashtags = implode("|", $widget_hashtag);
	$all_hashtags = str_replace("'", "''", $all_hashtags);
	$query .= " AND wi.description REGEXP '{$all_hashtags}'";
} else {
	$query .= " AND wi.description LIKE '%{$widget_hashtag}%'";
}

$wire_ids = array();
$wires = get_data($query);
foreach ($wires as $wire) {
	$wire_ids[] = $wire->guid;
}

$widget_datas = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => $object_type,
	'limit' => $num_items,
	'full_view' => false,
	'list_type_toggle' => false,
	'pagination' => false,
	'guids' => $wire_ids
));

echo $widget_datas;
