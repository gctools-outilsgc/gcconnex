<?php

	// retrieving entity object from the database
	$resultset = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'gc_notification',
		'limit' => ''));

	$notify_time = new DateTime();
	foreach ($resultset as $result)
	{
		$log = fopen(elgg_get_plugins_path()  . "/c_notification_manager/cronjob_logging.txt", 'a');
		fwrite($log,  '[' . date_format($notify_time, 'Y-m-d H:i:s') . '] purged: '.$result->guid. "\r\n" );
		fclose($log);
		$result->delete();
	}

forward(REFERER);