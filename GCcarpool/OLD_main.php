<?php
	
    $body = "PSC";
    $title = "Carpool";
    $body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => "this is a content",
	'title' => $title,
	'sidebar' => elgg_view('Carpool/sidebar'),
));
	echo elgg_view_page($title, $body);

?>