<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$skill_array = $_SESSION['mission_skill_match_array'];
$skill_set = implode(', ', $skill_array);
unset($_SESSION['mission_skill_match_array']);

// Finds a list of users who have the same skills that were input in the third form.
$user_skill_match = array();
foreach($skill_array as $skill) {
	$options['type'] = 'object';
	$options['subtype'] = 'MySkill';
	$options['attribute_name_value_pairs'] = array(
			'name' => 'title',
			'value' => '%' . $skill . '%',
			'operand' => 'LIKE',
			'case_sensitive' => false
	);
	$skill_match = elgg_get_entities_from_attributes($options);

	foreach($skill_match as $key => $value) {
		$skill_match[$key] = $value->owner_guid;
	}

	if(empty($user_skill_match)) {
		$user_skill_match = $skill_match;
	}
	else {
		$user_skill_match = array_intersect($user_skill_match, $skill_match);
	}
}

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

// Clears all the sticky forms that have been in use so far.
elgg_clear_sticky_form('firstfill');
elgg_clear_sticky_form('secondfill');
elgg_clear_sticky_form('thirdfill');
elgg_clear_sticky_form('ldropfill');
elgg_clear_sticky_form('tdropfill');

unset($_SESSION['tab_context']);

// If the list of users with matching skills returned any results then those results are displayed.
if(count($user_skill_match) > 0) {
	forward(elgg_get_site_url() . 'missions/display-search-set');
}
else {
	system_message('missions:no_skill_matches_found', array($skill_set));
	forward(elgg_get_site_url() . 'missions/main');
}
