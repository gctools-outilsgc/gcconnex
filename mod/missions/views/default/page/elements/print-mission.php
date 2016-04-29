<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

/*
 * This view displays some of the mission metadata. It is meant to be a first glance summary.
 */
$mission = '';
if (isset($vars['entity'])) {
    $mission = $vars['entity'];
}

$description_string = elgg_get_excerpt($mission->description, 200);
$card_height = '450';

// Sets the buttons to the bottom of whichever view is used.
if(!$vars['override_buttons']) {
    $button_set = mm_create_button_set_base($mission, false);
}
else {
	$card_height = '400';
}

$mission_state = '';
if($mission->state == 'completed' || $mission->state == 'cancelled') {
	$mission_state = '(' . $mission->state . ')';
}

// Linking to the mission managers profile.
$manager = get_entity($mission->owner_guid);
$manager_profile = elgg_view('output/url', array(
		'href' => elgg_get_site_url() . 'profile/' . $manager->username,
		'text' => $mission->name,
		'id' => 'mission-user-link-' . $manager->guid
));
?>

<div class="mission-printer mission-less" style="height:<?php echo $card_height;?>px;" name="mission-object">
	<div>
		<h2>
			<div style="display:inline" name="mission-job-title">
				<?php echo $mission->job_title;?>
			</div>
			<div style="font-style:italic;font-size:small;display:inline;" name="mission-state">
				<?php echo $mission_state; ?>
			</div>
		</h2>
	</div>
	<div name="mission-job-type">
		<b><?php echo elgg_echo($mission->job_type); ?></b>
	</div>
	<div style="max-height:115px;overflow:hidden;" name="mission-description">
		<?php echo $description_string;?>
	</div>
	</br>
	<div>
		<div style="display:inline-block;vertical-align:top;">
			<h5><?php echo elgg_echo('missions:date') . ':';?></h5>
		</div>
		<div style="display:inline-block;">
			<div name="mission-start-and-completion-date">
				<span name="mission-start-date">
					<?php echo $mission->start_date; ?>
				</span>
				<span>
					<?php echo elgg_echo('missions:to'); ?>
				</span>
				<span name="mission-completion-date">
					<?php echo $mission->completion_date; ?>
				</span>
			</div>
			<div style="font-style:italic;" name="mission-time-commitment-and-interval">
				<span name="mission-time-commitment">
					<?php echo $mission->time_commitment; ?>
				</span>
				<span>
					<?php echo elgg_echo('missions:hours'); ?>
				</span>
				<span name="mission-time-interval">
					<?php echo elgg_echo($mission->time_interval); ?>
				</span>
			</div>
		</div>
	</div>
	<div>
		<div style="display:inline-block;">
			<h5><?php echo elgg_echo('missions:apply_by') . ':';?></h5>
		</div>
		<div style="display:inline-block;" name="mission-deadline">
			<?php echo $mission->deadline;?>
		</div>
	</div>
	</br>
	<div class="mission-user-card-info">
		<div style="float:left;margin-right:8px;">
			<?php echo elgg_view_entity_icon($manager, 'small');?>
		</div>
		<div name="mission-manager" style="text-align:left;">
			<div>
				<span name="mission-manager-name"><?php echo $manager_profile;?></span>
			</div>
			<div>
				<span name="mission-manager-department"><?php echo $manager->department;?></span>
			</div>
		</div>
	</div>
	<div class="mission-button-set">
		<?php
			if (! $full_view) {
			    foreach ($button_set as $value) {
			        echo $value;
			    }
			}
		?>
	</div>
</div>