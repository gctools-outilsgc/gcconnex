<?php

/**
 * Setup MySQL databases:
 * please note: when enabling the digest functionality, if the site activity is high, there may be chance of exceeding character limit that can be saved in the database
 * upon enabling module, we will create a new table with column data type that allows for more character storage
 */

run_sql_script(__DIR__ . '/install/mysql.sql');


/**
 * If there was an old version of cp_notifications installed in the past, check
 * and make sure that the information is migrated to and using the right tables then
 * start doing a clean up of the old data that is saved in the old data table structure
 */


$query = "SELECT * FROM elggobjects_entity WHERE title LIKE 'Newsletter|%'";
$newsletter_objects = get_data($query);

if (count($newsletter_objects) > 0) {

	error_log("-STARTING-----------------------------------------------------------------------------------------------");


	foreach ($newsletter_objects as $newsletter_object) {
		
		$newsletter_title = explode('|', $newsletter_object->title);
		error_log(">> user guid: {$newsletter_title[1]}");


		// long term fix for the chracter limit, segregate all the entries into records, retrieve via the user guid
		$newsletter_descriptions = json_decode($newsletter_object->description, true);
		foreach ($newsletter_descriptions as $newsletter_header => $newsletter_contents) {
			error_log(">>> {$newsletter_header}");

			if ($newsletter_header !== 'group') {
				foreach ($newsletter_contents as $content_type => $contents) {

					foreach ($contents as $content) {
						error_log(">>>> type: {$content_type} // content guid: {$content_guid}  // content: {$content}");
					}
				}
			}
			//$query = "INSERT INTO notification_digest ( user_guid, entry_type, notification_entry ) VALUES ( {$newsletter_title[1]}, '{$newsletter_header}', 'entry' )";
			//$insert_row = insert_data($query);
		}


		// delete the metadata cpn_newsletter		
		//$user->cpn_newsletter
		//$query = "INSERT INTO notification_digest ( user_guid, digest_content ) VALUES ( {$newsletter_title[1]}, {$newsletter_description} )";
		//$insert_row = insertData();
	}

	error_log("-FINISH-----------------------------------------------------------------------------------------------");;

}


