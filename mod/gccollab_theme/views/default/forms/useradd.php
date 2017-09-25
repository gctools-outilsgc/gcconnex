<?php
/**
 * Elgg add user form.
 *
 * @package Elgg
 * @subpackage Core
 * 
 */

if (elgg_is_sticky_form('useradd')) {
	$values = elgg_get_sticky_values('useradd');
	elgg_clear_sticky_form('useradd');
} else {
	$values = array();
}

$password = $password2 = '';
$name = elgg_extract('name', $values);
$username = elgg_extract('username', $values);
$email = elgg_extract('email', $values);
$admin = elgg_extract('admin', $values);
if (is_array($admin)) {
	$admin = array_shift($admin);
}
$sendemail = true;

?>
<script type="text/javascript">
$(document).ready(function() {
	$("#user_type").change(function() {
		var type = $(this).val();
		$('.occupation-choices').hide();

		if (type == 'federal') {
			$('#federal-wrapper').fadeIn();
		} else if (type == 'academic' || type == 'student') {
			if( type == 'academic' ){
				if( $("#institution").val() == 'highschool' ){ $("#institution").prop('selectedIndex', 0); }
				$("#institution option[value='highschool']").hide();
			} else {
				$("#institution option[value='highschool']").show();
			}
			$('#institution-wrapper').fadeIn();
			var institution = $('#institution').val();
			$('#' + institution + '-wrapper').fadeIn();
		} else if (type == 'provincial') {
			$('#provincial-wrapper').fadeIn();
			var province = $('#provincial').val();
			province = province.replace(/\s+/g, '-').toLowerCase();
			$('#' + province + '-wrapper').fadeIn();
		} else {
			$('#' + type + '-wrapper').fadeIn();
		}
	});

	$("#institution").change(function() {
		var type = $(this).val();
		$('.student-choices').hide();
		$('#' + type + '-wrapper').fadeIn();
	});

	$("#provincial").change(function() {
		var province = $(this).val();
		province = province.replace(/\s+/g, '-').toLowerCase();
		$('.provincial-choices').hide();
		$('#' + province + '-wrapper').fadeIn();
	});

	$("form.elgg-form-useradd").on("submit", function(){
	    $(".occupation-choices select:not(:visible), .occupation-choices input:not(:visible)").attr('disabled', 'disabled');
	    $(".occupation-choices select:visible, .occupation-choices input:visible").removeAttr('disabled');
	});
});
</script>

<div>
	<label for="user_type" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:occupation'); ?></span></label><br />
	<select id="user_type" name="user_type" class="form-control">
		<option value="academic"><?php echo elgg_echo('gcRegister:occupation:academic'); ?></option>
		<option value="student"><?php echo elgg_echo('gcRegister:occupation:student'); ?></option>
		<option value="federal"><?php echo elgg_echo('gcRegister:occupation:federal'); ?></option>
		<option value="provincial"><?php echo elgg_echo('gcRegister:occupation:provincial'); ?></option>
		<option value="municipal"><?php echo elgg_echo('gcRegister:occupation:municipal'); ?></option>
		<option value="international"><?php echo elgg_echo('gcRegister:occupation:international'); ?></option>
		<option value="ngo"><?php echo elgg_echo('gcRegister:occupation:ngo'); ?></option>
		<option value="community"><?php echo elgg_echo('gcRegister:occupation:community'); ?></option>
		<option value="business"><?php echo elgg_echo('gcRegister:occupation:business'); ?></option>
		<option value="media"><?php echo elgg_echo('gcRegister:occupation:media'); ?></option>
		<option value="retired"><?php echo elgg_echo('gcRegister:occupation:retired'); ?></option>
		<option value="other"><?php echo elgg_echo('gcRegister:occupation:other'); ?></option>
	</select>
</div>

<!-- Universities or Colleges -->
<div class="form-group occupation-choices" id="institution-wrapper">
	<label for="institution" class="required"><span class="field-name"><?php echo elgg_echo('Institution'); ?></span></label><br />
	<select id="institution" name="institution" class="form-control">
		<option value="university"> <?php echo elgg_echo('gcRegister:university'); ?> </option>
		<option value="college"> <?php echo elgg_echo('gcRegister:college'); ?> </option>
		<option value="highschool" hidden> <?php echo elgg_echo('gcRegister:highschool'); ?> </option>
	</select>
</div>

<?php
	$uniObj = elgg_get_entities(array(
	   	'type' => 'object',
	   	'subtype' => 'universities',
	));
	$unis = get_entity($uniObj[0]->guid);

	$universities = array();
	if (get_current_language() == 'en'){
		$universities = json_decode($unis->universities_en, true);
	} else {
		$universities = json_decode($unis->universities_fr, true);
	}

	// default to invalid value, so it encourages users to select
	$university_choices = elgg_view('input/select', array(
		'name' => 'university',
		'id' => 'university',
        'class' => 'form-control',
		'options_values' => $universities,
	));
?>

<!-- Universities -->
<div class="occupation-choices student-choices" id="university-wrapper" hidden>
	<label for="university" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:university'); ?></span></label><br />
	<?php echo $university_choices; ?>
</div>

<?php
	$colObj = elgg_get_entities(array(
	   	'type' => 'object',
	   	'subtype' => 'colleges',
	));
	$cols = get_entity($colObj[0]->guid);

	$colleges = array();
	if (get_current_language() == 'en'){
		$colleges = json_decode($cols->colleges_en, true);
	} else {
		$colleges = json_decode($cols->colleges_fr, true);
	}

	// default to invalid value, so it encourages users to select
	$college_choices = elgg_view('input/select', array(
		'name' => 'college',
		'id' => 'college',
        'class' => 'form-control',
		'options_values' => $colleges,
	));
?>

<!-- Colleges -->
<div class="occupation-choices student-choices" id="college-wrapper" hidden>
	<label for="college" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:college'); ?></span></label><br />
	<?php echo $college_choices; ?>
</div>

<?php
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

	// default to invalid value, so it encourages users to select
	$federal_choices = elgg_view('input/select', array(
		'name' => 'federal',
		'id' => 'federal',
        'class' => 'form-control',
		'options_values' => $federal_departments,
	));
?>

<div class="form-group occupation-choices" id="federal-wrapper" hidden>
	<label for="federal" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label><br />
	<?php echo $federal_choices; ?>
</div>

<?php
	$provObj = elgg_get_entities(array(
	   	'type' => 'object',
	   	'subtype' => 'provinces',
	));
	$provs = get_entity($provObj[0]->guid);

	$provincial_departments = array();
	if (get_current_language() == 'en'){
		$provincial_departments = json_decode($provs->provinces_en, true);
	} else {
		$provincial_departments = json_decode($provs->provinces_fr, true);
	}

	// default to invalid value, so it encourages users to select
	$provincial_choices = elgg_view('input/select', array(
		'name' => 'provincial',
		'id' => 'provincial',
        'class' => 'form-control',
		'options_values' => $provincial_departments,
	));
?>

<div class="form-group occupation-choices" id="provincial-wrapper" hidden>
	<label for="provincial" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:province'); ?></span></label><br />
	<?php echo $provincial_choices; ?>
</div>

<?php
	$minObj = elgg_get_entities(array(
	   	'type' => 'object',
	   	'subtype' => 'ministries',
	));
	$mins = get_entity($minObj[0]->guid);

	$ministries = array();
	if (get_current_language() == 'en'){
		$ministries = json_decode($mins->ministries_en, true);
	} else {
		$ministries = json_decode($mins->ministries_fr, true);
	}

	foreach($provincial_departments as $province => $province_name){
		$prov_id = str_replace(" ", "-", strtolower($province));
		echo '<div class="occupation-choices provincial-choices" id="' . $prov_id . '-wrapper" hidden><label for="' . $prov_id . '" class="required"><span class="field-name">' . elgg_echo('gcRegister:ministry') . '</span></label><br />';
		echo elgg_view('input/select', array(
			'name' => 'ministry',
			'id' => $prov_id,
	        'class' => 'form-control',
			'options_values' => $ministries[$province],
		));
		echo '</div>';
	}
?>

<?php
	$munObj = elgg_get_entities(array(
	   	'type' => 'object',
	   	'subtype' => 'municipal',
	));
	$municipals = get_entity($munObj[0]->guid);

	$municipal = array();
	if (get_current_language() == 'en'){
		$municipal = json_decode($municipals->municipal_en, true);
	} else {
		$municipal = json_decode($municipals->municipal_fr, true);
	}

	$municipal_choices = elgg_view('input/text', array(
		'name' => 'municipal',
		'id' => 'municipal',
        'class' => 'form-control',
        'list' => 'municipal-list'
	));
?>

<div class="form-group occupation-choices" id="municipal-wrapper" hidden>
	<label for="municipal" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label><br />
	<?php echo $municipal_choices; ?>
	<datalist id="municipal-list">
		<?php
			foreach($municipal as $municipal_name => $value){
				echo '<option value="' . $municipal_name . '">' . $value . '</option>';
			}
		?>
	</datalist>
</div>

<?php
	$international_choices = elgg_view('input/text', array(
		'name' => 'international',
		'id' => 'international',
        'class' => 'form-control',
	));
?>

<div class="form-group occupation-choices" id="international-wrapper" hidden>
	<label for="international" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label><br />
	<?php echo $international_choices; ?>
</div>

<?php
	$ngo_choices = elgg_view('input/text', array(
		'name' => 'ngo',
		'id' => 'ngo',
        'class' => 'form-control',
	));
?>

<div class="form-group occupation-choices" id="ngo-wrapper" hidden>
	<label for="ngo" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label><br />
	<?php echo $ngo_choices; ?>
</div>

<?php
	$community_choices = elgg_view('input/text', array(
		'name' => 'community',
		'id' => 'community',
        'class' => 'form-control',
	));
?>

<div class="form-group occupation-choices" id="community-wrapper" hidden>
	<label for="community" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label><br />
	<?php echo $community_choices; ?>
</div>

<?php
	$business_choices = elgg_view('input/text', array(
		'name' => 'business',
		'id' => 'business',
        'class' => 'form-control',
	));
?>

<div class="form-group occupation-choices" id="business-wrapper" hidden>
	<label for="business" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label><br />
	<?php echo $business_choices; ?>
</div>

<?php
	$media_choices = elgg_view('input/text', array(
		'name' => 'media',
		'id' => 'media',
        'class' => 'form-control',
	));
?>

<div class="form-group occupation-choices" id="media-wrapper" hidden>
	<label for="media" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label><br />
	<?php echo $media_choices; ?>
</div>

<?php
	$retired_choices = elgg_view('input/text', array(
		'name' => 'retired',
		'id' => 'retired',
        'class' => 'form-control',
        'list' => 'retired-list'
	));
?>

<div class="form-group occupation-choices" id="retired-wrapper" hidden>
	<label for="retired" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label><br />
	<?php echo $retired_choices; ?>
	<datalist id="retired-list">
		<?php
			foreach($federal_departments as $federal_name => $value){
				echo '<option value="' . $value . '"></option>';
			}
		?>
	</datalist>
</div>

<?php
	$otherObj = elgg_get_entities(array(
	   	'type' => 'object',
	   	'subtype' => 'other',
	));
	$others = get_entity($otherObj[0]->guid);

	$other = array();
	if (get_current_language() == 'en'){
		$other = json_decode($others->other_en, true);
	} else {
		$other = json_decode($others->other_fr, true);
	}

	$other_choices = elgg_view('input/text', array(
		'name' => 'other',
		'id' => 'other',
        'class' => 'form-control',
        'list' => 'other-list'
	));
?>

<div class="form-group occupation-choices" id="other-wrapper" hidden>
	<label for="other" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:other'); ?></span></label><br />
	<?php echo $other_choices; ?>
	<datalist id="other-list">
		<?php
			foreach($other as $other_name => $value){
				echo '<option value="' . $other_name . '">' . $value . '</option>';
			}
		?>
	</datalist>
</div>

<div>
	<label><?php echo elgg_echo('name');?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'name',
		'value' => $name,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('username'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'username',
		'value' => $username,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('email'); ?></label><br />
	<?php
	echo elgg_view('input/text', array(
		'name' => 'email',
		'value' => $email,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('password'); ?></label><br />
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password',
		'value' => $password,
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('passwordagain'); ?></label><br />
	<?php
	echo elgg_view('input/password', array(
		'name' => 'password2',
		'value' => $password2,
	));
	?>
</div>
<div>
<?php 
	echo elgg_view('input/checkboxes', array(
		'name' => "admin",
		'options' => array(elgg_echo('admin_option') => 1),
		'value' => $admin,
	));
?>
</div>
<div>
<?php 
	echo elgg_view('input/checkboxes', array(
		'name' => "sendemail",
		'options' => array(elgg_echo('sendemail') => 1),
		'value' => $sendemail,
	));
?>
</div>

<div class="elgg-foot">
	<?php echo elgg_view('input/submit', array('value' => elgg_echo('register'))); ?>
</div>