<?php

$english = array(
	// labels
    'gcRegister:form' => 'Registration form',
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
        <li>Your GCconnex account must be registered to a <b>valid Government of Canada email address</b> ending in gc.ca or canada.ca.</li>
		<li>You need to <b>validate</b> your newly created account before you can log in for the first time. A
		validation email will be sent to your email. Click (or copy/paste) the link in the email to validate
		your account. If you do not receive a validation email, submit a ticket to the <a href="https://gcconnex.gc.ca/help/knowledgebase">help desk</a>.
		<i>(Note: It may take several minutes to receive the validation email due to your departmental
		firewall. Be sure to check your Junk folder.)</i></li>
		<li><b>Already have an account?</b> <a href="https://gcconnex.gc.ca/forgotpassword">Request a password reset.</a> If you do not receive the password reset
		email, submit a ticket to the <a href="https://gcconnex.gc.ca/help/knowledgebase">help desk.</a>
		<i>(Note: It may take several minutes to receive the forgot password email due to your
		departmental firewall. Be sure to check your Junk folder.)</i></li>
		<li><b>Changed departments or email address? No need to create a new account.</b> Please submit a
		ticket to the <a href="https://gcconnex.gc.ca/help/knowledgebase">help desk.</a> We will make the necessary changes to your existing account and help
		you regain access. Be sure to include your old and new email address.</li>
		<li><b>Still having issues creating an account?</b> Submit a ticket to the <a href="https://gcconnex.gc.ca/help/knowledgebase">help desk</a> and we will gladly assist
		you.</li>
		</ol>
	',
	'gcRegister:terms_and_conditions' => 'I have read, understood, and agree to the <a target="_blank" href="http://gcconnex.gc.ca/terms">terms and conditions of use</a>.',
	'gcRegister:validation_notice' => '<b>NOTE:</b> You will be unable to login to GCconnex until you have received a validation email.',
	'gcRegister:tutorials_notice' => '<a href="http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex">GCconnex tutorials</a>',
	
	// error messages that pop up
	'gcRegister:toc_error' => '<a href="#toc2">Terms and Conditions of Use must be accepted</a>',
	'gcRegister:email_in_use' => 'This email address has already been registered',
	'gcRegister:password_mismatch' => '<a href="#password">Passwords do not match</a>',
	'gcRegister:password_too_short' => '<a href="#password">Password must contain minimum of 6 characters</a>',
	'gcRegister:email_mismatch' => '<a href="#email_initial">Emails do not match</a>',
	'gcRegister:display_name_is_empty' => '<a href="#name">Display name cannot be empty</a>',
	'gcRegister:department' => 'Department',
	'gcRegister:required' => 'Required',
    
);

add_translation("en", $english);