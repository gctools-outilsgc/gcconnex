<?php

// cyu - 12/22/2014: displaying number of items fixed and it now defaults to 15 instead of 10, also centered the pages at the bottom

$list_id = elgg_extract('list_id', $vars);

$list_options = elgg_extract('list_options', $vars);
$getter_options = elgg_extract('getter_options', $vars);

$offset = abs((int) elgg_extract('offset', $getter_options, 0));
$offset_key = elgg_extract('offset_key', $list_options, 'offset');

$limit_key = elgg_extract('limit_key', $list_options, 'limit');

if (!$limit = (int) elgg_extract('limit', $getter_options, 10)) {
	$limit = get_input($limit_key);
}

$count = (int) elgg_extract('count', $vars, 0);
$base_url = elgg_extract('base_url', $vars, full_url());
$base_url = hj_framework_http_remove_url_query_element($base_url, '__goto');

$num_pages = elgg_extract('num_pages', $vars, 5);

$delta = ceil($num_pages / 2);

if ($count <= $limit && $offset == 0) {
	// no need for pagination
	//return true;
} else {

	$total_pages = ceil($count / $limit);
	$current_page = ceil($offset / $limit) + 1;

	$pages = new stdClass();
	$pages->prev = array(
		'text' => '&laquo; ' . elgg_echo('previous'),
		'href' => '',
		'is_trusted' => true,
	);
	$pages->next = array(
		'text' => elgg_echo('next') . ' &raquo;',
		'href' => '',
		'is_trusted' => true,
	);
	$pages->items = array();

// Add pages before the current page
	if ($current_page > 1) {
		$prev_offset = $offset - $limit;
		if ($prev_offset < 0) {
			$prev_offset = 0;
		}

		$pages->prev['href'] = elgg_http_add_url_query_elements($base_url, array($offset_key => $prev_offset, $limit_key => $limit));

		$first_page = $current_page - $delta;
		if ($first_page < 1) {
			$first_page = 1;
		}

		$pages->items = range($first_page, $current_page - 1);
	}

	$pages->items[] = $current_page;

// add pages after the current one
	if ($current_page < $total_pages) {
		$next_offset = $offset + $limit;
		if ($next_offset >= $count) {
			$next_offset--;
		}

		$pages->next['href'] = elgg_http_add_url_query_elements($base_url, array($offset_key => $next_offset, $limit_key => $limit));

		$last_page = $current_page + $delta;
		if ($last_page > $total_pages) {
			$last_page = $total_pages;
		}

		$pages->items = array_merge($pages->items, range($current_page + 1, $last_page));
	}

	$pager .= "<ul class=\"elgg-pagination hj-framework-list-pagination \">";
	if ($pages->prev['href']) {
		$link = elgg_view('output/url', $pages->prev);
		$pager .= "<li>$link</li>";
	} else {
		$pager .= "<li class=\"elgg-state-disabled\"><span>{$pages->prev['text']}</span></li>";
	}

	foreach ($pages->items as $page) {
	
		if ($page == $current_page) {
			$pager .= "<li class=\"elgg-state-selected\"><span>$page</span></li>";
		} else {
			$page_offset = (($page - 1) * $limit);
			$url = elgg_http_add_url_query_elements($base_url, array($offset_key => $page_offset, $limit_key => $limit));
			$link = elgg_view('output/url', array(
				'href' => $url,
				'text' => $page,
				'is_trusted' => true,
				'data-list' => $list_id,
					//'data-scenario' => 'paginateList'
					));
			$pager .= "<li>$link</li>";
		}
	}

	if ($pages->next['href']) {
		$link = elgg_view('output/url', $pages->next);
		$pager .= "<li>$link</li>";
	} else {
		$pager .= "<li class=\"elgg-state-disabled\"><span>{$pages->next['text']}</span></li>";
	}

	$pager .= '</ul>';
}

// $filter .= '<label class="hj-framework-list-limit-select float">' . elgg_echo('hj:framework:list:limit') . '</label>';
// $filter .= elgg_view('input/dropdown', array(
// 	'name' => $limit_key,
// 	'value' => $limit,
// 	'options' => (is_array($list_options['limit_select_options'])) ? $list_options['limit_select_options'] : array(15, 25, 50, 100),
// 	'class' => 'hj-framework-list-limit-select float-alt'
// ));

// Limit dropdown
// echo '<div class="hj-framework-list-filter span3 clearfix">';
// if ($count > 15) {
// 	echo elgg_view('input/form', array(
// 		'method' => 'GET',
// 		'action' => $base_url,
// 		'disable_security' => true,
// 		'body' => $filter,
// 		'class' => 'clearfix'
// 	));
// }
// echo '</div>';


// echo '<div class="span9">';
echo $pager;
// echo '</div>';