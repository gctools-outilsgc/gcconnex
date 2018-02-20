<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

/***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * TLaw/ISal 	n/a 			GC Changes
 * CYu 			March 5 2014 	Second Email field for verification & code clean up & validate email addresses
 * CYu 			July 16 2014	clearer messages & code cleanup						
 * CYu 			Sept 19 2014 	adjusted textfield rules (no spaces for emails)
 * MBlondin 	Jan 25 2016 	Layout change
 * MBlondin 	Feb 08 2016 	Delete IE7 form
 * NickP        June 9 2016     Added function to the username generation ajax to provide link to password retrival if account already exists
 * CYu 			Aug 15 2016 	GCcollab - Student / Academic (w/Universities) & Public Servants
 * MWooff 		Jan 18 2017		Re-built for GCcollab-specific functions
 *
 ***********************************************************************/

$password = $password2 = '';
$username = get_input('e');
$email = get_input('e');
$name = get_input('n');
$site_url = elgg_get_site_url();

/*if (elgg_is_sticky_form('register')) {
	extract(elgg_get_sticky_values('register'));
	elgg_clear_sticky_form('register');
}*/

// Javascript
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#user_type").change(function() {
		var type = $(this).val();
		$('.occupation-choices').hide();
		$('#organization_notice').hide();

		if (type == 'academic' || type == 'student') {
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
		} else if (type == 'municipal') {
			$('#provincial-wrapper').fadeIn();
			var province = $('#provincial').val();
			province = province.replace(/\s+/g, '-').toLowerCase();
			$('#municipal').attr('list', 'municipal-'+province+'-list');
			$('#municipal-wrapper').fadeIn();
		} else if (type == 'federal') {
			$('#' + type + '-wrapper').fadeIn();
		} else {
			$('#' + type + '-wrapper').fadeIn();
			$('#organization_notice').show();
		}
	});

	$("#institution").change(function() {
		var type = $(this).val();
		$('.student-choices').hide();
		$('#' + type + '-wrapper').fadeIn();
	});

	$("#provincial").change(function() {
		var type = $("#user_type").val();
		var province = $(this).val();
		province = province.replace(/\s+/g, '-').toLowerCase();
		if( type == 'provincial' ){
			$('.provincial-choices').hide();
			$('#' + province + '-wrapper').fadeIn();
		} else if( type == 'municipal' ){
			$('.provincial-choices').hide();
			$('#municipal').attr('list', 'municipal-'+province+'-list');
		}
	});

	// Preload form options if page was reloaded
	if(sessionStorage.length > 0){
		$('.occupation-choices').hide();
		$.each(sessionStorage, function(key, value){
			if( $("#" + key).length > 0 ){
				$("#" + key).val(value);
				$("#" + key).closest('.occupation-choices').show();
			}
		});
	}
});

// make sure the email address given does not contain invalid characters
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 
    return re.test(email);
}

// Save form options if page was reloaded
$(window).on('beforeunload', function(){
	sessionStorage.clear();
	$("form.elgg-form-register input[type=text], form.elgg-form-register select").each(function(key, value) {
		if( $(value).is(":visible") && $(value).attr('type') != 'hidden' && $(value).attr('type') != 'password' && $(value).attr('id') != 'email2' ){
			sessionStorage.setItem( $(value).attr('id'), $(value).val() );
		}
	});
});
</script>

<!-- start of standard form -->
<div id="standard_version" class="row">

	<section class="col-md-6"><div class="plm">
	<?php
	    $InviteGUID = get_input('friend_guid');
	    
	    if( $InviteGUID ):

			$userObj = get_user($InviteGUID);

			if( $userObj ):
	              
			    $userType = $userObj->user_type;
			    // if user is public servant
			    if( $userType == 'federal' ){
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

			        $department = $federal_departments[$userObj->federal];

			    // otherwise if user is student or academic
			    } else if( $userType == 'student' || $userType == 'academic' ){
			        $institution = $userObj->institution;
			        $department = ($institution == 'university') ? $userObj->university : $userObj->college;

			    // otherwise if user is provincial employee
			    } else if( $userType == 'provincial' ){
			        $provObj = elgg_get_entities(array(
			            'type' => 'object',
			            'subtype' => 'provinces',
			        ));
			        $provs = get_entity($provObj[0]->guid);

			        $provinces = array();
			        if (get_current_language() == 'en'){
			            $provinces = json_decode($provs->provinces_en, true);
			        } else {
			            $provinces = json_decode($provs->provinces_fr, true);
			        }

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

			        $department = $provinces[$userObj->provincial];
			        if($userObj->ministry && $userObj->ministry !== "default_invalid_value"){ $department .= ' / ' . $ministries[$userObj->provincial][$userObj->ministry]; }

			    // otherwise show basic info
			    } else {
			        $department = $userObj->$userType;
			    }
	?>
				<p><strong><?php echo $userObj->name . elgg_echo('gcRegister:has_invited'); ?></strong></p>
			    <hr class="mtm mbm">
			    <div class="clearfix mrgn-bttm-sm">
			        <div class="row mrgn-lft-0 mrgn-rght-sm">
			            <div class="col-xs-4">
			                <div class="mrgn-tp-sm">
			                <?php echo elgg_view_entity_icon($userObj, 'medium', array('use_hover' => false, 'class' => 'pro-avatar', 'force_size' => true)); ?>
			                </div>
			            </div>

			            <div class="col-xs-8">
			                <h4 class="mrgn-tp-sm mrgn-bttm-0"><?php echo $userObj->name; ?></h4>
			                <div><?php echo $userObj->job; ?></div>
			                <div><?php echo $department; ?></div>
			            </div>
			        </div>
			    </div>
			    <hr class="mtm mbl">
	<?php
	    	endif;
	    endif;
		
		echo elgg_echo('gcRegister:welcome_message');
	?>
	</div></section>

	<!-- Registration Form -->
	<section class="col-md-6">
		<div class="panel panel-default">
			<header class="panel-heading"> <h3 class="panel-title"><?php echo elgg_echo('gcRegister:form'); ?></h3> </header>
			<div class="panel-body mrgn-lft-md">

				<!-- User Types -->
				<div class="form-group">
					<label for="user_type" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:occupation'); ?></span> <strong class="required">(<?php echo elgg_echo('gcRegister:required'); ?>)</strong></label>
					<?php
						$departments = array(
							'academic' => elgg_echo('gcRegister:occupation:academic'),
							'student' => elgg_echo('gcRegister:occupation:student'),
							'federal' => elgg_echo('gcRegister:occupation:federal'),
							'provincial' => elgg_echo('gcRegister:occupation:provincial'),
							'municipal' => elgg_echo('gcRegister:occupation:municipal'),
							'international' => elgg_echo('gcRegister:occupation:international'),
							'ngo' => elgg_echo('gcRegister:occupation:ngo'),
							'community' => elgg_echo('gcRegister:occupation:community'),
							'business' => elgg_echo('gcRegister:occupation:business'),
							'media' => elgg_echo('gcRegister:occupation:media'),
							'retired' => elgg_echo('gcRegister:occupation:retired'),
							'other' => elgg_echo('gcRegister:occupation:other')
						);

						echo elgg_view('input/select', array(
							'name' => 'user_type',
							'id' => 'user_type',
			        		'class' => 'form-control',
							'aria-required' => 'true',
							'required' => true,
							'options_values' => $departments
						));
					?>
				</div>
				<!-- End User Types -->

			<!-- Organizations -->
				<!-- University/College/High School -->
				<div class="form-group occupation-choices" id="institution-wrapper">
					<label for="institution" class="required"><span class="field-name"><?php echo elgg_echo('Institution'); ?></span></label>
					<?php
						$institutions = array(
							'default_invalid_value' => elgg_echo('gcRegister:make_selection'),
							'university' => elgg_echo('gcRegister:university'),
							'college' => elgg_echo('gcRegister:college'),
							'highschool' => elgg_echo('gcRegister:highschool')
						);

						echo elgg_view('input/select', array(
							'name' => 'institution',
							'id' => 'institution',
			        		'class' => 'form-control',
			        		'value' => 'default_invalid_value',
							'options_values' => $institutions
						));
					?>
				</div>
				<!-- End University/College/High School -->

				<!-- Universities -->
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
					asort($universities);

					// default to invalid value, so it encourages users to select
					$university_choices = elgg_view('input/select', array(
						'name' => 'university',
						'id' => 'university',
				        'class' => 'form-control',
						'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $universities),
					));
				?>

				<div class="form-group occupation-choices student-choices" id="university-wrapper" hidden>
					<label for="university" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:university'); ?></span></label>
					<?php echo $university_choices; ?>
				</div>
				<!-- End Universities -->

				<!-- Colleges -->
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
					asort($colleges);

					// default to invalid value, so it encourages users to select
					$college_choices = elgg_view('input/select', array(
						'name' => 'college',
						'id' => 'college',
				        'class' => 'form-control',
						'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $colleges),
					));
				?>

				<div class="form-group occupation-choices student-choices" id="college-wrapper" hidden>
					<label for="college" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:college'); ?></span></label>
					<?php echo $college_choices; ?>
				</div>
				<!-- End Colleges -->

				<!-- High Schools -->
				<?php
					$highschool_choices = elgg_view('input/text', array(
						'name' => 'highschool',
						'id' => 'highschool',
				        'class' => 'form-control',
					));
				?>

				<div class="form-group occupation-choices student-choices" id="highschool-wrapper" hidden>
					<label for="highschool" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:highschool'); ?></span></label>
					<?php echo $highschool_choices; ?>
				</div>
				<!-- End High Schools -->


				<!-- Federal Government -->
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
					asort($federal_departments);

					// default to invalid value, so it encourages users to select
					$federal_choices = elgg_view('input/select', array(
						'name' => 'federal',
						'id' => 'federal',
				        'class' => 'form-control',
						'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $federal_departments),
					));
				?>

				<div class="form-group occupation-choices" id="federal-wrapper" hidden>
					<label for="federal" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
					<?php echo $federal_choices; ?>
				</div>
				<!-- End Federal Government -->

				<!-- Provincial/Territorial Government -->
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
					asort($provincial_departments);

					// default to invalid value, so it encourages users to select
					$provincial_choices = elgg_view('input/select', array(
						'name' => 'provincial',
						'id' => 'provincial',
				        'class' => 'form-control',
						'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $provincial_departments),
					));
				?>

				<div class="form-group occupation-choices" id="provincial-wrapper" hidden>
					<label for="provincial" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:province'); ?></span></label>
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
					asort($ministries);

					if( !empty($provincial_departments) ){
						foreach($provincial_departments as $province => $province_name){
							asort($ministries[$province]);

							$prov_id = str_replace(" ", "-", strtolower($province));
							echo '<div class="form-group occupation-choices provincial-choices" id="' . $prov_id . '-wrapper" hidden><label for="' . $prov_id . '" class="required"><span class="field-name">' . elgg_echo('gcRegister:ministry') . '</span></label>';
							echo elgg_view('input/select', array(
								'name' => 'ministry',
								'id' => $prov_id,
						        'class' => 'form-control',
								'options_values' => array_merge(array('default_invalid_value' => elgg_echo('gcRegister:make_selection')), $ministries[$province]),
							));
							echo '</div>';
						}
					}
				?>
				<!-- End Provincial/Territorial Government -->

				<!-- Municipal Government -->
				<?php
					$munObj = elgg_get_entities(array(
					   	'type' => 'object',
					   	'subtype' => 'municipal',
					));
					$municipals = get_entity($munObj[0]->guid);

					$municipal_choices = elgg_view('input/text', array(
						'name' => 'municipal',
						'id' => 'municipal',
				        'class' => 'form-control',
				        'list' => ''
					));
				?>

				<div class="form-group occupation-choices" id="municipal-wrapper" hidden>
					<label for="municipal" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:city'); ?></span></label>
					<?php echo $municipal_choices; ?>
					<?php
						if( !empty($provincial_departments) ){
							foreach($provincial_departments as $province => $province_name){
								$municipal = json_decode($municipals->get($province), true);
								$prov_id = str_replace(" ", "-", strtolower($province));

								echo '<datalist id="municipal-'.$prov_id.'-list">';
										if( !empty($municipal) ){
											asort($municipal);
											
											foreach($municipal as $municipal_name => $value){
												echo '<option value="' . $municipal_name . '">' . $value . '</option>';
											}
										}
								echo '</datalist>';
							}
						}
					?>
				</div>
				<!-- End Municipal Government -->

				<!-- International/Foreign Government -->
				<?php
					$international_choices = elgg_view('input/text', array(
						'name' => 'international',
						'id' => 'international',
				        'class' => 'form-control',
					));
				?>

				<div class="form-group occupation-choices" id="international-wrapper" hidden>
					<label for="international" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
					<?php echo $international_choices; ?>
				</div>
				<!-- End International/Foreign Government -->


				<!-- Non-Governmental Organization -->
				<?php
					$ngo_choices = elgg_view('input/text', array(
						'name' => 'ngo',
						'id' => 'ngo',
				        'class' => 'form-control',
					));
				?>

				<div class="form-group occupation-choices" id="ngo-wrapper" hidden>
					<label for="ngo" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
					<?php echo $ngo_choices; ?>
				</div>
				<!-- End Non-Governmental Organization -->


				<!-- Community/Non-profit -->
				<?php
					$community_choices = elgg_view('input/text', array(
						'name' => 'community',
						'id' => 'community',
				        'class' => 'form-control',
					));
				?>

				<div class="form-group occupation-choices" id="community-wrapper" hidden>
					<label for="community" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
					<?php echo $community_choices; ?>
				</div>
				<!-- End Community/Non-profit -->

				<!-- Business -->
				<?php
					$business_choices = elgg_view('input/text', array(
						'name' => 'business',
						'id' => 'business',
				        'class' => 'form-control',
					));
				?>

				<div class="form-group occupation-choices" id="business-wrapper" hidden>
					<label for="business" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
					<?php echo $business_choices; ?>
				</div>
				<!-- End Business -->

				<!-- Media -->
				<?php
					$media_choices = elgg_view('input/text', array(
						'name' => 'media',
						'id' => 'media',
				        'class' => 'form-control',
					));
				?>

				<div class="form-group occupation-choices" id="media-wrapper" hidden>
					<label for="media" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
					<?php echo $media_choices; ?>
				</div>
				<!-- End Media -->

				<!-- Retired Public Servant -->
				<?php
					$retired_choices = elgg_view('input/text', array(
						'name' => 'retired',
						'id' => 'retired',
				        'class' => 'form-control',
				        'list' => 'retired-list'
					));
				?>

				<div class="form-group occupation-choices" id="retired-wrapper" hidden>
					<label for="retired" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
					<?php echo $retired_choices; ?>
					<datalist id="retired-list">
						<?php
							if( !empty($federal_departments) ){
								foreach($federal_departments as $federal_name => $value){
									echo '<option value="' . $value . '"></option>';
								}
							}
						?>
					</datalist>
				</div>
				<!-- End Retired Public Servant -->

				<!-- Other -->
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
					asort($other);

					$other_choices = elgg_view('input/text', array(
						'name' => 'other',
						'id' => 'other',
				        'class' => 'form-control',
				        'list' => 'other-list'
					));
				?>

				<div class="form-group occupation-choices" id="other-wrapper" hidden>
					<label for="other" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span></label>
					<?php echo $other_choices; ?>
					<datalist id="other-list">
						<?php
							if( !empty($other) ){
								foreach($other as $other_name => $value){
									echo '<option value="' . $other_name . '">' . $value . '</option>';
								}
							}
						?>
					</datalist>
				</div>
				<!-- End Other -->

		    <div id="organization_notice" class="alert alert-info mrgn-bttm-md" hidden><?php echo elgg_echo('gcRegister:organization_notice'); ?></div>
			<!-- End Organizations -->
				
				<!-- Display Name -->
				<div class="form-group">
					<label for="name" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:display_name'); ?></span> <strong class="required">(<?php echo elgg_echo('gcRegister:required'); ?>)</strong></label>
					<font id="name_error" color="red"></font>
					<?php
						echo elgg_view('input/text', array(
							'name' => 'name',
							'id' => 'name',
					        'class' => 'form-control display_name',
							'value' => $name,
							'aria-describedby' => 'display_name_notice',
							'aria-required' => 'true',
							'required' => true
						));
					?>
				</div>
		    	<div id="display_name_notice" class="alert alert-info mrgn-bttm-md"><?php echo elgg_echo('gcRegister:display_name_notice'); ?></div>
				<!-- End Display Name -->

				<!-- Email -->
				<div class="form-group">
					<label for="email" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:email'); ?></span> <strong class="required">(<?php echo elgg_echo('gcRegister:required'); ?>)</strong></label>
	    			<font id="email_error" color="red"></font>
	    			<?php
						echo elgg_view('input/text', array(
							'name' => 'email',
							'id' => 'email',
					        'class' => 'form-control',
							'aria-required' => 'true',
							'required' => true
						));
					?>

		    		<script>	
		        		$('#email').blur(function () {
		            		elgg.action( 'register/ajax', {
								data: {
									email: $('#email').val()
								},
								success: function (x) {
									var message = x.output;
									if(message.indexOf(">") >= 0){
										$('#email_error').html(message).removeClass('hidden');
									} else {
				    					$('#email_error').addClass('hidden');
				    				}
								}
							});
		        		});
		    		</script>
				</div>
				<!-- End Email -->

				<!-- Email2 -->
				<div class="form-group">
					<label for="email2" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:email_secondary'); ?></span> <strong class="required">(<?php echo elgg_echo('gcRegister:required'); ?>)</strong></label>
					<font id="email_secondary_error" color="red"></font>
					<?php
						echo elgg_view('input/text', array(
							'name' => 'email2',
							'id' => 'email2',
					        'class' => 'form-control',
							'aria-required' => 'true',
							'required' => true
						));
					?>
				</div>
				<!-- End Email2 -->

				<!-- Password -->
				<div class="form-group">
					<label for="password" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:password_initial'); ?></span> <strong class="required">(<?php echo elgg_echo('gcRegister:required'); ?>)</strong></label>
					<font id="password_initial_error" color="red"></font>
					<?php
						echo elgg_view('input/password', array(
							'name' => 'password',
							'id' => 'password1',
					        'class' => 'password_test form-control',
							'value' => $password,
							'aria-required' => 'true',
							'required' => true
						));
					?>
				</div>
				<!-- End Password -->

				<!-- Password2 -->
				<div class="form-group">
					<label for="password2" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:password_secondary'); ?></span> <strong class="required">(<?php echo elgg_echo('gcRegister:required'); ?>)</strong></label>
				    <font id="password_secondary_error" color="red"></font>
					<?php
						echo elgg_view('input/password', array(
							'name' => 'password2',
							'id' => 'password2',
					        'class' => 'password2_test form-control',
							'value' => $password2,
							'aria-required' => 'true',
							'required' => true
						));
					?>
				</div>
				<!-- End Password2 -->

				<!-- Terms and Conditions -->
			    <div class="checkbox">
			    	<label for="toc2">
			    	<?php
			    		echo elgg_view('input/checkbox', array(
							'name' => 'toc2',
							'id' => 'toc2',
							'value' => '1',
							'aria-required' => 'true',
							'required' => true
						));
						echo elgg_echo('gcRegister:terms_and_conditions');
					?>
					</label>
			    </div>
				<!-- End Terms and Conditions -->

				<?php
					// view to extend to add more fields to the registration form
					echo elgg_view('register/extend', $vars);

					// Add captcha hook
					echo elgg_view('input/captcha', $vars);
					echo '<div class="elgg-foot">';
					echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
					echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));

					// note: disable
					echo elgg_view('input/submit', array(
					    'value' => elgg_echo('gcRegister:register'),
					    'class' => 'btn-primary'
					));
					echo '</div>';
				?>
	            
			</div>
		</div>
	</section>

<script>
	// check if the initial email input is empty, then proceed to validate email
    $('#email').on("focusout", function() {
    	var val = $(this).val();
        if ( val === '' ) {
        	var c_err_msg = '<?php echo elgg_echo('gcRegister:empty_field') ?>';
            document.getElementById('email_error').innerHTML = c_err_msg;
        } else if ( val !== '' ) {
            document.getElementById('email_error').innerHTML = '';
            
            if (!validateEmail(val)) {
            	var c_err_msg = '<?php echo elgg_echo('gcRegister:invalid_email') ?>';
            	document.getElementById('email_error').innerHTML = c_err_msg;
            }
        }
    });

    // Disable cut/copy/paste for email fields
	$('#email, #email2').bind("cut copy paste", function(e) {
		e.preventDefault();
	});

    // check if secondary email is valid, then check if email fields match
    $('#email2').on("focusout", function() {
    	var val = $(this).val();
        if ( val === '' ) {
        	var c_err_msg = '<?php echo elgg_echo('gcRegister:empty_field') ?>';
            document.getElementById('email_secondary_error').innerHTML = c_err_msg;
        } else if ( val !== '' ) {
            document.getElementById('email_secondary_error').innerHTML = '';
            
            if (!validateEmail(val)) {
            	var c_err_msg = '<?php echo elgg_echo('gcRegister:invalid_email') ?>';
            	document.getElementById('email_secondary_error').innerHTML = c_err_msg;
            }

            var val2 = $('#email').attr('value');
			if (val2.toLowerCase() != val.toLowerCase()){
				var c_err_msg = "<?php echo elgg_echo('gcRegister:mismatch') ?>";
				document.getElementById('email_secondary_error').innerHTML = c_err_msg;
			}
        }
    });

    $('.password_test').on("focusout", function() {
    	var val = $(this).val();
	    if ( val === '' ) {
	    	var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
	        document.getElementById('password_initial_error').innerHTML = c_err_msg;
	    } else if ( val !== '' ) {
	        document.getElementById('password_initial_error').innerHTML = '';
	    }

        var val_2 = $('#password2').val();
        if (val_2 == val) {
	        document.getElementById('password_secondary_error').innerHTML = '';
        } else if (val_2 !== '' && val_2 != val) {
            var c_err_msg = "<?php echo elgg_echo('gcRegister:mismatch') ?>";
	        document.getElementById('password_secondary_error').innerHTML = c_err_msg;
        }
	});	
    
    $('#password2').on("focusout", function() {
    	var val = $(this).val();
	    if ( val === '' ) {
	    	var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
	        document.getElementById('password_secondary_error').innerHTML = c_err_msg;
	    } else if ( val !== '' ) {
	        document.getElementById('password_secondary_error').innerHTML = '';
	        
	        var val2 = $('.password_test').val();
	        if (val2 != val) {
	        	var c_err_msg = "<?php echo elgg_echo('gcRegister:mismatch') ?>";
	        	document.getElementById('password_secondary_error').innerHTML = c_err_msg;
	        }
	    }
	});
    
    $('#name').on("focusout", function() {
    	var val = $(this).val();
        if ( val === '' ) {
        	var c_err_msg = '<?php echo elgg_echo('gcRegister:empty_field') ?>';
            document.getElementById('name_error').innerHTML = c_err_msg;
        } else if ( val !== '' ) {
            document.getElementById('name_error').innerHTML = '';
        }
    });

    $("form.elgg-form-register").on("submit", function(){
	    $(".occupation-choices select:not(:visible), .occupation-choices input:not(:visible)").attr('disabled', 'disabled');
	    $(".occupation-choices select:visible, .occupation-choices input:visible").removeAttr('disabled');
	});
</script>

</div>
