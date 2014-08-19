<?php
/**
 * Elgg page header
 * In the default theme, the header lives between the topbar and main content area.
 */

// link back to main site.
//echo elgg_view('page/elements/header_logo', $vars);


if (elgg_is_active_plugin('search')) {
    $search_box = elgg_view('search/search_box', array('class' => 'pull-right'));
    echo $search_box;
}

