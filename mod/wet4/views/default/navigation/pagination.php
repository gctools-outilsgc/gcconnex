<?php
/**
 * !
 * Elgg pagination
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses int    $vars['offset']     The offset in the list
 * @uses int    $vars['limit']      Number of items per page
 * @uses int    $vars['count']      Number of items in list
 * @uses string $vars['baseurl']    Base URL to use in links
 * @uses string $vars['offset_key'] The string to use for offet in the URL
 */

if (elgg_in_context('widget')) {
	// widgets do not show pagination
	return true;
}
$count = (int) elgg_extract('count', $vars, 0);
if (!$count) {
	return;
}

$offset = abs((int) elgg_extract('offset', $vars, 0));
// because you can say $vars['limit'] = 0
if (!$limit = (int) elgg_extract('limit', $vars, elgg_get_config('default_limit'))) {
	$limit = 10;
}

$offset_key = elgg_extract('offset_key', $vars, 'offset');
$url_fragment = elgg_extract('url_fragment', $vars, '');

// some views pass an empty string for base_url
if (isset($vars['base_url']) && $vars['base_url']) {
	$base_url = $vars['base_url'];
} else if (isset($vars['baseurl']) && $vars['baseurl']) {
	elgg_deprecated_notice("Use 'base_url' instead of 'baseurl' for the navigation/pagination view", 1.8);
	$base_url = $vars['baseurl'];
} elseif (elgg_is_xhr() && !empty($_SERVER['HTTP_REFERER'])) {
	$base_url = $_SERVER['HTTP_REFERER'];
} else {
	$base_url = current_page_url();
}
////////////
//fix for unvalidated users page
$current_url = explode('?',current_page_url());
if ($current_url[0] === elgg_get_site_url().'admin/users/unvalidated'){
	$base_url = current_page_url();
}
//$base_url = current_page_url();
$base_url_has_fragment = preg_match('~#.~', $base_url);

$get_href = function ($offset) use ($base_url, $base_url_has_fragment, $offset_key, $url_fragment) {
	$link = elgg_http_add_url_query_elements($base_url, array($offset_key => $offset));
	if (!$base_url_has_fragment && $offset) {
		$link .= "#$url_fragment";
	}
	return $link;
};

if ($count <= $limit && $offset == 0) {
	// no need for pagination
	return;
}

$total_pages = (int) ceil($count / $limit);
$current_page = (int) ceil($offset / $limit) + 1;

$pages = array();

// determine starting page
$start_page = max(min([$current_page - 2, $total_pages - 4]), 1);

// add previous
$prev_offset = $offset - $limit;
if ($prev_offset < 1) {
	// don't include offset=0
	$prev_offset = null;
}

$pages['prev'] = [
	'text' => elgg_echo('previous'),
	'href' => $get_href($prev_offset),
];

if ($current_page == 1) {
	$pages['prev']['disabled'] = true;
}

// add first page to be listed
if (1 < $start_page) {
	$pages[1] = [];
}

// added dotted spacer
if (1 < ($start_page - 2)) {
	$pages[] = ['text' => '...', 'disabled' => true];
} elseif ($start_page == 3) {
	$pages[2] = [];
}

$max = 1;
for ($page = $start_page; $page <= $total_pages; $page++) {
	if ($max > 5) {
		break;
	}
	$pages[$page] = [];
	$max++;
}

// added dotted spacer

if ($total_pages > ($start_page + 6)) {
	$pages[] = ['text' => '...', 'disabled' => true];
} elseif (($start_page + 4) == ($total_pages - 1)) {
	$pages[$total_pages - 1] = [];
}

// add last page to be listed
/*
if ($total_pages >= ($start_page + 5)) {
	$pages[$total_pages] = [];
}
*/
// add next
$next_offset = $offset + $limit;
if ($next_offset >= $count) {
	$next_offset--;
}

$pages['next'] = [
	'text' => elgg_echo('next'),
	'href' => $get_href($next_offset),
];

if ($current_page == $total_pages) {
	$pages['next']['disabled'] = true;
}



$list ="";
foreach ($pages as $page_num => $page) {
	if ($page_num == $current_page) {
		$list .= elgg_format_element('li', ['class' => 'elgg-state-selected active'], "<span>$page_num</span>");
	} else {
		$href = elgg_extract('href', $page);
		$text = elgg_extract('text', $page, $page_num);
		$disabled = elgg_extract('disabled', $page, false);

		if (!$href && !$disabled) {
			$page_offset = (($page_num - $current_page) * $limit) + $offset;
			if ($page_offset <= 0) {
				// don't include offset=0
				$page_offset = null;
			}
			$href = $get_href($page_offset);
		}

		if ($href && !$disabled) {
			$link = elgg_view('output/url', array(
				'href' => $href,
				'text' => $text,
				'is_trusted' => true,
			));
		} else {
			$link = elgg_format_element('span', [], $page['text']);
		}

		$element_options = array();
		if ($disabled) {
			$element_options['class'] = 'elgg-state-disabled ';
		}

		$list .= elgg_format_element('li', $element_options, $link);
	}
}

echo elgg_format_element('ul', ['class' => 'elgg-pagination pagination'], $list);


/* WET PAGER
$offset = abs((int) elgg_extract('offset', $vars, 0));
// because you can say $vars['limit'] = 0
if (!$limit = (int) elgg_extract('limit', $vars, 10)) {
	$limit = 10;
}

$count = (int) elgg_extract('count', $vars, 0);
$offset_key = elgg_extract('offset_key', $vars, 'offset');
// some views pass an empty string for base_url
if (isset($vars['base_url']) && $vars['base_url']) {
	$base_url = $vars['base_url'];
} else {
	$base_url = current_page_url();
}

$num_pages = elgg_extract('num_pages', $vars, 10);
$delta = ceil($num_pages / 2);

if ($count <= $limit && $offset == 0) {
	// no need for pagination
	return true;
}

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

	$pages->prev['href'] = elgg_http_add_url_query_elements($base_url, array($offset_key => $prev_offset));

	$first_page = $current_page - 2; //GCChange - from[$delta] to [2]
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

	$pages->next['href'] = elgg_http_add_url_query_elements($base_url, array($offset_key => $next_offset));

	$last_page = $current_page + 2; //GCChange - from[$delta] to [2]
	if ($last_page > $total_pages) {
		$last_page = $total_pages;
	}

	$pages->items = array_merge($pages->items, range($current_page + 1, $last_page));
}



//echo '<div class="">';
echo '<ul class=" elgg-pagination pagination">';

if ($pages->prev['href']) {
	$link = elgg_view('output/url', $pages->prev);
	echo "<li>$link</li>";
} else {
	echo "";
}

foreach ($pages->items as $page) {
	if ($page == $current_page) {
        $page_offset = (($page - 1) * $limit);
        $url = elgg_http_add_url_query_elements($base_url, array($offset_key => $page_offset));
		echo "<li class=\"elgg-state-selected active\"><a href=\"$url\">$page</a></li>";
	} else {
		$page_offset = (($page - 1) * $limit);
		$url = elgg_http_add_url_query_elements($base_url, array($offset_key => $page_offset));
		echo "<li><a href=\"$url\">$page</a></li>";
	}
}

if ($pages->next['href']) {
	$link = elgg_view('output/url', $pages->next);
	echo "<li>$link</li>";
} else {
	echo "";
}

echo '</ul>';
//echo '</div>';

*/