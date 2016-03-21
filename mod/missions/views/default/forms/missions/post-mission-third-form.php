<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$_SESSION['mission_skill_input_number'] = 0;
elgg_load_js('typeahead');

$flexibility = get_input('tt');
$remotely = get_input('tr');
$location = get_input('tl');
$security = get_input('ts');
$time_commitment = get_input('ttc');
$time_interval = get_input('tti');

if (elgg_is_sticky_form('thirdfill')) {
    extract(elgg_get_sticky_values('thirdfill'));
    // elgg_clear_sticky_form('thirdfill');
}

if(!$timezone) {
	$timezone = 'Canada/Eastern (-5)';
}

// Determines whether the remote work checkbox is checked or not.
if($remotely == 'on') {
	$remotely = true;
}
else {
	$remotely = false;
}

$input_remotely = elgg_view('input/checkbox', array(
	    'name' => 'remotely',
	    'checked' => $remotely,
	    'id' => 'post-mission-remotely-checkbox-input'
));
$input_location = elgg_view('input/text', array(
	    'name' => 'location',
	    'value' => $location,
	    'id' => 'post-mission-location-text-input'
));
$input_security = elgg_view('input/dropdown', array(
	    'name' => 'security',
	    'value' => $security,
	    'options' => explode(',', elgg_get_plugin_setting('security_string', 'missions')),
	    'id' => 'post-mission-security-dropdown-input'
));
$input_timezone = elgg_view('input/dropdown', array(
	    'name' => 'timezone',
	    'value' => $timezone,
	    'options' => explode(',', elgg_get_plugin_setting('timezone_string', 'missions')),
	    'id' => 'post-mission-timezone-dropdown-input'
));
$input_skills_0 = elgg_view('missions/add-skill');
$input_time_commit = elgg_view('input/text', array(
		'name' => 'time_commitment',
		'value' => $time_commitment,
		'id' => 'post-mission-time-commitment-text-input',
		'style' => 'display:inline-block;max-width:75px;'
));
$input_time_interval = elgg_view('input/dropdown', array(
		'name' => 'time_interval',
		'value' => $time_interval,
		'options' => explode(',', elgg_get_plugin_setting('time_rate_string', 'missions')),
		'id' => 'post-mission-time-interval-dropdown-input',
		'style' => 'display:inline-block;margin-left:4px;'
));

$languages = elgg_view('page/elements/language-dropdown', $vars);
$language_field = elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:language_requirements'),
		'toggle_id' => 'language_input',
		'hidden_content' => $languages,
		'additional_text' => elgg_echo('missions:optional_in_parentheses'),
		'field_bordered' => true
));

$time_content = '<div class="form-group"><label for="post-mission-timezone-dropdown-input" class="col-sm-3" style="text-align:right;">';
$time_content .= elgg_echo('missions:timezone') . ':';
$time_content .= '</label>';
$time_content .= '<div class="col-sm-9">';
$time_content .= $input_timezone;
$time_content .= '</div></div>';
$time_content .= elgg_view('page/elements/time-table', $vars);
$time_field = elgg_view('page/elements/hidden-field', array(
		'toggle_text' => elgg_echo('missions:specific_time_requirements'),
		'toggle_id' => 'time_input',
		'hidden_content' => $time_content,
		'additional_text' => elgg_echo('missions:optional_in_parentheses'),
		'field_bordered' => true
));

$add_skill_button = elgg_view('output/url', array(
		'text' => ' ' . elgg_echo('missions:add'),
		'class' => 'elgg-button btn fa fa-plus-circle',
		'id' => 'add-skill-button',
		'onclick' => 'add_skill_field()'
));
?>

<h4><?php echo elgg_echo('missions:third_post_form_title'); ?></h4></br>
<div class="form-group">
	<label for='post-mission-skills-text-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:skills') . ':';?>
	</label>
	<div class="col-sm-9">
		<div id="mission-skill-container" style="display:inline-block;">
			<?php echo $input_skills_0; ?>
		</div>
		<div>
			<?php echo $add_skill_button; ?>
		</div>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-time-commitment-text-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:time_commitment_in_hours') . '*:';?>
	</label>
	<div class="col-sm-9">
		<?php 
			echo $input_time_commit;
			echo $input_time_interval;
		?>
	</div>
</div>
<div class="form-group">
	<?php echo $time_field; ?>
</div>
<div class="form-group">
	<label for='post-mission-remotely-checkbox-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:work_remotely') . ':';?>
	</label>
	<div class="col-sm-9">
		<?php echo $input_remotely; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-location-text-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:location') . '*:';?>
	</label>
	<div class="col-sm-9">
		<?php echo $input_location; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-security-dropdown-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:security_level') . ':';?>
	</label>
	<div class="col-sm-9">
		<?php echo $input_security; ?>
	</div>
</div>
<div class="form-group">
	<?php echo $language_field; ?>
</div>

<div> 
	<?php
		echo elgg_view('output/url', array(
			'href' => elgg_get_site_url() . 'missions/mission-post/step-one',
			'text' => elgg_echo('missions:back'),
			'class' => 'elgg-button btn btn-default'
		));
		echo elgg_view('input/submit', array(
			'value' => elgg_echo('missions:create_opportunity'),
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