<?php
/*
* GC-Elgg Read Only Mode CM
*
* Read only mode for gcconnex CM 
*
* @author Adi github.com/AdiMakkar
* @version 1.0
*/

elgg_register_event_handler('init', 'system', 'read_only_mode_CM');

function read_only_mode_CM(){
	elgg_unregister_page_handler('missions');

	elgg_register_page_handler('missions', 'mm_create_button_set_base_CM');

}

function init_ajax_block_no_edit_CM($title, $section, $user) {

    switch($section){
        case 'about-me':
            $field = elgg_echo('gcconnex_profile:about_me');
            break;
        case 'education':
            $field = elgg_echo('gcconnex_profile:education');
            break;
        case 'work-experience':
            $field = elgg_echo('gcconnex_profile:experience');
            break;
        case 'skills':
            $field = elgg_echo('gcconnex_profile:gc_skills');
            break;
        case 'languages':
            $field = elgg_echo('gcconnex_profile:langs');
            break;
        case 'portfolio':
            $field = elgg_echo('gcconnex_profile:portfolio');
            break;
    }

    echo '<div class="panel">';
    echo'<div class="panel-body profile-title">';
    echo '<h2 class="pull-left">' . $title . '</h2>'; // create the profile section title

    echo '</div>';
     // create the profile section wrapper div for css styling
    echo '<div id="edit-' . $section . '" tabindex="-1" class="gcconnex-profile-section-wrapper panel-body gcconnex-' . $section . '">';
}

