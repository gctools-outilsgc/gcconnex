<?php

$title = elgg_echo('user/site statistics/status');

$content = elgg_view('c_statistics/content_us');


// layout the column with side bar being default
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title, 
	));


// render the page and send to requester
echo elgg_view_page($title, $body);