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

$label = elgg_echo('missions:search_for_opportunities');
if($_SESSION['mission_search_switch'] == 'candidate') {
	$label = elgg_echo('missions:search_for_candidates');
}

if (elgg_is_sticky_form('searchsimplefill')) {
    extract(elgg_get_sticky_values('searchsimplefill'));
    elgg_clear_sticky_form('searchsimplefill');
}

$input_simple_text = elgg_view('input/text', array(
    'name' => 'simple',
    'value' => $simple,
    'id' => 'search-mission-simple-text-input'
));
?>

<div class="form-group">
	<h4><label for="search-mission-simple-text-input"><?php echo $label . ':'; ?></label></h4>
	<div style="display:inline-block;vertical-align:middle;">
		<?php echo $input_simple_text; ?> 
	</div>
	<div style="display:inline-block;vertical-align:middle;">
		<?php echo elgg_view('input/submit', array('value' => elgg_echo('missions:search'))); ?>
	</div>
</div>