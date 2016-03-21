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

$title = elgg_echo('missions:candidate_search');

elgg_push_breadcrumb(elgg_echo('missions:micromissions'), elgg_get_site_url() . 'missions/main');
elgg_push_breadcrumb($entity->job_title, $entity->getURL());
elgg_push_breadcrumb($title);

$content = elgg_view_title($title);
$content .= '<div style="display:inline-block;margin-right:16px;">' . elgg_view_form('missions/search-simple') . '</div>';

$advanced_search_form = elgg_view_form('missions/advanced-search-form', array(
		'class' => 'form-horizontal'
));
$content .=  elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:filter_search'),
		'toggle_id' => 'advanced-search',
		'hidden_content' => $advanced_search_form,
		'field_bordered' => true
));

echo elgg_view_page($title, $content);