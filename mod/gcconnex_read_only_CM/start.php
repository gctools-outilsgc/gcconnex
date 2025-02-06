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

function mm_create_button_set_base_CM($mission, $full_view=false) {
	$returner = array();

	if(!$full_view) {
		// Handles the case where a read more button is needed.
		$button_zero = '<div id="read-more-button-mission-' . $mission->guid . '" name="read-more-button" style="display:inline-block;">' . elgg_view('output/url', array(
				'href' => $mission->getURL(),
				'text' => elgg_echo('missions:view').elgg_echo("mission:button:oppurtunity", array($mission->title)),
				'class' => 'elgg-button btn btn-default',
 				'style' => 'margin:2px;'
		)) . '</div>';
	}

	$returner['button_zero'] = $button_zero;
	return $returner;
}

function decommission_message_CM() {

    echo "<div class='panel panel-default'>
        <div class='panel-body'>
            <div class='col-md-4'>
                <img src='" . $site_url . "/mod/gcconnex_read_only_CM/graphics/GCconnex_Decom_Final_Banner.png' alt='" . elgg_echo('readonly:message') . "' />
            </div>
            <div class='col-md-8'>
                <div class='mrgn-lft-lg'>
                    <div class='mrgn-bttm-md h3 mrgn-tp-0'>" . elgg_echo('readonly:message') . "</div>
                    <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:1') . "</div>
                    <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:2') . "</div>
                    <div class='mrgn-bttm-md'>" . elgg_echo('readonly:message:3') . "</div>
                    <div>" . elgg_echo('readonly:message:4') . "</div>
                </div>
            </div>
        </div>
    </div>";
}
