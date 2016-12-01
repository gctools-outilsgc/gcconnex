<?php

/**
 * GC-Information Banne
 * 
 * @author Government of Canada
 */

elgg_register_event_handler('init', 'system', 'gcconnex_theme');

function gcconnex_theme_init() {
    elgg_register_page_handler('hello', 'gcconnex_theme_page_handler');
}
