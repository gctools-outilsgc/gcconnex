<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * Form which allows a manager to modify their mission.
 * This form includes all the same input fields as the post opportunity forms and they are formatted similarly..
 */
$mission = $vars['entity'];
$unpacked = mm_unpack_mission($mission);
$vars['mission_metadata'] = $unpacked;
elgg_load_js('typeahead');
elgg_load_js('missions_flot');

$department_string = $mission->department;
$ancestor_array = mo_get_all_ancestors($department_string);
$progenitor = get_entity($ancestor_array[0]);

$department_abbr = $progenitor->abbr;
if(get_current_language() == 'fr') {
	$department_abbr = $progenitor->abbr_french;
}

$remotely = false;
if($mission->remotely == 'on') {
	$remotely = true;
}
$openess = false;
if($mission->openess == 'on') {
	$openess = true;
}

$max_applicants = elgg_get_plugin_setting('mission_max_applicants', 'missions');
$max_array = array();
for($i=1;$i<=$max_applicants;$i++) {
	$max_array[$i-1] = $i;
}

$input_name = elgg_view('input/text', array(
	    'name' => 'name',
	    'value' => $mission->name,
	    'id' => 'edit-mission-name-text-input'
));

$input_department = elgg_view('page/elements/organization-input', array(
		'organization_string' => $mission->department
));

$input_email = elgg_view('input/text', array(
	    'name' => 'email',
	    'value' => $mission->email,
	    'id' => 'edit-mission-email-text-input'
));

$input_phone = elgg_view('input/text', array(
    	'name' => 'phone',
	    'value' => $mission->phone,
	    'id' => 'edit-mission-phone-text-input'
));

$input_title = elgg_view('input/text', array(
		'name' => 'job_title',
		'value' => $mission->job_title,
		'id' => 'edit-mission-title-text-input'
));

$input_type = elgg_view('input/dropdown', array(
		'name' => 'job_type',
		'value' => $mission->job_type,
		'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('opportunity_type_string', 'missions')),
		'id' => 'edit-mission-type-dropdown-input'
));

$sort_areas = mm_echo_explode_setting_string(elgg_get_plugin_setting('program_area_string', 'missions'));
asort($sort_areas);
$sort_areas['missions:other'] = elgg_echo('missions:other');
if(array_key_exists($mission->program_area, $sort_areas)) {
	$initial_value = $mission->program_area;
	$other_value = '';
}
else {
	$initial_value = 'missions:other';
	$other_value = $mission->program_area;
}
$input_area = elgg_view('input/dropdown', array(
	    'name' => 'job_area',
	    'value' => $initial_value,
		'options_values' => $sort_areas,
	    'id' => 'edit-mission-area-dropdown-input'
));
$input_other_area = elgg_view('page/elements/other-text-input', array(
		'parent_id' => 'edit-mission-area-dropdown-input',
		'value_override' => $other_value
));

$input_number_of = elgg_view('input/dropdown', array(
		'name' => 'number',
		'value' => $mission->number,
		'options' => $max_array,
		'id' => 'edit-mission-number-dropdown-input'
));

$input_start_date = elgg_view('input/date', array(
		'name' => 'start_date',
		'value' => $mission->start_date,
		'id' => 'edit-mission-start-date-input',
		'placeholder' => 'yyyy-mm-dd'
));

$input_completion_date = elgg_view('input/date', array(
		'name' => 'completion_date',
		'value' => $mission->completion_date,
		'id' => 'edit-mission-completion-date-input',
		'placeholder' => 'yyyy-mm-dd'
));

$input_deadline = elgg_view('input/date', array(
		'name' => 'deadline',
		'value' => $mission->deadline,
		'id' => 'edit-mission-deadline-date-input',
		'placeholder' => 'yyyy-mm-dd'
));

$input_description = elgg_view('input/longtext', array(
		'name' => 'description',
		'value' => $mission->description,
		'id' => 'edit-mission-description-plaintext-input'
));

$input_openess = elgg_view('input/checkbox', array(
	    'name' => 'openess',
	    'checked' => $openess,
	    'id' => 'edit-mission-openess-checkbox-input'
));

$input_remotely = elgg_view('input/checkbox', array(
		'name' => 'remotely',
		'checked' => $remotely,
		'id' => 'edit-mission-remotely-checkbox-input'
));

$input_location = elgg_view('input/dropdown', array(
		'name' => 'location',
		'value' => $mission->location,
	    'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('province_string', 'missions')),
		'id' => 'edit-mission-location-dropdown-input'
));

$input_security = elgg_view('input/dropdown', array(
		'name' => 'security',
		'value' => $mission->security,
		'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('security_string', 'missions')),
		'id' => 'edit-mission-security-dropdown-input'
));

$input_timezone = elgg_view('input/dropdown', array(
		'name' => 'timezone',
		'value' => $mission->timezone,
		'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('timezone_string', 'missions')),
		'id' => 'edit-mission-timezone-dropdown-input'
));

$input_time_commit = elgg_view('input/text', array(
		'name' => 'time_commitment',
		'value' => $mission->time_commitment,
		'id' => 'edit-mission-time-commitment-text-input',
		'style' => 'display:inline-block;max-width:75px;'
));

$input_time_interval = elgg_view('input/dropdown', array(
		'name' => 'time_interval',
		'value' => $mission->time_interval,
		'options_values' => mm_echo_explode_setting_string(elgg_get_plugin_setting('time_rate_string', 'missions')),
		'id' => 'edit-mission-time-interval-dropdown-input',
		'style' => 'display:inline-block;margin-left:4px;'
));

//Nick - adding group and level to the edit
$input_gl_group = elgg_view('input/dropdown', array(
	'name'=>'group',
	'value'=>$mission->gl_group,
	'options'=> mm_echo_explode_setting_string(elgg_get_plugin_setting('gl_group_string', 'missions')),
	'id'=>'post-mission-gl-group',
	'class'=>'',
));

$skill_set = '';
$skill_array = explode(', ', $mission->key_skills);
foreach($skill_array as $skill) {
	$skill_set .= elgg_view('missions/add-skill', array('value' => $skill));
}

$add_skill_button = elgg_view('output/url', array(
		'text' => ' ' . elgg_echo('missions:add'),
		'class' => 'elgg-button btn fa fa-plus-circle',
		'id' => 'add-skill-button',
		'onclick' => 'add_skill_field()'
));

$languages = elgg_view('page/elements/language-dropdown', $vars);

$time_content = elgg_view('page/elements/time-table', $vars);

if($department_abbr) {
	$openess_string = elgg_echo('missions:openess_sentence', array(strtoupper($department_abbr)));
}
else {
	$openess_string = elgg_echo('missions:openess_sentence_generic');
}

$hidden_guid = elgg_view('input/hidden', array(
    'name' => 'hidden_guid',
    'value' => $mission->guid
));

$button_set = mm_create_button_set_full($mission);
?>

<div class="row clearfix">
	<div>
		<?php echo $hidden_guid; ?>
	</div>
	<div class="form-group">
		<label class="col-sm-3 required" for="edit-mission-title-text-input" style="text-align:right;" aria-required="true">
			<?php echo elgg_echo('missions:opportunity_title'); ?>
			<strong class="required" aria-required="true">
				<?php echo elgg_echo('missions:required'); ?>
			</strong>
			:
		</label>
		<div class="col-sm-3">
			<?php echo $input_title;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-type-dropdown-input" style="text-align:right;">
			<?php echo elgg_echo('missions:opportunity_type') . ':';?>
		</label>
		<div class="col-sm-3">
			<?php echo $input_type;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-description-plaintext-input" style="text-align:right;">
			<?php echo elgg_echo('missions:opportunity_description') . ':';?>
		</label>
		<div class="col-sm-7">
			<?php echo $input_description;?>
		</div>
	</div>
	<br>
	<div>
		<h4><?php echo elgg_echo('mission:manager_information') . ':'; ?></h4>
	</div>
	<div class="form-group">
		<label class="col-sm-3 required" for="edit-mission-name-text-input" style="text-align:right;" aria-required="true">
			<?php echo elgg_echo('missions:manager_name');?>
			<strong class="required" aria-required="true">
				<?php echo elgg_echo('missions:required'); ?>
			</strong>
			:
		</label>
		<div class="col-sm-3">
			<?php echo $input_name;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 required" style="text-align:right;" aria-required="true">
			<?php echo elgg_echo('missions:department');?>
			<strong class="required" aria-required="true">
				<?php echo elgg_echo('missions:required'); ?>
			</strong>
			:
		</label>
		<div class="col-sm-5">
			<?php echo $input_department;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 required" for="edit-mission-email-text-input" style="text-align:right;" aria-required="true">
			<?php echo elgg_echo('missions:manager_email');?>
			<strong class="required" aria-required="true">
				<?php echo elgg_echo('missions:required'); ?>
			</strong>
			:
		</label>
		<div class="col-sm-3">
			<?php echo $input_email;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-phone-text-input" style="text-align:right;">
			<?php echo elgg_echo('missions:your_phone') . ':';?>
		</label>
		<div class="col-sm-3">
			<?php echo $input_phone;?>
		</div>
	</div>
	<br>
	<div>
		<div>
			<h4><?php echo elgg_echo('mission:opportunity_details') . ':'; ?></h4>
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
					<input class="form-control" id="numeric1" name="level" type="number" data-rule-digits="true" min="1" max="10" step="1" value="<?php echo $mission->gl_level; /*Nick - put the value in the input*/?>"/>
				</div>

			</div>
			<script>
					$('#post-mission-gl-group').change(function(){
						$('#numeric1').val('1');
					})
			</script>
		</div>


		<div class="form-group">
			<label for='edit-mission-area-dropdown-input' class="col-sm-3" style="text-align:right;">
				<?php echo elgg_echo('missions:program_area') . ':';?>
			</label>
			<div class="col-sm-3">
				<?php echo $input_area; ?>
				<?php echo $input_other_area; ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-number-dropdown-input" style="text-align:right;">
				<?php echo elgg_echo('missions:opportunity_number')  . ':';?>
			</label>
			<div class="col-sm-3">
				<?php echo $input_number_of;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 required" for="edit-mission-start-date-input" style="text-align:right;" aria-required="true">
				<?php echo elgg_echo('missions:ideal_start_date');?>
			<strong class="required" aria-required="true">
				<?php echo elgg_echo('missions:required'); ?>
			</strong>
			:
			</label>
			<div class="col-sm-3">
				<?php echo $input_start_date;?>
			</div>
			<div class="fa fa-calendar fa-lg"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-completion-date-input" style="text-align:right;">
				<?php echo elgg_echo('missions:ideal_completion_date') . ':';?>
			</label>
			<div class="col-sm-3">
				<?php echo $input_completion_date;?>
			</div>
			<div class="fa fa-calendar fa-lg"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 required" for="edit-mission-deadline-date-input" style="text-align:right;" aria-required="true">
				<?php echo elgg_echo('missions:deadline');?>
			<strong class="required" aria-required="true">
				<?php echo elgg_echo('missions:required'); ?>
			</strong>
			:
			</label>
			<div class="col-sm-3">
				<?php echo $input_deadline;?>
			</div>
			<div class="fa fa-calendar fa-lg"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-remotely-checkbox-input" style="text-align:right;">
				<?php echo elgg_echo('missions:work_remotely') . ':';?>
			</label>
			<div class="col-sm-3">
				<?php echo $input_remotely;?>
			</div>
		</div>
		<div class="form-group">
			<label for='edit-mission-openess-checkbox-input' class="col-sm-3" style="text-align:right;">
				<?php echo $openess_string;?>
			</label>
			<div class="col-sm-7">
				<?php echo $input_openess; ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 required" for="edit-mission-location-dropdown-input" style="text-align:right;" aria-required="true">
				<?php echo elgg_echo('missions:location') . ':';?>
				<strong class="required" aria-required="true">
					<?php echo elgg_echo('missions:required'); ?>
				</strong>
				:
			</label>
			<div class="col-sm-3">
				<?php echo $input_location;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-security-dropdown-input" style="text-align:right;">
				<?php echo elgg_echo('missions:security_level') . ':';?>
			</label>
			<div class="col-sm-3">
				<?php echo $input_security;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" style="text-align:right;">
				<?php echo elgg_echo('missions:skills') . ':';?>
			</label>
			<div class="col-sm-9">
				<div id="mission-skill-container" style="display:inline-block;">
				<?php echo $skill_set; ?>
				</div>
				<div>
					<?php echo $add_skill_button; ?>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div>
		<h5><?php echo elgg_echo('missions:language_requirements') . ':';?></h5>
		<div class="form group">
			<?php echo $languages;?>
		</div>
	</div>
	<br>
	<div>
		<h5><?php echo elgg_echo('missions:scheduling_requirements') . ':';?></h5>
		<div class="form-group">
			<label class="col-sm-3 required" for="edit-mission-time-commitment-text-input" style="text-align:right;" aria-required="true">
				<?php echo elgg_echo('missions:time_in_hours');?>
			<strong class="required" aria-required="true">
				<?php echo elgg_echo('missions:required'); ?>
			</strong>
			:
			</label>
			<div class="col-sm-1">
				<?php echo $input_time_commit; ?>
			</div>
			<div class="col-sm-2">
				<?php echo $input_time_interval; ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-timezone-dropdown-input" style="text-align:right;">
				<?php echo elgg_echo('missions:timezone') . ':';?>
			</label>
			<div class="col-sm-3">
				<?php echo $input_timezone;?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<?php echo $time_content; ?>
	</div>
	<br>
</div>

<div style="float:left;display:inline">
	<?php
		foreach ($button_set as $value) {
			echo $value;
		}
	?>
</div>
<div style="float:right;display:inline;">
	<?php
		echo elgg_view('output/url', array(
				'href' => $_SERVER['HTTP_REFERER'],
				'text' => elgg_echo('missions:cancel_changes'),
				'class' => 'elgg-button btn btn-danger',
				'id' => 'mission-edit-form-cancel-changes-button',
				'style' => 'margin-right:8px;'
		));

		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:save'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;',
				'id' => 'mission-edit-form-submission-button'
		));
		echo elgg_view('page/elements/one-click-restrictor', array('restricted_element_id' => 'mission-edit-form-submission-button'));
	?>
</div>

<script>
	function add_skill_field() {
		elgg.get('ajax/view/missions/add-skill', {
			success: function(result, success, xhr) {
				$("#mission-skill-container").append(result);
			}
		});
	}
</script>
