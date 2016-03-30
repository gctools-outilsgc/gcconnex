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
$input_area = elgg_view('input/dropdown', array(
	    'name' => 'job_area',
	    'value' => $job_area,
		'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('program_area_string', 'missions')),
	    'id' => 'post-mission-area-dropdown-input'
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
		<?php echo elgg_echo('missions:openess_sentence', array(strtoupper($department_abbr)));?>
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