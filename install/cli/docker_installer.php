<?php
/**
 * Docker CLI installer script.
 *
 * @access private
 */

$enabled = getenv('DOCKER') != ''; //are we in a Docker container?
if (!$enabled) {
	echo "This script should be run only in a properly configured Docker container environment.\n";
	exit(1);
}

if (PHP_SAPI !== 'cli') {
	echo "You must use the command line to run this script.\n";
	exit(2);
}

$init_type = getenv('INIT');
switch ($init_type) {
	case 'gcconnex':
		$type = "connex";
		break;
	case 'gccollab':
		$type = "collab";
		break;
	
	default:
		echo "Install script not running as per configuration ( INIT environment variable not one of gcconnex or gccollab).\n";
		exit(0);
		break;
}

$elggRoot = dirname(dirname(__DIR__));

require_once "$elggRoot/vendor/autoload.php";

$installer = new ElggInstaller();

if (getenv('DBHOST') != '')
	$dbhost = getenv('DBHOST');
else
	$dbhost = 'gcconnex-db';

if (getenv('DBUSER') != '')
	$dbuser = getenv('DBUSER');
else
	$dbuser = 'elgg';

if (getenv('DBPASS') != '')
	$dbpass = getenv('DBPASS');
else
	$dbpass = 'gcconnex';

if (getenv('DBNAME') != '')
	$dbname = getenv('DBNAME');
else
	$dbname = 'elgg';


if (getenv('WWWROOT') != '')
	$wwwroot = getenv('WWWROOT');
else
	$wwwroot = 'http://localhost:8080/';

if (getenv('E2E_TEST_INIT') != '')
	$e2e_test_init = getenv('E2E_TEST_INIT') == 'true' || getenv('E2E_TEST_INIT') === true;
else
	$e2e_test_init = false;

// none of the following may be empty
$params = array(
	// database parameters
	'dbuser' => $dbuser,
	'dbpassword' => $dbpass,
	'dbname' => $dbname,
	
	// We use a wonky dbprefix to catch any cases where folks hardcode "elgg_"
	// instead of using config->dbprefix
	'dbprefix' => 'd_elgg_',
	'dbhost' => $dbhost,

	// site settings
	'sitename' => 'Docker GC' . $type,
	'siteemail' => 'no_reply@gcconnex.gc.ca',
	'wwwroot' => $wwwroot,
	'dataroot' => getenv('DATAROOT'),

	// admin account
	'displayname' => 'Administrator',
	'email' => 'admin@gcconnex.gc.ca',
	'username' => 'admin',
	'password' => 'adminpassword',
);

// wait for db to be ready
echo "Connecting to database..";
$etmp = error_reporting(E_ERROR);     // don't need all the connection errors...

do{
  echo ".";
  sleep(1); // wait for the db container
  $dbconnect = mysqli_connect($dbhost, $params['dbuser'], $params['dbpassword']);
}while(!$dbconnect);

echo "Connected!";
mysqli_close($dbconnect);
error_reporting($etmp);     // revert error reporting to default

// install and create the .htaccess file
$installer->batchInstall($params, TRUE);

// at this point installation has completed (otherwise an exception halted execution).
echo "Elgg CLI install successful. wwwroot: " . elgg_get_config('wwwroot') . "\n";

// arrange and activate mods
init_mods( $type );

echo "Elgg CLI plugin install successful. \n";

if ($e2e_test_init){
	echo "preparing for e2e tests  \n";
	require_once("docker_install_additions/e2e_test_init.php");
	e2e_init();
	echo "e2e setup completed.  \n";
}


function init_mods( $type ){
	
// GCcollab
$plugins_connex = array(
	'garbagecollector',
	'groups',
	'logrotate',
	'group_tools',
	'blog',
	'bookmarks',
	'dashboard',
	'diagnostics',
	'friend_request',
	'externalpages',
	'file',
	'embed',
	'group_operators',
	'htmlawed',
	'invitefriends',
	'likes',
	'logbrowser',
	'gcforums',
	'messageboard',
	'messages',
	'polls',
	'profile',
	'rename_friends',
	'members',
	'thewire',
	'uservalidationbyemail',
	'unvalidatedemailchange',
	'widget_manager',
	'zaudio',
	'custom_index_widgets',
	'file_tools',
	'event_calendar',
	'ideas',
	'pages',
	'analytics',
	'tidypics',
	'translation_editor',
	'gcProfilePictureBadges',
	'upload_users',
	'c_email_extensions',
	'gcRegistration',
	'c_module_dump',
	'au_subgroups',
	'widget_manager_accessibility',
	'b_extended_profile',
	'c_members_byDepartment',
	'blog_tools',
	'ckeditor',
	'contactform',
	'site_notifications',
	'web_services',
	'missions_organization',
	'missions',
	'data_views',
	'mt_activity_tabs',
	'geds_sync',
	'gc_api',
	'achievement_badges',
	'embed_extender',
	'toggle_language',
	'cp_notifications',
	'login_as',
	'thewire_tools',
	'mentions',
	'GoC_dev_banner',
	'questions',
	'wet4',
	'GC_profileStrength',
	'saml_link',
	'simplesaml',
	'elgg-jsonp',
	'machine_translation',
	'phpmailer',
	'gc_newsfeed',
	'gc_onboard',
	'gc_splash_page',
	'gc_group_layout',
	'gcconnex_theme',
	'gc_streaming_content',
	'multi_file_upload',
	'gccollab_stats',
	'gc_communities',
	'gc_tags',
	'gc_elgg_sitemap',
	);
	$plugins_off_connex = array(
	'developers',
	'oauth_api',
	'reportedcontent',
	'search',
	'tagcloud',
	'tasks',
	'twitter',
	'unvalidated_user_cleanup',
	'twitter_api',
	'sphinx',
	'gc_group_deletion',
	'custom_error_page',
	'maintenance',
	'gc_fedsearch_gsa',
	'gc_official_groups',
	'apiadmin',
	'gc_profile_nudge',
	'enhanced_user_search',
	'GC_profileStrength_collab',
	'b_extended_profile_collab',
	'gcRegistration_collab',
	'gc_onboard_collab',
	'gc_splash_page_collab',
	'gccollab_theme',
	);
	
	
	// GCcollab	
	$plugins_collab = array(
	'garbagecollector',
	'groups',
	'logrotate',
	'group_tools',
	'blog',
	'bookmarks',
	'dashboard',
	'diagnostics',
	'friend_request',
	'externalpages',
	'file',
	'embed',
	'group_operators',
	'htmlawed',
	'invitefriends',
	'likes',
	'logbrowser',
	'messageboard',
	'messages',
	'polls',
	'profile',
	'rename_friends',
	'search',
	'members',
	'thewire',
	'uservalidationbyemail',
	'unvalidatedemailchange',
	'widget_manager',
	'zaudio',
	'custom_index_widgets',
	'file_tools',
	'event_calendar',
	'login_as',
	'ideas',
	'pages',
	'analytics',
	'tidypics',
	'translation_editor',
	'gcProfilePictureBadges',
	'upload_users',
	'c_email_extensions',
	'gcRegistration_collab',
	'c_module_dump',
	'au_subgroups',
	'widget_manager_accessibility',
	'b_extended_profile',
	'b_extended_profile_collab',
	'blog_tools',
	'ckeditor',
	'contactform',
	'site_notifications',
	'web_services',
	'missions_organization',
	'missions',
	'missions_collab',
	'data_views',
	'mt_activity_tabs',
	'gc_api',
	'achievement_badges',
	'embed_extender',
	'toggle_language',
	'cp_notifications',
	'thewire_tools',
	'mentions',
	'GoC_dev_banner',
	'wet4',
	'wet4_collab',
	'GC_profileStrength',
	'GC_profileStrength_collab',
	'elgg-jsonp',
	'phpmailer',
	'gc_onboard',
	'gc_onboard_collab',
	'gc_newsfeed',
	'gc_splash_page',
	'gc_splash_page_collab',
	'gc_group_layout',
	'freshdesk_help',
	'gccollab_stats',
	'gccollab_theme',
	'gc_streaming_content',
	'multi_file_upload',
	'vroom',
	'elgg_solr',
	'elgg_recaptcha',
	'loginrequired',
	'gcRegistration_invitation',
	'gc_autosubscribegroup',
	'apiadmin',
	'gc_mobile_api',
	'gc_communities',
	'gc_tags',
	'gc_elgg_sitemap',
	'thewire_images',
	);
	$plugins_off_collab = array(
	'developers',
	'gcforums',
	'oauth_api',
	'reportedcontent',
	'tagcloud',
	'tasks',
	'twitter',
	'unvalidated_user_cleanup',
	'twitter_api',
	'sphinx',
	'gcRegistration',
	'c_members_byDepartment',
	'gc_group_deletion',
	'custom_error_page',
	'geds_sync',
	'etherpad',
	'saml_link',
	'simplesaml',
	'maintenance',
	'machine_translation',
	'gcconnex_theme',
	'gc_fedsearch_gsa',
	'gc_official_groups',
	'linkedin_profile_importer',
	'gc_profile_nudge',
	'questions',
	'enhanced_user_search',
	'plugin_loader',
	'member_selfdelete',
	'merge_users',
	'gc_lang_url_handler',
	'solr_api',
	'talent_cloud_invite_api',
	'delete_old_notif',
	'paas_integration',
	'pleio',	// enable to test with openid, will need to be configured on the admin side in-app
	);
	

	// deactivate plugins that are not active in prod, order doesn't matter.
	// This happens first to ensure we don't run into conflicts when activating mods in the next step
	$plugins_off = ${"plugins_off_$type"};
	foreach ($plugins_off as $key => $id) {
		$plugin = elgg_get_plugin_from_id($id);

		if (!$plugin) {
			unset($plugins_off[$key]);
			continue;
		}

		if (!$plugin->isActive()){
			unset($plugins_off[$key]);
			continue;
		}

		$plugin->deactivate();
	}


	// activate plugins that are not activated on install, arrange those that are
	$plugins = ${"plugins_$type"};
	foreach ($plugins as $key => $id) {
		$plugin = elgg_get_plugin_from_id($id);

		if (!$plugin) {
			unset($plugins[$key]);
			continue;
		}

		$plugin->setPriority('last');	// move to the end of the list

		if ($plugin->isActive()){
			unset($plugins[$key]);
			continue;
		}

		$plugin->activate();
	}
}
