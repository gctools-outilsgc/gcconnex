<?php
/**
 * !
 * Displays breadcrumbs.
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['breadcrumbs'] (Optional) Array of arrays with keys 'title' and 'link'
 * @uses $vars['class']
 *
 * @see elgg_push_breadcrumb
 */

$breadcrumbs = elgg_extract('breadcrumbs', $vars, elgg_get_breadcrumbs());
$additional_class = elgg_extract('class', $vars, '');

$class = 'breadcrumb elgg-menu elgg-breadcrumbs';
if ($additional_class) {
	$class = "$class $additional_class";
}

if (is_array($breadcrumbs) && !empty($breadcrumbs)) {
	echo "<ul class=\"$class\">";
	foreach ($breadcrumbs as $breadcrumb) {
	    $divider = '<span class="divider">/</span> ';
		if (!empty($breadcrumb['link'])) {
			$crumb = elgg_view('output/url', array(
				'href' => $breadcrumb['link'],
				'text' => $breadcrumb['title'],
				'is_trusted' => true,
			));
			
			
			echo "<li>$divider $crumb</li>";
		} else {
			$crumb = $breadcrumb['title'];
		    echo "<li class=\"active\">$divider $crumb</li>";
		}
	}
	echo '</ul>';
}

