<?php

$english = array(

	'gcRegister:membertype' => "Member Type",
	
	'gcRegister:occupation' => "Occupation",
	'gcRegister:occupation:academic' => "Academic",
	'gcRegister:occupation:student' => "Student",
	'gcRegister:occupation:federal' => "Federal Government",
	'gcRegister:occupation:provincial' => "Provincial/Territorial Government",
	'gcRegister:occupation:municipal' => "Municipal Government",
	'gcRegister:occupation:international' => "International/Foreign Government",
	'gcRegister:occupation:ngo' => "Non-Governmental Organization",
	'gcRegister:occupation:community' => "Community/Non-profit",
	'gcRegister:occupation:business' => "Business",
	'gcRegister:occupation:media' => "Media",
	'gcRegister:occupation:retired' => "Retired Public Servant",
	'gcRegister:occupation:other' => "Other",

	'gcRegister:occupation:university' => "University or College",
	'gcRegister:occupation:department' => "Departments/Agencies",
	'gcRegister:occupation:province' => "Province or Territory",

	'gcRegister:department' => 'Organization',
	'gcRegister:university' => 'University',
	'gcRegister:college' => 'College',
	'gcRegister:highschool' => 'High School',
	'gcRegister:province' => 'Province/Territory',
	'gcRegister:ministry' => 'Ministry',
	'gcRegister:city' => 'City',

	// labels
    'gcRegister:form' => 'Registration form',
	'gcRegister:email' => 'Enter your e-mail',
	'gcRegister:email_secondary' => 'Confirm your e-mail',
	'gcRegister:username' => 'Your username (auto-generated)',
	'gcRegister:password_initial' => 'Password',
	'gcRegister:password_secondary' => 'Confirm your password',
	'gcRegister:display_name' => 'Full Name',
	'gcRegister:display_name_notice' => 'Please enter your first and last name, as you are known in the workplace/school. As per the Terms and Conditions, your display name must reflect your real name. Pseudonyms are not allowed.',
	'gcRegister:please_enter_email' => 'Please enter email',
	'gcRegister:please_enter_name' => 'Please enter display name',
	'gcRegister:department_name' => 'Enter your Department',
	'gcRegister:register' => 'Register',
	'gcRegister:has_invited' => ' invited you to join GCcollab:',

	// error messages on the form
	'gcRegister:failedMySQLconnection' => 'Unable to connect to the database',
	'gcRegister:invalid_email' => 'Invalid email',
	'gcRegister:invalid_email_link' => '<a href="#email">Invalid email</a>',
	'gcRegister:empty_field' => 'Empty field',
	'gcRegister:mismatch' => 'Mismatch',
	'gcRegister:make_selection' => 'Please make a selection',
	'gcRegister:EmptyPassword' => '<a href="#password1">The password fields cannot be empty</a>',
	'gcRegister:PasswordMismatch' => '<a href="#password1">Passwords must match</a>',
	'gcRegister:FederalNotSelected' => '<a href="#federal">Organization not selected</a>',
	'gcRegister:InstitutionNotSelected' => '<a href="#institution">Institution not selected</a>',
	'gcRegister:UniversityNotSelected' => '<a href="#university">University not selected</a>',
	'gcRegister:CollegeNotSelected' => '<a href="#college">College not selected</a>',
	'gcRegister:HighschoolNotSelected' => '<a href="#highschool">High School not entered</a>',
	'gcRegister:ProvincialNotSelected' => '<a href="#provincial">Province/Territory not selected</a>',
	'gcRegister:MinistryNotSelected' => '<a href="#ministry">Ministry not selected</a>',
	'gcRegister:MunicipalNotSelected' => '<a href="#municipal">Organization not entered</a>',
	'gcRegister:InternationalNotSelected' => '<a href="#international">Organization not entered</a>',
	'gcRegister:NGONotSelected' => '<a href="#ngo">Organization not entered</a>',
	'gcRegister:CommunityNotSelected' => '<a href="#community">Organization not entered</a>',
	'gcRegister:BusinessNotSelected' => '<a href="#business">Organization not entered</a>',
	'gcRegister:MediaNotSelected' => '<a href="#media">Organization not entered</a>',
	'gcRegister:RetiredNotSelected' => '<a href="#retired">Organization not entered</a>',
	'gcRegister:OtherNotSelected' => '<a href="#other">Organization not entered</a>',

	// notice
	'gcRegister:email_notice' => '<h2 class="h2"></h2>',

	'gcRegister:terms_and_conditions' => 'I have read, understood, and agree to the <a href="/terms" target="_blank">terms and conditions of use</a>.',
	'gcRegister:validation_notice' => '<b>NOTE:</b> You will be unable to login to GCconnex until you have received a validation email.',
	'gcRegister:tutorials_notice' => '<a href="http://www.gcpedia.gc.ca/wiki/Tutorials_on_GC2.0_Tools_/_Tutoriels_sur_les_outils_GC2.0/GCconnex">GCconnex tutorials</a>',
	
	// error messages that pop up
	'gcRegister:toc_error' => '<a href="#toc2">Terms and Conditions of Use must be accepted</a>',
	'gcRegister:email_in_use' => 'This email address has already been registered',
	'gcRegister:password_mismatch' => '<a href="#password">Passwords do not match</a>', 
	'gcRegister:password_too_short' => '<a href="#password">Password must contain minimum of 6 characters</a>',
	'gcRegister:email_mismatch' => '<a href="#email">Emails do not match</a>',
	'gcRegister:display_name_is_empty' => '<a href="#name">Display name cannot be empty</a>',

	'gcRegister:welcome_message' => "<p>GCcollab, hosted by the Government of Canada, facilitates collaboration between academics, students, Canadian public servants, as well as other key communities.</p>
	<p class='ptm pbm'><strong>Who can register?</strong></p>
	<ul>
		<li>Canadian public servants (federal, provincial, territorial and municipal) can register by using their government email addresses.</li>
		<li>Academics and students of all Canadian universities and colleges can register using their institution email addresses.</li>
	</ul>
	<p><strong>Not part of these groups?</strong> Canadians are able to join GCcollab by invitation! Existing GCcollab members can invite their stakeholders and partners on to GCcollab, making it a truly collaborative environment.</p>
	<p class='ptm pbm'><strong>Register and validate your account!</strong></p>
	<p>After completing the registration form, you will receive a validation email. Click on the link (or copy paste it in the address bar) to activate your account. If you do not receive the email, please contact the <a href='" . elgg_get_site_url() . "mod/contactform/'>GCcollab help desk</a>.</p>",

	'gcRegister:required' => 'required',
	'gcRegister:organization_notice' => 'Individuals from this occupation need to be invited by an existing GCcollab member to register for an account. After receiving your invitation, register using the same email address that was used to invite you.',
);

add_translation("en", $english);