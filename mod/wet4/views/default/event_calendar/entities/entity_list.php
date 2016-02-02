<?php

/**
 * View a list of entities
 *
 * @package Elgg
 * @author Curverider Ltd <info@elgg.com>
 * @link http://elgg.com/
 *
 */

$offset = $vars['offset'];
$entities = $vars['entities'];
$limit = $vars['limit'];
$count = $vars['count'];
$base_url = $vars['base_url'];
$pagination = $vars['pagination'];
$full_view = $vars['full_view'];

$html = "";
$nav = "";

if ($pagination) {
	$nav .= elgg_view('navigation/pagination', array(
		'base_url' => $base_url,
		'offset' => $offset,
		'count' => $count,
		'limit' => $limit,
	));
}

$html .= $nav;

if (is_array($entities) && sizeof($entities) > 0) {
	foreach($entities as $entity) {
		$html .= elgg_view_entity($entity, $full_view);
	}
}

if ($count) {
	$html .= $nav;
}

echo $html;
