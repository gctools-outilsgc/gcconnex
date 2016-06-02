<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Form with a single text input for a simple search.
 */
$simple = get_input('ss');
$limit = get_input('sl');

$limit_options = array(9,18,30,60,120);
$placeholder = elgg_echo('missions:mission_simple_search_placeholder');
$button_text = elgg_echo('missions:search');

if($_SESSION['mission_search_switch'] == 'candidate') {
	$label = elgg_echo('missions:find_candidates');
	$limit_options = array(10,25,50,100);
	$placeholder = elgg_echo('missions:candidate_simple_search_placeholder');
	$button_text = elgg_echo('missions:find');
}

if (elgg_is_sticky_form('searchsimplefill')) {
    extract(elgg_get_sticky_values('searchsimplefill'));
    elgg_clear_sticky_form('searchsimplefill');
}

$input_simple_text = elgg_view('input/text', array(
	    'name' => 'simple',
	    'value' => $simple,
	    'id' => 'search-mission-simple-text-input',
		'placeholder' => $placeholder,
		'style' => 'width:400px;'
));

$input_simple_limit = elgg_view('input/dropdown', array(
		'name' => 'limit',
		'value' => $limit,
		'options' => $limit_options,
		'id' => 'search-mission-limit-dropdown-input'
));

$hidden_input = elgg_view('input/hidden', array(
		'name' => 'hidden_return',
		'value' => $vars['return_to_referer']
));
?>

<?php echo $hidden_input; ?>
<div class="form-group" style="display:inline-block;margin-right:16px;">
	<div style="display:inline-block;vertical-align:middle;">
		<?php echo $input_simple_text; ?> 
	</div>
	<!-- <label for="search-mission-limit-dropdown-input" style="display:inline-block;"><?php //echo elgg_echo('missions:search_limit') . ': '; ?></label>
	<div style="display:inline-block;"><?php //echo $input_simple_limit; ?></div> -->
	<div style="display:inline-block;vertical-align:middle;">
		<?php 
			echo elgg_view('input/submit', array(
					'value' => $button_text,
					'id' => 'mission-simple-search-form-submission-button'
			));
			echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'mission-simple-search-form-submission-button'));
		?>
	</div>
</div>