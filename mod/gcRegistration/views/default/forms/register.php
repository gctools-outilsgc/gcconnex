<?php
/**
 * Elgg register form
 *
 */

$password = $password2 = '';
$username = get_input('e');
$email = get_input('e');
$name = get_input('n');

if (elgg_is_sticky_form('register')) {
	extract(elgg_get_sticky_values('register'));
	elgg_clear_sticky_form('register');
}

$account_exist_message = elgg_echo('registration:userexists');
?>

<style>
	.registration-error {
		color: red;
	}
</style>

<script>
	var frDepartmentsGeds = {};
	var enDepartmentsGeds = {};
	$(document).ready(function() {
		$.ajax({
			type: 'POST',
			contentType: "application/json",
			url: 'https://api.sage-geds.gc.ca',
			data: "{\"requestID\" : \"B01\", \"authorizationID\" : \"X4GCCONNEX\"}",
			dataType: 'json',
			success: function(feed) {
				var departments = feed.requestResults.departmentList;
				for (var i = 0; i < departments.length; i++) {
					enDepartmentsGeds[departments[i].dn] = departments[i].desc;
				}

				$.ajax({
					type: 'POST',
					contentType: "application/json",
					url: 'https://api.sage-geds.gc.ca/fr/GAPI/',
					data: "{\"requestID\" : \"B01\", \"authorizationID\" : \"X4GCCONNEX\"}",
					dataType: 'json',
					success: function(feed) {
						var departments = feed.requestResults.departmentList;
						for (var i = 0; i < departments.length; i++) {
							frDepartmentsGeds[departments[i].dn] = departments[i].desc;
						}
					},
					complete: function() {
						elgg.action('saveDept', {
							data: {
								listEn: JSON.stringify(enDepartmentsGeds),
								listFr: JSON.stringify(frDepartmentsGeds),
							}
						})
					}
				});
			}
		});
	});

	function check_fields2() {
		var is_valid = true;

		$('.registration-error').each(function() {
			var error = $(this).attr('id');
			if (error !== undefined && document.getElementById(error).innerHTML !== '') {
				is_valid = false;
				return false;
			}
		});
		return is_valid;
	}

	function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
</script>

<!-- start of standard form -->
<div id="standard_version" class="row">

	<section class="col-md-6">
		<?php
			echo elgg_echo('gcRegister:email_notice') ;
			$js_disabled = false;
		?>
	</section>
	<section class="col-md-6">
		<div class="panel panel-default">
			<header class="panel-heading">
				<h3 class="panel-title"><?php echo elgg_echo('gcRegister:form'); ?></h3>
			</header>
			<div class="panel-body mrgn-lft-md">
				<div class="form-group">
					<label for="email_initial" class="required">
						<span class="field-name"><?php echo elgg_echo('gcRegister:email_initial'); ?></span>
						<strong class="required">(required)</strong>
					</label>
					<span id="email_initial_error" class="registration-error"></span>
					<br />
					<input type="text" name="email_initial" id="email_initial" value='<?php echo $email ?>' class="form-control" />
				</div>

				<div class="form-group">
					<label for="email" class="required">
						<span class="field-name"><?php echo elgg_echo('gcRegister:email_secondary'); ?></span>
						<strong class="required">(required)</strong>
					</label>
					<span id="email_secondary_error" class="registration-error"></span>
					<br />
					<input id="email" class="form-control" type="text" value='<?php echo $email ?>' name="email" />
					<script>
						$('#email').blur(function() {
							elgg.action('register/ajax', {
								data: {
									args: document.getElementById('email').value
								},
								success: function(x) {
									//create username
									$('.username_test').val(x.output);
									//Nick - Testing here if the username already exists and add a feedback to the user
									if (x.output == "<?php echo '> ' . elgg_echo('gcRegister:email_in_use'); ?>") {
										$('.already-registered-message span').html("<?php echo $account_exist_message; ?>").removeClass('hidden');
									} else {
										$('.already-registered-message span').addClass('hidden');
									}

									//generate display name (remove '.' in name)
									var dName = $('.username_test').val();

									if (dName.indexOf('.') != false) {
										dName = dName.replace(/\./g, ' ');
									}

									$('.display_name').val(dName);
								}
							});
						});
					</script>
				</div>

				<div class="return_message"></div>

				<div class="form-group">
					<label for="department" class="required"><span class="field-name"><?php echo elgg_echo('gcRegister:department'); ?></span><strong class="required">(required)</strong></label>
					<?php
					$obj = elgg_get_entities(array(
						'type' => 'object',
						'subtype' => 'dept_list',
						'owner_guid' => elgg_get_logged_in_user_guid()
					));
					$provinces = array();
					if (get_current_language()=='en') {
						$departments = $obj[0]->deptsEn;
						$provinces['pov-alb'] = 'Government of Alberta';
						$provinces['pov-bc'] = 'Government of British Columbia';
						$provinces['pov-man'] = 'Government of Manitoba';
						$provinces['pov-nb'] = 'Government of New Brunswick';
						$provinces['pov-nfl'] = 'Government of Newfoundland and Labrador';
						$provinces['pov-ns'] = 'Government of Nova Scotia';
						$provinces['pov-nwt'] = 'Government of Northwest Territories';
						$provinces['pov-nun'] = 'Government of Nunavut';
						$provinces['pov-ont'] = 'Government of Ontario';
						$provinces['pov-pei'] = 'Government of Prince Edward Island';
						$provinces['pov-que'] = 'Government of Quebec';
						$provinces['pov-sask'] = 'Government of Saskatchewan';
						$provinces['pov-yuk'] = 'Government of Yukon';
						$provinces['CIRNAC-RCAANC'] = 'Crown-Indigenous Relations and Northern Affairs Canada';
					} else {
						$departments = $obj[0]->deptsFr;
						$provinces['pov-alb'] = "Gouvernement de l'Alberta";
						$provinces['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
						$provinces['pov-man'] = 'Gouvernement du Manitoba';
						$provinces['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
						$provinces['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
						$provinces['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
						$provinces['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
						$provinces['pov-nun'] = 'Gouvernement du Nunavut';
						$provinces['pov-ont'] = "Gouvernement de l'Ontario";
						$provinces['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
						$provinces['pov-que'] = 'Gouvernement du Québec';
						$provinces['pov-sask'] = 'Gouvernement de Saskatchewan';
						$provinces['pov-yuk'] = 'Gouvernement du Yukon';
						$provinces['CIRNAC-RCAANC'] = 'Relations Couronne-Autochtones et Affaires du Nord Canada';
					}
					$departments = json_decode($departments, true);
					unset($departments['ou=INAC-AANC, o=GC, c=CA']);
					echo elgg_view('input/select', array(
						'name' => 'department',
						'id' => 'department',
						'class' => 'department_test form-control',
						'options_values' => array_merge($departments, $provinces),
					));
					?>
				</div>
				<div class="form-group">
					<label for="username" class="required">
						<span class="field-name"><?php echo elgg_echo('gcRegister:username'); ?></span>
						<strong class="required">(required)</strong>
					</label>
					<div class="already-registered-message mrgn-bttm-sm">
						<span class="label label-danger tags mrgn-bttm-sm"></span>
					</div>
					<?php
					echo elgg_view('input/text', array(
						'name' => 'username',
						'id' => 'username',
						'class' => 'username_test form-control',
						'readonly' => 'readonly',
						'value' => $username,
					));
					?>
				</div>

				<div class="form-group">
					<label for="password" class="required">
						<span class="field-name"><?php echo elgg_echo('gcRegister:password_initial'); ?></span>
						<strong class="required">(required)</strong>
					</label>
					<span id="password_initial_error" class="registration-error"></span>
					<br />
					<?php
					echo elgg_view('input/password', array(
						'name' => 'password',
						'id' => 'password',
						'class'=>'password_test form-control',
						'value' => $password,
					));
					?>
				</div>

				<div class="form-group">
					<label for="password2" class="required">
						<span class="field-name"><?php echo elgg_echo('gcRegister:password_secondary'); ?></span>
						<strong class="required">(required)</strong>
					</label>
					<span id="password_secondary_error" class="registration-error"></span>
					<br />
					<?php
					echo elgg_view('input/password', array(
						'name' => 'password2',
						'value' => $password2,
						'id' => 'password2',
						'class'=>'password2_test form-control',
					));
					?>
				</div>

				<div class="form-group">
					<label for="name" class="required">
						<span class="field-name"><?php echo elgg_echo('gcRegister:display_name'); ?></span>
						<strong class="required">(required)</strong>
					</label>
					<?php
					echo elgg_view('input/text', array(
						'name' => 'name',
						'id' => 'name',
						'class' => 'form-control display_name',
						'value' => $name,
					));
					?>
				</div>
				<div class="alert alert-info">
					<?php echo elgg_echo('gcRegister:display_name_notice'); ?>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" value="1" name="toc2" id="toc2" />
						<?php echo elgg_echo('gcRegister:terms_and_conditions')?>
					</label>
				</div>
				<?php
				// view to extend to add more fields to the registration form
				echo elgg_view('register/extend', $vars);
				// Add captcha hook
				echo elgg_view('input/captcha', $vars);
				echo '<div class="elgg-foot">';
				echo elgg_view('input/hidden', array(
					'name' => 'friend_guid',
					'value' => $vars['friend_guid']));
				echo elgg_view('input/hidden', array(
					'name' => 'invitecode',
					'value' => $vars['invitecode']));
				echo elgg_view('input/submit', array(
					'name' => 'submit',
					'value' => elgg_echo('gcRegister:register'),
					'id' => 'submit',
					'class'=>'submit_test btn-primary',
					'onclick' => 'return check_fields2();'));
				echo '</div>';
				echo '<center>'.elgg_echo('gcRegister:tutorials_notice').'</center>';
				?>
				<br/>
			</div>
		</div>
	</section>

	<script>
		$('#email_initial').on("keydown", function(e) {
			return e.which !== 32;
		});

		$('#email').on("keydown", function(e) {
			return e.which !== 32;
		});

		$('#email_initial').on("focusout", function() {
			var val = $(this).attr('value');
			if (val === '') {
				var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
				document.getElementById('email_initial_error').innerHTML = c_err_msg;
			} else if (!validateEmail(val)) {
				var c_err_msg = "<?php echo elgg_echo('gcRegister:invalid_email') ?>";
				document.getElementById('email_initial_error').innerHTML = c_err_msg;
			} else {
				document.getElementById('email_initial_error').innerHTML = '';
			}

			var val_2 = $('#email').attr('value');
			if (val_2 == val) {
				document.getElementById('email_secondary_error').innerHTML = '';
			}
		});

		$('#email').on("focusout", function() {
			var val = $(this).attr('value');
			if (val === '') {
				var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
				document.getElementById('email_secondary_error').innerHTML = c_err_msg;
			} else {
				document.getElementById('email_secondary_error').innerHTML = '';

				var val2 = $('#email_initial').attr('value');
				if (val2.toLowerCase() != val.toLowerCase()) {
					var c_err_msg = "<?php echo elgg_echo('gcRegister:mismatch') ?>";
					document.getElementById('email_secondary_error').innerHTML = c_err_msg;
				}
			}
		});

		$('.password_test').on("focusout", function() {
			var val = $(this).val();
			if (val === '') {
				var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
				document.getElementById('password_initial_error').innerHTML = c_err_msg;
			} else {
				document.getElementById('password_initial_error').innerHTML = '';
			}

			var val_2 = $('#password2').attr('value');
			if (val_2 == val) {
				document.getElementById('password_secondary_error').innerHTML = '';
			} else if (val_2 != val) {
				var c_err_msg = "<?php echo elgg_echo('gcRegister:mismatch') ?>";
				document.getElementById('password_secondary_error').innerHTML = c_err_msg;
			}
		});

		$('#password2').on("focusout", function() {
			var val = $(this).val();
			if (val === '') {
				var c_err_msg = "<?php echo elgg_echo('gcRegister:empty_field') ?>";
				document.getElementById('password_secondary_error').innerHTML = c_err_msg;
			} else {
				document.getElementById('password_secondary_error').innerHTML = '';

				var val2 = $('.password_test').val();
				if (val2 != val) {
					var c_err_msg = "<?php echo elgg_echo('gcRegister:mismatch') ?>";
					document.getElementById('password_secondary_error').innerHTML = c_err_msg;
				}
			}
		});
	</script>
</div>
