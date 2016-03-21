<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Wrap the user profile details in divs for css styling and for jQuery elements (edit/save/cancel controls below)
 * Requires: Sections must be pre-populated in the $sections array below. The view for that section must be registered in start.php, and the file has
 * to be in lowercases, named the same as what you populate $sections with, but replacing spaces with dashes.
 * IE: "About Me" becomes "about-me.php"
 */
elgg_load_js('typeahead');
elgg_load_js('gcconnex-profile'); // js file for handling the edit/save/cancel toggles
elgg_load_css('gcconnex-css'); // main css styling sheet
elgg_load_css('font-awesome'); // font-awesome icons for social media and some of the basic profile fields
elgg_load_js('lightbox'); // overlay for editing the basic profile fields
elgg_load_css('lightbox'); // css for it..
elgg_load_js('basic-profile'); // load js file to init the lightbox overlay (sets the width)
//elgg_load_js('bootstrap-tour');
//elgg_load_css('bootstrap-tour-css');
?>

<div class="profile">
    <div class="clearfix panel-custom panel">
        <?php //echo elgg_view('profile/owner_block'); ?>
        <?php echo elgg_view('profile/details'); ?>
    </div>

    
    <div class="gcconnex-profile-wire-post">
        <?php $user = get_user(elgg_get_page_owner_guid());
            $params = array(
                'type' => 'object',
                'subtype' => 'thewire',
                'owner_guid' => $user->guid,
                'limit' => 1,
            );
        $latest_wire = elgg_get_entities($params);
        if ($latest_wire && count($latest_wire) > 0) {
            //echo '<img class="profile-icons double-quotes" src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/double-quotes.png">';
            //echo elgg_view("profile/status", array("entity" => $user));
        }
        ?>
    </div>
    
   <?php //echo elgg_get_context(); 
    
    

?>
    
    <div class="b_extended_profile">
        <?php

        echo '<div role="tabpanel">';
/* Old Tab Menu
        
        echo '<ul class="nav nav-tabs" role="tablist">';
        echo '<li role="presentation" class="active"><a href="#profile-display" aria-controls="profile-display" role="tab" data-toggle="tab">' . elgg_echo('gcconnex_profile:profile') . '</a></li>';
        echo '<li role="presentation" ><a href="#splashboard" aria-controls="splashboard" role="tab" data-toggle="tab">' . elgg_echo('gcconnex_profile:widgets') . '</a></li>';
        echo '<li role="presentation"><a href="#portfolio" aria-controls="portfolio" role="tab" data-toggle="tab">' . elgg_echo('gcconnex_profile:portfolio') . '</a></li>';
        echo '</ul>';
        */

        //add additional tabs
        echo elgg_view('groups/profile/tab_menu');

        echo '<div class="tab-content">';
            echo '<div role="tabpanel" class="tab-pane active" id="profile-display">';

        if ( has_content($user, 'description') ) {
            init_ajax_block(elgg_echo('gcconnex_profile:about_me'), 'about-me', $user);
            echo elgg_view('b_extended_profile/about-me');
            finit_ajax_block('about-me');
        }

        if ( has_content($user, 'education') ) {
            init_ajax_block(elgg_echo('gcconnex_profile:education'), 'education', $user);
            echo elgg_view('b_extended_profile/education');
            finit_ajax_block('education');
        }

        if ( has_content($user, 'work') ) {
            init_ajax_block(elgg_echo('gcconnex_profile:experience'), 'work-experience', $user);
            echo elgg_view('b_extended_profile/work-experience');
            finit_ajax_block('work-experience');
        }
		
        /*
         * MODIFIED CODE
         * Constructs the opt-in section according to the original plugin methodology.
         */
        if(elgg_is_active_plugin('missions') && $user->opt_in_missions == 'gcconnex_profile:opt:yes') {
        	echo elgg_view('missions/completed-missions');
        }
        /*
         * END MODIFIED CODE
         */
        
        if(elgg_is_logged_in()){
            if ( has_content($user, 'gc_skills') ) {
                init_ajax_block(elgg_echo('gcconnex_profile:gc_skills'), 'skills', $user);
                echo elgg_view('b_extended_profile/skills');
                finit_ajax_block('skills');
            }
        }

        if ( has_content($user, 'english') || has_content($user, 'french') ) {
            init_ajax_block(elgg_echo('gcconnex_profile:sle'), 'languages', $user);
            echo elgg_view('b_extended_profile/languages');
            finit_ajax_block('languages');
        }
        
        /*
         * MODIFIED CODE
         * Constructs the opt-in section according to the original plugin methodology.
         */
        if(has_content($user, 'opt-in')) {
        	init_ajax_block(elgg_echo('gcconnex_profile:opt:opt-in'), 'opt-in', $user);
        	echo elgg_view('b_extended_profile/opt-in');
        	finit_ajax_block('opt-in');
        }
        /*
         * END MODIFIED CODE
         */
        
        // create the div wrappers and edit/save/cancel toggles for each profile section

            echo '</div>'; //close div id=#profile-display


            echo '<div role="tabpanel" class="tab-pane" id="splashboard">';

                $num_columns = elgg_extract('num_columns', $vars, 2);
                $show_add_widgets = elgg_extract('show_add_widgets', $vars, true);
                $exact_match = elgg_extract('exact_match', $vars, false);
                $show_access = elgg_extract('show_access', $vars, true);

                $owner = elgg_get_page_owner_entity();

                $widget_types = elgg_get_widget_types();

                $context = elgg_get_context();
                elgg_push_context('widgets');

                $widgets = elgg_get_widgets($owner->guid, $context);

                if (elgg_can_edit_widget_layout($context)) {

                    $params = array(
                        'widgets' => $widgets,
                        'context' => $context,
                        'exact_match' => $exact_match,
                        'show_access' => $show_access,
                    );
                    echo elgg_view('page/layouts/widgets/add_panel', $params);
                }
                if (elgg_can_edit_widget_layout($context)) {
                    if ($show_add_widgets) {
                        echo elgg_view('page/layouts/widgets/add_button');
                    }

                    $params = array(
                        'widgets' => $widgets,
                        'context' => $context,
                        'exact_match' => $exact_match,
                    );
                    echo elgg_view('page/layouts/widgets/add_panel', $params);
                }
                $widget_class = "elgg-col-1of{$num_columns}";
                for ($column_index = 1; $column_index <= $num_columns; $column_index++) {
                    if (isset($widgets[$column_index])) {
                        $column_widgets = $widgets[$column_index];
                    } else {
                        $column_widgets = array();
                    }

                    echo "<div class=\"$widget_class elgg-widgets col-sm-6 col-xs-12 widget-area-col\" id=\"elgg-widget-col-$column_index\">";
                    if (sizeof($column_widgets) > 0) {
                        foreach ($column_widgets as $widget) {
                            if (array_key_exists($widget->handler, $widget_types)) {
                                echo elgg_view_entity($widget, array('show_access' => $show_access));
                            }
                        }
                    }
                    echo '</div>';
                }
            echo '</div>'; // close div id="splashboard"


            echo '<div role="tabpanel" class="tab-pane" id="portfolio">';

                init_ajax_block(elgg_echo('gcconnex_profile:portfolio'), 'portfolio', $user);
                echo elgg_view('b_extended_profile/portfolio'); // call the proper view for the section
                finit_ajax_block('portfolio');
            echo '</div>'; // close div id="#portfolio"

            //add tab panels with preview content
            echo elgg_view('profile/tab-content');

            echo '</div>'; // close div class="tab-content'
        echo '</div>'; // close div role="tabpanel"
        ?>
    </div>
</div>