<?php

$title = elgg_echo('gcconnex web application statistics');

$content = elgg_view('c_statistics/content_ss');


// layout the column with side bar being default
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title, 
	));


// render the page and send to requester
echo elgg_view_page($title, $body);