<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Page which displays the results of a users search, simple or advanced.
 */
gatekeeper();
$search_form = elgg_get_sticky_values('searchsimplefill');
$search_typing = $_SESSION['mission_search_switch'];
$advanced_form = elgg_get_sticky_values('advancedfill');
$number_of_rows = elgg_get_plugin_setting('advanced_element_limit', 'missions');

if($_SESSION[$search_typing . '_entities_per_page']) {
	$entities_per_page = $_SESSION[$search_typing . '_entities_per_page'];
}

$sort_missions_form .= elgg_view_form('missions/sort-missions-form', array(
		'class' => 'form-horizontal'
));

$opp_type_field = $_SESSION['missions_type_field_value'];
$role_type_field = $_SESSION['missions_role_field_value'];

if ($opp_type_field || $role_type_field) {
    $clear_link = elgg_view('output/url', array(
		'text' => elgg_echo('missions:clear_filter'),
		'href' => 'action/missions/sort-missions-form?opp_filter=&role_filter=',
		'class' => 'mrgn-lft-sm',
		'is_action' => true,
		'is_trusted' => true,
	));
}

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
if($search_typing == 'mission') {
    $list_typing = 'gallery';
    $list_class = 'mission-gallery wb-eqht clearfix';
    $item_class = 'col-sm-4';
}else{
	$list_class = 'candidate-holder clearfix';
	$item_class = "col-sm-3 candidate-panel";
}

// Function which sorts the search set according to a given value in ascending or descending order.
$search_set = mm_sort_mission_decider($_SESSION['missions_sort_field_value'], $_SESSION['missions_order_field_value'], $search_set, $_SESSION['missions_type_field_value'], $_SESSION['missions_role_field_value']);
$count = count($search_set);		// count the filtered list
if ( $offset >= $count )			// reset offset if it no longer makes sense after filtering
	$offset = 0;

$max_reached = '';
if(($offset + $max) >= elgg_get_plugin_setting('search_limit', 'missions') && $count >= elgg_get_plugin_setting('search_limit', 'missions')) {
	$max_reached = '<div class="col-sm-12" style="font-style:italic;">' . elgg_echo('missions:reached_maximum_entities') . '</div>';
}

$content = elgg_view_title($title);

if($_SESSION['missions_from_skill_match']) {
	unset($_SESSION['missions_from_skill_match']);
	$content .= '<div>' . elgg_echo('missions:placeholder_e') . '</div>';
}

$content .= elgg_view('page/elements/mission-tabs') . $max_reached;

if ($search_form ) {
    
	$content .= '<div style="clear:both">'.elgg_view_form('missions/search-simple').'</div>';
}

 $search_fields = array(
	        //'' => 'Choose',
	        '',
	        elgg_echo('missions:title'),
	        elgg_echo('missions:type'),
	        elgg_echo('missions:department'),
	        elgg_echo('missions:key_skills'),
	        elgg_echo('missions:security_clearance'),
	        elgg_echo('missions:location'),
	        elgg_echo('missions:language'),
	        elgg_echo('missions:time'),
	        elgg_echo('missions:period'),
	        elgg_echo('missions:start_time'),
	        elgg_echo('missions:duration'),
	        elgg_echo('missions:work_remotely'),
	        elgg_echo('missions:program_area')
    );

if ($advanced_form){
	$form_name = $_SESSION['mission_search_switch'];
	$content .='<div class="mrgn-bttm-sm"><strong>'.elgg_echo('missions:search_value').':</strong> ';
	for ($s = 0; $s < $number_of_rows; $s ++) {
		if ($advanced_form[$form_name.'_'.$s]){

			$content .= '<span class="mrgn-rght-md"><strong>'.elgg_echo($advanced_form[$form_name.'_'.$s]).':</strong> '.elgg_echo($advanced_form[$form_name.'_'.$s.'_element']).'</span>';

		}
	}

	$content .= "</div>";
	$content .= elgg_view('output/url', array(
		'text' => elgg_echo('missions:clear_search'),
		'href' => 'missions/main?clear=true&search='.$advanced_form,
		'class' => 'mrgn-lft-sm',
		'is_action' => true,
		'is_trusted' => true,
	));
    
	// Advanced search form which gets hidden.
	$advanced_search_form = elgg_view_form('missions/advanced-search-form', array(
		'class' => 'form-horizontal'
	));
	$content .= '<br>'.elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:search:Refine'),
		'toggle_text_hidden' => elgg_echo('close'),
		'toggle_id' => 'advanced-search',
		'hidden_content' => $advanced_search_form,
		'hideable_pre_content' => $simple_search_form,
		'field_bordered' => true
	));
}

// Only displays sort form if the search set is missions.
if($search_typing == 'mission') {
	$content .= '<div class="col-sm-12 mrgn-tp-lg">' . $sort_missions_form . $clear_link . '</div>';
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

echo elgg_view_page($title, $content);