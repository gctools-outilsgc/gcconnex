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
		'text' => $mission->name
));
?>

<div class="mission-printer mission-less" style="height:<?php echo $card_height;?>px;">
	<div>
		<h2>
			<?php echo $mission->job_title;?>
			<div style="font-style:italic;font-size:small;display:inline-block;">
				<?php echo $mission_state; ?>
			</div>
		</h2>
	</div>
	<div style="max-height:115px;overflow:hidden;">
		<?php echo $description_string;?>
	</div>
	</br>
	<div>
		<div style="display:inline-block;">
			<h5><?php echo elgg_echo('missions:posted_by') . ':';?></h5>
		</div>
		<div style="display:inline-block;">
			<?php echo $manager_profile;?>
		</div>
	</div>
	</br>
	<div>
		<div style="display:inline-block;vertical-align:top;">
			<h5><?php echo elgg_echo('missions:date') . ':';?></h5>
		</div>
		<div style="display:inline-block;">
			<?php echo $mission->start_date . ' - ' . $mission->completion_date;?>
			<div style="font-style:italic;">
				<?php echo $mission->time_commitment . ' ' . elgg_echo('missions:hours') . ' ' . $mission->time_interval;?>
			</div>
		</div>
	</div>
	</br>
	<div>
		<div style="display:inline-block;">
			<h5><?php echo elgg_echo('missions:apply_by') . ':';?></h5>
		</div>
		<div style="display:inline-block;">
			<?php echo $mission->deadline;?>
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