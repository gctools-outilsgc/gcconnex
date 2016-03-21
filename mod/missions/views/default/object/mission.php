<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * View for the mission entity.
 */ 
gatekeeper();

$mission = $vars['entity'];
$button_override = $vars['override_buttons'];
$full_view = $vars['mission_full_view'];
$current_uri = $_SERVER['REQUEST_URI'];
$current_guid = $mission->guid;
$_SESSION['mid_act'] = $current_guid;

// Decides an whether to use the expanded view or not
if (!$full_view && strpos($current_uri, 'view/' . $mission->guid) === false) {
    echo elgg_view('page/elements/print-mission', array(
        'entity' => $mission,
        'full_view' => false,
        'override_buttons' => $button_override
    ));
} else {
	elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
	elgg_push_breadcrumb($mission->job_title);
	
    $content = elgg_view('page/elements/print-mission-more', array(
        'entity' => $mission,
        'full_view' => true,
        'override_buttons' => $button_override
    ));
    
    $content .= elgg_view('page/elements/related-candidates', array(
    		'entity' => $mission
    ));
    
    echo $content;
}
?>