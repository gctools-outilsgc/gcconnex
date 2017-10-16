<?php
/*
 * Exposes API endpoints for registering a user
 */

elgg_ws_expose_function(
	"register.user",
	"register_new_user",
	array(
		"userdata" => array('type' => 'string', 'required' => true),
		"lang" => array('type' => 'string', 'required' => false, 'default' => "en")
	),
	'Registers a new user',
	'POST',
	false,
	false
);

function register_new_user($userdata, $lang)
{
	$data = json_decode($userdata);

	$user_type = isset($data->user_type) ? $data->user_type : "";
	$name = isset($data->name) ? $data->name : "";
	$email = isset($data->email) ? $data->email : "";
	$password = isset($data->password) ? $data->password : "";
	$toc = isset($data->toc) ? $data->toc : "";
	$institution = isset($data->institution) ? $data->institution : "";
	$university = isset($data->university) ? $data->university : "";
	$college = isset($data->college) ? $data->college : "";
	$highschool = isset($data->highschool) ? $data->highschool : "";
	$federal = isset($data->federal) ? $data->federal : "";
	$provincial = isset($data->provincial) ? $data->provincial : "";
	$ministry = isset($data->ministry) ? $data->ministry : "";
	$municipal = isset($data->municipal) ? $data->municipal : "";
	$international = isset($data->international) ? $data->international : "";
	$ngo = isset($data->ngo) ? $data->ngo : "";
	$community = isset($data->community) ? $data->community : "";
	$business = isset($data->business) ? $data->business : "";
	$media = isset($data->media) ? $data->media : "";
	$retired = isset($data->retired) ? $data->retired : "";
	$other = isset($data->other) ? $data->other : "";

	$resulting_error = array();

	// check if the college/university is filled
	if ($user_type === 'student' || $user_type === 'academic') {
		if ($institution === 'default_invalid_value') {
			$resulting_error[] = elgg_echo('gcRegister:InstitutionNotSelected');
		}

		if ($institution === 'university' && $university === 'default_invalid_value') {
			$resulting_error[] = elgg_echo('gcRegister:UniversityNotSelected');
		}

		if ($institution === 'college' && $college === 'default_invalid_value') {
			$resulting_error[] = elgg_echo('gcRegister:CollegeNotSelected');
		}

		if ($institution === 'highschool' && $highschool === '') {
			$resulting_error[] = elgg_echo('gcRegister:HighschoolNotSelected');
		}
	}

	// check if the federal department is filled
	if ($user_type === 'federal' && $federal === 'default_invalid_value') {
		$resulting_error[] = elgg_echo('gcRegister:FederalNotSelected');
	}

	// check if the provincial department is filled
	if ($user_type === 'provincial') {
		if ($provincial === 'default_invalid_value') {
			$resulting_error[] = elgg_echo('gcRegister:ProvincialNotSelected');
		}

		if ($ministry === 'default_invalid_value') {
			$resulting_error[] = elgg_echo('gcRegister:MinistryNotSelected');
		}
	}

	// check if the municipal department is filled
	if ($user_type === 'municipal' && $municipal === '') {
		$resulting_error[] = elgg_echo('gcRegister:MunicipalNotSelected');
	}

	// check if the international department is filled
	if ($user_type === 'international' && $international === '') {
		$resulting_error[] = elgg_echo('gcRegister:InternationalNotSelected');
	}

	// check if the NGO department is filled
	if ($user_type === 'ngo' && $ngo === '') {
		$resulting_error[] = elgg_echo('gcRegister:NGONotSelected');
	}

	// check if the community department is filled
	if ($user_type === 'community' && $community === '') {
		$resulting_error[] = elgg_echo('gcRegister:CommunityNotSelected');
	}

	// check if the business department is filled
	if ($user_type === 'business' && $business === '') {
		$resulting_error[] = elgg_echo('gcRegister:BusinessNotSelected');
	}

	// check if the media department is filled
	if ($user_type === 'media' && $media === '') {
		$resulting_error[] = elgg_echo('gcRegister:MediaNotSelected');
	}

	// check if the retired department is filled
	if ($user_type === 'retired' && $retired === '') {
		$resulting_error[] = elgg_echo('gcRegister:RetiredNotSelected');
	}

	// check if the other department is filled
	if ($user_type === 'other' && $other === '') {
		$resulting_error[] = elgg_echo('gcRegister:OtherNotSelected');
	}

	if (empty(trim($name))) {
		$resulting_error[] = elgg_echo('gcRegister:display_name_is_empty');
	}

	// check if password is not empty
	if (empty(trim($password))) {
		$resulting_error[] = elgg_echo('gcRegister:EmptyPassword');
	}

	// check if toc is checked, user agrees to TOC
	if (!$toc) {
		$resulting_error[] = elgg_echo('gcRegister:toc_error');
	}

	// if there are any registration error, throw an exception
	if (!empty($resulting_error)) {
		return $resulting_error;
	}

	$emaildomain = explode('@', $email);
	$emailgc = explode('.', $emaildomain[1]);
	$gcca = $emailgc[count($emailgc) - 2] .".".$emailgc[count($emailgc) - 1];

	/*** Username Generation ***/
	$username = "";
	$temp_name = str_replace(" ", ".", $name);
	$usrname = str_replace("'", "", create_username($temp_name));

	// Troy - fix for usernames generated with "-" in them; better solution may present itself.
	while (strpos($usrname, '-')!==false) {
		$usrname = substr_replace($usrname, ".", strpos($usrname, '-'), 1);
	}

	if (rtrim($usrname, "0..9") != "") {
		$usrname = rtrim($usrname, "0..9");
	}

	// select matching usernames
	$query1 = "SELECT count(*) as num FROM elggusers_entity WHERE username = '". $usrname ."'";
	$result1 = get_data($query1);

	// check if username exists and increment it
	if ($result1[0]->num > 0) {
		$unamePostfix = 0;
		$usrnameQuery = $usrname;

		do {
			$unamePostfix++;
			$tmpUsrnameQuery = $usrnameQuery . $unamePostfix;

			$query = "SELECT count(*) as num FROM elggusers_entity WHERE username = '". $tmpUsrnameQuery ."'";
			$tmpResult = get_data($query);

			$uname = $tmpUsrnameQuery;
		} while ($tmpResult[0]->num > 0);
	} else {
		// username is available
		$uname = $usrname;
	}
	// username output
	$username = $uname;
	/*** End Username Generation ***/

	$friend_guid = "";
	$invitecode = "";
	$validemail = false;
	$meta_fields = array('institution', 'university', 'college', 'highschool', 'federal', 'provincial', 'ministry', 'municipal', 'international', 'ngo', 'community', 'business', 'media', 'retired', 'other');

	// if domain doesn't exist in database, check if it's a gc.ca domain
	if (strcmp($gcca, 'gc.ca') == 0) {
		$validemail = true;
	}

	if (elgg_is_active_plugin('c_email_extensions')) {
		// Checks against the domain manager list...
		$wildcard_query = "SELECT ext FROM email_extensions WHERE ext LIKE '%*%'";
		$wildcard_emails = get_data($wildcard_query);

		if ($wildcard_emails) {
			foreach ($wildcard_emails as $wildcard) {
				$regex = str_replace(".", "\.", $wildcard->ext);
				$regex = str_replace("*", "[\w-.]+", $regex);
				$regex = "/^@" . $regex . "$/";
				if (preg_match($regex, "@".$emaildomain[1]) || strtolower(str_replace("*.", "", $wildcard->ext)) == strtolower($emaildomain[1])) {
					$validemail = true;
					break;
				}
			}
		}
	}

	if (elgg_is_active_plugin('gcRegistration_invitation')) {
		// Checks against the email invitation list...
		$invitation_query = "SELECT email FROM email_invitations WHERE email = '{$email}'";
		$result = get_data($invitation_query);

		if (count($result) > 0) {
			$validemail = true;
		}
	}

	if (!$validemail) {
		$resulting_error[] = elgg_echo('gcRegister:invalid_email_link');
	}

	// if there are any registration error, throw an exception
	if (!empty($resulting_error)) {
		return $resulting_error;
	}

	$guid = register_user($username, $password, $name, $email, false, $friend_guid, $invitecode);

	if ($guid) {
		$new_user = get_entity($guid);

		// condition whether or not we want to record the type of user (for gccollab)
		$new_user->user_type = $user_type;

		// allow plugins to respond to self registration
		// note: To catch all new users, even those created by an admin,
		// register for the create, user event instead.
		// only passing vars that aren't in ElggUser.
		$params = array(
			'user' => $new_user,
			'password' => $password,
			'friend_guid' => $friend_guid,
			'invitecode' => $invitecode
		);

		// *************************
		// ***TEMPORARILY REMOVED***
		// *************************
		// @todo should registration be allowed no matter what the plugins return?
		// if (!elgg_trigger_plugin_hook('register', 'user', $params, TRUE)) {
		// 	$ia = elgg_set_ignore_access(true);
		// 	$new_user->delete();
		// 	elgg_set_ignore_access($ia);
		// 	// @todo this is a generic messages. We could have plugins
		// 	// throw a RegistrationException, but that is very odd
		// 	// for the plugin hooks system.
		// 	error_log('registerbad with params: ' . json_encode($params) . "\n");
		// 	return elgg_echo('registerbad');
		// }

		if ($invitecode && elgg_is_active_plugin('gcRegistration_invitation')) {
			$data = array('invitee' => $guid, 'email' => $new_user->email);
			elgg_trigger_plugin_hook('gcRegistration_invitation_register', 'all', $data);
		}

		// Save user metadata
		foreach ($meta_fields as $field) {
			$new_user->set($field, $$field);
		}
		$new_user->last_department_verify = time();

		/*** Activate User ***/
		$access = access_get_show_hidden_status();
		access_show_hidden_entities(true);
		$holder = elgg_set_ignore_access(true);

		// only validate if not validated
		elgg_set_user_validation_status($guid, true, 'mobileapp');
		$new_user->enable();

		elgg_set_ignore_access($holder);
		access_show_hidden_entities($access);
		/*** End Activate User ***/

		return true;
	} else {
		error_log('registerbad with username: ' . $username . "\n");
		return elgg_echo("registerbad");
	}
}
