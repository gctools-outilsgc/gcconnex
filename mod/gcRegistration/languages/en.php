<?php

$english = array(
	// labels
	'gcRegister:email_initial' => 'Enter your e-mail',
	'gcRegister:email_secondary' => 'Confirm your e-mail',
	'gcRegister:username' => 'Your username (auto-generated)',
	'gcRegister:password_initial' => 'Password',
	'gcRegister:password_secondary' => 'Confirm your Password',
	'gcRegister:display_name' => 'Display name',
	'gcRegister:display_name_notice' => 'Please enter your first and last name, as you are known in the workplace. As per the Terms and Conditions, your display name must reflect your real name. Pseudonyms are not allowed.',
	'gcRegister:please_enter_email' => 'Please enter email',
	'gcRegister:department_name' => 'Enter your Department',
	'gcRegister:register' => 'Register',

	// error messages on the form
	'gcRegister:failedMySQLconnection' => 'Unable to connect to the database',
	'gcRegister:invalid_email' => '<a href="#email_initial">Invalid email</a>',
    'gcRegister:invalid_email2' => 'Invalid email',
	'gcRegister:empty_field' => 'empty field',
	'gcRegister:mismatch' => 'mismatch',

	// notice
	'gcRegister:email_notice' => '

		<h2 class="h2">Please create your account.</h2>

		<ol>
        <li>The system can only create GCconnex accounts using a valid Government of Canada email address ending in gc.ca or canada.ca. If your Government email address is different and you have received an “invalid email notice”, please contact <a href="mailto:GCconnex@tbs-sct.gc.ca">GCconnex@tbs-sct.gc.ca</a>.</li>
		<li>The system will not let you create a second account with the same email address. If you get an “This email address has already been registered” error, you likely already have a GCconnex account. Please contact <a href="mailto:GCconnex@tbs-sct.gc.ca">GCconnex@tbs-sct.gc.ca</a> to retrieve your GCconnex account credentials.</li>
		<li>Before you are able to login to GCconnex, you will receive a validation email and you must validate your account. If you do not receive the email, please contact <a href="mailto:GCconnex@tbs-sct.gc.ca">GCconnex@tbs-sct.gc.ca</a>.</li>
		</ol>
	',
	'gcRegister:terms_and_conditions' => 'I have read, understood, and agree to the <a target="_blank" href="http://gcconnex.gc.ca/terms">terms and conditions of use</a>.',
	'gcRegister:validation_notice' => '<b>NOTE:</b> You will be unable to login to GCconnex until you have received a validation email.',
	'gcRegister:tutorials_notice' => '<a href="http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex">GCconnex tutorials</a>',
	
	// error messages that pop up
	'gcRegister:toc_error' => '<a href="#toc2">Terms and Conditions of Use must be accepted</a>',
	'gcRegister:email_in_use' => '<a href="#email_initial">This email address has already been registered</a>',
	'gcRegister:password_mismatch' => '<a href="#password">Passwords do not match</a>',
	'gcRegister:password_too_short' => '<a href="#password">Password must contain minimum of 6 characters</a>',
	'gcRegister:email_mismatch' => '<a href="#email_initial">Emails do not match</a>',
	'gcRegister:display_name_is_empty' => '<a href="#name">Display name cannot be empty</a>',
    
);

add_translation("en", $english);