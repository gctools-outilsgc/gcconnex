<?php
/**
 * Defines database credentials.
 *
 * Most of Elgg's configuration is stored in the database.  This file contains the
 * credentials to connect to the database, as well as a few optional configuration
 * values.
 *
 * The Elgg installation attempts to populate this file with the correct settings
 * and then rename it to settings.php.
 *
 * @todo Turn this into something we handle more automatically.
 * @package    Elgg.Core
 * @subpackage Configuration
 */

// defaults mainly focused on less hastle in local dev environments
$defaults = [
	"DBUSER" => "elgg",
	"DBPASS" => "gcconnex",
	"DBNAME" => "elgg",
	"DBHOST" => "gcconnex-db",
	"DBPREFIX" => "d_elgg_",
	"MEMCACHE_HOST" => "127.0.0.1",
	"SESSION_NAME" => "Elgg",
	"REMEMBERME_NAME" => "elggperm"
];

global $CONFIG;
if (!isset($CONFIG)) {
	$CONFIG = new \stdClass;
}

/**
 * The database username
 *
 * @global string $CONFIG->dbuser
 */
$CONFIG->dbuser = getenv('DBUSER') ? getenv('DBUSER') : $defaults['DBUSER'];

/**
 * The database password
 *
 * @global string $CONFIG->dbpass
 */
$CONFIG->dbpass = getenv('DBPASS') ? getenv('DBPASS') : $defaults['DBPASS'];

/**
 * The database name
 *
 * @global string $CONFIG->dbname
 */
$CONFIG->dbname = getenv('DBNAME') ? getenv('DBNAME') : $defaults['DBNAME'];

/**
 * The database host.
 *
 * @global string $CONFIG->dbhost
 */
$CONFIG->dbhost = getenv('DBHOST') ? getenv('DBHOST') : $defaults['DBHOST'];

/**
 * The database prefix
 *
 * @global string $CONFIG->dbprefix
 */
$CONFIG->dbprefix = getenv('DBPREFIX') ? getenv('DBPREFIX') : $defaults['DBPREFIX'];

/**
 * Multiple database connections
 *
 * Elgg supports master/slave MySQL configurations. The master should be set as
 * the 'write' connection and the slave(s) as the 'read' connection(s).
 *
 * To use, uncomment the below configuration and update for your site.
 */
//$CONFIG->db['split'] = true;

//$CONFIG->db['write']['dbuser'] = "";
//$CONFIG->db['write']['dbpass'] = "";
//$CONFIG->db['write']['dbname'] = "";
//$CONFIG->db['write']['dbhost'] = "";

//$CONFIG->db['read'][0]['dbuser'] = "";
//$CONFIG->db['read'][0]['dbpass'] = "";
//$CONFIG->db['read'][0]['dbname'] = "";
//$CONFIG->db['read'][0]['dbhost'] = "";
//$CONFIG->db['read'][1]['dbuser'] = "";
//$CONFIG->db['read'][1]['dbpass'] = "";
//$CONFIG->db['read'][1]['dbname'] = "";
//$CONFIG->db['read'][1]['dbhost'] = "";

/**
 * Memcache setup (optional)
 * This is where you may optionally set up memcache.
 */
$CONFIG->memcache = getenv('MEMCACHE_HOST');
$CONFIG->memcache_servers = array (
	array(getenv('MEMCACHE_HOST'), 11211),
);


/**
 * Better caching performance
 *
 * Configuring the location of your data directory and enabling simplecache in
 * the settings.php file improves caching performance. It allows Elgg to skip
 * connecting to the database when serving cached JavaScript and CSS files. If
 * you uncomment and configure these settings, you will not be able to change
 * them from the Elgg advanced settings page.
 */
//$CONFIG->dataroot = "";
//$CONFIG->simplecache_enabled = true;


/**
 * Cookie configuration
 *
 * Elgg uses 2 cookies: a PHP session cookie and an extended login cookie 
 * (also called the remember me cookie). See the PHP manual for documentation on
 * each of these parameters. Possible options:
 * 
 *  - Set the session name to share the session across applications.
 *  - Set the path because Elgg is not installed in the root of the web directory.
 *  - Set the secure option to true if you only serve the site over HTTPS.
 *  - Set the expire option on the remember me cookie to change its lifetime
 *
 * To use, uncomment the appropriate sections below and update for your site.
 * 
 * @global array $CONFIG->cookies
 */
// get the default parameters from php.ini
//$CONFIG->cookies['session'] = session_get_cookie_params();
$CONFIG->cookies['session']['name'] = getenv('SESSION_NAME') ? getenv('SESSION_NAME') : $defaults['SESSION_NAME'];
// optionally overwrite the defaults from php.ini below
//$CONFIG->cookies['session']['path'] = "/";
//$CONFIG->cookies['session']['domain'] = "";
//$CONFIG->cookies['session']['secure'] = false;
//$CONFIG->cookies['session']['httponly'] = false;

// extended session cookie
//$CONFIG->cookies['remember_me'] = session_get_cookie_params();
$CONFIG->cookies['remember_me']['name'] = getenv('REMEMBERME_NAME') ? getenv('REMEMBERME_NAME') : $defaults['REMEMBERME_NAME'];
//$CONFIG->cookies['remember_me']['expire'] = strtotime("+30 days");
// optionally overwrite the defaults from php.ini below
//$CONFIG->cookies['remember_me']['path'] = "/";
//$CONFIG->cookies['remember_me']['domain'] = "";
//$CONFIG->cookies['remember_me']['secure'] = false;
//$CONFIG->cookies['remember_me']['httponly'] = false;


/**
 * Use non-standard headers for broken MTAs.
 *
 * The default header EOL for headers is \r\n.  This causes problems
 * on some broken MTAs.  Setting this to true will cause Elgg to use
 * \n, which will fix some problems sending email on broken MTAs.
 *
 * @global bool $CONFIG->broken_mta
 */
$CONFIG->broken_mta = false;

/**
 * Disable the database query cache
 *
 * Elgg stores each query and its results in a query cache.
 * On large sites or long-running scripts, this cache can grow to be
 * large.  To disable query caching, set this to true.
 *
 * @global bool $CONFIG->db_disable_query_cache
 */
$CONFIG->db_disable_query_cache = false;

/**
 * Minimum password length
 *
 * This value is used when validating a user's password during registration.
 *
 * @global int $CONFIG->min_password_length
 */
$CONFIG->min_password_length = 6;

/**
 * This is an optional script used to override Elgg's default handling of
 * uncaught exceptions.
 * 
 * This should be an absolute file path to a php script that will be called
 * any time an uncaught exception is thrown.
 * 
 * The script will have access to the following variables as part of the scope
 * global $CONFIG
 * $exception - the unhandled exception
 * 
 * @warning - the database may not be available
 * 
 * @global string $CONFIG->exception_include
 */
$CONFIG->exception_include = '';

/**
 * Minimum username length
 *
 * This value is used when validating a user's username during registration.
 *
 * @global int $CONFIG->minusername
 */
$CONFIG->minusername = 2;
