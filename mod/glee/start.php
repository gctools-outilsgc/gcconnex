<?php

elgg_register_event_handler('init',  'system', 'glee_init', 1);

function glee_init() {
    /**
     * LIBRARY
     */
    $lib_path = elgg_get_plugins_path() . 'glee/lib/';
    elgg_register_library('glee-lib', $lib_path . 'glee.lib.php');
    
    // load library
    elgg_load_library('glee-lib');

    /**
     * jQuery & BOOTSTRAP JS
     */
    elgg_register_js('jquery',     'mod/glee/vendors/jquery/jquery-1.7.1.min.js',    'head');
    elgg_register_js('bootstrap',  'mod/glee/vendors/bootstrap/js/bootstrap.min.js', 'head');
    
    /**
    * INTERNAL JS
    */
    elgg_register_simplecache_view('js/glee/init');
    $url = elgg_get_simplecache_url('js', 'glee/init');
    elgg_register_js('glee:init', $url, 'footer', 1);
    
//     /**
//      * BOOTSTRAP LESS
//      */
//     elgg_register_simplecache_view('css/glee/less/bootstrap.less');
//     $url = elgg_get_simplecache_url('css', 'glee/less/bootstrap.less');
//     glee_register_less('bootstrap-less-css', $url, 1);
       
//     elgg_register_simplecache_view('css/glee/less/bootstrap.responsive.less');
//     $url = elgg_get_simplecache_url('css', 'glee/less/bootstrap.responsive.less');
//     glee_register_less('bootstrap-responsive-less-css', $url, 2);
    
    /**
    * BOOTSTRAP CSS
    */
    $css_url = 'mod/glee/vendors/bootstrap/css/';

    /**
    * BOOTSTRAP CSS - Original 
    *   elgg_register_css('bootstrap-css', $css_url.'bootstrap.min.css', 1);
    */


    elgg_register_css('bootstrap-css', $css_url.'bootstrap.css', 1);
    //elgg_register_css('bootstrap-responsive-css', $css_url.'bootstrap-responsive.min.css', 2);

    /**
     * HOOK HANDLER
     */
    // add <link ref="stylesheet/less" ... /> to head
    elgg_register_plugin_hook_handler('view', 'page/elements/head', 'glee_page_elements_head_hook', 900);
    
    /**
     * PAGE HANDLER
     */
    // serves "less" files
    elgg_register_page_handler('less', 'glee_less_page_handler');
    
    // example page handler
    //elgg_register_page_handler('glee', 'glee_example_page_handler');

    elgg_register_plugin_hook_handler('glee', 'themes', 'glee_register_bootswatch_themes');
       
    return true;
}

function glee_load_bootstrap_style() {
    /**
    * LOAD CSS AND JS
    */
    elgg_load_js('jquery');
    elgg_load_js('bootstrap');
    elgg_load_js('glee:init');

    $themes = glee_get_themes();
    
    $theme_name = elgg_get_plugin_setting('theme', 'glee');
    $theme      = elgg_extract($theme_name, $themes, false);
    
    // if no theme has been selected: load default bootstrap file
    $css_name = 'none';
    if(is_array($theme)) {           
        $css_name = elgg_extract(0, $theme, 'none'); 
    }
    
    if (strcmp('none', $css_name) == 0) {
        elgg_load_css('bootstrap-css');     
    }
    else {
        elgg_load_css($css_name);
    }
    
    return true;
}

function glee_register_bootswatch_themes($hook, $type, $return, $params) {
    $css_url = 'mod/glee/vendors/bootswatch/';
    
    $standard_themes = array(
        'none'      => array(),
        'amelia'    => array('bootstrap-amelia-css',    $css_url.'amelia/bootstrap.min.css'), 
        'cerulean'  => array('bootstrap-cerulean-css',  $css_url.'cerulean/bootstrap.min.css'),
        'cyborg'    => array('bootstrap-cyborg-css',    $css_url.'cyborg/bootstrap.min.css'),
        'journal'   => array('bootstrap-journal-css',   $css_url.'journal/bootstrap.min.css'),
        'readable'  => array('bootstrap-readable-css',  $css_url.'readable/bootstrap.min.css'),
        'simplex'   => array('bootstrap-simplex-css',   $css_url.'simplex/bootstrap.min.css'),
        'slate'     => array('bootstrap-slate-css',     $css_url.'slate/bootstrap.min.css'),
        'spacelab'  => array('bootstrap-spacelab-css',  $css_url.'spacelab/bootstrap.min.css'),
        'spruce'    => array('bootstrap-spruce-css',    $css_url.'spruce/bootstrap.min.css'),
        'superhero' => array('bootstrap-superhero-css', $css_url.'superhero/bootstrap.min.css'),
        'united'    => array('bootstrap-united-css',    $css_url.'united/bootstrap.min.css'),
    );
    
    // register bootswatch themes
    foreach ($standard_themes as $name => $options) {
        $css_name = elgg_extract(0, $options);
        $css_file = elgg_extract(1, $options);
        
        elgg_register_css($css_name, $css_file, 1);
    }
    
    $return = array_merge($return, $standard_themes);
    
    return $return;
}
