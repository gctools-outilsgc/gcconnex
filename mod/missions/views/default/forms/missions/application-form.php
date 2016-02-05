<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */
 
/*
 * Form which allows the user to generate a simple foreword for their application via longtext input.
 */
$current_uri = $_SERVER['REQUEST_URI'];
$exploded_uri = explode('/', $current_uri);
$current_guid = array_pop($exploded_uri);
$mission = get_entity($current_guid);
$_SESSION['mid_act'] = $current_guid;

$email_body = get_input('eb');

if (elgg_is_sticky_form('applicationfill')) {
    extract(elgg_get_sticky_values('applicationfill'));
    elgg_clear_sticky_form('applicationfill');
}

$input_email_body = elgg_view('input/longtext', array(
    'name' => 'email_body',
    'value' => $email_body,
    'id' => 'apply-mission-body-text-input'
));

$input_manager_permission = elgg_view('input/checkbox', array(
		'name' => 'manager_permission',
		'id' => 'apply-to-mission-manager-permission-checkbox-input'
));
$input_email_manager = elgg_view('input/checkbox', array(
		'name' => 'email_manager',
		'id' => 'apply-to-mission-email-manager-checkbox-input'
));
$input_email = elgg_view('input/text', array(
    'name' => 'email',
    'value' => $email,
    'id' => 'apply-to-mission-email-text-input'
));
?>

<div class="form-group">
	<label for='apply-mission-body-text-input'><?php echo elgg_echo('missions:message_to_manager', array($mission->name)); ?> </label>
	<div style="max-width:800px;">
		<?php echo $input_email_body; ?>
	</div>
</div>
<div class="form-group">
	<div style="display:inline-block;">
		<?php echo $input_manager_permission; ?>
	</div>
	<div style="display:inline-block;"">
		<?php echo elgg_echo('missions:manager_permission_disclaimer'); ?>
	</div>
</div>
<div class="form-group" style="display:flex;align-items:center;">
	<div style="display:inline-block;">
		<?php echo $input_email_manager; ?>
	</div>
	<p style="font-style:normal;margin:0px 4px;">
		<?php echo elgg_echo('missions:email_manager_question'); ?>
	</p>
	<div>
		<?php echo $input_email; ?>
	</div>
</div>
<div> 
	<?php 
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:send'),
				'class' => 'elgg-button btn btn-primary',
				'style' => 'float:right;'
		)); 
	?> 
</div>