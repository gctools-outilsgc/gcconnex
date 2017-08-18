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

require_once __DIR__ . "/../../autoloader.php";

$installer = new ElggInstaller();

if (getenv('DBHOST') != '')
	$dbhost = getenv('DBHOST');
else
	$dbhost = 'gcconnex-db';

// none of the following may be empty
$params = array(
	// database parameters
	'dbuser' => 'elgg',
	'dbpassword' => 'gcconnex',
	'dbname' => 'elgg',
	
	// We use a wonky dbprefix to catch any cases where folks hardcode "elgg_"
	// instead of using config->dbprefix
	'dbprefix' => 'd_elgg_',
	'dbhost' => 'gcconnex-db',

	// site settings
	'sitename' => 'Docker GCconnex',
	'siteemail' => 'no_reply@gcconnex.gc.ca',
	'wwwroot' => 'http://localhost:8080/',
	'dataroot' => getenv('HOME') . '/data/',

	// admin account
	'displayname' => 'Administrator',
	'email' => 'admin@gcconnex.gc.ca',
	'username' => 'admin',
	'password' => 'adminpassword',
	
	// timezone
	'timezone' => 'UTC'
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
'reportedcontent',
'search',
'tagcloud',
'tasks',
'members',
'thewire',
'twitter',
'uservalidationbyemail',
'unvalidatedemailchange',
'widget_manager',
'zaudio',
'custom_index_widgets',
'file_tools',
'event_calendar',
'login_as',
'ideas',
'unvalidated_user_cleanup',
'pages',
'twitter_api',
'analytics',
'tidypics',
'translation_editor',
'sphinx',
'gcProfilePictureBadges',
'upload_users',
'c_email_extensions',
'gcRegistration',
'au_subgroups',
'widget_manager_accessibility',
'b_extended_profile',
'c_members_byDepartment',
'blog_tools',
'ckeditor',
'contactform',
'gc_group_deletion',
'site_notifications',
'web_services',
'missions_profile_extend',
'missions_organization',
'missions',
'custom_error_page',
'data_views',
'mt_activity_tabs',
'geds_sync',
'gc_api',
'achievement_badges',
'embed_extender',
'toggle_language',
'thewire_tools',
'mentions',
'GoC_dev_banner',
'wet4',
'GC_profileStrength',
'apiadmin',
'cp_notifications',
'saml_link',
'simplesaml',
'gc_fedsearch_gsa',
'maintenance',
'elgg-jsonp',
'gc_group_layout',
'gc_official_groups',
'machine_translation',
'gc_profile_nudge',
'phpmailer',
'gc_onboard',
'gc_streaming_content',
'gc_newsfeed',
'gccollab_stats',
'gc_splash_page',
'multi_file_upload',
'questions',
'gcconnex_theme'
);

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