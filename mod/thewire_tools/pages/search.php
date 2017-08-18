<?php
/**
 * Search in TheWire
 */

$query = get_input("query", get_input("q"));

elgg_push_breadcrumb(elgg_echo("thewire"), "thewire/all");
elgg_push_breadcrumb(elgg_echo("thewire_tools:search:title:no_query"));

if (!empty($query)) {
	$entities_list = get_wire_entries_by_query($query);
	if (!empty($entities_list)) {
		$result = $entities_list;
	} else {
		$result = elgg_echo("notfound");
	}

	// set title
	$title_text = elgg_echo("thewire_tools:search:title", array($query));
} else {
	$title_text = elgg_echo("thewire_tools:search:title:no_query");
	$result = elgg_echo("thewire_tools:search:no_query");
}

//build search form
$form_vars = array(
	"id" => "thewire_tools_search_form",
	"action" => "thewire/search",
	"disable_security" => true,
	"method" => "GET"
);
$body_vars = array(
	"query" => $query
);
$form = elgg_view_form("thewire/search", $form_vars , $body_vars);

// build page
$body = elgg_view_layout("content", array(
    'filter_context' => 'mentions',
	"title" => $title_text,
	"content" => $form . $result,
    'sidebar' => elgg_view('thewire/sidebar'),
));

// Display page
echo elgg_view_page($title_text,$body);
