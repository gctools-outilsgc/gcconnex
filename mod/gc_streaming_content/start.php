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
    
}