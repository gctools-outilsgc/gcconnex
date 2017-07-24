<?php
/**
 * Elgg registration action
 *
 * @package Elgg.Core
 * @subpackage User.Account
 */


/***********************************************************************
 * MODIFICATION LOG
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * USER 		DATE 			DESCRIPTION
 * TLaw/ISal 	n/a 			GC Changes
 * CYu 			March 5 2014 	checks for email validity
 * CYu 			July 7 2014		force user to accept ToC
 * CYu 			Aug 15 2016 	
 * MWooff 		Jan 18 2017		Re-built for GCcollab-specific functions	
 ***********************************************************************/

elgg_make_sticky_form('register');
global $CONFIG;
// default code (core)
$username = get_input('username');
$email = strtolower(trim(get_input('email')));
$email2 = strtolower(trim(get_input('email2')));
$password = get_input('password', null, false);
$password2 = get_input('password2', null, false);
$name = get_input('name');
$toc = get_input('toc2');

$friend_guid = (int) get_input('friend_guid', 0);
$invitecode = get_input('invitecode');

$meta_fields = array('user_type', 'institution', 'university', 'college', 'highschool', 'federal', 'provincial', 'ministry', 'municipal', 'international', 'ngo', 'community', 'business', 'media', 'retired', 'other');
foreach($meta_fields as $field){
	$$field = get_input($field);
}

// check form (incompleteness & validity)
if (elgg_get_config('allow_registration')) {
	try {
		// check if domain exists in database
		$db_config = new \Elgg\Database\Config($CONFIG);
		if ($db_config->isDatabaseSplit()) {
			$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ);
		} else {	
			$read_settings = $db_config->getConnectionConfig(\Elgg\Database\Config::READ_WRITE);
		}

		$connection = mysqli_connect($read_settings["host"], $read_settings["user"], $read_settings["password"], $read_settings["database"])or die(mysqli_error($connection));
		$emaildomain = explode('@',$email);
		$query = "SELECT count(*) AS num FROM email_extensions WHERE ext ='".$emaildomain[1]."'";
		
		$result = mysqli_query($connection, $query)or die(mysqli_error($connection));
		$result = mysqli_fetch_array($result);
		
		$emailgc = explode('.',$emaildomain[1]);
		$gcca = $emailgc[count($emailgc) - 2] .".".$emailgc[count($emailgc) - 1];
		
		mysqli_close($connection);
		
		$resulting_error = "";

		$validemail = false;
		// if domain doesn't exist in database, check if it's a gc.ca domain
		if ($dept_exist[0]->num > 0 && strcmp($gcca, 'gc.ca') == 0){
			$validemail = true;
		}

		if( elgg_is_active_plugin('c_email_extensions') ){
			// Checks against the domain manager list...
			$wildcard_query = "SELECT ext FROM email_extensions WHERE ext LIKE '%*%'";
			$wildcard_emails = get_data($wildcard_query);
			
			if( $wildcard_emails ){
				foreach($wildcard_emails as $wildcard){
					$regex = str_replace(".", "\.", $wildcard->ext);
					$regex = str_replace("*", "[\w-.]+", $regex);
					$regex = "/^@" . $regex . "$/";
					if(preg_match($regex, "@".$emaildomain[1]) || strtolower(str_replace("*.", "", $wildcard->ext)) == strtolower($emaildomain[1])){
						$validemail = true;
						break;
					}
				}
			}
		}

		if( elgg_is_active_plugin('gcRegistration_invitation') ){
			// Checks against the email invitation list...
			$invitation_query = "SELECT email FROM email_invitations WHERE email = '{$email}'";
			$result = get_data($invitation_query);

			if( count($result) > 0 ) 
				$validemail = true;
		}

		// check if the college/university is filled
		if ($user_type === 'student' || $user_type === 'academic') {
			if($institution === 'default_invalid_value')
				$resulting_error .= elgg_echo('gcRegister:InstitutionNotSelected').'<br/>';

			if($institution === 'university' && $university === 'default_invalid_value')
				$resulting_error .= elgg_echo('gcRegister:UniversityNotSelected').'<br/>';

			if($institution === 'college' && $college === 'default_invalid_value')
				$resulting_error .= elgg_echo('gcRegister:CollegeNotSelected').'<br/>';

			if($institution === 'highschool' && $highschool === '')
				$resulting_error .= elgg_echo('gcRegister:HighschoolNotSelected').'<br/>';
		}

		// check if the federal department is filled
		if ($user_type === 'federal' && $federal === 'default_invalid_value')
			$resulting_error .= elgg_echo('gcRegister:FederalNotSelected').'<br/>';

		// check if the provincial department is filled
		if ($user_type === 'provincial') {
			if($provincial === 'default_invalid_value')
				$resulting_error .= elgg_echo('gcRegister:ProvincialNotSelected').'<br/>';

			if($ministry === 'default_invalid_value')
				$resulting_error .= elgg_echo('gcRegister:MinistryNotSelected').'<br/>';
		}

		// check if the municipal department is filled
		if ($user_type === 'municipal' && $municipal === '')
			$resulting_error .= elgg_echo('gcRegister:MunicipalNotSelected').'<br/>';

		// check if the international department is filled
		if ($user_type === 'international' && $international === '')
			$resulting_error .= elgg_echo('gcRegister:InternationalNotSelected').'<br/>';

		// check if the NGO department is filled
		if ($user_type === 'ngo' && $ngo === '')
			$resulting_error .= elgg_echo('gcRegister:NGONotSelected').'<br/>';

		// check if the community department is filled
		if ($user_type === 'community' && $community === '')
			$resulting_error .= elgg_echo('gcRegister:CommunityNotSelected').'<br/>';

		// check if the business department is filled
		if ($user_type === 'business' && $business === '')
			$resulting_error .= elgg_echo('gcRegister:BusinessNotSelected').'<br/>';

		// check if the media department is filled
		if ($user_type === 'media' && $media === '')
			$resulting_error .= elgg_echo('gcRegister:MediaNotSelected').'<br/>';

		// check if the retired department is filled
		if ($user_type === 'retired' && $retired === '')
			$resulting_error .= elgg_echo('gcRegister:RetiredNotSelected').'<br/>';

		// check if the other department is filled
		if ($user_type === 'other' && $other === '')
			$resulting_error .= elgg_echo('gcRegister:OtherNotSelected').'<br/>';

		if( empty(trim($name)) )
			$resulting_error .= elgg_echo('gcRegister:display_name_is_empty').'<br/>';

		if( !$validemail )
			$resulting_error .= elgg_echo('gcRegister:invalid_email_link').'<br/>';

		// check if two emails match
		if (strcmp($email, $email2) != 0)
			$resulting_error .= elgg_echo('gcRegister:email_mismatch').'<br/>';

		// check if two passwords are not empty
		if (empty(trim($password)) || empty(trim($password2)))
			$resulting_error .= elgg_echo('gcRegister:EmptyPassword').'<br/>';

		// check if two passwords match
		if (strcmp($password, $password2) != 0)
			$resulting_error .= elgg_echo('gcRegister:PasswordMismatch').'<br/>';

		// check if toc is checked, user agrees to TOC
		if ($toc[0] != 1)
			$resulting_error .= elgg_echo('gcRegister:toc_error').'<br/>';

		// if there are any registration error, throw an exception
		if (!empty($resulting_error))
			throw new RegistrationException($resulting_error);

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
				'invitecode' => $invitecode,
			);

			// @todo should registration be allowed no matter what the plugins return?
			if (!elgg_trigger_plugin_hook('register', 'user', $params, TRUE)) {
				$ia = elgg_set_ignore_access(true);
				$new_user->delete();
				elgg_set_ignore_access($ia);
				// @todo this is a generic messages. We could have plugins
				// throw a RegistrationException, but that is very odd
				// for the plugin hooks system.
				throw new RegistrationException(elgg_echo('registerbad'));
			}

			if ($invitecode && elgg_is_active_plugin('gcRegistration_invitation')) {
				$data = array('invitee' => $guid, 'email' => $new_user->email);
				elgg_trigger_plugin_hook('gcRegistration_invitation_register', 'all', $data);
			}

			elgg_clear_sticky_form('register');
			// system_message(elgg_echo("registerok", array(elgg_get_site_entity()->name)));

			// if exception thrown, this probably means there is a validation
			// plugin that has disabled the user
			try {
				login($new_user);
			} catch (LoginException $e) {
				// do nothing
			}

			// Save user metadata
			foreach($meta_fields as $field){
				$new_user->set($field, $$field);
			}
	        $new_user->last_department_verify = time();
			
			// Forward on success, assume everything else is an error...
			forward();
		} else {
			register_error(elgg_echo("registerbad"));
		}
	} catch (RegistrationException $r) {
		register_error($r->getMessage());
	}
} else {
	register_error(elgg_echo('registerdisabled'));
}

forward(REFERER);
