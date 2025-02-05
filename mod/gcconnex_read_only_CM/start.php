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
	$button_one = null;
	$button_two = null;
	$button_three = null;
	$button_four = null;

	if(!$full_view) {
		// Handles the case where a read more button is needed.
		$button_zero = '<div id="read-more-button-mission-' . $mission->guid . '" name="read-more-button" style="display:inline-block;">' . elgg_view('output/url', array(
				'href' => $mission->getURL(),
				'text' => elgg_echo('missions:view').elgg_echo("mission:button:oppurtunity", array($mission->title)),
				'class' => 'elgg-button btn btn-default',
 				'style' => 'margin:2px;'
		)) . '</div>';

		// Handles the case where an edit button is needed.
		// This overwrites the read more button.
        //Nick - letting site admins have access to edit/ deactivate missions

		// EDIT 
		
		//  if(($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid() || elgg_is_admin_logged_in())
		//  		&& $mission->state != 'completed' && $mission->state != 'cancelled') {
		//  	$button_one = '<div id="edit-button-mission-' . $mission->guid . '" name="edit-button" style="display:inline-block;">' . elgg_view('output/url', array(
		//  			'href' => elgg_get_site_url() . 'missions/mission-edit/' . $mission->guid,
		//  			'text' => elgg_echo('missions:edit').elgg_echo("mission:button:oppurtunity", array($mission->title)),
		//  			'class' => 'elgg-button btn btn-primary',
 		//  			'style' => 'margin:2px;'
		//  	)) . '</div>';
		//  }
	}

	//if($mission->state == 'completed' || $mission->state == 'cancelled' || $mission->owner_guid != elgg_get_logged_in_user_guid()) {
		// Creates the share button which is always present.

		// SHARE 

		// $button_two = '<div id="share-button-mission-' . $mission->guid . '" name="share-button" style="display:inline-block;">' . elgg_view('output/url', array(
		// 		'href' => elgg_get_site_url() . 'missions/message-share/' . $mission->guid,
		// 		'text' => elgg_echo('missions:share').elgg_echo("mission:button:oppurtunity", array($mission->title)),
		// 		'class' => 'elgg-button btn btn-default',
 		// 		'style' => 'margin:2px;'
		// )) . '</div>';
	//}

	// Logic to handle the third button.
	if($mission->state != 'completed' && $mission->state != 'cancelled') {
		if ($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid()) {
			$candidate_total = count(elgg_get_entities_from_relationship(array(
					'relationship' => 'mission_accepted',
					'relationship_guid' => $mission->guid
			)));

			// FIND

			// $button_three ='<div id="invite-button-mission-' . $mission->guid . '" name="invite-button" style="display:inline-block;">' .  elgg_view('output/url', array(
			// 		'href' => elgg_get_site_url() . 'missions/mission-candidate-search/' . $mission->guid,
			// 		'text' => elgg_echo('missions:find').elgg_echo("mission:button:find", array($mission->title)),
			// 		'class' => 'elgg-button btn btn-success',
 			// 		'style' => 'margin:2px;'
			// )) . '</div>';

			// Handles the case where a complete button is needed.
			if(!$full_view && $candidate_total == $mission->number) {
				$button_three = '<div id="complete-button-mission-' . $mission->guid . '" name="complete-button" style="display:inline-block;">' . elgg_view('output/url', array(
						'href' => elgg_get_site_url() . 'action/missions/complete-mission?mission_guid=' . $mission->guid,
						'text' => elgg_echo('missions:complete').elgg_echo("mission:button:oppurtunity", array($mission->title)),
		            	'is_action' => true,
						'class' => 'elgg-button btn btn-success',
						'confirm' => elgg_echo('missions:confirm:complete_mission'),
 						'style' => 'margin:2px;'
				)) . '</div>';
			}
		}
		else {
			$relationship_count = elgg_get_entities_from_relationship(array(
					'relationship' => 'mission_accepted',
					'relationship_guid' => $mission->guid,
					'count' => true
			));

			// APPLY

			if($relationship_count < $mission->number) {
				$user = elgg_get_logged_in_user_entity();
				$mmdep = trim( explode('/', $mission->department_path_english)[0] );
				// if( $mission->role_type != 'missions:seeking'){
				// 	if ((!$mission->openess || stripos( $user->department, $mmdep ) !== false) && ($mission->role_type != 'missions:seeking')){
				// 		$button_three = '<div id="apply-button-mission-' . $mission->guid . '" name="apply-button" style="display:inline-block;">' . $apply_button = elgg_view('output/url', array(
				// 				'href' => elgg_get_site_url() . 'missions/mission-application/' . $mission->guid,
				// 				'text' => elgg_echo('missions:apply').elgg_echo("mission:button:apply", array($mission->title)),
				// 				'class' => 'elgg-button btn btn-primary',
				// 				'style' => 'margin:2px;'
				// 		)) . '</div>';
				// 	}
				// }	
			}

			if(check_entity_relationship($mission->guid, 'mission_tentative', elgg_get_logged_in_user_guid())) {
				$button_three = '<div id="accept-button-mission-' . $mission->guid . '" name="accept-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/accept-invite?applicant=' . elgg_get_logged_in_user_guid() . '&mission=' . $mission->guid,
					'text' => elgg_echo('missions:accept').elgg_echo("mission:button:oppurtunity", array($mission->title)),
					'is_action' => true,
					'class' => 'elgg-button btn btn-success',
 					'style' => 'margin:2px;'
				)) . '</div>';
				$button_four = '<div id="decline-button-mission-' . $mission->guid . '" name="decline-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/reason-to-decline/' . $mission->guid,
					'text' => elgg_echo('missions:decline').elgg_echo("mission:button:oppurtunity", array($mission->title)),
					'class' => 'elgg-button btn btn-danger',
 					'style' => 'margin:2px;'
				)) . '</div>';
				$button_two = null;
			}

			if(check_entity_relationship($mission->guid, 'mission_offered', elgg_get_logged_in_user_guid())) {
				$button_three = '<div id="final-accept-button-mission-' . $mission->guid . '" name="final-accept-button" style="display:inline-block;">' . mm_finalize_button($mission, elgg_get_logged_in_user_entity()) . '</div>';
				$button_four = '<div id="decline-button-mission-' . $mission->guid . '" name="decline-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/reason-to-decline/' . $mission->guid,
					'text' => elgg_echo('missions:decline').elgg_echo("mission:button:oppurtunity", array($mission->title)),
					'class' => 'elgg-button btn btn-danger',
 					'style' => 'margin:2px;'
				)) . '</div>';
				$button_two = null;
			}

			if(check_entity_relationship($mission->guid, 'mission_accepted', elgg_get_logged_in_user_guid()) ||
					check_entity_relationship($mission->guid, 'mission_applied', elgg_get_logged_in_user_guid())) {
				$button_three = '<div id="withdraw-button-mission-' . $mission->guid . '" name="withdraw-button" style="display:inline-block;">' . elgg_view('output/url', array(
						'href' => elgg_get_site_url() . 'missions/reason-to-decline/' . $mission->guid,
						'text' => elgg_echo('missions:withdraw').elgg_echo("mission:button:withdraw", array($mission->title)),
						'class' => 'elgg-button btn btn-danger',
 						'style' => 'margin:2px;'
				)) . '</div>';
			}
		}
	}
	else {
		if(check_if_opted_in(elgg_get_logged_in_user_entity())) {
			$button_three = '<div id="duplicate-button-mission-' . $mission->guid . '" name="duplicate-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'action/missions/duplicate-mission?mid=' . $mission->guid,
					'text' => elgg_echo('missions:duplicate').elgg_echo("mission:button:oppurtunity", array($mission->title)),
					'is_action' => true,
					'class' => 'elgg-button btn btn-success',
	 				'style' => 'margin:2px;'
			)) . '</div>';
		}

        //Nick - Adding the option for admins to delete and edit archived missions
        if(elgg_is_admin_logged_in()){
            $returner['edit_button'] = '<div id="edit-button-mission-' . $mission->guid . '" name="edit-button" style="display:inline-block;">' . elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-edit/' . $mission->guid,
					'text' => elgg_echo('missions:edit').elgg_echo("mission:button:oppurtunity", array($mission->title)),
					'class' => 'elgg-button btn btn-primary',
 					'style' => 'margin:2px;'
			)) . '</div>';

            $button_four = '<div id="delete-button-mission-' . $mission->guid . '" name="delete-button" style="display:inline-block;">' . elgg_view('output/url', array(
                        'href' => elgg_get_site_url() . 'action/missions/delete-mission?mission_guid=' . $mission->guid,
                        'text' => elgg_echo('missions:delete').elgg_echo("mission:button:oppurtunity", array($mission->title)),
                        'is_action' => true,
                        'class' => 'elgg-button btn btn-danger',
                        'style' => 'margin:2px;'
                )) . '</div>';
        }

	}

	$returner['button_zero'] = $button_zero;
	$returner['button_one'] = $button_one;
	$returner['button_two'] = $button_two;
	$returner['button_three'] = $button_three;
	$returner['button_four'] = $button_four;
	return $returner;
}

function mm_create_button_set_full_CM($mission) {
    $returner = mm_create_button_set_base_CM($mission, true);

    // Button to revert the state of a mission to posted.
    if (($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid())
            && ($mission->state == 'completed' || $mission->state == 'cancelled')
            && elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {
        $returner['reopen_button'] = '<div id="reopen-button-mission-' . $mission->guid . '" name="reopen-button" style="display:inline-block;">' . elgg_view('output/url', array(
                'href' => elgg_get_site_url() . 'action/missions/reopen-mission?mission_guid=' . $mission->guid,
                'text' => elgg_echo('missions:reopen'),
                'is_action' => true,
                'class' => 'elgg-button btn btn-default',
                'style' => 'margin:2px;'
        )) . '</div>';
    }

    // Button to advance the mission state to cancelled from posted.
    if (($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid() ||elgg_is_admin_logged_in())
            && $mission->state != 'cancelled' && $mission->state != 'completed') {
        $candidate_total = count(elgg_get_entities_from_relationship(array(
                'relationship' => 'mission_accepted',
                'relationship_guid' => $mission->guid
        )));

        $disabled = true;
        if($candidate_total > 0) {
            $disabled = false;
        }

       // COMPLETE 

    //     $returner['complete_button'] = '<div id="complete-button-mission-' . $mission->guid . '" name="complete-button" style="display:inline-block;">' . elgg_view('output/url', array(
    //             'href' => elgg_get_site_url() . 'action/missions/complete-mission?mission_guid=' . $mission->guid,
    //             'text' => elgg_echo('missions:complete'),
    //             'is_action' => true,
    //             'class' => 'elgg-button btn btn-success',
    //              'disabled' => $disabled,
    //              'confirm' => elgg_echo('missions:confirm:complete_mission'),
    //              'style' => 'margin:2px;'
    //    )) . '</div>';

       // DEACTIVATE

        // $returner['cancel_button'] = '<div id="cancel-button-mission-' . $mission->guid . '" name="cancel-button" style="display:inline-block;">' . elgg_view('output/url', array(
        //         'href' => elgg_get_site_url() . 'action/missions/cancel-mission?mission_guid=' . $mission->guid,
        //         'text' => elgg_echo('missions:deactivate'),
        //         'is_action' => true,
        //         'class' => 'elgg-button btn btn-danger',
        //         'confirm' => elgg_echo('missions:confirm:cancel_mission'),
        //         'style' => 'margin:2px;'
        // )) . '</div>';

       // EDIT 

    //    $returner['edit_button'] = '<div id="edit-button-mission-' . $mission->guid . '" name="edit-button" style="display:inline-block;">' . elgg_view('output/url', array(
    //                'href' => elgg_get_site_url() . 'missions/mission-edit/' . $mission->guid,
    //                'text' => elgg_echo('missions:edit'),
    //                'class' => 'elgg-button btn btn-primary',
    //                 'style' => 'margin:2px;'
    //        )) . '</div>';
    }

   // DELETE

    if(($mission->owner_guid == elgg_get_logged_in_user_guid() || $mission->account == elgg_get_logged_in_user_guid())
            && elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {
        // $returner['delete_button'] = '<div id="delete-button-mission-' . $mission->guid . '" name="delete-button" style="display:inline-block;">' . elgg_view('output/url', array(
        //         'href' => elgg_get_site_url() . 'action/missions/delete-mission?mission_guid=' . $mission->guid,
        //         'text' => elgg_echo('missions:delete'),
        //         'is_action' => true,
        //         'class' => 'elgg-button btn btn-danger',
        //         'style' => 'margin:2px;'
        // )) . '</div>';
    }
    //Nick - adding the ability for site admins to delete missions from the edit page
    //They don't want deleting to be an option for users for the sake of analytics
    //Only admins can delete missions if need be (ex inapropriate content)
    if(elgg_is_admin_logged_in()){

        // DELETE FOR ADMINS 

        // $returner['delete_button'] = '<div id="delete-button-mission-' . $mission->guid . '" name="delete-button" style="display:inline-block;">' . elgg_view('output/url', array(
        //             'href' => elgg_get_site_url() . 'action/missions/delete-mission?mission_guid=' . $mission->guid,
        //             'text' => elgg_echo('missions:delete'),
        //             'is_action' => true,
        //             'class' => 'elgg-button btn btn-danger',
        //             'style' => 'margin:2px;'
        //     )) . '</div>';
    }

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
