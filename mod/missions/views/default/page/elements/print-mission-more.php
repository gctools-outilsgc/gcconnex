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

// Clean up several variables to make sure that something is displayed if they are null.
$clean_phone = elgg_echo('missions:none_given');
$clean_security = elgg_echo('missions:none_required');
$clean_skills = elgg_echo('missions:none_given');
$clean_timezone = elgg_echo('missions:none_given');
$clean_remotely = elgg_echo('missions:no');
if (! empty($mission->phone)) {
    $clean_phone = $mission->phone;
}
if (! empty($mission->security)) {
    $clean_security = $mission->security;
}
if (! empty($mission->key_skills)) {
    $clean_skills = $mission->key_skills;
}
if (! empty($mission->timezone)) {
	$clean_timezone =  $mission->timezone;
}
if(! empty($mission->remotely)) {
	$clean_remotely = elgg_echo('missions:yes');
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
        $unpacked_language .= elgg_echo('missions:formatted:english', array($unpacked_array['lwc_english'])) . ' ';
    }
    if (! empty($unpacked_array['lwc_french'])) {
        $unpacked_language .= elgg_echo('missions:formatted:french', array($unpacked_array['lwc_french']));
    }
    $unpacked_language .= '</br>';
}
if (! empty($unpacked_array['lwe_english']) || ! empty($unpacked_array['lwe_french'])) {
    $unpacked_language .= '<h5>' . elgg_echo('missions:written_expression') . ': </h5>';
    if (! empty($unpacked_array['lwe_english'])) {
        $unpacked_language .= elgg_echo('missions:formatted:english', array($unpacked_array['lwe_english'])) . ' ';
    }
    if (! empty($unpacked_array['lwe_french'])) {
        $unpacked_language .= elgg_echo('missions:formatted:french', array($unpacked_array['lwc_french']));
    }
    $unpacked_language .= '</br>';
}
if (! empty($unpacked_array['lop_english']) || ! empty($unpacked_array['lop_french'])) {
    $unpacked_language .= '<h5>' . elgg_echo('missions:oral_proficiency') . ': </h5>';
    if (! empty($unpacked_array['lop_english'])) {
        $unpacked_language .= elgg_echo('missions:formatted:english', array($unpacked_array['lop_english'])) . ' ';
    }
    if (! empty($unpacked_array['lop_french'])) {
        $unpacked_language .= elgg_echo('missions:formatted:french', array($unpacked_array['lop_french']));
    }
    $unpacked_language .= '</br>';
}
if (empty($unpacked_language)) {
    $unpacked_language = elgg_echo('missions:none_required');
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
    $unpacked_time .= $mission->mon_start . ' ' . elgg_echo('missions:to') . ' ' . $mission->mon_duration . '</br>';
}
if ($mission->tue_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:tue') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['tue_start_hour'],
    		$unpacked_array['tue_start_min'],
    		$unpacked_array['tue_duration_hour'],
    		$unpacked_array['tue_duration_min']
    )) . '</br>';*/
    $unpacked_time .= $mission->tue_start . ' ' . elgg_echo('missions:to') . ' ' . $mission->tue_duration . '</br>';
}
if ($mission->wed_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:wed') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['wed_start_hour'],
    		$unpacked_array['wed_start_min'],
    		$unpacked_array['wed_duration_hour'],
    		$unpacked_array['wed_duration_min']
    )) . '</br>';*/
    $unpacked_time .= $mission->wed_start . ' ' . elgg_echo('missions:to') . ' ' . $mission->wed_duration . '</br>';
}
if ($mission->thu_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:thu') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['thu_start_hour'],
    		$unpacked_array['thu_start_min'],
    		$unpacked_array['thu_duration_hour'],
    		$unpacked_array['thu_duration_min']
    )) . '</br>';*/
    $unpacked_time .= $mission->thu_start . ' ' . elgg_echo('missions:to') . ' ' . $mission->thu_duration . '</br>';
}
if ($mission->fri_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:fri') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['fri_start_hour'],
    		$unpacked_array['fri_start_min'],
    		$unpacked_array['fri_duration_hour'],
    		$unpacked_array['fri_duration_min']
    )) . '</br>';*/
    $unpacked_time .= $mission->fri_start . ' ' . elgg_echo('missions:to') . ' ' . $mission->fri_duration . '</br>';
}
if ($mission->sat_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:sat') . ': </h5>';
    /*$unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['sat_start_hour'],
    		$unpacked_array['sat_start_min'],
    		$unpacked_array['sat_duration_hour'],
    		$unpacked_array['sat_duration_min']
    )) . '</br>';*/
    $unpacked_time .= $mission->sat_start . ' ' . elgg_echo('missions:to') . ' ' . $mission->sat_duration . '</br>';
}
if ($mission->sun_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:sun') . ': </h5>';
   /* $unpacked_time .= elgg_echo('missions:formatted:time', array(
    		$unpacked_array['sun_start_hour'],
    		$unpacked_array['sun_start_min'],
    		$unpacked_array['sun_duration_hour'],
    		$unpacked_array['sun_duration_min']
    )) . '</br>';*/
    $unpacked_time .= $mission->sun_start . ' ' . elgg_echo('missions:to') . ' ' . $mission->sun_duration . '</br>';
}
if (empty($unpacked_time)) {
    $unpacked_time = elgg_echo('missions:none_required');
}

// Creates a set of buttons for the bottom of the view.
if(!$vars['override_buttons']) {
    $button_set = mm_create_button_set_full($mission);
}
?>

<div class="mission-printer">
	<div>
		<h2><?php echo $mission->job_title;?></h2>
	</div>
	<div>
		<h5><?php echo elgg_echo('missions:opportunity_type') . ':';?></h5> 
		<?php echo $mission->job_type;?>
	</div>
	<div>
		<?php echo $mission->descriptor;?>
	</div>
	</br>
	<div>
		<h4><?php echo elgg_echo('mission:poster_information') . ':'; ?></h4>
	</div>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:manager_name')  . ':';?></h5> 
		<?php echo $mission->name;?>
	</div>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:department')  . ':';?></h5> 
		<?php echo $department_path;?>
	</div>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:manager_email') . ':';?></h5> 
		<?php echo $mission->email;?>
	</div>
	<div class="col-sm-offset-1">
		<h5><?php echo elgg_echo('missions:your_phone') . ':';?></h5> 
		<?php echo $clean_phone;?>
	</div>
	</br>
	<div>
		<div>
			<h4><?php echo elgg_echo('mission:opportunity_details') . ':'; ?></h4>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:opportunity_number')  . ':';?></h5> 
			<?php echo $mission->number;?>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:ideal_start_date') . ':';?></h5> 
			<?php echo $mission->start_date;?>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:ideal_completion_date') . ':';?></h5> 
			<?php echo $mission->completion_date;?>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:deadline') . ':';?></h5> 
			<?php echo $mission->deadline;?>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:work_remotely') . ':';?></h5> 
			<?php echo $clean_remotely;?>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:opportunity_location') . ':';?></h5> 
			<?php echo $mission->location;?>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:security_level') . ':';?></h5> 
			<?php echo $clean_security;?>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:key_skills_opportunity') . ':';?></h5> 
			<?php echo $clean_skills;?>
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
			<?php echo $mission->time_commitment . ' ' . elgg_echo('missions:hours') . ' ' . $mission->time_interval;?>
		</div>
		<div class="col-sm-offset-1">
			<h5><?php echo elgg_echo('missions:timezone') . ':';?></h5> 
			<?php echo $clean_timezone;?>
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