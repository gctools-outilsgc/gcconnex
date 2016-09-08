<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
// This sends users who are not logged in back to the gcconnex login page
gatekeeper();
$_SESSION['mission_search_switch'] = 'mission';

$current_uri = $_SERVER['REQUEST_URI'];
$current_user = get_entity(elgg_get_logged_in_user_guid());

$title = elgg_echo('missions:micromissions');

$content = elgg_view_title($title);

elgg_push_breadcrumb($title);

if(!check_if_opted_in($current_user)) {
	// Splash page for users not opted in to micro missions.
	$content .= elgg_view('page/elements/main-splash');
}
else {
	// Selects the last section of the current URI.
	$current_uri = $_SERVER['REQUEST_URI'];
	$exploded_uri = explode('/', $current_uri);
	$last_segment = array_pop($exploded_uri);
	$last_segment = mm_clean_url_segment($last_segment);
	
	$highlight_one = false;
	$highlight_two = false;
	$highlight_three = false;
	$highlight_four = false;
	$highlight_five = false;
	
	// The opted in main page has a regular view and a my missions view.
	switch($last_segment) {
		case 'analytics':
			$main_content = elgg_view('page/elements/main-analytics');
			$highlight_five = true;
			break;
		case 'archive':
			$main_content = elgg_view('page/elements/main-archive');
			$highlight_four = true;
			break;
		case 'members':
			$main_content = elgg_view('page/elements/main-members');
			$highlight_three = true;
			break;
		case 'mine':
			$main_content = elgg_view('page/elements/main-mine');
			$highlight_two = true;
			break;
		default:
			$main_content = elgg_view('page/elements/main-find');
			$highlight_one = true;
	}
	
	$content .= '<div class="panel panel-default mission-info-card">' . elgg_echo('missions:placeholder_a') . '</div>';
	
	$content .= elgg_view('page/elements/mission-tabs', array(
			'highlight_one' => $highlight_one,
			'highlight_two' => $highlight_two,
			'highlight_three' => $highlight_three,
			'highlight_four' => $highlight_four,
			'highlight_five' => $highlight_five
	));
	
	// Links to the post opportunity pages.
	//if($last_segment != 'members' && $last_segment != 'archive' && $last_segment != 'analytics') {
		/*$content .= '<div class="col-sm-12" style="margin-top:16px;margin-bottom:16px;">' . elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/missions/pre-create-opportunity',
				'text' => elgg_echo('missions:create_opportunity'),
				'is_action' => true,
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;',
				'id' => 'mission-create-opportunity-button'
		)) . '</div>';*/
	//}
	
	$content .= $main_content;
	
	$content .= '<div>' . elgg_echo('missions:placeholder_b') . '</div>';
	
	if(elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {
		// Opt out button.
		$content .= '<br><div>' . elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'action/missions/opt-from-main',
				'text' => elgg_echo('missions:opt_out'),
				'is_action' => true,
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;',
				'id' => 'mission-opt-out-button'
		)) . '</div>';
	}
}

// Displays the page with the given title and body
echo elgg_view_page($title, $content);