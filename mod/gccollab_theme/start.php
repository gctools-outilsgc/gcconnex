<?php

/**
 * start.php
 *
 * GCcollab theme - includes all GCTools branding, links and language.
 * 
 * @author Government of Canada
 */

elgg_register_event_handler('init', 'system', 'gccollab_theme_init');

function gccollab_theme_init() {
    elgg_register_page_handler('hello', 'gccollab_theme_page_handler');
    elgg_register_plugin_hook_handler('register', 'menu:site', 'career_menu_hander');
    
    //jobs.gc.ca menu link
    elgg_register_menu_item('subSite', array(
        'name' => 'jobs',
        'text' => elgg_echo('wet:jobs:link'),
        'href' => elgg_echo('wet:jobs:href'),
        'target' => '_blank',
    ));
    
    //menu item for Jobs Marketplace
    elgg_register_menu_item('subSite', array(
        'name' => 'Jobs Marketplace',
        'text' => elgg_echo('wet:marketplace:link'),
        'href' => elgg_echo('wet:marketplace:href'),
    ));
    
    //menu item for career dropdown
    elgg_register_menu_item('site', array(
    		'name' => 'career',
    		'href' => '#career_menu',
    		'text' => elgg_echo('career') . '<span class="expicon glyphicon glyphicon-chevron-down"></span>'
    ));
}


// function that handles moving jobs marketplace and micro missions into drop down menu
function career_menu_hander($hook, $type, $menu, $params){
    foreach ($menu as $key => $item){

        switch ($item->getName()) {
            case 'career':
                $item->addChild(elgg_get_menu_item('subSite', 'Jobs Marketplace'));
                
                if(elgg_is_active_plugin('missions')){
                    $item->addChild(elgg_get_menu_item('site', 'mission_main'));
                }
                if(elgg_is_active_plugin('gcforums')){
                    $item->addChild(elgg_get_menu_item('subSite', 'Forum'));
                }

                $item->addChild(elgg_get_menu_item('subSite', 'jobs'));
                $item->setLinkClass('item');
                break;
        }
    }
}
