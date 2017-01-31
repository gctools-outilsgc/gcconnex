<?php

/*
* start.php
*
* This mod adds some javascript to thewire/all page on the elgg site. It works with the GCAPI mod to check if there are new wire posts and adds the new posts directly to the DOM through ajax
*
* @author Nick github.com/piet0024
*/

elgg_register_event_handler('init', 'system', 'gc_streaming_init');

function gc_streaming_init(){
    elgg_require_js("stream_wire");
    
    elgg_extend_view('css/elgg', 'css/css');
    
    elgg_register_ajax_view('ajax/wire_posts');
    
    elgg_register_page_handler('thewire', 'streaming_wire_page');
    // live stream wire widget
    elgg_register_widget_type('stream_wire_index',elgg_echo ('custom_index_widgets:stream_wire_index'),elgg_echo ('custom_index_widgets:stream_wire_index'), array("custom_index_widgets"), true);
    
}

function streaming_wire_page(){
    @include (dirname ( __FILE__ ) . "/pages/thewire/everyone.php");
    return true;
}