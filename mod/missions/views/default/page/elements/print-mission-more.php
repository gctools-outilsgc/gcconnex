<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This view displays the full scope of metadata attached to mission objects.
 * This view extends the print-mission view element.
 */
$mission = '';
$full_view = '';
if (isset($vars['entity'])) {
    $mission = $vars['entity'];
}
if (isset($vars['full_view'])) {
    $full_view = $vars['full_view'];
}

$department_string = $mission->department;
$ancestor_array = mo_get_all_ancestors($department_string);
$progenitor = get_entity($ancestor_array[0]);

$department_abbr = $progenitor->abbr;
if(get_current_language() == 'fr') {
	$department_abbr = $progenitor->abbr_french;
}

// Clean up several variables to make sure that something is displayed if they are null.
$clean_phone = elgg_echo('missions:none_given');
$clean_security = elgg_echo('missions:none_required');
$clean_skills = elgg_echo('missions:none_given');
$clean_timezone = elgg_echo('missions:none_given');
$clean_remotely = elgg_echo('missions:no');
$clean_openess = elgg_echo('missions:no');
if(!empty($mission->phone)) {
    $clean_phone = $mission->phone;
}
if(!empty($mission->security)) {
    $clean_security = elgg_echo($mission->security);
}
if(!empty($mission->key_skills)) {
    $clean_skills = $mission->key_skills;
}
if(!empty($mission->timezone)) {
	$clean_timezone =  $mission->timezone;
}
if(!empty($mission->remotely)) {
	$clean_remotely = elgg_echo('missions:yes');
}
if(!empty($mission->openess)) {
	$clean_openess = elgg_echo('missions:yes');
}

$department_path = $mission->department_path_english;
if(get_current_language() == 'fr') {
	$department_path = $mission->department_path_french;
}

// Unpacks all language and time metadata attached to the mission.
$unpacked_array = mm_unpack_mission($mission);

// Sets up the display for language metadata.
$unpacked_language = '';
if (! empty($unpacked_array['lwc_english']) || ! empty($unpacked_array['lwc_french'])) {
    $unpacked_language .= '<h5>' . elgg_echo('missions:written_comprehension') . ': </h5>';
    if (! empty($unpacked_array['lwc_english'])) {
        $unpacked_language .= '<span name="mission-lwc-english">' . elgg_echo('missions:formatted:english', array($unpacked_array['lwc_english'])) . '</span> ';
    }
    if (! empty($unpacked_array['lwc_french'])) {
        $unpacked_language .= '<span name="mission-lwc-french">' . elgg_echo('missions:formatted:french', array($unpacked_array['lwc_french'])) . '</span>';
    }
    $unpacked_language .= '</br>';
}
if (! empty($unpacked_array['lwe_english']) || ! empty($unpacked_array['lwe_french'])) {
    $unpacked_language .= '<h5>' . elgg_echo('missions:written_expression') . ': </h5>';
    if (! empty($unpacked_array['lwe_english'])) {
        $unpacked_language .= '<span name="mission-lwe-english">' . elgg_echo('missions:formatted:english', array($unpacked_array['lwe_english'])) . '</span> ';
    }
    if (! empty($unpacked_array['lwe_french'])) {
        $unpacked_language .= '<span name="mission-lwe-french">' . elgg_echo('missions:formatted:french', array($unpacked_array['lwc_french'])) . '</span>';
    }
    $unpacked_language .= '</br>';
}
if (! empty($unpacked_array['lop_english']) || ! empty($unpacked_array['lop_french'])) {
    $unpacked_language .= '<h5>' . elgg_echo('missions:oral_proficiency') . ': </h5>';
    if (! empty($unpacked_array['lop_english'])) {
        $unpacked_language .= '<span name="mission-lop-english">' . elgg_echo('missions:formatted:english', array($unpacked_array['lop_english'])) . '</span> ';
    }
    if (! empty($unpacked_array['lop_french'])) {
        $unpacked_language .= '<span name="mission-lop-french">' . elgg_echo('missions:formatted:french', array($unpacked_array['lop_french'])) . '</span>';
    }
    $unpacked_language .= '</br>';
}
if (empty($unpacked_language)) {
    $unpacked_language = '<span name="no-languages">' . elgg_echo('missions:none_required') . '</span>';
}

// Sets up the display for time metadata.
$unpacked_time = '';
if ($mission->mon_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:mon') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['mon_start_hour'],
    		$unpacked_array['mon_start_min'],
    		$unpacked_array['mon_duration_hour'],
    		$unpacked_array['mon_duration_min']
    )) . '</br>';*/
    $unpacked_time .= '<span name="mission-mon-start">' . $mission->mon_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-mon-duration">' . $mission->mon_duration . '</span></br>';
}
if ($mission->tue_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:tue') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['tue_start_hour'],
    		$unpacked_array['tue_start_min'],
    		$unpacked_array['tue_duration_hour'],
    		$unpacked_array['tue_duration_min']
    )) . '</br>';*/
   $unpacked_time .= '<span name="mission-tue-start">' . $mission->tue_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-tue-duration">' . $mission->tue_duration . '</span></br>';
}
if ($mission->wed_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:wed') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['wed_start_hour'],
    		$unpacked_array['wed_start_min'],
    		$unpacked_array['wed_duration_hour'],
    		$unpacked_array['wed_duration_min']
    )) . '</br>';*/
    $unpacked_time .= '<span name="mission-wed-start">' . $mission->wed_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-wed-duration">' . $mission->wed_duration . '</span></br>';
}
if ($mission->thu_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:thu') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['thu_start_hour'],
    		$unpacked_array['thu_start_min'],
    		$unpacked_array['thu_duration_hour'],
    		$unpacked_array['thu_duration_min']
    )) . '</br>';*/
    $unpacked_time .= '<span name="mission-thu-start">' . $mission->thu_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-thu-duration">' . $mission->thu_duration . '</span></br>';
}
if ($mission->fri_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:fri') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['fri_start_hour'],
    		$unpacked_array['fri_start_min'],
    		$unpacked_array['fri_duration_hour'],
    		$unpacked_array['fri_duration_min']
    )) . '</br>';*/
    $unpacked_time .= '<span name="mission-fri-start">' . $mission->fri_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-fri-duration">' . $mission->fri_duration . '</span></br>';
}
if ($mission->sat_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:sat') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['sat_start_hour'],
    		$unpacked_array['sat_start_min'],
    		$unpacked_array['sat_duration_hour'],
    		$unpacked_array['sat_duration_min']
    )) . '</br>';*/
    $unpacked_time .= '<span name="mission-sat-start">' . $mission->sat_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-sat-duration">' . $mission->sat_duration . '</span></br>';
}
if ($mission->sun_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:sun') . ': </h5>';
   /* $unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['sun_start_hour'],
    		$unpacked_array['sun_start_min'],
    		$unpacked_array['sun_duration_hour'],
    		$unpacked_array['sun_duration_min']
    )) . '</br>';*/
    $unpacked_time .= '<span name="mission-sun-start">' . $mission->sun_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-sun-duration">' . $mission->sun_duration . '</span></br>';
}
if (empty($unpacked_time)) {
    $unpacked_time = '<span name="no-times">' . elgg_echo('missions:none_required') . '</span>';
}

// Creates a set of buttons for the bottom of the view.
if(!$vars['override_buttons']) {
    $button_set = mm_create_button_set_full($mission);
}
?>

<div class="mission-printer">
	<div>
		<h2 name="mission-job-title"><?php echo $mission->job_title;?></h2>
	</div>
	<div>
		<h5><?php echo elgg_echo('missions:opportunity_type') . ':';?></h5> 
		<span name="mission-job-type"><?php echo elgg_echo($mission->job_type);?></span>
	</div>
	<div name="mission-description">
		<?php echo $mission->descriptor;?>
	</div>
	</br>
	<div>
		<h4><?php echo elgg_echo('mission:poster_information') . ':'; ?></h4>
	</div>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:manager_name')  . ':';?></h5> 
		<span name="mission-name"><?php echo $mission->name;?></span>
	</div>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:department')  . ':';?></h5> 
		<span name="mission-department-path"><?php echo $department_path;?></span>
	</div>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:manager_email') . ':';?></h5> 
		<span name="mission-email"><?php echo $mission->email;?></span>
	</div>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:your_phone') . ':';?></h5> 
		<span name="mission-phone"><?php echo $clean_phone;?></span>
	</div>
	</br>
	<div>
		<div>
			<h4><?php echo elgg_echo('mission:opportunity_details') . ':'; ?></h4>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:program_area')  . ':';?></h5> 
			<span name="mission-program-area"><?php echo elgg_echo($mission->program_area);?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:opportunity_number')  . ':';?></h5> 
			<span name="mission-number"><?php echo $mission->number;?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:ideal_start_date') . ':';?></h5> 
			<span name="mission-start-date"><?php echo $mission->start_date;?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:ideal_completion_date') . ':';?></h5> 
			<span name="mission-completion-date"><?php echo $mission->completion_date;?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:deadline') . ':';?></h5> 
			<span name="mission-deadline"><?php echo $mission->deadline;?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:work_remotely') . ':';?></h5> 
			<span name="mission-remotely"><?php echo $clean_remotely;?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:openess_sentence', array(strtoupper($department_abbr)));?></h5> 
			<span name="mission-openess"><?php echo $clean_openess;?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:opportunity_location') . ':';?></h5> 
			<span name="mission-location"><?php echo elgg_echo($mission->location);?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:security_level') . ':';?></h5> 
			<span name="mission-security"><?php echo $clean_security;?></span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:key_skills_opportunity') . ':';?></h5> 
			<span name="mission-skills"><?php echo $clean_skills;?></span>
		</div>
	</div>
	</br>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:language_requirements') . ':</br>';?></h5>
		<div class="col-sm-offset-1">
			<?php echo $unpacked_language;?>
		</div>
	</div>
	</br>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:scheduling_requirements') . ':</br>';?></h5>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:time_commitment') . ':';?></h5>
			<span name="mission-time-commitment">
				<?php echo $mission->time_commitment; ?>
			</span>
			<span>
				<?php echo ' ' . elgg_echo('missions:hours') . ' '; ?>
			</span>
			<span name="mission-time-interval">
				<?php echo elgg_echo($mission->time_interval); ?>
			</span>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:timezone') . ':';?></h5> 
			<span name="mission-time-zone"><?php echo $clean_timezone;?></span>
		</div>
		<div class="col-sm-offset-1">
			<?php echo $unpacked_time; ?>
		</div>
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