<?php
/**
 * Docker CLI installer script.
 *
 * @access private
 */

$enabled = getenv('DOCKER') != ''; //are we in a Docker container?

if (!$enabled) {
	echo "This script should be run only in a Docker container environment.\n";
	exit(1);
}

if (PHP_SAPI !== 'cli') {
	echo "You must use the command line to run this script.\n";
	exit(2);
}

$elggRoot = dirname(dirname(__DIR__));

require_once "$elggRoot/vendor/autoload.php";

$installer = new ElggInstaller();

if (getenv('DBHOST') != '')
	$dbhost = getenv('DBHOST');
else
	$dbhost = 'gcconnex-db';

if (getenv('WWWROOT') != '')
	$wwwroot = getenv('WWWROOT');
else
	$wwwroot = 'http://localhost:8080/';

// none of the following may be empty
$params = array(
	// database parameters
	'dbuser' => 'elgg',
	'dbpassword' => 'gcconnex',
	'dbname' => 'elgg',
	
	// We use a wonky dbprefix to catch any cases where folks hardcode "elgg_"
	// instead of using config->dbprefix
	'dbprefix' => 'd_elgg_',
	'dbhost' => $dbhost,

	// site settings
	'sitename' => 'Docker GCconnex',
	'siteemail' => 'no_reply@gcconnex.gc.ca',
	'wwwroot' => $wwwroot,
	'dataroot' => getenv('HOME') . '/data/',

	// admin account
	'displayname' => 'Administrator',
	'email' => 'admin@gcconnex.gc.ca',
	'username' => 'admin',
	'password' => 'adminpassword',
);

// install and create the .htaccess file
$installer->batchInstall($params, TRUE);

// at this point installation has completed (otherwise an exception halted execution).
echo "Elgg CLI install successful. wwwroot: " . elgg_get_config('wwwroot') . "\n";


// arrange and activate mods
$plugins = array(
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

$plugins_off = array(
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

// deactivate plugins that are not active in prod, order doesn't matter.
// This happens first to ensure we don't run into conflicts when activating mods in the next step
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

echo "Elgg CLI plugin install successful. \n";
