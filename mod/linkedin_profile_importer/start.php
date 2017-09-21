<?php

// object subtype names for imported data
define('LINKEDIN_POSITION_SUBTYPE', 'employment');
define('LINKEDIN_PROJECT_SUBTYPE', 'project');
define('LINKEDIN_EDUCATION_SUBTYPE', 'education');
define('LINKEDIN_PUBLICATION_SUBTYPE', 'publication');
define('LINKEDIN_PATENT_SUBTYPE', 'patent');
define('LINKEDIN_CERTIFICATION_SUBTYPE', 'certification');
define('LINKEDIN_COURSE_SUBTYPE', 'course');
define('LINKEDIN_VOLUNTEER_SUBTYPE', 'volunteer');
define('LINKEDIN_RECOMMENDATION_SUBTYPE', 'recommendation');

// Composer autoload
require_once __DIR__ . '/vendors/autoload.php';

/**
 * Elgg HybridAuth
 */
elgg_register_event_handler('init', 'system', 'linkedin_profile_importer_init');

/**
 * Initialize the plugin
 */
function linkedin_profile_importer_init() {

	elgg_register_page_handler('linkedin', 'linkedin_profile_importer_page_handler');

	elgg_register_action('linkedin_profile_importer/settings/save', elgg_get_plugins_path() . 'linkedin_profile_importer/actions/settings/save.php', 'admin');

	elgg_register_action('linkedin/deauthorize', elgg_get_plugins_path() . 'linkedin_profile_importer/actions/linkedin/deauthorize.php');
	elgg_register_action('linkedin/import', elgg_get_plugins_path() . 'linkedin_profile_importer/actions/linkedin/import.php');

	elgg_register_css('linkedin.css', elgg_get_simplecache_url('css', 'core'));
	elgg_register_simplecache_view('css/linkedin/core');

	elgg_register_js('linkedin.js', elgg_get_simplecache_url('js', 'core'));
	elgg_register_simplecache_view('js/linkedin/core');

	// Add linkedin settings to the user profile page
	// elgg_extend_view('profile/details', 'linkedin/settings');
	elgg_extend_view('profile/sidebar', 'profile/sidebar/linkedin_profile_importer', 450);

	// Add linkedin settings to the user settings page
    // elgg_extend_view('forms/account/settings', 'profile/settings/linkedin_profile_importer');

    elgg_register_widget_type('linkedin_profile_importer', elgg_echo('linkedin:profile'), 'LinkedIn Profile Importer Widget', array('custom_index_widgets'), false);

	// Add linkedin metatags to the list of profile fields
	elgg_register_plugin_hook_handler('profile:fields', 'profile', 'linkedin_profile_importer_field_mapping');
	elgg_register_plugin_hook_handler('linkedin:fields', 'profile', 'linkedin_profile_importer_field_mapping');

	// Register widgets for LinkedIn data
	elgg_register_widget_type('employment', elgg_echo('linkedin:widget:employment'), elgg_echo('linkedin:widget:employment:desc'), 'profile', false);
	elgg_register_widget_type('projects', elgg_echo('linkedin:widget:projects'), elgg_echo('linkedin:widget:projects:desc'), 'profile', false);
	elgg_register_widget_type('education', elgg_echo('linkedin:widget:education'), elgg_echo('linkedin:widget:education:desc'), 'profile', false);
	elgg_register_widget_type('publications', elgg_echo('linkedin:widget:publications'), elgg_echo('linkedin:widget:publications:desc'), 'profile', false);
	elgg_register_widget_type('patents', elgg_echo('linkedin:widget:patents'), elgg_echo('linkedin:widget:patents:desc'), 'profile', false);
	elgg_register_widget_type('certification', elgg_echo('linkedin:widget:certification'), elgg_echo('linkedin:widget:certification:desc'), 'profile', false);
	elgg_register_widget_type('courses', elgg_echo('linkedin:widget:courses'), elgg_echo('linkedin:widget:courses:desc'), 'profile', false);
	elgg_register_widget_type('volunteer_experiences', elgg_echo('linkedin:widget:volunteer_experiences'), elgg_echo('linkedin:widget:volunteer_experiences:desc'), 'profile', false);
	elgg_register_widget_type('recommendations', elgg_echo('linkedin:widget:recommendations'), elgg_echo('linkedin:widget:recommendations:desc'), 'profile', false);
}

/**
 * Page handler callback for /linkedin
 * Used an auth start and endpoint
 *
 * To authenticate a given provider, use the following URL structure
 * /linkedin/authenticate?provider=$provider
 *
 * If you are authenticating a provider for a logged in user, and would like to
 * forward the user to a specific page upon successful authentication,
 * pass an encoded URL as a 'elgg_forward_url' URL query parameter, e.g.
 * /linkedin/authenticate?provider=$provider&elgg_forward_to=$url.
 * This can be helpful if you are implementing an import or sharing tool:
 * you can first check if the user is authenticated with a given provider
 * and then use this handler to avoid duplicating the authentication logic
 *
 * @param type $page
 * @return boolean
 */
function linkedin_profile_importer_page_handler($page) {

	gatekeeper();

	$action = elgg_extract(0, $page);

	if (!isset($_SESSION['linkedin'])) {
		$_SESSION['linkedin'] = array(
			'friend_guid' => get_input('friend_guid'),
			'invitecode' => get_input('invitecode')
		);
	}

	switch ($action) {

		case 'authenticate' :
			$ha_provider = $provider = get_input('provider');

			if (!$ha_provider) {
				return false;
			}

			try {
				$ha = new ElggHybridAuth();
				$adapter = $ha->authenticate($ha_provider);
				$profile = $adapter->getUserProfile();
			} catch (Exception $e) { // catching authentication exceptions
				register_error($e->getMessage());
				forward("profile/$user->username");
			}

			// Does this user profile exist?
			$options = array(
				'type' => 'user',
				'plugin_id' => 'linkedin_profile_importer',
				'plugin_user_setting_name_value_pairs' => array(
					'name' => "$provider:uid",
					'value' => $profile->identifier
				),
				'limit' => 0
			);

			$users = elgg_get_entities_from_plugin_user_settings($options);

			if (elgg_is_logged_in()) {
				$logged_in = elgg_get_logged_in_user_entity();
				if (!$users || $users[0]->guid == $logged_in->guid) {
					// User already has an account
					// Linking provider profile to an existing account
					elgg_set_plugin_user_setting("$provider:uid", $profile->identifier, $logged_in->guid, 'linkedin_profile_importer');

					elgg_trigger_plugin_hook('hybridauth:authenticate', $provider, array('entity' => $logged_in));
					system_message(elgg_echo('hybridauth:link:provider', array($provider)));

					if ($elgg_forward_url = get_input('elgg_forward_url')) {
						forward(urldecode($elgg_forward_url));
					} else {
						$query = parse_url(current_page_url(), PHP_URL_QUERY);
						forward("settings/user/" . elgg_get_logged_in_user_entity()->username . '?' . $query);
					}
				} else {
					// Another user has already linked this profile
					$adapter->logout();
					register_error(elgg_echo('hybridauth:link:provider:error', array($provider)));
					forward("profile/$user->username");
				}
			}

			if (!$users) {
				// try one more time to match a user with plugin setting
				$testusers = get_user_by_email($profile->email);
				foreach ($testusers as $t) {
					$users = array();
					if ($profile->identifier == elgg_get_plugin_user_setting("$provider:uid", $t->guid, 'linkedin_profile_importer')) {
						// they do have an account, but for some reason egef_plugin_settings didn't work...
						// we've had a few cases of it
						$users[] = $t;
					}
				}
			}


			if ($users) {
				if (count($users) > 1) {
					// find the user that was created first
					foreach ($users as $u) {
						if (empty($user_to_login) || $u->time_created < $user_to_login->time_created) {
							$user_to_login = $u;
						}
					}
				} else if (count($users) == 1) {
					$user_to_login = $users[0];
				}

				// Profile for this provider exists
				if (!elgg_is_logged_in()) {
					$user_to_login->linkedin_profile_importer_login = 1;
					login($user_to_login);
					system_message(elgg_echo('hybridauth:login:provider', array($provider)));
					forward();
				}
			}

			if ($profile->emailVerified) {
				$email = $profile->emailVerified;
			} else if ($profile->email) {
				$email = $profile->email;
			} else if (get_input('email')) {
				$email = urldecode(get_input('email'));
			}

			if ($email && $users = get_user_by_email($email)) {
				// User already has an account, save the token and login
				$user_to_login = $users[0];
				elgg_set_plugin_user_setting("$provider:uid", $profile->identifier, $user_to_login->guid, 'linkedin_profile_importer');
				elgg_trigger_plugin_hook('hybridauth:authenticate', $provider, array('entity' => $user_to_login));
				$user_to_login->linkedin_profile_importer_login = 1;
				login($user_to_login);
				system_message(elgg_echo('hybridauth:login:provider', array($provider)));
				forward();
			}

			register_error(elgg_echo('hybridauth:link:provider:error', array($provider)));
			forward("profile/$user->username");
			return true;
			break;

		case 'endpoint' :
			Hybrid_Endpoint::process();
			break;

		case 'import' :

			gatekeeper();

			$ha = new ElggHybridAuth();
			$adapter = $ha->getAdapter('LinkedIn');

			$forward_url = urlencode(current_page_url());
			$auth_url = elgg_http_add_url_query_elements('linkedin/authenticate', array(
				'provider' => 'LinkedIn',
				'elgg_forward_url' => $forward_url
			));
			if (!$adapter->isUserConnected()) {
				forward($auth_url);
			}

			elgg_push_context('profile_edit');

			$title = elgg_echo('linkedin:import-linkedin');
			$content = elgg_view_form('linkedin/import');

			$layout = elgg_view_layout('content', array(
				'title' => $title,
				'content' => $content,
				'filter' => false
			));

			echo elgg_view_page($title, $layout);
			return true;
			break;
	}


	return false;
}

/**
 * Setup LinkedIn import and profile fields
 *
 * @param string $hook Equals 'profile:fields' or 'linkedin:fields'
 * @param string $type Equals 'profile'
 * @param array $return An array of current fields
 * @return array An updated array of fields
 */
function linkedin_profile_importer_field_mapping($hook, $type, $return) {

	// Configure what metadata names will be assigned to imported tags
	$linkedin_metatags = array(
		'pictureUrls' => 'picture-url',
		'publicProfileUrl' => 'profile-url',
		'summary' => 'description',
		'location' => 'location',
		// 'headline' => 'briefdescription',
		// 'industry' => 'industry',
		// 'associations' => 'associations',
		// 'interests' => 'interests',
		// 'languages' => 'languages',
		// 'skills' => 'skills',
		// 'honorsAwards' => 'awards',
		// 'dateOfBirth' => 'birthday',
		// 'mainAddress' => 'address',
		// 'phoneNumbers' => 'phone',
		// 'twitterAccounts' => 'twitter',
	);

	// Map the above fields to their value types
	$linkedin_profile_fields = array(
		'pictureUrls' => 'text',
		'publicProfileUrl' => 'text',
		'description' => 'longtext',
		'location' => 'tags',
		// 'briefdescription' => 'longtext',
		// 'birthday' => 'date',
		// 'phone' => 'text',
		// 'address' => 'text',
		// 'interests' => 'tags',
		// 'languages' => 'tags',
		// 'skills' => 'tags',
		// 'industry' => 'tags',
		// 'awards' => 'tags',
		// 'associations' => 'tags',
		// 'twitter' => 'text',
	);

	if (!is_array($return)) {
		$return = array();
	}

	if ($hook == 'profile:fields') {
		return array_merge($linkedin_profile_fields, $return);
	} else if ($hook == 'linkedin:fields') {
		return array_merge($linkedin_metatags, $return);
	}

	return $return;
}
