<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
$department_string = $_SESSION['missions_pass_department_to_second_form'];
$ancestor_array = mo_get_all_ancestors($department_string);
$progenitor = get_entity($ancestor_array[0]);

$department_abbr = $progenitor->abbr;
if(get_current_language() == 'fr') {
	$department_abbr = $progenitor->abbr_french;
}

$job_title = get_input('sjt');
$job_type = get_input('sty');
$job_area = get_input('sja');
$number = get_input('sn');
$start_date = get_input('ssd');
$completion_date = get_input('scd');
$key_skills = get_input('sks');
$deadline = get_input('sd');
$description = get_input('sdesc');
$openess = get_input('so');

if (elgg_is_sticky_form('secondfill')) {
    extract(elgg_get_sticky_values('secondfill'));
    // elgg_clear_sticky_form('secondfill');
}

if($openess == 'on') {
	$openess = true;
}
else {
	$openess = false;
}

$duplicating_entity = get_entity($_SESSION['mission_duplication_id']);
if(get_subtype_from_id($duplicating_entity->subtype) == 'mission') {
	$job_title = $duplicating_entity->job_title;
	$job_type = $duplicating_entity->job_type;
	$job_area = $duplicating_entity->program_area;
	$number = $duplicating_entity->number;
	$description = $duplicating_entity->descriptor;
	$openess = $duplicating_entity->openess;
	
	$start_date = false;
	$completion_date = false;
	$deadline = false;
}

$input_title = elgg_view('input/text', array(
	    'name' => 'job_title',
	    'value' => $job_title,
	    'id' => 'post-mission-title-text-input'
));

$input_type = elgg_view('input/dropdown', array(
	    'name' => 'job_type',
	    'value' => $job_type,
		'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('opportunity_type_string', 'missions')),
	    'id' => 'post-mission-type-dropdown-input'
));

$sort_areas = mm_echo_explode_setting_string(elgg_get_plugin_setting('program_area_string', 'missions'));
asort($sort_areas);
$sort_areas['missions:other'] = elgg_echo('missions:other');
if(array_search($job_area, $sort_areas)) {
	$initial_value = $job_area;
	$other_value = '';
}
else {
	$initial_value = 'missions:other';
	$other_value = $other_text;
}
$input_area = elgg_view('input/dropdown', array(
	    'name' => 'job_area',
	    'value' => $job_area,
		'options_values' => $sort_areas,
	    'id' => 'post-mission-area-dropdown-input'
));
$input_other_area = elgg_view('page/elements/other-text-input', array(
		'parent_id' => 'post-mission-area-dropdown-input',
		'value_override' => $other_value
));

$input_number_of = elgg_view('input/dropdown', array(
	    'name' => 'number',
	    'value' => $number,
	    'options' => array(1,2,3,4,5),
	    'id' => 'post-mission-number-dropdown-input'
));

$input_start_date = elgg_view('input/date', array(
	    'name' => 'start_date',
	    'value' => $start_date,
	    'id' => 'post-mission-start-date-input'
));

$input_completion_date = elgg_view('input/date', array(
	    'name' => 'completion_date',
	    'value' => $completion_date,
	    'id' => 'post-mission-completion-date-input'
));

$input_deadline = elgg_view('input/date', array(
	    'name' => 'deadline',
	    'value' => $deadline,
	    'id' => 'post-mission-deadline-date-input'
));

$input_description = elgg_view('input/plaintext', array(
	    'name' => 'description',
	    'value' => $description,
	    'id' => 'post-mission-description-plaintext-input'
));

$input_openess = elgg_view('input/checkbox', array(
	    'name' => 'openess',
	    'checked' => $openess,
	    'id' => 'post-mission-openess-checkbox-input'
));

if($department_abbr) {
	$openess_string = elgg_echo('missions:openess_sentence', array(strtoupper($department_abbr)));
}
else {
	$openess_string = elgg_echo('missions:openess_sentence_generic');
}
?>

<h4><?php echo elgg_echo('missions:second_post_form_title'); ?></h4></br>
<div class="form-group">
	<label for='post-mission-title-text-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:opportunity_title') . '*:';?>
	</label>
	<div class="col-sm-5">
		<?php echo $input_title; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-type-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:opportunity_type') . '*:';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_type; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-area-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:program_area') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_area; ?>
		<?php echo $input_other_area; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-number-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:opportunity_number') . '*:';?>
	</label>
	<div class="col-sm-1">
		<?php echo $input_number_of; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-start-date-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:ideal_start_date') . '*:';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_start_date; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-completion-date-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:ideal_completion_date') . '*:';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_completion_date; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-deadline-date-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:application_deadline') . '*:';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_deadline; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-description-plaintext-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:opportunity_description') . ':';?>
	</label>
	<div class="col-sm-7">
		<?php echo $input_description; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-openess-checkbox-input' class="col-sm-3" style="text-align:right;">
		<?php echo $openess_string;?>
	</label>
	<div class="col-sm-7">
		<?php echo $input_openess; ?>
	</div>
</div>

<div> 
	<?php
		echo elgg_view('output/url', array(
				'href' => elgg_get_site_url() . 'missions/mission-post/step-one',
				'text' => elgg_echo('missions:back'),
				'class' => 'elgg-button btn btn-default',
				'id' => 'mission-post-opportunity-second-form-back-button'
		));
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:next'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;',
				'id' => 'mission-post-opportunity-second-form-submission-button'
		)); 
	?> 
</div>