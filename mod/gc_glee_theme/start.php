<?php

elgg_register_event_handler('init',      'system', 'glee_theme_draft_one_init',      1);
elgg_register_event_handler('ready',     'system', 'glee_theme_draft_one_ready',     1);
elgg_register_event_handler('pagesetup', 'system', 'glee_theme_draft_one_pagesetup', 1);

function glee_theme_draft_one_init() {
    /**
     * INTERNAL CSS
     */
    elgg_register_simplecache_view('css/glee_theme_draft_one/misc');
    $url = elgg_get_simplecache_url('css', 'glee_theme_draft_one/misc');
    elgg_register_css('glee-theme-draft-one:misc', $url);
    //elgg_load_css('glee-theme-draft-one:misc');
    
    elgg_extend_view('css/elgg', 'css/glee_theme_draft_one/misc', 1000);

    /**
     * INTERNAL JS
     */
    elgg_register_simplecache_view('js/glee_theme_draft_one/init');
    $url = elgg_get_simplecache_url('js', 'glee_theme_draft_one/init');
    elgg_register_js('glee-theme-draft-one:init', $url, 'footer');
    elgg_load_js('glee-theme-draft-one:init');


	elgg_register_menu_item('site', array(
         'name' => 'EmailUs',
         'href' => 'mailto:GCCONNEX@tbs-sct.gc.ca',
         'text' => elgg_echo('emailus'),
         'priority' => 101,
    ) ); 
    return true;
}


function glee_theme_draft_one_ready() {     
    if (elgg_is_active_plugin('search')) {
        // unextend the original search bar in the header
        elgg_unextend_view('page/elements/header', 'search/header');
    }

    return true;
}

/**
* Unregister/register logos
*/
function glee_theme_draft_one_pagesetup() {
    
// SEARCH BAR  
//     if (elgg_is_active_plugin('search')) {
//         $search_bar = elgg_view('search/search_box', array('class' => 'elgg-search-topbar'));
//         elgg_register_menu_item('topbar', array(
// 			'name' => 'search_bar',
// 			'href' => false,
// 			'text' => $search_bar,
// 			'priority' => 1,
// 			'section' => 'alt',
 //        ));
  //   }
    
    
    glee_load_bootstrap_style();
      
    return true;
}
