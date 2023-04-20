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
require_once "docker_install_additions/mods_init.php";


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
// some mods require some configuration to work as expected, do that now
init_mods_config();

echo "Elgg CLI plugin install successful. \n";

if ($e2e_test_init){
	echo "preparing for e2e tests  \n";
	require_once("docker_install_additions/e2e_test_init.php");
	e2e_init();
	echo "e2e setup completed.  \n";
}

