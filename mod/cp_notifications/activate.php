<?php

/**
 * Setup MySQL databases:
 * please note: when enabling the digest functionality, if the site activity is high, there may be chance of exceeding character limit that can be saved in the database
 * upon enabling module, we will create a new table with column data type that allows for more character storage.
 * 
 * create the indices for specific columns in the table that we just created
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

    // iterate through each newsletter object
    foreach ($newsletter_objects as $newsletter_object) {
        
        $newsletter_title = explode('|', $newsletter_object->title);

        // if user does not exist because it was deleted, remove digest then skip
        if (!(get_user_by_email($newsletter_title[1]) instanceof ElggUser)) 
        {
            $object = get_entity($newsletter_object->guid);
            $object->delete();
            continue; 
        }

        // long term fix for the chracter limit, segregate all the entries into records, retrieve via the user guid
        $newsletter_descriptions = json_decode($newsletter_object->description, true);
        foreach ($newsletter_descriptions as $newsletter_header => $newsletter_contents) {
    

            foreach ($newsletter_contents as $content_type => $contents) {

                foreach ($contents as $content_id => $content) {

                    // group notifications are different than the rest (the content is saved as an array)
                    if ($newsletter_header === 'group') {
                        $group_contents = $content;
                        
                        foreach ($group_contents as $group_content_id => $group_content) {
                            /**
                             * entity_guid:	$group_content_id
                             * user id:     $newsletter_title[1]
                             * entry_tyoe:  $content_id
                             * group_name:  $content_type
                             * action_type:	$newsletter_header
                             * notification_entry: $group_content
                             */ 

                            $content_type = base64_encode($content_type);
                            $user_guid = (is_numeric($user_guid)) ? $user_guid : get_user_by_email($newsletter_title[1])->getGUID();
                            $query = "INSERT INTO notification_digest ( entity_guid, user_guid, entry_type, group_name, action_type, notification_entry ) VALUES ( {$group_content_id}, {$newsletter_title[1]}, '{$newsletter_header}', '{$content_type}', '{$content_id}', '{$group_content}' )";
                            $body .= '<br/>'.$query.'<br/>';
                            $insert_row = insert_data($query);
                        }

                    } else {

                        /**
                         * entity_guid:	$content_id
                         * user id:     $newsletter_title[1]
                         * entry_tyoe:  $content_type
                         * group_name:  NULL
                         * action_type:	$newsletter_header 
                         * notification_entry: $content
                         */ 


                        $content_id = preg_replace("/[^0-9,.]/", "", $content_id);
                        $user_guid = (is_numeric($user_guid)) ? $user_guid : get_user_by_email($newsletter_title[1])->getGUID();

                        $query = "INSERT INTO notification_digest ( entity_guid, user_guid, entry_type, group_name, action_type, notification_entry ) VALUES ( {$content_id}, {$newsletter_title[1]}, '{$newsletter_header}', NULL, '{$content_type}', '{$content_id}', '{$content}' )";
                        $insert_row = insert_data($query);
                    }
                }
            }
        }

        // remove the cpn_newsletter metadata... we don't need a reference between object entity and the digest metadata
        $user = get_user($newsletter_title[1]);
        $user->deleteMetadata('cpn_newsletter');

        // delete the Newsletter object
        $object = get_entity($newsletter_object->guid);
        $object->delete();
    }
}
