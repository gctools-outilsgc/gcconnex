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
    
    //Extend the forms
    elgg_extend_view('forms/blog/save','gc_tags/community_tags');
    
}