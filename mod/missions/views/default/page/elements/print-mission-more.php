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
$clean_completion_date = elgg_echo('missions:unknown');
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
	$clean_timezone =  elgg_echo($mission->timezone);
}
if(!empty($mission->remotely)) {
	$clean_remotely = elgg_echo('missions:yes');
}
if(!empty($mission->openess)) {
	$clean_openess = elgg_echo('missions:yes');
}
if(!empty($mission->completion_date)) {
	$clean_completion_date = $mission->completion_date;
}

$department_path = $mission->department_path_english;
if(get_current_language() == 'fr') {
	$department_path = $mission->department_path_french;
}

if(trim($department_path) == '') {
	if(strpos($mission->department, 'MOrg:') === false) {
		$department_path = $mission->department;
	}
}

//Nick - Adding group and level to the mission view
if(!empty($mission->gl_group)){
  $print_groupandlevel = '<h5>'.elgg_echo('missions:groupandlevel').': </h5><span>'.$mission->gl_group.'-'.$mission->gl_level.'</span>';
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
    $unpacked_language .= '<br>';
}
if (! empty($unpacked_array['lwe_english']) || ! empty($unpacked_array['lwe_french'])) {
    $unpacked_language .= '<h5>' . elgg_echo('missions:written_expression') . ': </h5>';
    if (! empty($unpacked_array['lwe_english'])) {
        $unpacked_language .= '<span name="mission-lwe-english">' . elgg_echo('missions:formatted:english', array($unpacked_array['lwe_english'])) . '</span> ';
    }
    if (! empty($unpacked_array['lwe_french'])) {
        $unpacked_language .= '<span name="mission-lwe-french">' . elgg_echo('missions:formatted:french', array($unpacked_array['lwc_french'])) . '</span>';
    }
    $unpacked_language .= '<br>';
}
if (! empty($unpacked_array['lop_english']) || ! empty($unpacked_array['lop_french'])) {
    $unpacked_language .= '<h5>' . elgg_echo('missions:oral_proficiency') . ': </h5>';
    if (! empty($unpacked_array['lop_english'])) {
        $unpacked_language .= '<span name="mission-lop-english">' . elgg_echo('missions:formatted:english', array($unpacked_array['lop_english'])) . '</span> ';
    }
    if (! empty($unpacked_array['lop_french'])) {
        $unpacked_language .= '<span name="mission-lop-french">' . elgg_echo('missions:formatted:french', array($unpacked_array['lop_french'])) . '</span>';
    }
    $unpacked_language .= '<br>';
}
if (empty($unpacked_language)) {
    $unpacked_language = '<span name="no-languages">' . elgg_echo('missions:none_required') . '</span>';
}

// Sets up the display for time metadata.
$unpacked_time = '';
if ($mission->mon_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:mon') . ': </h5>';
    $unpacked_time .= '<span name="mission-mon-start">' . $mission->mon_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-mon-duration">' . $mission->mon_duration . '</span><br>';
}
if ($mission->tue_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:tue') . ': </h5>';
   $unpacked_time .= '<span name="mission-tue-start">' . $mission->tue_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-tue-duration">' . $mission->tue_duration . '</span><br>';
}
if ($mission->wed_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:wed') . ': </h5>';
    $unpacked_time .= '<span name="mission-wed-start">' . $mission->wed_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-wed-duration">' . $mission->wed_duration . '</span><br>';
}
if ($mission->thu_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:thu') . ': </h5>';
    $unpacked_time .= '<span name="mission-thu-start">' . $mission->thu_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-thu-duration">' . $mission->thu_duration . '</span><br>';
}
if ($mission->fri_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:fri') . ': </h5>';
    $unpacked_time .= '<span name="mission-fri-start">' . $mission->fri_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-fri-duration">' . $mission->fri_duration . '</span><br>';
}
if ($mission->sat_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:sat') . ': </h5>';
    $unpacked_time .= '<span name="mission-sat-start">' . $mission->sat_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-sat-duration">' . $mission->sat_duration . '</span><br>';
}
if ($mission->sun_start) {
    $unpacked_time .= '<h5>' . elgg_echo('missions:sun') . ': </h5>';
    $unpacked_time .= '<span name="mission-sun-start">' . $mission->sun_start . '</span>' . elgg_echo('missions:to') . '<span name="mission-sun-duration">' . $mission->sun_duration . '</span><br>';
}
if (empty($unpacked_time)) {
    $unpacked_time = '<span name="no-times">' . elgg_echo('missions:none_required') . '</span>';
}

// Creates a set of buttons for the bottom of the view.
if(!$vars['override_buttons']) {
    $button_set = mm_create_button_set_full($mission);
}

$mission_state = '';
if($mission->state == 'completed') {
	$mission_state = '(' . strtolower(elgg_echo('missions:completed')) . ')';
}
if($mission->state == 'cancelled') {
	$mission_state = '(' . strtolower(elgg_echo('missions:cancelled')) . ')';
}

$creator = get_user($mission->owner_guid);

$accept_and_decline_top_buttons = '';
if(strpos($button_set['button_three'], 'accept-button') !== false) {
	$accept_and_decline_top_buttons = $button_set['button_three'] . $button_set['button_four'];
}
?>

<div class="row clearfix">
    <div class="col-sm-8 print-mission-more-holder">
	<div>
		<h2 name="mission-job-title">
			<?php echo elgg_get_excerpt($mission->job_title, 200);?>
			<span style="font-style:italic;font-size:small;" name="mission-state">
				<?php echo $mission_state; ?>
			</span>
		</h2>
	</div>
	<div style="text-align:right;">
		<?php echo $accept_and_decline_top_buttons; ?>
	</div>
        <div class="mission-details mrgn-bttm-lg">

		<span name="mission-job-type"><?php echo elgg_echo($mission->job_type);?></span> <i class="fa fa-circle mrgn-lft-sm timeStamp mrgn-bttm-sm" aria-hidden="true" style="font-size:8px"></i>
            <span class="mrgn-lft-sm"><?php echo elgg_get_friendly_time($mission->time_created); ?></span>
	</div>
	<div name="mission-description">
		<?php
      //echo elgg_get_excerpt($mission->descriptor, 2000);
      //Nick - Changed from exceprt to echo the metadata so it does not strip the tags made by ck editor
      echo $mission->descriptor;
    ?>
	</div>

	<div>
		<div>
			<h4><?php echo elgg_echo('mission:opportunity_details') . ':'; ?></h4>
		</div>
		<div class="clearfix">
			<h5><?php echo elgg_echo('missions:program_area')  . ':';?></h5>
			<span  name="mission-program-area"><?php echo elgg_echo($mission->program_area);?></span>
		</div>
    <div class="clearfix">
        <?php echo $print_groupandlevel; ?>
    </div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:opportunity_number')  . ':';?></h5>
			<span name="mission-number"><?php echo $mission->number;?></span>
		</div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:ideal_start_date') . ':';?></h5>
			<span name="mission-start-date"><?php echo $mission->start_date;?></span>
		</div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:ideal_completion_date') . ':';?></h5>
			<span name="mission-completion-date"><?php echo $clean_completion_date;?></span>
		</div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:deadline') . ':';?></h5>
			<span name="mission-deadline"><?php echo $mission->deadline;?></span>
		</div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:work_remotely') . ':';?></h5>
			<span name="mission-remotely"><?php echo $clean_remotely;?></span>
		</div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:openess_sentence', array(strtoupper($department_abbr)));?></h5>
			<span name="mission-openess"><?php echo $clean_openess;?></span>
		</div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:opportunity_location') . ':';?></h5>
			<span name="mission-location"><?php echo elgg_echo($mission->location);?></span>
		</div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:security_level') . ':';?></h5>
			<span name="mission-security"><?php echo $clean_security;?></span>
		</div>
		<div class="clearfix">
                <h5><?php echo elgg_echo('missions:key_skills_opportunity') . ':';?></h5>
			<span name="mission-skills"><?php echo elgg_get_excerpt($clean_skills, 500);?></span>
		</div>
	</div>
	</br>
	<div class="mission-details">
		<h5 class="mrgn-tp-md"><?php echo elgg_echo('missions:language_requirements') . ':</br>';?></h5>
		<div class="col-sm-offset-1">
			<?php echo $unpacked_language;?>
		</div>
	</div>
	</br>
        <div class="mission-details">
		<h5 class="mrgn-tp-md"><?php echo elgg_echo('missions:scheduling_requirements') . ':</br>';?></h5>
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
	<div>
		<?php
			foreach ($button_set as $value) {
			    echo $value;
			}
        ?>
	</div>
    </div>

    <div class="col-sm-4 mission-details">
        <div class="panel panel-default mission-printer">
            <div>
                <h4 class="mrgn-tp-sm">
                    <?php echo elgg_echo('mission:manager_information') . ':'; ?>
                </h4>
            </div>
            <div class="mrgn-bttm-md clearfix">
                <!--
                                    <h5>
                    <?php echo elgg_echo('missions:name')  . ':';?>
                </h5>
                <span name="mission-name">
                    <?php echo elgg_get_excerpt($mission->name, 100);?>
                </span>

                    -->

                <?php
                echo elgg_view('page/elements/mission-manager-info', array(
                    'mission' => $mission,
                    'container_class' => 'mission-user-card-info',
                    'grid_number' => '2'
                ));
                ?>

            </div>
            <div class="">
                <h5>
                    <?php echo elgg_echo('missions:department')  . ':';?>
                </h5>
                <span name="mission-department-path">
                    <?php echo elgg_get_excerpt($department_path, 500);?>
                </span>
            </div>
            <div class="">
                <h5>
                    <?php echo elgg_echo('missions:email') . ':';?>
                </h5>
                <span name="mission-email">
                    <?php echo elgg_get_excerpt($mission->email, 100);?>
                </span>
            </div>
            <div class="">
                <h5>
                    <?php echo elgg_echo('missions:your_phone') . ':';?>
                </h5>
                <span name="mission-phone">
                    <?php echo $clean_phone;?>
                </span>
            </div>
        </div>

        <div>

            <?php
              echo elgg_view('page/elements/related-candidates', array(
    		        'entity' => $mission,
                ));
            ?>

        </div>

    </div>
</div>
