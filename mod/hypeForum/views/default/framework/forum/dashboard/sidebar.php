<?php

$search_title = elgg_echo('hj:forum:filter');
$search_box = elgg_view('framework/forum/filters/forums', $vars);

echo elgg_view_module('aside', $search_title, $search_box);