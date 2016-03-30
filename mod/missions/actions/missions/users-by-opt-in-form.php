<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

elgg_make_sticky_form('useroptfill');

$err = '';
$opt_form = elgg_get_sticky_values('useroptfill');

$option = $opt_form['opt_in_option'];

$name_option = '';
switch($option) {
	case elgg_echo('gcconnex_profile:opt:micro_mission'):
		$name_option = 'opt_in_missions';
		break;
	case elgg_echo('gcconnex_profile:opt:job_swap'):
		$name_option = 'opt_in_swap';
		break;
	case elgg_echo('gcconnex_profile:opt:mentored'):
		$name_option = 'opt_in_mentored';
		break;
	case elgg_echo('gcconnex_profile:opt:mentoring'):
		$name_option = 'opt_in_mentoring';
		break;
	case elgg_echo('gcconnex_profile:opt:shadowed'):
		$name_option = 'opt_in_shadowed';
		break;
	case elgg_echo('gcconnex_profile:opt:shadowing'):
		$name_option = 'opt_in_shadowing';
		break;
	case elgg_echo('gcconnex_profile:opt:peer_coached'):
		$name_option = 'opt_in_peer_coached';
		break;
	case elgg_echo('gcconnex_profile:opt:peer_coaching'):
		$name_option = 'opt_in_peer_coaching';
		break;
	case elgg_echo('gcconnex_profile:opt:skill_sharing'):
		$name_option = 'opt_in_skill_sharing';
		break;
	case elgg_echo('gcconnex_profile:opt:job_sharing'):
		$name_option = 'opt_in_job_sharing';
		break;
}
	
$options_attribute['type'] = 'user';
$options_metadata['metadata_name_value_pairs'] = array(array('name' => $name_option, 'value' => 'gcconnex_profile:opt:yes'));
$options_metadata['limit'] = elgg_get_plugin_setting('search_limit', 'missions');
$options_metadata['metadata_case_sensitive'] = false;
$entities = elgg_get_entities_from_metadata($options_metadata);

$_SESSION['missions_user_by_opt_in_results'] = $entities;

forward(REFERER);