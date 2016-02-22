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

$remotely = false;
if($mission->remotely == 'on') {
	$remotely = true;
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
$input_type = elgg_view('input/text', array(
		'name' => 'job_type',
		'value' => $mission->job_type,
		'id' => 'edit-mission-type-text-input'
));
$input_number_of = elgg_view('input/dropdown', array(
		'name' => 'number',
		'value' => $mission->number,
		'options' => array(1,2,3,4,5),
		'id' => 'edit-mission-number-dropdown-input'
));
$input_start_date = elgg_view('input/date', array(
		'name' => 'start_date',
		'value' => $mission->start_date,
		'id' => 'edit-mission-start-date-input'
));
$input_completion_date = elgg_view('input/date', array(
		'name' => 'completion_date',
		'value' => $mission->completion_date,
		'id' => 'edit-mission-completion-date-input'
));
$input_deadline = elgg_view('input/date', array(
		'name' => 'deadline',
		'value' => $mission->deadline,
		'id' => 'edit-mission-deadline-date-input'
));
$input_description = elgg_view('input/plaintext', array(
		'name' => 'description',
		'value' => $mission->description,
		'id' => 'edit-mission-description-plaintext-input'
));

$input_remotely = elgg_view('input/checkbox', array(
		'name' => 'remotely',
		'checked' => $remotely,
		'id' => 'edit-mission-remotely-checkbox-input'
));
$input_location = elgg_view('input/text', array(
		'name' => 'location',
		'value' => $mission->location,
		'id' => 'edit-mission-location-text-input'
));
$input_security = elgg_view('input/dropdown', array(
		'name' => 'security',
		'value' => $mission->security,
		'options' => explode(',', elgg_get_plugin_setting('security_string', 'missions')),
		'id' => 'edit-mission-security-dropdown-input'
));
$input_timezone = elgg_view('input/dropdown', array(
		'name' => 'timezone',
		'value' => $mission->timezone,
		'options' => explode(',', elgg_get_plugin_setting('timezone_string', 'missions')),
		'id' => 'edit-mission-timezone-dropdown-input'
));
$input_skills = elgg_view('input/text', array(
		'name' => 'key_skills',
		'value' => $mission->key_skills,
		'id' => 'edit-mission-skills-text-input'
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
		'options' => explode(',', elgg_get_plugin_setting('time_rate_string', 'missions')),
		'id' => 'edit-mission-time-interval-dropdown-input',
		'style' => 'display:inline-block;margin-left:4px;'
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

$time_content .= elgg_view('page/elements/time-table', $vars);

$hidden_guid = elgg_view('input/hidden', array(
    'name' => 'hidden_guid',
    'value' => $mission->guid
));

$button_set = mm_create_button_set_full($mission);
?>

<div class="mission-printer">
	<div>
		<?php echo $hidden_guid; ?>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-title-text-input" style="text-align:right;">
			<?php echo elgg_echo('missions:opportunity_title') . ':';?>
		</label> 
		<div>
			<?php echo $input_title;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-type-text-input" style="text-align:right;">
			<?php echo elgg_echo('missions:opportunity_type') . ':';?>
		</label> 
		<div>
			<?php echo $input_type;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-description-plaintext-input" style="text-align:right;">
			<?php echo elgg_echo('missions:opportunity_type') . ':';?>
		</label> 
		<div>
			<?php echo $input_description;?>
		</div>
	</div>
	</br>
	<div>
		<h4><?php echo elgg_echo('mission:poster_information') . ':'; ?></h4>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-name-text-input" style="text-align:right;">
			<?php echo elgg_echo('missions:manager_name')  . ':';?>
		</label>
		<div>
			<?php echo $input_name;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-department-text-input" style="text-align:right;">
			<?php echo elgg_echo('missions:department')  . ':';?>
		</label> 
		<div class="col-sm-7">
			<?php echo $input_department;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-email-text-input" style="text-align:right;">
			<?php echo elgg_echo('missions:manager_email') . ':';?>
		</label>
		<div>
			<?php echo $input_email;?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3" for="edit-mission-phone-text-input" style="text-align:right;">
			<?php echo elgg_echo('missions:your_phone') . ':';?>
		</label> 
		<div>
			<?php echo $input_phone;?>
		</div>
	</div>
	</br>
	<div>
		<div>
			<h4><?php echo elgg_echo('mission:opportunity_details') . ':'; ?></h4>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-number-dropdown-input" style="text-align:right;">
				<?php echo elgg_echo('missions:opportunity_number')  . ':';?>
			</label> 
			<div>
				<?php echo $input_number_of;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-start-date-input" style="text-align:right;">
				<?php echo elgg_echo('missions:ideal_start_date') . ':';?>
			</label>
			<div>
				<?php echo $input_start_date;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-completion-date-input" style="text-align:right;">
				<?php echo elgg_echo('missions:ideal_completion_date') . ':';?>
			</label>
			<div>
				<?php echo $input_completion_date;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-deadline-date-input" style="text-align:right;">
				<?php echo elgg_echo('missions:deadline') . ':';?>
			</label>
			<div>
				<?php echo $input_deadline;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-remotely-checkbox-input" style="text-align:right;">
				<?php echo elgg_echo('missions:work_remotely') . ':';?>
			</label>
			<div>
				<?php echo $input_remotely;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-location-text-input" style="text-align:right;">
				<?php echo elgg_echo('missions:location') . ':';?>
			</label> 
			<div>
				<?php echo $input_location;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-security-dropdown-input" style="text-align:right;">
				<?php echo elgg_echo('missions:security_level') . ':';?>
			</label> 
			<div>
				<?php echo $input_security;?>
			</div>
		</div>
		<div class="form-group">
			<label for='post-mission-skills-text-input' class="col-sm-3" style="text-align:right;">
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
	</br>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:language_requirements') . ':</br>';?></h5>
	</div>
	<div class="form group">
		<?php echo $languages;?>
	</div>
	</br>
	<div>
		<h5><?php echo elgg_echo('missions:scheduling_requirements') . ':</br>';?></h5>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-time-commitment-text-input" style="text-align:right;">
				<?php echo elgg_echo('missions:time_commitment') . ':';?>
			</label>
			<div>
				<?php echo $input_time_commit . $input_time_interval;?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3" for="edit-mission-timezone-dropdown-input" style="text-align:right;">
				<?php echo elgg_echo('missions:timezone') . ':';?>
			</label>
			<div>
				<?php echo $input_timezone;?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<?php echo $time_content; ?>
	</div>
	</br>
	</br>
	<div>
		<?php
			foreach ($button_set as $value) {
			    echo $value;
			}
		?>
	</div>
</div>

<div style="text-align:right;"> 
	<?php
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:save'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;'
		));
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