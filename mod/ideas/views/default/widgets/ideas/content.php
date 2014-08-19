<?php
/**
 * Elgg ideas widget
 *
 * @package ideas
 */

$max = (int) $vars['entity']->max_display;
$type = $vars['entity']->type_display;

if ( $type == 'top' ) {
	$content = elgg_list_entities_from_annotation_calculation(array(
		'type' => 'object',
		'subtype' => 'idea',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'annotation_names' => 'point',
		'order_by' => 'annotation_calculation desc',
		'full_view' => 'sidebar',
		'item_class' => 'elgg-item-idea pts pbs',
		'list_class' => 'sidebar-idea-list',
		'limit' => $max,
		'pagination' => false
	));
} elseif ( $type == 'new' ) {
	$content = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'idea',
		'owner_guid' => elgg_get_logged_in_user_guid(),
		'limit' => $max,
		'pagination' => false,
		'order_by' => 'time_created desc',
		'full_view' => 'sidebar',
		'list_class' => 'sidebar-idea-list',
		'item_class' => 'elgg-item-idea pts pbs'
	));
}

echo $content;

if ($content) {
	$url = "ideas/owner/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $url,
		'text' => elgg_echo('ideas:more'),
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('ideas:none');
}
