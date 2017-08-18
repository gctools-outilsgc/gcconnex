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

