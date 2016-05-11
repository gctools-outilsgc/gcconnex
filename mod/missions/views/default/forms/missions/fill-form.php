<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Form which allows a mission manager to add multiple tentative candidates to their mission.
 */
$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$current_guid = array_pop($exploded_uri);
$_SESSION['mid_act'] = $current_guid;

$mission = get_entity($current_guid);
$applicant_list = get_entity_relationships($mission->guid);

// Creates a set of input field equal to the number of opportunities.
for ($i = 0; $i < $mission->number; $i ++) {
    $applicant = '';
    echo '<label for="fill-mission-applicant-' . $i . '-text-input" class="mission-emphasis-extra">' . elgg_echo('missions:applicant') . ' ' . ($i + 1) . ': </label>';
    if($applicant_list[$i]->relationship == 'mission_accepted'){
        $applicant = get_user($applicant_list[$i]->guid_two);
    }
    
    // If there is already a candidate attached to the mission then they will fill one of the spots.
    $readonly = false;
    if($applicant) {
        $readonly = true;
    }
    
    echo '<span class="missions-inline-drop">';
    // Allows input of the candidate's username if the spot is not already filled by another candidate.
    echo elgg_view('input/text', array(
        'name' => 'applicant_' . $i,
        'value' => $applicant->username,
        'class' => 'advanced-text-email',
        'readonly' => $readonly,
        'id' => 'fill-mission-applicant-' . $i . '-text-input'
    ));
    echo '</span>';
    // Creates a button to remove the user if the spot is already filled.
    if($readonly) {
        echo elgg_view('output/url', array(
            'href' => elgg_get_site_url() . 'action/missions/remove-applicant?mission_applicant=' . $applicant->guid,
            'text' => elgg_echo('missions:remove'),
            'is_action' => true,
            'class' => 'elgg-button btn btn-default',
        	'id' => 'fill-mission-applicant-' . $i . '-remove-button'
        ));
    }
}
?>

<div class="form-button"> <?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:add'))); ?> </div>