<?php
/*
* Tag and communities Help page.
*
* @author Nick github.com/piet0024
*/
$content = elgg_view_layout('one_sidebar', array(
    'title' => elgg_echo('gctags:help:title'),
    'content' => elgg_view('gc_tags/community_help',array(
    
    )),
));

echo elgg_view_page(elgg_echo('gctags:help:title'), $content);