<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * User display within the context of the micro missions plugin.
 */
$user = $vars['user'];
$feedback_string = '';
if(time() > ($_SESSION['candidate_search_feedback_timestamp'] + elgg_get_plugin_setting('mission_session_variable_timeout', 'missions')) 
		&& $_SESSION['candidate_search_feedback_timestamp'] != '') {
	unset($_SESSION['candidate_search_feedback'][$user->guid]);
	unset($_SESSION['candidate_search_feedback_timestamp']);
}
else {
	$feedback_string = $_SESSION['candidate_search_feedback'][$user->guid];
}

$mission_guid = $_SESSION['mission_that_invites'];

// Creates a gray background if the user is not opted in to micro missions.
$background_content = '';
if(!check_if_opted_in($user)) {
	$background_content = 'style="background-color:#efefef;"';
}

$user_link = elgg_view('output/url', array(
	    'href' => $user->getURL(),
	    'text' => $user->name
));

// Displays search feedback from simple search.
$feedback_content = '';
if($feedback_string != '') {
	$feedback_content = '<h4 class="mrgn-tp-sm mrgn-bttm-sm">' . elgg_echo('missions:user_matched_by') . ':</h4>';
	$count = 1;
    $feedback_array = explode(',', $feedback_string);
    
    foreach($feedback_array as $feedback) {
        if($feedback) {
            $feedback_content .= '<div class="mrgn-lft-md" name="search-feedback-' . $count . '">' . $feedback . '</div>';
        }
        $count++;
    }
}

$options['type'] = 'object';
$options['subtype'] = 'MySkill';
$options['owner_guid'] = $user->guid;
$user_skills = elgg_get_entities($options);

$skill_set = '';
$count = 1;
foreach($user_skills as $skill) {
	$skill_set .= '<span name="user-skill-' . $count . '" class="mission-skills">' . $skill->title . '</span>';
	$count++;
}

// Displays invitation button if the user is opted in to micro missions.
$button_content = '';
if(check_if_opted_in($user)) {
	if($mission_guid != 0) {
		$mission = get_entity($mission_guid);
		if($user->guid != $mission->owner_guid && $user->guid != $mission->account) {
			if(!check_entity_relationship($mission->guid, 'mission_tentative', $user->guid)
					&& !check_entity_relationship($mission->guid, 'mission_applied', $user->guid)
					&& !check_entity_relationship($mission->guid, 'mission_accepted', $user->guid)) {
				$button_content = elgg_view('output/url', array(
				        'href' => elgg_get_site_url() . 'action/missions/invite-user?aid=' . $user->guid . '&mid=' . $mission_guid,
				        'text' => elgg_echo('missions:invite_user_to_mission'),
						'is_action' => true,
				        'class' => 'elgg-button btn btn-default'
			    ));
			}
			else {
				$button_content .= elgg_view('output/url', array(
				        'href' => '',
				        'text' => elgg_echo('missions:already_invited'),
				        'class' => 'elgg-button btn btn-default',
						'disabled' => true
			    ));
			}
		}
	}
	else {
		if($user->guid != elgg_get_logged_in_user_guid()) {
			/*$button_content = elgg_view('output/url', array(
					'href' => elgg_get_site_url() . 'missions/mission-select-invite/' . $user->guid,
					'text' => elgg_echo('missions:invite_user_to_mission'),
					'class' => 'elgg-button btn btn-default'
			));*/
			$button_content = elgg_view_form('missions/mission-invite-selector', array(
			    	'class' => 'form-horizontal'
			), array(
			    	'candidate_guid' => $user->guid
			));
		}
	}
}
else {
	$button_content = elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'missions/message-share/' . $user->guid,
			'text' => elgg_echo('missions:invite_to_opt_in'),
			'class' => 'elgg-button btn btn-default'
	));
}
?>

<div class="col-xs-12 mrgn-tp-sm" <?php echo $background_content; ?>>
	<div class="col-xs-6">
		<div class="col-xs-2 mrgn-tp-sm">
			<?php echo elgg_view_entity_icon($user, 'medium'); ?>
		</div>
		<div class="col-xs-8">
			<h3 name="user-name" class="mrgn-tp-sm"><?php echo $user_link; ?></h3>
			<div name="user-job-title"><?php echo $user->job; ?></div>
			<div name="user-location"><?php echo $user->location; ?></div>
			
			<div>
				<?php echo $skill_set; ?>
			</div>
		</div>
		
	</div>
	<div class="col-xs-4">
		<?php echo $feedback_content; ?>
	</div>
    <div class="col-xs-2">
        <?php echo $button_content; ?>
    </div>
</div>