<?php

/**
 * Newsfeed start.php
 *
 *
 * @version 1.0
 * @author Nick Pietrantonio    github.com/piet0024
 */


elgg_register_event_handler('init','system', 'newsfeed_init');
elgg_register_plugin_hook_handler('index', 'system', 'new_index');

function newsfeed_init(){
    //set up metadata for user's landing page preference
    if(elgg_is_logged_in()){
        $user = elgg_get_logged_in_user_entity();
        if(!isset($user->landingpage)){
            $user->landingpage = 'news';
        }
    }

    //Register newsfeed page handler
    elgg_register_page_handler('newsfeed', 'newsfeed_page_handler');

    if(elgg_is_logged_in()){//for my the my groups widget on the home page
        $newsfeed_title = elgg_echo('newsfeed:title');
    }else{
        $newsfeed_title = elgg_echo('newsfeed:titlenolog');
    }

    //Register the custom index widget for the newsfeed page
    elgg_register_widget_type('newsfeed', $newsfeed_title, 'Group and Friend Activity', array('custom_index_widgets'),false);
    //Unregister old widget so it doesn't double up in the database on prod
    elgg_unregister_widget_type('wet_activity');

    //Register the site menu link
    elgg_register_menu_item('site', array(
        'name'=>'newsfeed',
        'href'=>elgg_get_site_url().'newsfeed',
        'text'=>elgg_echo("newsfeed:menu"),
        ));

    //Register newsfeed filter form
    elgg_register_ajax_view("ajax/newsfeed_filter");
    elgg_register_action("newsfeed/filter", elgg_get_plugins_path() . "/gc_newsfeed/actions/newsfeed/filter.php");

}

//Custom Newsfeed Page
function newsfeed_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/newsfeed.php");
    return true;
}

/*
 *  Set new index page to sort user's landing page preference
 */

function new_index() {
    return !include_once(dirname(__FILE__) . "/pages/index.php");
}
