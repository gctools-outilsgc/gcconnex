<?php

$body .= elgg_view('input/text', array(
	'name' => "__q",
	'value' => get_input("__q", ''),
	'placeholder' => elgg_echo('hj:framework:filter:keywords'),
		));

// Reset all offsets so that lists return to first page
$query = elgg_parse_str(full_url());
foreach ($query as $key => $val) {
	if (strpos($key, '__off') === 0) {
		$footer .= elgg_view('input/hidden', array(
			'name' => $key,
			'value' => 0
				));
	}
}

$footer .= '<div class="hj-ajax-loader hj-loader-indicator hidden"></div>';

$footer .= elgg_view('input/submit', array(
	'value' => elgg_echo('filter'),
		));

$footer .= elgg_view('input/reset', array(
	'value' => elgg_echo('reset'),
	'class' => 'elgg-button-reset'
));

$filter = elgg_view_module('form', '', $body, array(
	'footer' => $footer
));

echo '<div class="hj-framework-list-filter">';

echo elgg_view('input/form', array(
	'method' => 'GET',
	'action' => full_url(),
	'disable_security' => true,
	'body' => $filter,
	'class' => 'float-alt'
));
echo '</div>';