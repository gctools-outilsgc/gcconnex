<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

gatekeeper();

$result_set = $_SESSION['missions_user_by_opt_in_results'];
//unset($_SESSION['missions_user_by_opt_in_results']);

$title = elgg_echo('missions:users_by_opt_in');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view('page/elements/mission-tabs');

$content .= elgg_view_form('missions/users-by-opt-in-form', array(
		'class' => 'form-horizontal'
)) . '<br>';

if($result_set) {
	$count = count($result_set);
	$offset = (int) get_input('offset', 0);
	$max = elgg_get_plugin_setting('search_result_per_page', 'missions');
	
	$content .= elgg_view_entity_list(array_slice($result_set, $offset, $max), array(
			'count' => $count,
			'offset' => $offset,
			'limit' => $max,
			'pagination' => true,
			'missions_full_view' => false
	), $offset, $max);
}

echo elgg_view_page($title, $content);