<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Page content for finding GCconnex users.
 */
$_SESSION['mission_that_invites'] = 0;
$_SESSION['mission_search_switch'] = 'candidate';

$result_set = array();
if(time() > ($_SESSION['candidate_search_set_timestamp'] + elgg_get_plugin_setting('mission_session_variable_timeout', 'missions')) 
		&& $_SESSION['candidate_search_set_timestamp'] != '') {
	system_message(elgg_echo('missions:last_results_have_expired'));
	unset($_SESSION['candidate_search_set']);
	unset($_SESSION['candidate_search_set_timestamp']);
}
else {
	$result_set = $_SESSION['candidate_search_set'];
}

if($_SESSION['candidate_entities_per_page']) {
	$entities_per_page = $_SESSION['candidate_entities_per_page'];
}

// Simple search form.
$simple_search_form = elgg_view_form('missions/search-simple', array(), array(
		'return_to_referer' => true
));

// Advanced search form which gets hidden.
$advanced_search_form = elgg_view_form('missions/advanced-search-form', array(
		'class' => 'form-horizontal'
), array(
		'return_to_referer' => true
));
$advanced_field = elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:advanced_find'),
		'toggle_text_hidden' => elgg_echo('missions:simple_find'),
		'toggle_id' => 'advanced-search',
		'hidden_content' => $advanced_search_form,
		'hideable_pre_content' => $simple_search_form,
		'field_bordered' => true
));

if($result_set) {
	$search_set = '<h4>' . elgg_echo('missions:search_results') . '</h4>';
	$count = count($result_set);
	$offset = (int) get_input('offset', 0);
	if($entities_per_page) {
		$max = $entities_per_page;
	}
	else {
		$max = elgg_get_plugin_setting('search_result_per_page', 'missions');
	}

	$max_reached = '';
	if(($offset + $max) >= elgg_get_plugin_setting('search_limit', 'missions') && $count >= elgg_get_plugin_setting('search_limit', 'missions')) {
		$max_reached = '<div class="col-sm-12" style="font-style:italic;">' . elgg_echo('missions:reached_maximum_entities') . '</div>';
	}

	$search_set .= elgg_view_entity_list(array_slice($result_set, $offset, $max), array(
			'count' => $count,
			'offset' => $offset,
			'limit' => $max,
			'pagination' => true,
			'missions_full_view' => false
	), $offset, $max);
	
	$change_entities_per_page_form = elgg_view_form('missions/change-entities-per-page', array(
			'class' => 'form-horizontal'
	), array(
			'entity_type' => 'candidate',
			'number_per' => $entities_per_page
	));
}
?>

<div>
	<h4><?php echo elgg_echo('missions:find_candidates') . ':'; ?></h4>
	<?php 
		//echo $simple_search_form;
		echo $advanced_field;
	?>
</div>
<?php echo $max_reached; ?>
<div class="col-sm-12">
    
	<?php echo $search_set; ?>
</div>
<div class="col-sm-12">
   
	<?php echo $change_entities_per_page_form; ?>
</div>