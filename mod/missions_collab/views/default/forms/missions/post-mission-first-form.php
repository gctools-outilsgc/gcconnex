<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$disclaimer_uncheck = $vars['disclaimer_uncheck'];

$name = get_input('fn');
$email = get_input('fe');
$phone = get_input('fp');
$disclaimer = get_input('fd');

if(elgg_is_sticky_form('firstfill')) {
	$temp_form = elgg_get_sticky_values('firstfill');
	$extracted_org = mo_get_last_input_node($temp_form);
    extract($temp_form);
}

if($disclaimer == 'YES' && !$disclaimer_uncheck) {
	$disclaimer = true;
}
else {
	$disclaimer = false;
}

if(!elgg_is_sticky_form('firstfill')) {
	$user = get_entity(elgg_get_logged_in_user_guid());
	if(!$name) {
		$name = $user->name;
	}
	if(!$extracted_org) {
		$exploded_department = explode('/', $user->department);
		$department_name = trim($exploded_department[0]);
		$extracted_org = mo_format_input_node(mo_get_department_next_to_root($department_name));
	}
	if(!$email) {
		$email = $user->email;
	}
	if(!$phone) {
		$phone = $user->phone;
	}
}


$input_name = elgg_view('input/text', array(
    'name' => 'name',
    'value' => $name,
    'id' => 'post-mission-name-text-input'
));

/* MW - Changed for GCcollab version of Opp Platform
$input_department = elgg_view('page/elements/organization-input', array(
		'organization_string' => $extracted_org
));
*/

$deptObj = elgg_get_entities(array(
   	'type' => 'object',
   	'subtype' => 'federal_departments',
));
$depts = get_entity($deptObj[0]->guid);

$federal_departments = array();
if (get_current_language() == 'en'){
	$federal_departments = json_decode($depts->federal_departments_en, true);
} else {
	$federal_departments = json_decode($depts->federal_departments_fr, true);
}
uksort($federal_departments, 'strcasecmp');

$input_department = elgg_view('input/text', array(
	'name' => 'department',
	'id' => 'org-no-tree-exists-text-input',
	'value' => elgg_get_logged_in_user_entity()->federal,
    'list' => 'departmentlist'
));
$input_department .= '<datalist id="departmentlist">';
foreach($federal_departments as $key => $value){
	$input_department .= '<option value="' . $key . '">' . $value . '</option>';
}
$input_department .= '</datalist>';

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

<h2 class='h4'><?php echo elgg_echo('missions:first_post_form_title'); ?></h2><br>
<div class="form-group">
	<label for='post-mission-name-text-input' class="col-sm-3 required text-right" aria-required="true">
		<?php echo elgg_echo('missions:your_name');?>
		<strong class="required" aria-required="true">
			<?php echo elgg_echo('missions:required'); ?>
		</strong>
		:
	</label>
	<div class="col-sm-4">
		<?php echo $input_name; ?>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 text-right" aria-required="true">
		<?php echo elgg_echo('missions:your_department');?>
	</label>
	<div class="col-sm-4">
		<?php echo $input_department; ?>
		<div><?php echo elgg_echo('missions:placeholder_d2'); ?></div>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-email-text-input' class="col-sm-3 required text-right" aria-required="true">
		<?php echo elgg_echo('missions:your_email');?>
		<strong class="required" aria-required="true">
			<?php echo elgg_echo('missions:required'); ?>
		</strong>
		:
	</label>
	<div class="col-sm-4">
		<?php echo $input_email; ?>
	</div>
</div>
<div class="form-group">
	<label for='post-mission-phone-text-input' class="col-sm-3 text-right">
		<?php echo elgg_echo('missions:your_phone') . ':';?>
	</label>
	<div class="col-sm-4">
		<?php echo $input_phone; ?>
		<p style="font-style:italic;">
			<?php //echo elgg_echo('missions:post_contact_disclaimer')?>
		</p>
	</div>
</div>
<div class="form-group">
	<div class="col-sm-7 col-md-offset-3">
		<label for='post-mission-disclaimer-checkbox-input' style="font-weight:normal;">
			<?php echo $input_disclaimer;?>&nbsp;
			<?php echo elgg_echo('missions:post_disclaimer'); ?>
			<strong class="required" aria-required="true">
				<?php echo elgg_echo('missions:required'); ?>
			</strong>
		</label>		
	</div>
</div>
<div>
	<?php
		echo elgg_view('input/submit', array(
				'value' => elgg_echo('missions:next'),
				'class' => 'elgg-button btn btn-primary pull-right',
				'id' => 'mission-post-opportunity-first-form-submission-button'
		));
	?>
</div>
