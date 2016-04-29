<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page to enter a date, time period, and interval.
 */
gatekeeper();

unset($_SESSION['mission_graph_date_array']);
unset($_SESSION['mission_graph_data_array']);
unset($_SESSION['mission_graph_name_array']);

$title = elgg_echo('missions:graph_interval');

if(!mo_get_tree_root()) {
	register_error(elgg_echo('missions:error:no_departments_loaded'));
}

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);

$content .= elgg_view('page/elements/mission-tabs', array(
		'highlight_five' => true
));

//$content .= elgg_echo('missions:graph_interval_paragraph');
$content .= elgg_view_form('missions/graph-interval-form', array(
		'class' => 'form-horizontal'
));

echo elgg_view_page($title, $content);