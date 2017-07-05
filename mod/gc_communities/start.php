<?php

/**
 * Communities start.php
 */

elgg_register_event_handler('init', 'system', 'gc_communities_init');

function gc_communities_init(){

    $subtypes = elgg_get_plugin_setting('subtypes', 'gc_communities');
    if( !$subtypes ){
        elgg_set_plugin_setting('subtypes', json_encode(array('blog', 'groupforumtopic', 'event_calendar', 'file')), 'gc_communities');
    }

    // Register ajax save action
    elgg_register_action("gc_communities/save", __DIR__ . "/actions/gc_communities/save.php");

    // Register ajax tag view
    elgg_register_ajax_view("tags/form");

    // Register streaming ajax calls
    elgg_register_ajax_view('ajax/community_feed');
    elgg_register_ajax_view('ajax/community_wire');

    $communities = json_decode(elgg_get_plugin_setting('communities', 'gc_communities'), true);
    $context = array();

    if( count($communities) > 0 ){
        $parent = new ElggMenuItem('communities', elgg_echo('gc_communities:communities') . '<span class="expicon glyphicon glyphicon-chevron-down"></span>', '#communities_menu');
        elgg_register_menu_item('site', $parent);

        foreach( $communities as $community ){
            $url = $community['community_url'];
            $community_animator = $community['community_animator'];

            $text = (get_current_language() == 'fr') ? $community['community_fr'] : $community['community_en'];
            if( elgg_is_logged_in() && (elgg_is_admin_logged_in() || $community_animator == elgg_get_logged_in_user_entity()->username) ){
                $text .= " <span class='elgg-lightbox' data-colorbox-opts='".json_encode(['href'=>elgg_normalize_url('ajax/view/tags/form?community_url='.$url),'width'=>'800px','height'=>'255px'])."'><i class='fa fa-cog fa-lg'><span class='wb-inv'>Customize this Community</span></i></span>";
            }

            //Register Community page handler
            elgg_register_page_handler($url, 'gc_community_page_handler');

            //Register each Community page menu link
            elgg_register_menu_item('communities', array(
                'name' => $url,
                'href' => elgg_get_site_url() . $url,
                'text' => $text
            ));

            $parent->addChild( elgg_get_menu_item('communities', $url) );
            $parent->setLinkClass('item');

            $context[] = "gc_communities-" . $url;
        }
    }

    // Register plugin hooks
    elgg_register_plugin_hook_handler('permissions_check', 'object', 'gc_communities_permissions_hook');
    elgg_register_plugin_hook_handler('permissions_check', 'widget_layout', 'gc_communities_widget_permissions_hook');

    // Register widgets for custom Community pages
    elgg_register_widget_type('filtered_activity_index', elgg_echo('gc_communities:filtered_activity_index'), elgg_echo('gc_communities:filtered_activity_index'), $context, true);

    if( elgg_is_active_plugin('blog') ){
        elgg_register_widget_type('filtered_blogs_index', elgg_echo('gc_communities:filtered_blogs_index'), elgg_echo('gc_communities:filtered_blogs_index'), $context, true);
    }
    
    elgg_register_widget_type('filtered_discussions_index', elgg_echo('gc_communities:filtered_discussions_index'), elgg_echo('gc_communities:filtered_discussions_index'), $context, true);

    if( elgg_is_active_plugin('event_calendar') ){
        elgg_register_widget_type('filtered_events_index', elgg_echo('gc_communities:filtered_events_index'), elgg_echo('gc_communities:filtered_events_index'), $context, true);
    }
    
    // Removing widget since Filtered Feed is now shown by default
    // elgg_register_widget_type('filtered_feed_index', elgg_echo('gc_communities:filtered_feed_index'), elgg_echo('gc_communities:filtered_feed_index'), $context, true);
    
    if( elgg_is_active_plugin('groups') ){
        elgg_register_widget_type('filtered_groups_index', elgg_echo('gc_communities:filtered_groups_index'), elgg_echo('gc_communities:filtered_groups_index'), $context, true);
    }

    // Only for GCcollab
    $site = elgg_get_site_entity();
    if( strpos(strtolower($site->name), 'gccollab') !== false ){
        elgg_register_widget_type('filtered_members_index', elgg_echo('gc_communities:filtered_members_index'), elgg_echo('gc_communities:filtered_members_index'), $context, true);
    }

    // Removing widget since Filtered Wire is now shown by default
    // if( elgg_is_active_plugin('thewire') ){
    //     elgg_register_widget_type('filtered_wire_index', elgg_echo('gc_communities:filtered_wire_index'), elgg_echo('gc_communities:filtered_wire_index'), $context, true);
    // }

    elgg_register_widget_type('free_html', elgg_echo("widgets:free_html:title"), elgg_echo("widgets:free_html:description"), $context, true);
}

function gc_communities_permissions_hook($hook, $entity_type, $returnvalue, $params) {
    $communities = json_decode(elgg_get_plugin_setting('communities', 'gc_communities'), true);
    $url = explode('gc_communities-', $params['entity']->context)[1];

    foreach( $communities as $community ){
        if( $community['community_url'] == $url ){
            $community_animator = $community['community_animator'];
            break;
        }
    }

    if( $community_animator == elgg_get_logged_in_user_entity()->username ){
        $returnvalue = true;
    }

    return $returnvalue;
}

function gc_communities_widget_permissions_hook($hook, $entity_type, $returnvalue, $params) {
    $communities = json_decode(elgg_get_plugin_setting('communities', 'gc_communities'), true);
    $url = explode('gc_communities-', $params['context'])[1];

    foreach( $communities as $community ){
        if( $community['community_url'] == $url ){
            $community_animator = $community['community_animator'];
            break;
        }
    }

    if( $community_animator == elgg_get_logged_in_user_entity()->username ){
        $returnvalue = true;
    }

    return $returnvalue;
}

function gc_community_page_handler($page, $url){
    $communities = json_decode(elgg_get_plugin_setting('communities', 'gc_communities'), true);

    foreach( $communities as $community ){
        if( $community['community_url'] == $url ){
            $community_en = $community['community_en'];
            $community_fr = $community['community_fr'];
            $community_tags = $community['community_tags'];
            $community_animator = $community['community_animator'];
            break;
        }
    }

    set_input('community_url', $url);
    set_input('community_en', $community_en);
    set_input('community_fr', $community_fr);
    set_input('community_tags', $community_tags);
    set_input('community_animator', $community_animator);

    @include (dirname ( __FILE__ ) . "/pages/community.php");
    return true;
}

function gc_communities_build_widgets($area_widget_list, $widgettypes, $build_server_side = true){

    $column_widgets_view = array();
    $column_widgets_string = "";
    
    if( is_array($area_widget_list) && sizeof($area_widget_list) > 0 ){
        foreach( $area_widget_list as $widget ){
            if( $build_server_side ){
                $title = $widget->widget_title;

                if($widget->widget_title_en && get_current_language() == 'en'){
                    $title = $widget->widget_title_en;
                }

                if($widget->widget_title_fr && get_current_language() == 'fr'){
                    $title = $widget->widget_title_fr;
                }

                if( !$title ){
                    $title = $widgettypes[$widget->handler]->name;
                }
                if( !$title ){
                    $title = $widget->handler;
                }
                $widget->title = $title;
                
                if( ($widget->guest_only == "yes" && !elgg_is_logged_in()) || $widget->guest_only == "no" || !isset($widget->guest_only) ){
                    $column_widgets_view[] = $widget;  
                }
                
            } else {
                if( !empty($column_widgets_string) ){
                    $column_widgets_string .= "::";
                }
                $column_widgets_string .= "{$widget->handler}::{$widget->getGUID()}";
            }
        }
        
        if( $build_server_side ){
            return $column_widgets_view;
        } else {
            return $column_widgets_string;
        }
    }
    return NULL;    
}

function gc_communities_animator_block($user){
    $title = elgg_echo('gc_communities:animator');
    $display_avatar = 'yes';

    $html = "";
    if( $user ){

        $userObj = get_user_by_username($user);

        if( $userObj ){

            $userType = $userObj->user_type;

            switch( $userType ){
                case "federal":
                    $deptObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'federal_departments',
                    ));
                    $depts = get_entity($deptObj[0]->guid);

                    $federal_departments = array();
                    if (get_current_language() == 'en'){
                        $federal_departments = json_decode($depts->federal_departments_en, true);
                    } else {
                        $federal_departments = json_decode($depts->federal_departments_fr, true);
                    }

                    $department = $federal_departments[$userObj->federal];
                    break;
                case "student":
                case "academic":
                    $institution = $userObj->institution;
                    $department = ($institution == 'university') ? $userObj->university : $userObj->college;
                    break;
                case "provincial":
                    $provObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'provinces',
                    ));
                    $provs = get_entity($provObj[0]->guid);

                    $provinces = array();
                    if (get_current_language() == 'en'){
                        $provinces = json_decode($provs->provinces_en, true);
                    } else {
                        $provinces = json_decode($provs->provinces_fr, true);
                    }

                    $minObj = elgg_get_entities(array(
                        'type' => 'object',
                        'subtype' => 'ministries',
                    ));
                    $mins = get_entity($minObj[0]->guid);

                    $ministries = array();
                    if (get_current_language() == 'en'){
                        $ministries = json_decode($mins->ministries_en, true);
                    } else {
                        $ministries = json_decode($mins->ministries_fr, true);
                    }

                    $department = $provinces[$userObj->provincial];
                    if( $userObj->ministry && $userObj->ministry !== "default_invalid_value" ){
                        $department .= ' / ' . $ministries[$userObj->provincial][$userObj->ministry];
                    }
                    break;
                default:
                    $department = $userObj->$userType;
            }

            $html = '<div class="panel panel-default elgg-module-widget">
            <header class="panel-heading"><div class="clearfix"><h3 class="elgg-widget-title pull-left">' . $title . '</h3></div></header>
            <div class="panel-body clearfix">
            <div class="elgg-widget-content">
            <div class="let_crawler_know_to_ignore_this">
            <div class="col-xs-12 mrgn-tp-sm  clearfix mrgn-bttm-sm">
                <div class="mrgn-tp-sm col-xs-2">';
                if( $display_avatar == 'yes' ){
                    $html .= '<a href="' . elgg_get_site_url() . 'profile/' . $userObj->username . '">
                        <img src="' . $userObj->getIconURL() . '" alt="' . $userObj->getDisplayName() . '" title="' . $userObj->getDisplayName() . '" class="img-responsive img-circle">
                    </a>';
                }
                $html .= '</div>
                <div class="mrgn-tp-sm col-xs-10 noWrap">
                    <span class="mrgn-bttm-0 summary-title">
                        <a href="' . elgg_get_site_url() . 'profile/' . $userObj->username . '" rel="me">' . $userObj->getDisplayName() . '</a>
                    </span>
                    <div class=" mrgn-bttm-sm mrgn-tp-sm timeStamp clearfix">' . $department . '</div>
                </div>
            </div>
            </div>
            </div>
            </div>
            </div>';
        }
    }
    
    return $html;
}
