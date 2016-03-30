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

if($current_user->opt_in_missions != 'gcconnex_profile:opt:yes') {
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
	
	// The opted in main page has a regular view and a my missions view.
	switch($last_segment) {
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
	
	$navigation_tabs = array(
			array(
					'text' => elgg_echo('missions:find_opportunity'),
					'href' => elgg_get_site_url() . 'missions/main/find',
					'selected' => $highlight_one,
					'id' => 'mission-navigate-to-find-opportunity'
			),
			array(
					'text' => elgg_echo('missions:find_members'),
					'href' => elgg_get_site_url() . 'missions/main/members',
					'selected' => $highlight_three,
					'id' => 'mission-navigate-to-member-search'
			),
			array(
					'text' => elgg_echo('missions:my_opportunities'),
					'href' => elgg_get_site_url() . 'missions/main/mine',
					'selected' => $highlight_two,
					'id' => 'mission-navigate-to-my-opportunities'
			),
			array(
					'text' => elgg_echo('missions:archive'),
					'href' => elgg_get_site_url() . 'missions/archive',
					'id' => 'mission-navigate-to-archive'
			),
			array(
					'text' => elgg_echo('missions:analytics'),
					'href' => elgg_get_site_url() . 'missions/graph-interval',
					'id' => 'mission-navigate-to-analytics'
			)/*,
			array(
					'text' => elgg_echo('missions:users_by_opt_in'),
					'href' => elgg_get_site_url() . 'missions/users-by-opt-in',
					'id' => 'mission-navigate-to-users-by-opt-in'
			)*/
	);
	
	$content .= elgg_view('navigation/tabs', array(
			'class' => 'elgg-menu elgg-menu-filter list-inline mrgn-lft-sm elgg-menu-filter-default mission-tab',
			'tabs' => $navigation_tabs
	));
	
	// Links to the post opportunity pages.
	if($last_segment != 'members') {
		$content .= elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'missions/mission-post',
				'text' => elgg_echo('missions:create_opportunity'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;',
				'id' => 'mission-create-opportunity-button'
		)) . '</br>';
	}
	
	$content .= $main_content;
	
	if(elgg_get_plugin_setting('mission_developer_tools_on', 'missions') == 'YES') {
		// Opt out button.
		$content .= '</br><div>' . elgg_view('output/url', array(
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