<?php

$params = array(
	'title' => 'Hello world!',
	'content' => 'My first page!',
	'filter' => '',
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page('Hello', $body);
