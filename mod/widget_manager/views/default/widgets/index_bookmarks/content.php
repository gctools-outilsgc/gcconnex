<?php
	
// get widget settings
$count = sanitise_int($vars["entity"]->bookmark_count, false);
if (empty($count)) {
	$count = 8;
}

$options = array(
	"type" => "object",
	"subtype" => "bookmarks",
	"limit" => $count,
	"full_view" => false,
	"pagination" => false
);

if ($bookmarks = elgg_list_entities($options)) {
	echo $bookmarks;
} else {
	echo elgg_echo("bookmarks:none");
}
