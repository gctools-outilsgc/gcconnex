<?php
/*
* GC-Elgg Read Only Mode 
*
* Read only mode for gcconnex
*
* @author Adi github.com/AdiMakkar
* @version 1.0
*/

elgg_register_event_handler('init', 'system', 'read_only_mode');

function read_only_mode(){
    elgg_register_event_handler('pagesetup', 'system', 'remove_add_buttons');

    elgg_unregister_page_handler('photos');
    elgg_register_page_handler('photos', 'tidypics_read_only');

    elgg_unregister_page_handler('file');
    elgg_register_page_handler('file', 'file_read_only_handler');
}

function remove_add_buttons(){
    $remove_contexts = ['blog', 'discussion', 'bookmarks', 'pages', 'groups'];
    if (in_array(elgg_get_context(), $remove_contexts)) {
        elgg_unregister_menu_item('title', 'add');
    }
}

function init_ajax_block_no_edit($title, $section, $user) {

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

function decommission_message(){
    $site_url = elgg_get_site_url();
    echo "<div class='panel panel-default'>";
    echo "<div class='panel-body'>";
    echo "<div class='col-md-4'><img src='" . $site_url . "mod/wet4/graphics/gcx_deer_in_snow.png' alt='" . elgg_echo('readonly:message') . "'/></div>";
    echo "<div class='col-md-8'>";
    echo "<div class='mrgn-lft-lg'>";
    echo "<div class='mrgn-bttm-md h3 mrgn-tp-0'>" . elgg_echo('readonly:message') . "</div>";
    echo "<div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:1') . "</div>";
    echo "<div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:2') . "</div>";
    echo "<div>" . elgg_echo('readonly:message:3') . "</div>";
    echo "</div>";
    echo "</div></div>";
    echo "</div>";
}
