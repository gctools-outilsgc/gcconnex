<?php

elgg_push_context('table-view');

$list_id = elgg_extract('list_id', $vars);
$entities = elgg_extract('entities', $vars);
$list_options = elgg_extract('list_options', $vars);

$viewer_options = elgg_extract('viewer_options', $vars);
$vars = array_merge($vars, $viewer_options);

$class = "elgg-table hj-framework-table-view";
$item_class = trim("elgg-item " . elgg_extract('item_class', $list_options, ''));

if (isset($list_options['list_class'])) {
	$class = "$class {$list_options['list_class']}";
}

if (isset($vars['list_options']['filter'])) {
	echo '<div class="hj-framework-list-filter">';
	echo $vars['list_options']['filter'];
	echo '</div>';
}


// cyu - 22/12/2014: allow users to select how many items to display
//echo '<br/><br/>';
//echo 'Display: <a href="?__off_ft46=0&__lim_ft46=15">15</a> | <a href="?__off_ft46=0&__lim_ft46=20">20</a> | <a href="?__off_ft46=0&__lim_ft46=25">25</a>';

$table_head = elgg_view('page/components/grids/elements/table/head', $vars);

if (is_array($entities) && count($entities) > 0) {

	foreach ($entities as $entity) {
		$vars['entity'] = $entity;
		$vars['class'] = $item_class;
		$table_body .= elgg_view('page/components/grids/elements/table/row', $vars);
	}
	
} else {
	$table_body = elgg_view('page/components/grids/elements/table/placeholder', array(
		'class' => $item_class,
		'data-uid' => -1,
		'data-ts' => time(),
		'colspan' => count($list_options['list_view_options']['table']['head'])
			));
}

$table_body = '<tbody>' . $table_body . '</tbody>';
$table = "<table id=\"$list_id\" class=\"$class\">$table_head$table_body</table>";

$show_pagination = elgg_extract('pagination', $list_options, true);

$pagination_type = elgg_extract('pagination_type', $list_options, 'paginate');

if ($show_pagination) {
	$pagination = elgg_view("page/components/grids/elements/pagination/$pagination_type", $vars);
}

$pagination = '<div class="hj-framework-list-pagination-wrapper row-fluid" for="' . $list_id . '">' . $pagination . '</div>';

$position = elgg_extract('pagination_position', $list_options, 'after');

if ($position == 'both') {
	$table = "$pagination $table $pagination";
} else if ($position == 'before') {
	$table = "$pagination $table";
} else {
	$table = "$table $pagination";
}

echo $table;

elgg_pop_context();