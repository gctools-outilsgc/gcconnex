<?php
/*
* GC-Elgg Tags and Communities 
*
* Users can add community of practice meta data to their content.
*
* @author Nick github.com/piet0024
* @version 1.0
*/

elgg_register_event_handler('init', 'system', 'tags_and_communities');

function tags_and_communities(){
    //Register selectize library
    elgg_require_js("selectize_require");
    elgg_register_js('selectize', 'mod/gc_tags/views/default/js/selectize.min.js');
    elgg_extend_view('css/elgg', 'css/selectize.bootstrap3.css');
    
    //override the form actions so we can save community meta data :3
    $action_path = elgg_get_plugins_path() . 'gc_tags/actions';
    //Blog form
    elgg_unregister_action('blog/save');
	elgg_register_action('blog/save', "$action_path/blog/save.php");
}