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
 *
 ***********************************************************************/

elgg_make_sticky_form('register');
global $CONFIG;
// default code (core)
$username = get_input('username');
$email = get_input('email');
$password = get_input('password', null, false);
$password2 = get_input('password2', null, false);
$name = get_input('name');

$friend_guid = (int) get_input('friend_guid', 0);
$invitecode = get_input('invitecode');


//////////////////////////// Troy
$deptNum = get_input('department');

// since the retired form has been removed and the type used is no longer passed, this check and the handling of the retired form input should not be here anymore
// check which version the form is (retired vs standard) & must trim everything
//if (get_input('noscript') !== 'retired' && get_input('form_type') === 'standard')
//{
	$username = get_input('username');
	$email = str_replace(' ','',trim(get_input('email')));
	$password = trim(get_input('password', null, false));
	$password2 = trim(get_input('password2', null, false));
	$name = get_input('name');
	$email2 = str_replace(' ','',get_input('email_initial'));
	$toc = get_input('toc2');


/*} else {

	$email = str_replace(' ', '',trim(get_input('c_email')));
	$email2 = str_replace(' ', '', trim(get_input('c_email2')));
	$password = trim(get_input('c_password', null, false));
	$password2 = trim(get_input('c_password2', null, false));
	$toc = get_input('toc1');

	$emailarr = explode('@', $email);
	$name = str_replace('.', ' ', $emailarr[0]);
	$username = $emailarr[0];

	// we need to have it in this format: First.Last@domain.gc.ca for both username and name
	$tmp_holder = explode('.', $emailarr[0]);
	$first_name = ucfirst($tmp_holder[0]);
	$last_name = ucfirst($tmp_holder[1]);
	$name = $first_name.' '.$last_name;
	$username = $first_name.'.'.$last_name;
	$username = str_replace('-', '.', $username);


	// generate the username (test1, test2, test3, ...)
	global $CONFIG;
	$connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
	if (mysqli_connect_errno($connection)) 
		exit;

	$query = "SELECT count(*) AS num FROM elggusers_entity WHERE username = '". $username ."'";
	$result = mysqli_query($connection, $query);
	$result = mysqli_fetch_array($result);

	// check if username exists and increment it (code taken from RegisterAJAX)
	if ( $result['num'] > 0 ) {	
		$unamePostfix = 0;
		$usrnameQuery = $username;
		do {
				$unamePostfix++;
				$tmpUsrnameQuery = $usrnameQuery . $unamePostfix;		
				$query = "SELECT count(*) AS 'num' FROM `elggusers_entity` WHERE username = '". $tmpUsrnameQuery ."'";
				$tmpResult = mysqli_query($connection, $query);
				$tmpResult = mysqli_fetch_array($tmpResult);	
				$uname = $tmpUsrnameQuery;
			} while ( $tmpResult['num'][0] > 0 );
				
		} else {
			// username is available
			$uname = $username;
		}
		// username output
		$username = $uname;
	mysqli_close($connection);
} */// end of condition (retired form - js disabled and IE7)


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

		if ($toc[0] != 1)
		{
			//throw new RegistrationException(elgg_echo('gcRegister:toc_error'));
			$resulting_error .= elgg_echo('gcRegister:toc_error').'<br/>';
		}

		// if domain doesn't exist in database, check if it's a gc.ca domain
		if ($result['num'][0] <= 0) 
		{
			if ($gcca !== 'gc.ca')
				//throw new RegistrationException(elgg_echo('gcRegister:email_error'));
				$resulting_error .= '- '.elgg_echo('gcRegister:invalid_email').'<br/>';
			
		}

		if (get_input('form_type') !== 'standard')
		{
			if (trim($email) !== trim($email2)) 
				//throw new RegistrationException(elgg_echo('gcRegister:email_error'));
				$resulting_error .= elgg_echo('gcRegister:email_mismatch').'<br/>';
		}

		if (trim($password) == "" || trim($password2) == "") {
			//throw new RegistrationException(elgg_echo('RegistrationException:EmptyPassword'));
			$resulting_error .= '- '.elgg_echo('RegistrationException:EmptyPassword').'<br/>';
		}

		if (strcmp($password, $password2) != 0) {
			//throw new RegistrationException(elgg_echo('RegistrationException:PasswordMismatch'));
			$resulting_error .= '- '.elgg_echo('RegistrationException:PasswordMismatch').'<br/>';
		}


		if ($resulting_error !== "")
		{
			throw new RegistrationException($resulting_error);
		}


		$guid = register_user($username, $password, $name, $email, false, $friend_guid, $invitecode);

		if ($guid) {
			$new_user = get_entity($guid);

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

			elgg_clear_sticky_form('register');
			system_message(elgg_echo("registerok", array(elgg_get_site_entity()->name)));

			// if exception thrown, this probably means there is a validation
			// plugin that has disabled the user
			try {
				login($new_user);
			} catch (LoginException $e) {
				// do nothing
			}
			/////// Troy
			$obj = elgg_get_entities(array(
   				'type' => 'object',
   				'subtype' => 'dept_list',
   				'owner_guid' => elgg_get_logged_in_user_guid()
			));
			$departmentsEn = json_decode($obj[0]->deptsEn, true);
			$provincesEn['pov-alb'] = 'Government of Alberta';
			$provincesEn['pov-bc'] = 'Government of British Columbia';
			$provincesEn['pov-man'] = 'Government of Manitoba';
			$provincesEn['pov-nb'] = 'Government of New Brunswick';
			$provincesEn['pov-nfl'] = 'Government of Newfoundland and Labrador';
			$provincesEn['pov-ns'] = 'Government of Nova Scotia';
			$provincesEn['pov-nwt'] = 'Government of Northwest Territories';
			$provincesEn['pov-nun'] = 'Government of Nunavut';
			$provincesEn['pov-ont'] = 'Government of Ontario';
			$provincesEn['pov-pei'] = 'Government of Prince Edward Island';
			$provincesEn['pov-que'] = 'Government of Quebec';
			$provincesEn['pov-sask'] = 'Government of Saskatchewan';
			$provincesEn['pov-yuk'] = 'Government of Yukon';
			$departmentsEn = array_merge($departmentsEn,$provincesEn);
			
			$departmentsFr = json_decode($obj[0]->deptsFr, true);
			$provincesFr['pov-alb'] = "Gouvernement de l'Alberta";
			$provincesFr['pov-bc'] = 'Gouvernement de la Colombie-Britannique';
			$provincesFr['pov-man'] = 'Gouvernement du Manitoba';
			$provincesFr['pov-nb'] = 'Gouvernement du Nouveau-Brunswick';
			$provincesFr['pov-nfl'] = 'Gouvernement de Terre-Neuve-et-Labrador';
			$provincesFr['pov-ns'] = 'Gouvernement de la Nouvelle-Écosse';
			$provincesFr['pov-nwt'] = 'Gouvernement du Territoires du Nord-Ouest';
			$provincesFr['pov-nun'] = 'Gouvernement du Nunavut';
			$provincesFr['pov-ont'] = "Gouvernement de l'Ontario";
			$provincesFr['pov-pei'] = "Gouvernement de l'Île-du-Prince-Édouard";
			$provincesFr['pov-que'] = 'Gouvernement du Québec';
			$provincesFr['pov-sask'] = 'Gouvernement de Saskatchewan';
			$provincesFr['pov-yuk'] = 'Gouvernement du Yukon';
			$departmentsFr = array_merge($departmentsFr,$provincesFr);
			
			if (get_current_language()=='en'){
				$deptString = $departmentsEn[$deptNum]." / ".$departmentsFr[$deptNum];
			}else{
				$deptString = $departmentsFr[$deptNum]." / ".$departmentsEn[$deptNum];
			}
			
			$new_user->set('department',$deptString);
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
