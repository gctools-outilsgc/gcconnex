<?php

/*
* start.php
*
* 
*
* @author Nick github.com/piet0024
*/

elgg_register_event_handler('init', 'system', 'gc_streaming_init');

function gc_streaming_init(){
    elgg_require_js("stream_wire");
    
    elgg_extend_view('css/elgg', 'css/css');
    
    elgg_register_ajax_view('ajax/wire_posts');
    elgg_register_ajax_view('ajax/time_stamp');
    
    elgg_register_page_handler('thewire', 'streaming_wire_page');
    
    elgg_register_action("get_timestamp", elgg_get_plugins_path() . "/gc_streaming_content/actions/get_wire_timestamp.php", "public");
    
}

function streaming_wire_page(){
    @include (dirname ( __FILE__ ) . "/pages/thewire/everyone.php");
    return true;
}