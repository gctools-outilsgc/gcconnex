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
$result_set = $_SESSION['candidate_search_set'];

// Simple search form.
$simple_search_form = '<div style="display:inline-block;margin-right:16px;">' . elgg_view_form('missions/search-simple', array(), array(
		'return_to_referer' => true
)) . '</div>';

// Advanced search form which gets hidden.
$advanced_search_form = elgg_view_form('missions/advanced-search-form', array(
		'class' => 'form-horizontal'
), array(
		'return_to_referer' => true
));
$advanced_field = elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:advanced_search'),
		'toggle_id' => 'advanced-search',
		'hidden_content' => $advanced_search_form,
		'field_bordered' => true
));

if($result_set) {
	$search_set = '<h4>' . elgg_echo('missions:search_results') . '</h4>';
	$count = count($result_set);
	$offset = (int) get_input('offset', 0);
	$max = elgg_get_plugin_setting('search_result_per_page', 'missions');

	$search_set .= elgg_view_entity_list(array_slice($result_set, $offset, $max), array(
			'count' => $count,
			'offset' => $offset,
			'limit' => $max,
			'pagination' => true,
			'missions_full_view' => false
	), $offset, $max);
}
?>

<div>
	<?php 
		echo $simple_search_form;
		echo $advanced_field;
	?>
</div>
<div>
	<?php echo $search_set; ?>
</div>