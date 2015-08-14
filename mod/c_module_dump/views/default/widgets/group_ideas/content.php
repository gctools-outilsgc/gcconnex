<?php
/**
 * Elgg ideas widget
 * Modified by Christine Yu : Patch for issue [Helpdesk: does not display X number of ideas in widget]
 *
 * @package ideas
 */

$max = (int) $vars['entity']->max_display;
$widget = $vars["entity"];
$group_guid = $widget->getOwnerGUID();
$content = elgg_list_entities_from_annotation_calculation(array(
	'type' => 'object',
	'subtype' => 'idea',
	'container_guid' => $group_guid,
	'annotation_names' => 'point',
	'order_by' => 'annotation_calculation desc',
	'full_view' => 'sidebar',
	'item_class' => 'elgg-item-idea pts pbs',
	'list_class' => 'sidebar-idea-list',
	'limit' => $max,
	'pagination' => false
));

echo $content;

if ($content) {
	$url = "ideas/group/".$group_guid;
	$more_link = elgg_view('output/url', array(
		'href' => $url,
		'text' => elgg_echo('ideas:more'),
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('ideas:none');
}
