<?php

echo '<thead>';

$list_options = $vars['list_options'];
$list_view_options = $list_options['list_view_options'];
$headers = $list_view_options['table']['head'];

$order_by_key = $list_options['order_by_key'];
$direction_key = $list_options['direction_key'];
$offset_key = $list_options['offset_key'];
//$limit_key = $list_options['limit_key'];

$order_by = get_input($order_by_key, false);
$direction = get_input($direction_key, 'DESC');

$base_url = elgg_extract('base_url', $vars, current_page_url());
$base_url = hj_framework_http_remove_url_query_element($base_url, '__goto');

if ($headers) {
	foreach ($headers as $key => $value) {

		if (!$value)
			continue;

		if (isset($value['colspan'])) {
			foreach ($value['colspan'] as $colspan_key => $colspan_value) {
				$ungrouped_headers[$colspan_key] = $colspan_value;
			}
		} else {
			$ungrouped_headers[$key] = $value;
		}
	}

	foreach ($ungrouped_headers as $header => $options) {

		if (!$options['sortable'])
			continue;

		$active_class = ($order_by == $options['sort_key'] && $direction == 'ASC') ? 'elgg-state-active' : 'elgg-state-selectable';
		$controls[$header]['asc'] = elgg_view('output/url', array(
			'text' => '&#9652;',
			'title' => elgg_echo('hj:framework:sort:ascending'),
			'href' => elgg_http_add_url_query_elements($base_url, array($order_by_key => $options['sort_key'], $direction_key => 'ASC', $offset_key => 0)),
			'class' => "sort-control sort-control-asc $active_class"
				));

		$active_class = ($order_by == $options['sort_key'] && $direction == 'DESC') ? 'elgg-state-active' : 'elgg-state-selectable';
		$controls[$header]['desc'] = elgg_view('output/url', array(
			'text' => '&#9662;',
			'title' => elgg_echo('hj:framework:sort:descending'),
			'href' => elgg_http_add_url_query_elements($base_url, array($order_by_key => $options['sort_key'], $direction_key => 'DESC', $offset_key => 0)),
			'class' => "sort-control sort-control-desc $active_class"
				));

		if ($order_by != $options['sort_key'] || ($order_by == $options['sort_key'] && $direction == 'DESC')) {
			$title_url = elgg_http_add_url_query_elements($base_url, array($order_by_key => $options['sort_key'], $direction_key => 'ASC', $offset_key => 0));
		} else {
			$title_url = elgg_http_add_url_query_elements($base_url, array($order_by_key => $options['sort_key'], $direction_key => 'DESC', $offset_key => 0));
		}

		$title_class = ($order_by == $options['sort_key']) ? 'elgg-state-active' : 'elgg-state-selectable';

		$text = (isset($options['text'])) ? $options['text'] : elgg_echo("table:head:$header");

		$controls[$header]['title'] = elgg_view('output/url', array(
			'text' => $text,
			'title' => elgg_echo('hj:framework:grid:sort:column'),
			'href' => $title_url,
			'class' => "sort-title $title_class"
				));
	}

	echo '<tr class="table-headers">';

	foreach ($headers as $key => $options) {
		if (!$options)
			continue;

		if (isset($options['colspan'])) {
			$colspan = count($options['colspan']);
			$class = "table-header table-header-join table-header-$key";
			if (isset($options['class'])) {
				$class = "$class {$options['class']}";
			}
			echo "<th class=\"$class\">";
			foreach ($options['colspan'] as $col_key => $col_options) {
				if (!$col_options)
					continue;
				if (isset($controls[$col_key])) {
					echo '<div class="table-header-sortable-col">';
					echo $controls[$col_key]['title'];
					echo $controls[$col_key]['asc'];
					echo $controls[$col_key]['desc'];
					echo '</div>';
				} else {
					$text = (isset($col_options['text'])) ? $col_options['text'] : elgg_echo("table:head:$header");
					echo $text;
				}
			}
			echo '</th>';
		} else {
			$header = $key;
			$class = "table-header table-header-$key";

			// cyu 12/22/2014: formats the style of the column of the table (last post)
			if ($key === 'last_post')
				echo "<th class=\"$class\" style=\"white-space:nowrap; width:1px;\" >";
			else
				echo "<th class=\"$class\" >";

			if (isset($controls[$header])) {
				echo $controls[$header]['title'];
				echo $controls[$header]['asc'];
				echo $controls[$header]['desc'];
			} else {
				$text = (isset($options['text'])) ? $options['text'] : elgg_echo("table:head:$header");
				echo $text;
			}
			echo '</th>';
		}
	}

	echo '</tr>';
}

echo '</thead>';