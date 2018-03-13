<?php
if (elgg_is_active_plugin("rijkshuisstijl")) {
    return;
}

echo elgg_view('search/search_box', array('class' => 'elgg-search-header'));