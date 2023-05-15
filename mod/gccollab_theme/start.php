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
        'title' => elgg_echo('missions:alttext'),
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
		'text' => elgg_echo('career') . '<span class="expicon glyphicon glyphicon-chevron-down"></span>',
        'title' => elgg_echo('missions:alttext'),
    ));

    elgg_register_page_handler('about', 'expages_collab_page_handler');        
    elgg_register_page_handler('a_propos', 'expages_collab_page_handler');

    elgg_register_page_handler('terms', 'expages_collab_page_handler');
    elgg_register_page_handler('termes', 'expages_collab_page_handler');   

    elgg_register_page_handler('privacy', 'expages_collab_page_handler');
    elgg_register_page_handler('confidentialite', 'expages_collab_page_handler');

    elgg_register_page_handler('faq', 'expages_collab_page_handler');
    elgg_register_page_handler('qfp', 'expages_collab_page_handler');

    elgg_register_page_handler('participating_organizations', 'expages_collab_page_handler');
    elgg_register_page_handler('organismes_participants', 'expages_collab_page_handler');

    elgg_register_page_handler('partners', 'expages_collab_page_handler');
    elgg_register_page_handler('partenaires', 'expages_collab_page_handler');

    // Register public external pages
    elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'expages_collab_public');

    elgg_register_plugin_hook_handler('register', 'menu:expages', 'expages_collab_menu_register_hook');

    // add footer links
    expages_collab_setup_footer_menu();

    elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'collab_menu_block_handler');

    elgg_register_plugin_hook_handler('members:list', 'type', "members_list_type");
    elgg_register_plugin_hook_handler('members:config', 'tabs', "members_nav_type");

    elgg_register_widget_type('poll',elgg_echo('polls:my_widget_title'),elgg_echo('polls:my_widget_description'), array("profile", "dashboard", "index", "groups"), true);
    elgg_register_widget_type('poll_individual',elgg_echo('polls:individual'),elgg_echo('poll_individual_group:widget:description'), array("profile", "dashboard", "index", "groups"), true);   
}

/**
 * Extend the public pages range
 *
 */
function expages_collab_public($hook, $handler, $return, $params){
    $pages = array('about', 'a_propos', 'terms', 'termes', 'privacy', 'confidentialite', 'faq', 'qfp', 'participating_organizations', 'organismes_participants', 'help/knowledgebase', 'help/embed');     // GCChange change - Ilia: Bilingual page url
    return array_merge($pages, $return);
}

/**
 * Setup the links to site pages
 */
function expages_collab_setup_footer_menu() {
    $pages = array('about', 'a_propos', 'terms', 'termes', 'privacy', 'confidentialite', 'faq', 'qfp', 'participating_organizations', 'organismes_participants', 'help/knowledgebase');     // GCChange change - Ilia: Bilingual page url
    
    foreach ($pages as $page) {
        $url = "$page";
        $wg_item = new ElggMenuItem($page, elgg_echo("expages:$page"), $url);
        elgg_register_menu_item('walled_garden', $wg_item);

        $footer_item = clone $wg_item;
        elgg_register_menu_item('footer', $footer_item);
    }
}

/**
 * External pages page handler
 *
 * @param array  $page    URL segements
 * @param string $handler Handler identifier
 * @return bool
 */
function expages_collab_page_handler($page, $handler) {
    if ($handler == 'expages') {
        expages_url_forwarder($page[1]);
    }
    $type = strtolower($handler);

    $title = elgg_echo("expages:$type");
    $header = elgg_view_title($title);

    $object = elgg_get_entities(array(
        'type' => 'object',
        'subtype' => $type,
        'limit' => 1,
    ));
    if ($object) {
        $content .= elgg_view('output/longtext', array('value' => $object[0]->description));
    } else {
        $content .= elgg_echo("expages:notset");
    }
    $content = elgg_view('expages/wrapper', array('content' => $content));
    
    if (elgg_is_admin_logged_in()) {
        elgg_register_menu_item('title', array(
            'name' => 'edit',
            'text' => elgg_echo('edit'),
            'href' => "admin/appearance/expages?type=$type",
            'link_class' => 'elgg-button elgg-button-action',
        ));
    }

    if (elgg_is_logged_in() || !elgg_get_config('walled_garden')) {
        $body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content));
        echo elgg_view_page($title, $body);
    } else {
        elgg_load_css('elgg.walled_garden');
        $body = elgg_view_layout('walled_garden', array('content' => $header . $content));
        echo elgg_view_page($title, $body, 'walled_garden');
    }
    return true;
}

/**
 * Adds menu items to the expages edit form
 *
 * @param string $hook   'register'
 * @param string $type   'menu:expages'
 * @param array  $return current menu items
 * @param array  $params parameters
 * 
 * @return array
 */
function expages_collab_menu_register_hook($hook, $type, $return, $params) {
    $type = elgg_extract('type', $params);
        
    $pages = array('about', 'a_propos', 'terms', 'termes', 'privacy', 'confidentialite', 'faq', 'qfp', 'participating_organizations', 'organismes_participants', 'partners', 'partenaires');
    foreach ($pages as $page) {
        $return[] = ElggMenuItem::factory(array(
            'name' => $page,
            'text' => elgg_echo("expages:$page"),
            'href' => "admin/appearance/expages?type=$page",
            'selected' => $page === $type,
        ));
    }
    return $return;
}

// function that handles moving jobs marketplace and micro missions into drop down menu
function career_menu_hander($hook, $type, $menu, $params){
    foreach ($menu as $key => $item){

        switch ($item->getName()) {
            case 'career':
                //$item->addChild(elgg_get_menu_item('subSite', 'Jobs Marketplace'));
                
                if(elgg_is_active_plugin('missions')){
                    $item->addChild(elgg_get_menu_item('site', 'mission_main'));
                }
                /*if(elgg_is_active_plugin('gcforums')){
                    $item->addChild(elgg_get_menu_item('subSite', 'Forum'));
                }*/

                $item->addChild(elgg_get_menu_item('subSite', 'jobs'));
                $item->setLinkClass('item');
                break;
        }
    }
}

function collab_menu_block_handler($hook, $type, $menu, $params){
    //rearrange menu items
    if(elgg_get_context() == 'groupSubPage' || elgg_in_context('group_profile')){

        elgg_unregister_menu_item('owner_block', 'activity');

        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){
            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));
                    $item->setPriority('1');
                    break;
                case 'gcforums':
                    $item->setPriority('1');
                    $item->setLinkClass('forums');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));
                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));
                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));
                    $item->setPriority('4');
                    break;
                case 'etherpad':
                    $item->setPriority('5');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));
                    $item->setPriority('6');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));
                    $item->setPriority('7');
                    break;
                case 'activity':
                    $item->setText(elgg_echo('activity'));
                    $item->setPriority('8');
                    $item->addItemClass('removeMe');
                    break;
                case 'questions':
                    $item->setText(elgg_echo('widget:questions:title'));
                    $item->setPriority('9');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));
                    $item->setPriority('10');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));
                    $item->setPriority('11');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('12');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));
                    $item->setPriority('13');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));
                    $item->setPriority('14');
                    break;
                case 'related_groups':
                    $item->setPriority('15');
                    break;
            }
        }
    }

    if(elgg_get_context() == 'profile'){

        elgg_unregister_menu_item('owner_block', 'activity');

        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){
            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));
                    $item->setPriority('1');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));
                    $item->setHref('#file');
                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));
                    $item->setHref('#blog');
                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));
                    $item->setHref('#events');
                    $item->setPriority('4');
                    break;
                case 'thewire':
                    //$item->setText(elgg_echo('The Wire'));
                    $item->setHref('#thewire');
                    $item->setPriority('5');
                    break;
                case 'etherpad':
                    $item->setHref('#etherpad');
                    $item->setPriority('6');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));
                    $item->setHref('#page_top');
                    $item->setPriority('7');
                    break;
                case 'questions':
                    $item->setText(elgg_echo('widget:questions:title'));
                    $item->setHref('#question');
                    $item->setPriority('8');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));
                    $item->setHref('#bookmarks');
                    $item->setPriority('9');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));
                    $item->setHref('#poll');
                    $item->setPriority('10');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));
                    $item->setHref('#task_top');
                    $item->setPriority('11');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('12');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));
                    $item->setHref('#album');
                    $item->setPriority('13');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('14');
                    break;
                case 'orgs':
                    $item->setPriority('15');
                    break;
                case 'activity':
                    $item->setText(elgg_echo('activity'));
                    $item->setPriority('16');
                    $item->addItemClass('removeMe');
                    break;
                case 'user_invite_from_profile':
                    $item->setPriority('17');
                    break;
            }
        }
    }
}

/**
 * Returns content for the "type" page
 *
 * @param string      $hook        "members:list"
 * @param string      $type        "type"
 * @param string|null $returnvalue list content (null if not set)
 * @param array       $params      array with key "options"
 * @return string
 */
function members_list_type($hook, $type, $returnvalue, $params) {
    if ($returnvalue !== null) {
        return;
    }

    $type = get_input('type');

    $user_types = array('' => elgg_echo('gcRegister:make_selection'), 'academic' => elgg_echo('gcRegister:occupation:academic'), 'student' => elgg_echo('gcRegister:occupation:student'), 'federal' => elgg_echo('gcRegister:occupation:federal'), 'provincial' => elgg_echo('gcRegister:occupation:provincial'), 'first_nations' => elgg_echo('gcRegister:occupation:first_nations'), 'municipal' => elgg_echo('gcRegister:occupation:municipal'), 'international' => elgg_echo('gcRegister:occupation:international'), 'ngo' => elgg_echo('gcRegister:occupation:ngo'), 'community' => elgg_echo('gcRegister:occupation:community'), 'business' => elgg_echo('gcRegister:occupation:business'), 'media' => elgg_echo('gcRegister:occupation:media'), 'retired' => elgg_echo('gcRegister:occupation:retired'), 'other' => elgg_echo('gcRegister:occupation:other'));
    
    $data = "<label class='mtm' for='by_type'>" . elgg_echo('gcRegister:membertype') . "</label>" . elgg_view('input/dropdown', array('id' => 'by_type', 'class' => 'mbm', 'name' => 'by_type', 'options_values' => $user_types, 'value' => $type));

    $data .= '<script>$(function() {
            $("#by_type").on("change", function() {
                if( $(this).val() !== "" ){
                    window.location.href = window.location.href.replace(/[\?#].*|$/, "?type=" + $(this).val());
                }
            });
        });</script>';

    $data .= elgg_list_entities_from_metadata(array(
        'type' => 'user', 
        'metadata_name' => 'user_type', 
        'metadata_value' => $type, 
        'pagination' => true,
        'limit' => 10
    ));

    return $data;
}

/**
 * Appends "type" tab to the navigation
 *
 * @param string $hook        "members:config"
 * @param string $type        "tabs"
 * @param array  $returnvalue array that build navigation tabs
 * @param array  $params      unused
 * @return array
 */
function members_nav_type($hook, $type, $returnvalue, $params) {
    $returnvalue['type'] = array(
        'title' => elgg_echo('members:label:type'),
        'url' => "members/type",
    );
    return $returnvalue;
}
