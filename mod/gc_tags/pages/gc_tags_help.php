<?php
/*
*
*/
$content = elgg_view_layout('one_sidebar', array(
    'title' => 'Right now we testing',
    'content' => elgg_view('gc_tags/community_help',array(
    
    )),
));

echo elgg_view_page(elgg_echo('OH NO!'), $content);