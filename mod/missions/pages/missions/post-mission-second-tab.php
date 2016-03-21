<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
// See firstpost.php comments
gatekeeper();

if ($_SESSION['tab_context'] == 'firstpost' || $_SESSION['tab_context'] == '') {
    $_SESSION['tab_context'] = 'secondpost';
}

$title = elgg_echo('missions:micromissions') . ': ' . elgg_echo('missions:post_opportunity');
$content = elgg_view_form('missions/post-mission-second-form', array(
    'class' => 'mission-form'
));
$context = $_SESSION['tab_context'];
$url = elgg_get_site_url() . 'missions/';
$tab_bar = mm_write_tab_links($context, $url);

$body = elgg_view_layout('one-tab-bar', array(
    'content' => $content,
    'tab_bar' => $tab_bar
));

echo elgg_view_page(elgg_echo('missions:tab:opportunity'), $body);