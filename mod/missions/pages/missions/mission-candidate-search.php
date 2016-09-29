<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page to search for a candidate.
 */
gatekeeper();

$_SESSION['mission_search_switch'] = 'candidate';

$current_uri = $_SERVER['REQUEST_URI'];
$blast_radius = explode('/', $current_uri);
$_SESSION['mission_that_invites'] = mm_clean_url_segment(array_pop($blast_radius));
$entity = get_entity($_SESSION['mission_that_invites']);

$title = elgg_echo('missions:invite_to_opportunity');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb(elgg_get_excerpt($entity->job_title, elgg_get_plugin_setting('mission_job_title_card_cutoff', 'missions')), $entity->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view('page/elements/mission-tabs');

$content .= '<h4>' . elgg_echo('missions:find_candidates') . ':' . '</h4>';

$simple_search_form = elgg_view_form('missions/search-simple');

$advanced_search_form = elgg_view_form('missions/advanced-search-form', array(
		'class' => 'form-horizontal'
));
$content .=  elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:advanced_find'),
		'toggle_text_hidden' => elgg_echo('missions:simple_find'),
		'toggle_id' => 'advanced-search',
		'hidden_content' => $advanced_search_form,
		'hideable_pre_content' => $simple_search_form,
		'field_bordered' => true
));

if(!empty($entity->key_skills)){
	// display the user search by skills

	// map for mission type to opt-in
	$typemap = array(
		'missions:micro_mission'	=> 'opt_in_missions',
		'missions:job_swap'	=>	'opt_in_swap',
		'missions:mentoring'	=>	'opt_in_mentored',
		'missions:job_shadowing'	=>	'opt_in_shadowed',
		'missions:assignment'	=> 'opt_in_assignSeek',
		'missions:deployment'	=>	'opt_in_deploySeek',
		'missions:job_rotation'	=>	'opt_in_rotation',
		'missions:skill_share'	=>	'opt_in_ssSeek',
		'missions:peer_coaching'	=>	'opt_in_pcSeek',
		'missions:job_share'	=>	'opt_in_jobshare',
		);

	$dbprefix = elgg_get_config('dbprefix');

	// prepare for query
	$skill_array = $entity->key_skills;
	$skill_array = explode( ',', $skill_array );
	$skillswhere = array();
	foreach($skill_array as $skill) {
		$skillswhere[] = "oe.title LIKE '%$skill%'";
	}
	$skillswhere = implode(' OR ', $skillswhere);
	$skill_subtype_id = get_data("SELECT id FROM {$dbprefix}entity_subtypes WHERE subtype = 'MySkill'");

	// query the database for the ordered + ranked list of users
	$user_match_query =
		"SELECT ue.guid as user_guid, count(DISTINCT oe.guid) as n_skills, count(md.id) as n_endorsments
	FROM {$dbprefix}objects_entity oe
	LEFT JOIN {$dbprefix}entities e ON oe.guid = e.guid
	LEFT JOIN {$dbprefix}users_entity ue ON e.owner_guid = ue.guid
	LEFT JOIN {$dbprefix}metadata md ON md.entity_guid = oe.guid
	WHERE ({$skillswhere})
	AND e.subtype = {$skill_subtype_id[0]->id}
	GROUP BY user_guid ORDER BY n_skills DESC, n_endorsments DESC";

	$user_skill_match = get_data( $user_match_query );

	// Turns the user GUIDs into user entities.
	$temp_opted = array();
	$temp_not_opted = array();
	foreach($user_skill_match as $key => $value) {
		if ( get_entity($value->user_guid)->$typemap[$entity->job_type] == 'gcconnex_profile:opt:yes' )
			$temp_opted[] = get_entity($value->user_guid);
		else
			$temp_not_opted[] = get_entity($value->user_guid);
	}
	$user_skill_match = array_merge( $temp_opted, $temp_not_opted );

	$_SESSION['mission_search_switch'] = 'candidate';
	$_SESSION['candidate_count'] = count($user_skill_match);
	$_SESSION['candidate_search_set'] = $user_skill_match;
	$_SESSION['candidate_search_set_timestamp'] = time();
	$_SESSION['missions_from_skill_match'] = true;

	// from display-search-set
	$search_typing = $_SESSION['mission_search_switch'];

	if($_SESSION[$search_typing . '_entities_per_page']) {
		$entities_per_page = $_SESSION[$search_typing . '_entities_per_page'];
	}

	$sort_missions_form .= elgg_view_form('missions/sort-missions-form', array(
			'class' => 'form-horizontal'
	));
	$sort_field = elgg_view('page/elements/hidden-field', array(
			'toggle_text' => elgg_echo('missions:sort_options'),
			'toggle_text_hidden' => elgg_echo('missions:sort_options'),
			'toggle_id' => 'sort_options',
			'hidden_content' => $sort_missions_form,
			'alignment' => 'left'
	));

	$title = elgg_echo('missions:display_search_results');
	if($search_typing == 'candidate') {
		$title = elgg_echo('missions:display_find_results');
	}

	elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
	elgg_push_breadcrumb($title);

	// Variables to help set up pagination
	$count = $_SESSION[$search_typing . '_count'];
	$offset = (int) get_input('offset', 0);
	if($entities_per_page) {
		$max = $entities_per_page;
	}
	else {
		$max = elgg_get_plugin_setting('search_result_per_page', 'missions');
	}

	// Calls a limited amount of missions for display
	$search_set = array();
	if(time() > ($_SESSION[$search_typing . '_search_set_timestamp'] + elgg_get_plugin_setting('mission_session_variable_timeout', 'missions'))
			&& $_SESSION[$search_typing . '_search_set_timestamp'] != '') {
		system_message(elgg_echo('missions:last_results_have_expired'));
		unset($_SESSION[$search_typing . '_search_set']);
		unset($_SESSION[$search_typing . '_search_set_timestamp']);
	}
	else {
		$search_set = $_SESSION[$search_typing . '_search_set'];
	}

	$list_typing = 'list';
	$list_class = '';
	$item_class = '';

	if($_SESSION['missions_from_skill_match']) {
		unset($_SESSION['missions_from_skill_match']);
		$content .= '<div>' . elgg_echo('missions:placeholder_e') . '</div>';
	}

	if(($offset + $max) >= elgg_get_plugin_setting('search_limit', 'missions') && $count >= elgg_get_plugin_setting('search_limit', 'missions')) {
		$content .= '<div class="col-sm-12" style="font-style:italic;">' . elgg_echo('missions:reached_maximum_entities') . '</div>';
	}

	// Displays the missions as a list with custom class mission-gallery
	$content .= '<div class="col-sm-12 clearfix">' . elgg_view_entity_list(array_slice($search_set, $offset, $max), array(
		    'count' => $count,
		    'offset' => $offset,
		    'limit' => $max,
		    'pagination' => true,
		    'list_type' => $list_typing,
		    'gallery_class' => $list_class,
	        'item_class'=>$item_class,
			'missions_full_view' => false
	), $offset, $max) . '</div>';

	$content .= '<div hidden name="mission-total-count">' . $count . '</div>';

	$content .= '<div class="col-sm-12">' . elgg_view_form('missions/change-entities-per-page', array(
			'class' => 'form-horizontal'
	), array(
			'entity_type' => $search_typing,
			'number_per' => $entities_per_page
	)) . '</div>';
	// end display-search-set
}

echo elgg_view_page($title, $content);
