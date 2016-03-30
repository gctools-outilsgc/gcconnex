<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$opt_in_option = get_input('uo');

if (elgg_is_sticky_form('useroptfill')) {
	extract(elgg_get_sticky_values('useroptfill'));
	//elgg_clear_sticky_form('useroptfill');
}

$input_dropdown = elgg_view('input/dropdown', array(
		'name' => 'opt_in_option',
        'value' => $opt_in_option,
        'options' => array(
        		elgg_echo('gcconnex_profile:opt:micro_mission'), 
        		elgg_echo('gcconnex_profile:opt:job_swap'), 
        		elgg_echo('gcconnex_profile:opt:mentored'),
        		elgg_echo('gcconnex_profile:opt:mentoring'),
        		elgg_echo('gcconnex_profile:opt:shadowed'),
        		elgg_echo('gcconnex_profile:opt:shadowing'),
        		elgg_echo('gcconnex_profile:opt:peer_coached'),
        		elgg_echo('gcconnex_profile:opt:peer_coaching'),
        		elgg_echo('gcconnex_profile:opt:skill_sharing'),
        		elgg_echo('gcconnex_profile:opt:job_sharing')
        )
));
?>

<div class="form-group">
	<h4 style="display:inline-block;"><label for="search-user-opt-in-dropdown-input"><?php echo elgg_echo('missions:opt_in_option') . ':'; ?></label></h4>
	<div style="display:inline-block;vertical-align:middle;">
		<?php echo $input_dropdown; ?> 
	</div>
	<div style="display:inline-block;vertical-align:middle;">
		<?php 
			echo elgg_view('input/submit', array(
					'value' => elgg_echo('missions:search'),
					'id' => 'mission-user-opt-in-form-submission-button'
			)); 
		?>
	</div>
</div>