<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
$name = get_input('fn');
$department = get_input('fd');
$email = get_input('fe');
$phone = get_input('fp');
$disclaimer = get_input('fd');

if (elgg_is_sticky_form('firstfill')) {
	$temp_form = elgg_get_sticky_values('firstfill');
	$extracted_org = mo_get_last_input_node($temp_form);
    extract($temp_form);
    // elgg_clear_sticky_form('firstfill');
}

if($disclaimer == 'YES') {
	$disclaimer = true;
}
else {
	$disclaimer = false;
}

$user = get_entity(elgg_get_logged_in_user_guid());
if(!$name) {
	$name = $user->name;
}
if(!$department) {
	$department = $user->department;
}
if(!$email) {
	$email = $user->email;
}
if(!$phone) {
	$phone = $user->phone;
}

$input_name = elgg_view('input/text', array(
    'name' => 'name',
    'value' => $name,
    'id' => 'post-mission-name-text-input'
));

$input_department = elgg_view('page/elements/organization-input', array(
		'organization_string' => $extracted_org
));

$input_email = elgg_view('input/text', array(
    'name' => 'email',
    'value' => $email,
    'id' => 'post-mission-email-text-input'
));
$input_phone = elgg_view('input/text', array(
    'name' => 'phone',
    'value' => $phone,
    'id' => 'post-mission-phone-text-input'
));
$input_disclaimer = elgg_view('input/checkbox', array(
		'name' => 'disclaimer',
		'value' => 'YES',
		'checked' => $disclaimer,
		'id' => 'post-mission-disclaimer-checkbox-input'
));
?>

<h4><?php echo elgg_echo('missions:first_post_form_title'); ?></h4></br>
<div class="form-group">
	<label for='post-mission-name-text-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:your_name') . '*:';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_name; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-department-text-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:your_department') . '*:';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_department; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-email-text-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:your_email') . '*:';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_email; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-phone-text-input' class="col-sm-3" style="text-align:right;">
		<?php echo elgg_echo('missions:your_phone') . ':';?>
	</label>
	<div class="col-sm-3">
		<?php echo $input_phone; ?>
		<p style="font-style:italic;">
			<?php echo elgg_echo('missions:post_contact_disclaimer')?>
		</p>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-phone-text-input' class="col-sm-1" style="text-align:right;">
		<?php echo $input_disclaimer;?>
	</label>
	<div class="col-sm-11">
		<?php echo elgg_echo('missions:post_disclaimer'); ?>
	</div>
</div>
<div> 
	<?php 
		echo elgg_view('input/submit', array(
			'value' => elgg_echo('missions:next'),
			'class' => 'elgg-button btn btn-primary',
			'style' => 'float:right;'
		)); 
	?>
</div>