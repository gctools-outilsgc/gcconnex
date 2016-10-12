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
}

if($openess == 'on') {
	$openess = true;
}
else {
	$openess = false;
}

$max_applicants = elgg_get_plugin_setting('mission_max_applicants', 'missions');
$max_array = array();
for($i=1;$i<=$max_applicants;$i++) {
	$max_array[$i-1] = $i;
}

$duplicating_entity = get_entity($_SESSION['mission_duplication_id']);
if(get_subtype_from_id($duplicating_entity->subtype) == 'mission' && !$_SESSION['mission_duplicating_override_second']) {
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
if(array_key_exists($job_area, $sort_areas)) {
	$initial_value = $job_area;
	$other_value = '';
}
else {
	$initial_value = 'missions:other';
	$other_value = $other_text;
}
$input_area = elgg_view('input/dropdown', array(
	    'name' => 'job_area',
	    'value' => $initial_value,
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
	    'options' => $max_array,
	    'id' => 'post-mission-number-dropdown-input'
));

$input_start_date = elgg_view('input/date', array(
	    'name' => 'start_date',
	    'value' => $start_date,
	    'id' => 'post-mission-start-date-input',
		'placeholder' => 'yyyy-mm-dd'
));

$input_completion_date = elgg_view('input/date', array(
	    'name' => 'completion_date',
	    'value' => $completion_date,
	    'id' => 'post-mission-completion-date-input',
		'placeholder' => 'yyyy-mm-dd'
));

$input_deadline = elgg_view('input/date', array(
	    'name' => 'deadline',
	    'value' => $deadline,
	    'id' => 'post-mission-deadline-date-input',
		'placeholder' => 'yyyy-mm-dd'
));

$input_description = elgg_view('input/longtext', array(
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

//Nick - adding group and level
//Dropdown for group

$input_gl_group = elgg_view('input/dropdown', array(
	'name'=>'group',
	'value'=>'gl_group',
	'options'=> mm_echo_explode_setting_string(elgg_get_plugin_setting('gl_group_string', 'missions')),
	'id'=>'post-mission-gl-group',
	'class'=>'',
    'disabled'=>true,

));

?>

<h4><?php echo elgg_echo('missions:second_post_form_title'); ?></h4><br>
<div class="form-group">
	<label for='post-mission-title-text-input' class="col-sm-3 required" style="text-align:right;" aria-required="true">
		<?php echo elgg_echo('missions:opportunity_title');?>
		<strong class="required" aria-required="true">
			<?php echo elgg_echo('missions:required'); ?>
		</strong>
		:
	</label>
	<div class="col-sm-5">
		<?php echo $input_title; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-type-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:opportunity_type') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_type; ?>
		<div><?php echo elgg_echo('missions:placeholder_j'); ?></div>
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
	<label for='post-mission-gl-group' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:groupandlevel') . ':';?>
	</label>
	<div class="col-sm-3">
		<div class="col-sm-6">
			<label for="post-mission-gl-group"><?php echo elgg_echo('missions:gl:group'); ?></label>
			<?php echo $input_gl_group;
			?>
		</div>
		<div class="col-sm-6">
			<label for="numeric1"><?php echo elgg_echo('missions:gl:level'); ?></label>
			<input class="form-control" id="numeric1" name="level" type="number" data-rule-digits="true" min="1" max="10" step="1" disabled/>
		</div>

	</div>
	<script>
        $('#post-mission-type-dropdown-input').change(function () {
            //Nick - this makes it so micromissions cannot have a group and level 
            var value = $(this).val();
            if (value !== 'missions:micro_mission') {
                $('#post-mission-gl-group').removeAttr('disabled');
                $('#numeric1').removeAttr('disabled');
            } else {//Deactivate and clear the group and level inputs
                $('#post-mission-gl-group').attr('disabled', true);
                $('#post-mission-gl-group').val('');
                $('#numeric1').attr('disabled', true);
                $('#numeric1').val('');

            }
        });

			$('#post-mission-gl-group').change(function(){
				$('#numeric1').val('1');
			})
	</script>
</div>

<div class="form-group">
	<label for='post-mission-number-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:opportunity_number') . ': ';?>
	</label>
	<div class="col-sm-1">
		<?php echo $input_number_of; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-start-date-input' class="col-sm-3 required" style="text-align:right;" aria-required="true">
		<?php echo elgg_echo('missions:ideal_start_date');?>
		<strong class="required" aria-required="true">
			<?php echo elgg_echo('missions:required'); ?>
		</strong>
		:
	</label>
	<div class="col-sm-3">
		<?php echo $input_start_date; ?>
	</div>
	<div class="fa fa-calendar fa-lg"></div>
</div>
<div class="form-group">
	<label for='post-mission-completion-date-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:ideal_completion_date') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_completion_date; ?>
	</div>
	<div class="fa fa-calendar fa-lg"></div>
</div>
<div class="form-group">
	<label for='post-mission-deadline-date-input' class="col-sm-3 required" style="text-align:right;" aria-required="true">
		<?php echo elgg_echo('missions:deadline');?>
		<strong class="required" aria-required="true">
			<?php echo elgg_echo('missions:required'); ?>
		</strong>
		:
	</label>
	<div class="col-sm-3">
		<?php echo $input_deadline; ?>
	</div>
	<div class="fa fa-calendar fa-lg"></div>
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
