<?php

/*
* GC Official groups - Allows site admins to flag groups as official recognized by the site
*
* @version 1.0
* @author Nick
*/

//Init
elgg_register_event_handler('init','system','gc_official_group_init');

function gc_official_group_init(){
    
    //Register the actions
    elgg_register_action('add_off_group', elgg_get_plugins_path() .'gc_official_groups/actions/add_off_group.php',"admin");
    
    elgg_register_action('remove_off_group', elgg_get_plugins_path() .'gc_official_groups/actions/remove_off_group.php',"admin");
    
    //Add CSS styles
    elgg_extend_view('css/elgg', 'css/official_groups');
    
    
    //Extend the summary view to add the official badge
    elgg_extend_view('object/elements/summary', 'object/elements/official_badge', 400);
    elgg_extend_view('page/layouts/one_sidebar', 'object/elements/badge_group_profile',400);
    elgg_extend_view('groups/edit', 'page/elements/add_off_edit', 330);
}