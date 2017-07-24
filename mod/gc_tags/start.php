<?php
/*
* GC-Elgg Tags and Communities 
*
* Users can add community of practice meta data to their content. New inputs for tagging content
*
* @author Nick github.com/piet0024
* @version 1.0
*/

elgg_register_event_handler('init', 'system', 'tags_and_communities');

function tags_and_communities(){
    //Register selectize library
    elgg_require_js("selectize_require");
    elgg_extend_view('css/elgg', 'css/selectize.bootstrap3.css');
    
    //Custom CSS
    elgg_extend_view('css/elgg', 'css/gc_tags.css');
    
    //Add metadata to the page header
    elgg_extend_view('page/elements/head', 'page/elements/tag_metadata');
    
    
    //Extend the forms with the tag and community modal
    //These modals get called in validate.js after the form is valid
    elgg_extend_view('forms/bookmarks/save', 'page/elements/tags_modal');
    elgg_extend_view('forms/pages/edit', 'page/elements/tags_modal');
    elgg_extend_view('forms/groups/edit', 'page/elements/tags_modal');
    elgg_extend_view('forms/file/upload', 'page/elements/tags_modal');
    elgg_extend_view('forms/discussion/save', 'page/elements/tags_modal');
    elgg_extend_view('forms/blog/save', 'page/elements/tags_modal');
    
    
    //Blog preview feature gets in the way a little so we will only override this action
    $action_path = elgg_get_plugins_path() . 'gc_tags/actions';
    elgg_unregister_action('blog/save');
	elgg_register_action('blog/save', "$action_path/blog/save.php");
    
    //FAQ / Help Page
    elgg_register_page_handler('community-help', 'gc_tags_help_page_handler');

    //Event handler for when objects and groups are created
    elgg_register_event_handler('create','object','gc_tags_add_comm_object');
    elgg_register_event_handler('create','group','gc_tags_add_comm_object');
    //Handler for when objects and groups are updated
    elgg_register_event_handler('update','object','gc_tags_add_comm_object');
    elgg_register_event_handler('update','group','gc_tags_add_comm_object');
}

function gc_tags_help_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/gc_tags_help.php");
    return true;
}


/*
 * Grabs the audience input and saves the metadata when the object / group is created / edit
 *
 * @param string $event		the name of the event
 * @param string $type		the type of object (eg "user", "group", ...)
 * @param mixed $object		the object/entity of the event
 */
function gc_tags_add_comm_object($event, $type, $object){
    $audience = get_input('audience');
    $object->audience = $audience;
}
