<?php

$content = elgg_view('page/elements/tagcloud_block', array(
    'subtypes' => array('idea')
));

$vars = array(
    'filter_context' => 'new',
    'content' => $content,
    'title' => $title,
    'sidebar' => elgg_view('ideas/sidebar'),
);

$body = elgg_view_layout('ideas', $vars);

echo elgg_view_page($title, $body);