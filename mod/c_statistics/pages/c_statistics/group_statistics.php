<?php

$group_url = explode('/',$_SERVER["REQUEST_URI"]);
$group_id = $group_url[4];

$title = elgg_echo('Group Statistics');

$content = elgg_view('c_statistics/content_gs');


// layout the column with side bar being default
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title, 
	));


// render the page and send to requester
echo elgg_view_page($title, $body);