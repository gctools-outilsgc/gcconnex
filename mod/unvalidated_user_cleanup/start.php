<?php
/**
 * unvalidated user cleanup.
 *
 * @package unvalidated_user_cleanup
 */

elgg_register_event_handler('init', 'system', 'unvalidated_user_cleanup_init');

function unvalidated_user_cleanup_init() {
	//$unvaldeleteage = elgg_get_plugin_setting('unvaldeleteage', 'unvalidated_user_cleanup');
	$period = elgg_get_plugin_setting('unvaldelete', 'unvalidated_user_cleanup');
	switch ($period) {
		case 'fiveminute':
		case 'hourly':
		case 'daily':
		case 'weekly':
		case 'monthly':
		case 'yearly':
			break;
		default:
			$period = 'daily';
	}


	/*$log = fopen( dirname( __FILE__ ) . '/Sett.txt', 'w' );
	fwrite( $log, "Script settings: " . $period . "\r\n" );
	fclose($log);*/

	// Register cron hook
	elgg_register_plugin_hook_handler('cron', $period, 'unvalidated_user_cleanup_cron');

	//unvalidateduser_delete_cron("", '', '', '');
	//echo "TEST!!!!!" . $log;
}

/**
 * Trigger unvalidated user deletion.
 */
function unvalidated_user_cleanup_cron($hook, $entity_type, $returnvalue, $params) {
	$log = fopen( dirname( __FILE__ ) . '/Log-' . date() . ".txt", 'a' );

	$day = 86400;
	$maxage = elgg_get_plugin_setting('unvaldeleteage', 'unvalidated_user_cleanup') * $day;


	fwrite( $log, "Starting script at " . time() . "\r\n" );
	echo "Starting unvalidated user cleanup script. <br /> ";	
	delete_unvalidated_users($maxage, $log);

	fwrite( $log, "Script end" . "\r\n \r\n ------------------ \r\n \r\n" );
	fclose($log);

	return $returnvalue;
}

/**
 * This function deletes unvalidated user accounts that are older than specified.
 *
 * @param $maxage is the oldest an unvalidated user account can be before being deleted (in sec)
 * @param $log is the output to the log file
 */
function delete_unvalidated_users($maxage, $log) {
	$ia = elgg_set_ignore_access(TRUE);
	$hidden_entities = access_get_show_hidden_status();
	access_show_hidden_entities(TRUE);

	$options = array(
		'type' => 'user',
		'wheres' => uservalidationbyemail_get_unvalidated_users_sql_where(),
	);

	$users = elgg_get_entities($options);

	foreach ( $users as $usr ){
		if ( ( time() - $usr->time_created ) > $maxage && !elgg_get_user_validation_status( $usr->guid ) ){
			fwrite( $log, "Deleting user: " . $usr->username . "\r\n" );
			echo "Deleting user: " . $usr->username . " <br /> ";
			$usr->delete();
		}
	}
	
}
