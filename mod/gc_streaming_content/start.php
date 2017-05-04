<?php

/**
* start.php
*
* This mod adds some javascript to thewire/all page on the elgg site. It works with the GCAPI mod to check if there are new wire posts and adds the new posts directly to the DOM through ajax
*
* @author Nick github.com/piet0024
* @author Ilia github.com/phanoix
**/

elgg_register_event_handler('init', 'system', 'gc_streaming_init');

function gc_streaming_init(){
    elgg_require_js("stream_wire");
    elgg_require_js("stream_newsfeed");
    
    elgg_extend_view('css/elgg', 'css/css');
    
    elgg_register_ajax_view('ajax/wire_posts');
    elgg_register_ajax_view('ajax/newsfeed_items');	
    elgg_register_ajax_view('ajax/newsfeed_check');
    
    elgg_register_page_handler('thewire', 'streaming_wire_page');
    // live stream wire widget
    elgg_register_widget_type('stream_wire_index',elgg_echo ('custom_index_widgets:stream_wire_index'),elgg_echo ('custom_index_widgets:stream_wire_index'), array("custom_index_widgets"), true);

    if(elgg_is_logged_in()){
        $newsfeed_title = elgg_echo('newsfeed:title');
    }else{
        $newsfeed_title = elgg_echo('newsfeed:titlenolog');
    }

    elgg_register_widget_type('stream_newsfeed_index', $newsfeed_title, elgg_echo ('custom_index_widgets:stream_newsfeed_index'), array("custom_index_widgets"), true);
    
}

function streaming_wire_page($page){
    
$base_dir = elgg_get_plugins_path() . 'thewire/pages/thewire';
    //The wire/all page is overwritten in this theme 
$stream_dir = elgg_get_plugins_path() .'gc_streaming_content/pages/thewire';
	if (!isset($page[0])) {
		$page = array('all');
	}

	switch ($page[0]) {
		case "all":
			include "$stream_dir/everyone.php";
			break;

		case "friends":
			include "$base_dir/friends.php";
			break;

		case "owner":
			include "$base_dir/owner.php";
			break;

		case "view":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include "$base_dir/view.php";
			break;

		case "thread":
			if (isset($page[1])) {
				set_input('thread_id', $page[1]);
			}
			include "$base_dir/thread.php";
			break;

		case "reply":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include "$base_dir/reply.php";
			break;

		case "tag":
			if (isset($page[1])) {
				set_input('tag', $page[1]);
			}
			include "$base_dir/tag.php";
			break;

		case "previous":
			if (isset($page[1])) {
				set_input('guid', $page[1]);
			}
			include "$base_dir/previous.php";
			break;

		default:
			return false;
	}
	return true;
}
