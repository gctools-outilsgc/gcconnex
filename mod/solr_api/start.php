<?php

// REFERENCE: http://learn.elgg.org/en/stable/guides/web-services.html#api-authentication
// Admin > Web Services > Create API Keys

elgg_register_event_handler('init','system','solr_api_init');


function your_plugin_auth_handler($credentials) {
   error_log("credentials...");
}

function api_hook_handler() {
	return "hey hey";
}

function solr_api_init() {

	elgg_register_event_handler('delete', 'object', 'intercept_object_deletion'); 

	// Register the authentication handler
	//register_pam_handler('your_plugin_auth_handler');
	//elgg_register_plugin_hook_handler('rest:output', 'get_entity_list', 'api_hook_handler');

	// @TODO limit access to only the specified user agent string for more strict security
	// @TODO will need authentication mechanism for this


	//$method, $function, array $parameters = NULL, $description = "",
	//	$call_method = "GET", $require_api_auth = false, $require_user_auth = false

	elgg_ws_expose_function(
		'delete.updated_index_list',
		'delete_updated_index_list',
		[
			'guids' => [
				'type' => 'array',
				'required' => false,
				'description' => 'deletes records based on collection of entity guids'
			]
		],
		'deletes record that already updated the solr index',
		'POST',
		true,
		false
	);


	elgg_ws_expose_function(
        'get.entity_list',
        'get_entity_list',
        [
            'type' => [
                'type' => 'string',
                'required' => true,
                'description' => 'the type of entity in string format',
            ],
            'subtype' => [
                'type' => 'string',
                'required' => false,
                'description' => 'the subtype of entity in string format, not required',
            ],
			'offset' => [
                'type' => 'int',
                'required' => true,
                'description' => 'the subtype of entity in string format, not required',
            ],

        ],
        'retrieves all entities filtered by type [and subtype]',
        'GET',
        true,
        false
	);


	elgg_ws_expose_function(
        'get.user_list',
        'get_user_list',
        [
        	'offset' => [
        		'type' => 'int',
        		'required' => true,
        		'description' => 'paging mechanism'
        	]
        ],
        'retrieves a user list',
        'GET',
        true,
        false
	);

	//$method, $function, array $parameters = NULL, $description = "",
	//	$call_method = "GET", $require_api_auth = false, $require_user_auth = false

	elgg_ws_expose_function(
        'get.group_list',
        'get_group_list',
        [
        	'offset' => [
        		'type' => 'int',
        		'required' => true,
        		'description' => 'api loads 20 groups at a time'
        	]
        ],
        'retrieves a group list',
        'GET',
        true,
        false
	);


	elgg_ws_expose_function(
		'get.list_of_deleted_records',
		'get_list_of_deleted_records',
		null,
		'retrieves a list of deleted content',
		'GET',
		true,
		false
	);
}


function delete_updated_index_list($guids) {

	$ids = array();
	foreach ($guids as $guid) {
		// guid must be an integer
		if (is_numeric($guid)) 
			$ids[] = $guid;
		else
			return "there is an issue deleting a record in the database, please see function delete_updated_index_list()";
	}

	if (sizeof($ids) > 0) {
		$ids = implode(",", $ids);
		$query = "DELETE FROM deleted_object_tracker WHERE id IN ({$ids})";
		$result = delete_data($query);
	}

	$arr[] = array('message' => 'deleted the following guid');
	$arr[] = $ids;

	return $arr;
}

// this is not an api call, this is a hook that will initiate once user attempts deletion
function intercept_object_deletion($event, $type, $object) {
	$unixtime = time();
	error_log("deleting ... id: {$object->guid}  //  title: {$object->title} on " . time());

	
	$query = "INSERT INTO deleted_object_tracker (id, time_deleted) VALUES ({$object->guid}, {$unixtime})";

	// just in case for some reason, the user is able to delete the same thing twice
	try {
		$insert_record = insert_data($query);
	} catch (Exception $e) {
		error_log("error occurred: {$e}");
	}

	$query = "SELECT * FROM deleted_object_tracker";
	$deleted_records = get_data($query);

	foreach ($deleted_records as $deleted_record) {
		error_log("the id: " . $deleted_record->id);
	}


	return false;
}


// api calls with sample set of limit 15
function get_list_of_deleted_records() {

	$query = "SELECT * FROM deleted_object_tracker";
	$deleted_records = get_data($query);

	foreach ($deleted_records as $deleted_record) {
		error_log("the id: " . $deleted_record->id);
		//$datetime = new DateTime("@{$deleted_record->time_deleted}");
		//$datetime->setTimeZone(new DateTimeZone('America/New York'));
		$arr[] = array(
			'guid' => $deleted_record->id,
			'time_deleted' => $deleted_record->time_deleted
		);
	}
	return $arr;
}


function get_user_list($offset) {

	$users = elgg_get_entities(array(
		'type' => 'user',
		'limit' => 10,
		'offset' => $offset
	));

	foreach ($users as $user) {

		$name_array['en'] = $user->name;
		$name_array['fr'] = $user->name;

		$arr[] = array(
			'guid' => $user->getGUID(),
			'name' => $name_array,
			'username' => $user->username,
			'email' => $user->email,
			'type' => $user->getType(),
			'date_created' => date("Y-m-d\TH:m:s\Z", $user->time_created),
			'date_modified' => date("Y-m-d\TH:m:s\Z", $user->time_created),
			'url' => $user->getURL()
		);
	}
    return $arr;
}

function get_group_list($offset) {

	$groups = elgg_get_entities(array(
		'type' => 'group',
		'limit' => 10,
		'offset' => $offset
	));

	foreach ($groups as $group) {

		if (isJson($group->name)) {
			$name_array = json_decode($group->name, true);
			$name_array['en'] = str_replace('"', '\"', $name_array['en']);
			$name_array['fr'] = str_replace('"', '\"', $name_array['fr']);
		} else {
			$name_array['en'] = $group->name_array;
			$name_array['fr'] = $group->name;
		}

		if (isJson($group->description)) {
			$description_array = json_decode($group->description, true);
			$description_array['en'] = str_replace('"', '\"', $description_array['en']);
			$description_array['fr'] = str_replace('"', '\"', $description_array['fr']);
		} else {
			$description_array['en'] = $group->description;
			$description_array['fr'] = $group->description;
		}

		$arr[] = array(
			'guid' => $group->getGUID(),
			'name' => $name_array,
			'description' => $description_array,
			'type' => $group->getType(),
			'access_id' => $group->access_id,
			'date_created' => date("Y-m-d\TH:m:s\Z", $group->time_created),
			'date_modified' => date("Y-m-d\TH:m:s\Z", $group->time_updated),
			'url' => $group->getURL()
		);
	}
    return $arr;
}


function get_entity_list($type, $subtype, $offset) {

	$entities = elgg_get_entities(array(
		'type' => $type,
		'subtype' => $subtype,
		'limit' => 10,
		'offset' => $offset
	));

	foreach ($entities as $entity) {

		if (isJson($entity->title)) {
			$title_array = json_decode($entity->title, true);
			if (!isset($title_array['en']) || !isset($title_array['en'])) {
				$title_array['en'] = str_replace('"', '\"', $title_array);
				$title_array['fr'] = str_replace('"', '\"', $title_array);
			} else {
				$title_array['en'] = str_replace('"', '\"', $title_array['en']);
				$title_array['fr'] = str_replace('"', '\"', $title_array['fr']);
			}
		} else {
			$title_array['en'] = $entity->title;
			$title_array['fr'] = $entity->title;
		}

		if (isJson($entity->description)) {
			$description_array = json_decode($entity->description, true);
			if (!isset($description_array['en']) || !isset($description_array['en'])) {
				$description_array['en'] = str_replace('"', '\"', $description_array);
				$description_array['fr'] = str_replace('"', '\"', $description_array);
			} else {
				$description_array['en'] = str_replace('"', '\"', $description_array['en']);
				$description_array['fr'] = str_replace('"', '\"', $description_array['fr']);
			}
		} else {
			$description_array['en'] = $entity->description;
			$description_array['fr'] = $entity->description;
		}

		$arr[] = array(
			'guid' => $entity->getGUID(), 
			'title' => $title_array,
			'description' => $description_array,
			'type' => $entity->getType(),
			'subtype' => $entity->getSubtype(),
			'access_id' => $entity->access_id,
			'date_created' => date("Y-m-d\TH:m:s\Z", $entity->time_created),
			'date_modified' => date("Y-m-d\TH:m:s\Z", $entity->time_updated),
			'url' => $entity->getURL()
		);
	}

	return $arr;
}

 

function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

