<?php

elgg_push_context('table-view');

$entities = elgg_extract('entities', $vars);
$list_options = elgg_extract('list_options', $vars);

$viewer_options = elgg_extract('viewer_options', $vars);
$vars = array_merge($vars, $viewer_options);

$output['list_type'] = $list_options['list_type'];
$output['list_id'] = elgg_extract('list_id', $vars);
$output['head'] = elgg_view('page/components/grids/elements/table/head', $vars);

$item_class = trim("elgg-item " . elgg_extract('item_class', $list_options, ''));

$output['items'] = array();

if (is_array($entities) && count($entities) > 0) {

	foreach ($entities as $entity) {
		$vars['entity'] = $entity;
		$vars['class'] = $class;
		$output['items'][] = elgg_view('page/components/grids/elements/table/row', $vars);
	}
	
} else {
	$output['items'][] = elgg_view('page/components/grids/elements/table/placeholder', array(
		'class' => $item_class,
		'data-uid' => -1,
		'data-ts' => time(),
		'colspan' => count($list_options['list_view_options']['table']['head'])
			));
}

$show_pagination = elgg_extract('pagination', $list_options, true);

$pagination_type = elgg_extract('pagination_type', $list_options, 'paginate');

if ($show_pagination) {
	$pagination = elgg_view("page/components/grids/elements/pagination/$pagination_type", $vars);
}

$list_id = elgg_extract('list_id', $vars);
$pagination = '<div class="hj-framework-list-pagination-wrapper row-fluid" for="' . $list_id . '">' . $pagination . '</div>';

$output['pagination'] = $pagination;

echo json_encode($output);

elgg_pop_context();